<?php
namespace App\Helpers;
use Razorpay\Api\Errors\SignatureVerificationError;
use Illuminate\Support\Facades\App;
use App\Models\Message_template;
use App\Models\OnlinePayment;
use Illuminate\Support\Str;
use App\Models\UserWallet;
use App\Models\Login_log;
use App\Models\Email_log;
use App\Models\Sms_log;
use App\Mail\SendMail;
use App\Models\Ledger;
use Razorpay\Api\Api;
use App\Models\User;
use Exception;
use Auth;
use Mail;
use DB;

class Razorpay
{


 	public static function create($request, $user, $address)
    {    
		$form_data = $request->all();
		$amount = $form_data['amount'];
		$user_id = $user->id;
		$user_name = $user->name;
		$email = $user->email;
		$phone_number = $user->phone_number;
		$address = $address;
		$api_key = config('payment.razorpay.razorpay_key');
		$api_secret = config('payment.razorpay.razorpay_secret');
        // Generate random receipt id
        $receiptId = date('Ymd').$user->id.time();
		
		try {

	        // Create an object of razorpay
	        $api = new Api($api_key, $api_secret);
	  
	        // In razorpay you have to convert rupees into paise we multiply by 100
	        // Currency will be INR
	        // Creating order
			$orderData = [
			    'receipt' => $receiptId,
			    'amount' => $amount * 100,
			    'currency' => 'INR'
			];
	     
	        $order = $api->order->create($orderData);

	        // Return response on payment page
	        $response = [
	            'orderId' => $order['id'],
	            'razorpayId' => $api_key,
	            'amount' => $amount * 100,
	            'name' =>  config('app.name'),
	            'currency' => 'INR',
	            'email' => $email,
	            'contactNumber' => $phone_number,
	            'address' => $address,
	            'user_name' => $user_name,
	            //'description' =>  $user_name.' add money in wallet.',
				'receiptId' => $receiptId
	        ];

	        OnlinePayment::insert([
	        	"user_id" => $user_id,
	        	"gateway_order_id" => $order['id'],
	        	"payment_id" => $receiptId,
	        	"amount" => $amount,
	        	"gateway_request" => json_encode($response),
	        ]);

	        return ['status' => 'success','message' => 'success', 'response' => $response];
	    }  
		catch (Exception $e) {

			return ['status' => 'success', 'message' =>  $e->getMessage()];

        }
    }






	public static function paymentVerify($data, $user)
	{
		$api_key = config('payment.razorpay.razorpay_key');
		$api_secret = config('payment.razorpay.razorpay_secret');
		// Create an object of razorpay
        $api = new Api($api_key, $api_secret);

		$check = OnlinePayment::where('gateway_order_id', $data['order_id'])->where('user_id', $user->id)->first();
		
		if($check)
		{
			OnlinePayment::where('gateway_order_id', $data['order_id'])->where('user_id', $user->id)->update([
		        	"gateway_response" => json_encode($data)
		    ]);

			try
			{
				$payment = $api->payment->fetch($data['payment_id']);

				if($payment) {

					OnlinePayment::where('gateway_order_id', $data['order_id'])->where('user_id', $user->id)->update([
				        	"gateway_response" => json_encode($payment->toArray())
				    ]);

					$status_name = 'Pending';
					
					if($payment['status'] == 'captured') {
						$status_name = 'Completed';
					} else if ($payment['status'] == 'failed') {
						$status_name = 'Cancelled';
					}

					OnlinePayment::where('gateway_order_id', $data['order_id'])->where('user_id', $user->id)->update([
		        		"status" => $status_name
		    		]);	

					if($status_name == 'Pending') {
		    			return ['status' => 'success', 'message' => 'pending', 'payment_id' => $check->payment_id, 'payment_method' => $payment['method']];
					} else if ($status_name == 'Completed') {
		    			return ['status' => 'success', 'message' => 'success', 'payment_id' => $check->payment_id, 'amount' => $check->amount, 'payment_method' => $payment['method']];
					} else if ($status_name == 'Cancelled') {
		    			return ['status' => 'error', 'message' => 'cancelled'];
					}
				}


			}
			catch(\verifyPaymentSignature $e)
			{
				// If Signature is not correct its give a excetption so we use try catch
				return ['status' => 'error', 'message' => $e->getMessage()];
			}
		}

		return ['status' => 'error', 'message' => 'field'];
	}





	// In this function we return boolean if signature is correct
	public static function SignatureVerify($data, $user)
	{
		$api_key = config('payment.razorpay.razorpay_key');
		$api_secret = config('payment.razorpay.razorpay_secret');
		// Create an object of razorpay
        $api = new Api($api_key, $api_secret);
		
		$check = OnlinePayment::where('gateway_order_id', $data['order_id'])->where('user_id', $user->id)->first();
		
		if($check)
		{
			OnlinePayment::where('gateway_order_id', $data['order_id'])->where('user_id', $user->id)->update([
		        	"gateway_response" => json_encode($data),
		    ]);

			try
			{
				$attributes = array(
						            'razorpay_order_id' => $data['order_id'],
						            'razorpay_payment_id' => $data['payment_id'],
						            'razorpay_signature' => $data['signature']
						        );
				$order = $api->utility->verifyPaymentSignature($attributes);
					dd($data, $order,$attributes);
			}
			catch(\verifyPaymentSignature $e)
			{
				// If Signature is not correct its give a excetption so we use try catch
				dd($e);
			}
		}
		else
		{
			return false;
			
		}

	}





}