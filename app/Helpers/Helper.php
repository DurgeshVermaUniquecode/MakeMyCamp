<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use App\Models\MessageTemplate;
use App\Models\Login_log;
use App\Models\EmailLog;
use App\Models\SmsLog;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\Notifications;
use App\Models\Ledger;
use App\Models\Wallet;
use Browser;
use Mail;
use Cookie;
use DB;
use App\Services\FirebaseService;


class Helper
{
	public static function setLocaleLang()
	{
		App::setLocale(Cookie::get('locale'));
	}

	public static function shortEncrypt($string, $key = 'durgeshverma') {
    	return rtrim(strtr(base64_encode(openssl_encrypt($string, 'aes-128-ecb', $key, OPENSSL_RAW_DATA)), '+/', '-_'), '=');
	}

	public static function shortDecrypt($encrypted, $key = 'durgeshverma') {
		return openssl_decrypt(base64_decode(strtr($encrypted, '-_', '+/')), 'aes-128-ecb', $key, OPENSSL_RAW_DATA);
	}

	public static function getTransId($type='')
	{

		if($type == 1)
		{
			return date('dmY').time();
		}
		else if ($type == 2)
		{
			return config('app.shortname').date('dmy').time();
		}
		else if ($type == 3)
		{
			return rand(000,999).date('dmy').time();
		}
		else
		{
			return $type.date('dmy').time();
		}
	}


	public static function creadit_ledger($data)
	{

		if(count($data) != 10)
		{
			return [
				'status' => 'error',
				'message' => 'invalid credentials.',
			];
		}

		$userwallet = Wallet::where('user_id', $data['user_id'])->first();
		$userledger = 0.00;
		$wallet_bal = 0.00;
		$current_bal = 0.00;

		if($userwallet)
		{
			if($data['wallet_type'] <= 0 || $data['wallet_type'] >= 7){
				return [
					'status' => 'error',
					'message' => 'Invalid Wallet type.',
				];
			}

			if($data['wallet_type'] == 1)
			{
				$wallet_bal = $userwallet->main_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'MAIN')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}
			else if ($data['wallet_type'] == 2)
			{
				$wallet_bal = $userwallet->dmt_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'DMT')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}
			else if ($data['wallet_type'] == 3)
			{
				$wallet_bal = $userwallet->aeps_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'AEPS')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}
			else if ($data['wallet_type'] == 4)
			{
				$wallet_bal = $userwallet->digi_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'DIGI')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}
			else if ($data['wallet_type'] == 5)
			{
				$wallet_bal = $userwallet->vps_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'VPS')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}
			else if ($data['wallet_type'] == 6)
			{
				$wallet_bal = $userwallet->bonus_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'BONUS')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}


			if((float)$wallet_bal != (float)$userledger)
			{
				return [
					'status' => 'error',
					'message' => 'Wallet balance is low.',
				];
			}

			$current_bal = (float)$wallet_bal+(float)abs($data['amount']);

			if($current_bal < 0)
			{
				return [
					'status' => 'error',
					'message' => 'negative balance not accepted.',
				];
			}

			$ledgerdata = [
		        "user_id" => $data['user_id'],
		        "trans_id" => $data['trans_id'],
		        "refrence_id" => $data['refrence_id'],
		        "old_bal" => (float)$wallet_bal,
		        "current_bal" => (float)$current_bal,
		        "cramount" => (float)abs($data['amount']),
		        "dramount" => 0.0000,
		        "cgst" => (float)$data['cgst'],
		        "sgst" => (float)$data['sgst'],
		        "ledger_type" => $data['ledger_type'],
		        "bal_type" => $data['wallet_type'],
		        "trans_from" => $data['trans_from'],
		        "description" => $data['description']
			];

			$userledger = Ledger::where('user_id', $data['user_id'])->insertGetId($ledgerdata);

			if($userledger)
			{
				if($data['wallet_type'] == 1)
				{
					Wallet::where('user_id', $data['user_id'])->update(["main_balance" => $current_bal]);
				}
				else if ($data['wallet_type'] == 2)
				{
					Wallet::where('user_id', $data['user_id'])->update(["dmt_balance" => $current_bal]);
				}
				else if ($data['wallet_type'] == 3)
				{
					Wallet::where('user_id', $data['user_id'])->update(["aeps_balance" => $current_bal]);
				}
				else if ($data['wallet_type'] == 4)
				{
					Wallet::where('user_id', $data['user_id'])->update(["digi_balance" => $current_bal]);
				}
				else if ($data['wallet_type'] == 5)
				{
					Wallet::where('user_id', $data['user_id'])->update(["vps_balance" => $current_bal]);
				}
				else if ($data['wallet_type'] == 6)
				{
					Wallet::where('user_id', $data['user_id'])->update(["bonus_balance" => $current_bal]);
				}

				return [
					'status' => 'success',
					'message' => 'Successfully Txn.',
					'insertGetId' => $userledger
				];
			}
			else
			{
				return [
					'status' => 'error',
					'message' => 'invalid credentials.',
				];
			}
		}
		else
		{
			return [
				'status' => 'error',
				'message' => 'invalid credentials.',
			];
		}
	}




	public static function debit_ledger($data)
	{

		if(count($data) != 10)
		{
			return [
				'status' => 'error',
				'message' => 'invalid credentials.',
			];
		}

		$userwallet = Wallet::where('user_id', $data['user_id'])->first();
		$userledger = 0.0000;
		$wallet_bal = 0.0000;
		$current_bal = 0.0000;

		if($userwallet)
		{
			if($data['wallet_type'] <= 0 || $data['wallet_type'] >= 7){
				return [
					'status' => 'error',
					'message' => 'Invalid Wallet type.',
				];
			}

			if($data['wallet_type'] == 1)
			{
				$wallet_bal = $userwallet->main_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'MAIN')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}
			else if ($data['wallet_type'] == 2)
			{
				$wallet_bal = $userwallet->dmt_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'DMT')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}
			else if ($data['wallet_type'] == 3)
			{
				$wallet_bal = $userwallet->aeps_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'AEPS')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}
			else if ($data['wallet_type'] == 4)
			{
				$wallet_bal = $userwallet->digi_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'DIGI')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}
			else if ($data['wallet_type'] == 5)
			{
				$wallet_bal = $userwallet->vps_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'VPS')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}
			else if ($data['wallet_type'] == 6)
			{
				$wallet_bal = $userwallet->bonus_balance;
				$userledger = Ledger::where('user_id', $data['user_id'])->where('bal_type', 'BONUS')->sum(DB::raw('ledgers.cramount - ledgers.dramount'));
			}

			if($wallet_bal < 1)
			{
				return [
					'status' => 'error',
					'message' => 'Wallet balance is low.',
				];
			}

			if((float)$wallet_bal != (float)$userledger)
			{
				return [
					'status' => 'error',
					'message' => 'Wallet balance is low.',
				];
			}


			$current_bal = (float)$wallet_bal-(float)abs($data['amount']);

			if($current_bal < 0)
			{
				return [
					'status' => 'error',
					'message' => 'Insufficient balance.',
				];
			}



			$ledgerdata = [
		        "user_id" => $data['user_id'],
		        "trans_id" => $data['trans_id'],
		        "refrence_id" => $data['refrence_id'],
		        "old_bal" => (float)$wallet_bal,
		        "current_bal" => (float)$current_bal,
		        "cramount" => 0.0000,
		        "dramount" => (float)abs($data['amount']),
		        "cgst" => (float)$data['cgst'],
		        "sgst" => (float)$data['sgst'],
		        "ledger_type" => $data['ledger_type'],
		        "bal_type" => $data['wallet_type'],
		        "trans_from" => $data['trans_from'],
		        "description" => $data['description']
			];


			$userledger = Ledger::where('user_id', $data['user_id'])->insertGetId($ledgerdata);

			if($userledger)
			{
				if($data['wallet_type'] == 1)
				{
					Wallet::where('user_id', $data['user_id'])->update(["main_balance" => $current_bal]);
				}
				else if ($data['wallet_type'] == 2)
				{
					Wallet::where('user_id', $data['user_id'])->update(["dmt_balance" => $current_bal]);
				}
				else if ($data['wallet_type'] == 3)
				{
					Wallet::where('user_id', $data['user_id'])->update(["aeps_balance" => $current_bal]);
				}
				else if ($data['wallet_type'] == 4)
				{
					Wallet::where('user_id', $data['user_id'])->update(["digi_balance" => $current_bal]);
				}
				else if ($data['wallet_type'] == 5)
				{
					Wallet::where('user_id', $data['user_id'])->update(["vps_balance" => $current_bal]);
				}
				else if ($data['wallet_type'] == 6)
				{
					Wallet::where('user_id', $data['user_id'])->update(["bonus_balance" => $current_bal]);
				}

				return [
					'status' => 'success',
					'message' => 'Successfully Txn.',
					'insertGetId' => $userledger
				];
			}
			else
			{
				return [
					'status' => 'error',
					'message' => 'invalid credentials.',
				];
			}
		}
		else
		{
			return [
				'status' => 'error',
				'message' => 'invalid credentials.',
			];
		}
	}


	public static function send_email($data)
	{
		$message_template = new MessageTemplate();
		$EmailTemp = $message_template->getByTempNameForEmail($data['template_name']);

		if($EmailTemp !== null)
		{
		    $data['content'] = $EmailTemp->content;
		    $data['subject'] = $EmailTemp->subject;
		    $data['pdf'] ='';
			$data['subject'] =  strtr($data['subject'],
						[ 	'{title}' => $data['title'],
							'{name}' => $data['name'],
							'{member_id}' => $data['member_id'],
							'{phone_number}' => $data['phone_number'],
							'{email}'=>$data['email'],
							'{password}'=>$data['password'],
							'{code}'=>$data['code'],
							'{message}'=>$data['message'],
							'{date}'=>$data['date'],
							'{link}'=>$data['link'],
							'{trans_id}'=>$data['trans_id'],
							'{other}'=>$data['other'],
							'{app_url}' => config('app.url'),
							'{app_name}' => config('app.name'),
						]
					);

		    $data['content'] =  strtr($data['content'],
		                        	[   '{title}' => $data['title'],
		                                '{name}' => $data['name'],
		                                '{member_id}' => $data['member_id'],
		                                '{phone_number}' => $data['phone_number'],
		                                '{email}'=>$data['email'],
		                                '{password}'=>$data['password'],
		                                '{code}'=>$data['code'],
		                                '{message}'=>$data['message'],
		                                '{date}'=>$data['date'],
		                                '{link}'=>$data['link'],
		                                '{trans_id}'=>$data['trans_id'],
		                                '{other}'=>$data['other'],
										'{app_url}' => config('app.url'),
										'{app_name}' => config('app.name'),
									]
		                        );


		    if($data['email'] != '')
		    {

		    	$ResponseData = Mail::to($data['email'])->send(new SendMail($data));
		    	//$ResponseData = 1;
		    	Email_log::Insert([
		    						'user_id' => $data['user_id'],
		    						'user_type' => $data['user_type'],
		    						'send_to' => $data['email'],
		    						'subject' => $data['subject'],
		    						'desc' => $data['content'],
		    						'response' => $ResponseData
		    					]);
		    }
		}
	}



	public static function send_sms($data)
	{
		$message_template = new MessageTemplate();
		$SmgTemp =  $message_template->getByTempNameForSMS($data['template_name']);

		if($SmgTemp !== null)
		{
		    $data['content'] = $SmgTemp->content;
		    $data['subject'] = $SmgTemp->subject;
		    $data['pdf'] ='';
			$data['subject'] =  strtr($data['subject'],
				[ 	'{title}' => $data['title'],
					'{name}' => $data['name'],
					'{member_id}' => $data['member_id'],
					'{phone_number}' => $data['phone_number'],
					'{email}'=>$data['email'],
					'{password}'=>$data['password'],
					'{code}'=>$data['code'],
					'{message}'=>$data['message'],
					'{date}'=>$data['date'],
					'{link}'=>$data['link'],
					'{trans_id}'=>$data['trans_id'],
					'{other}'=>$data['other'],
					'{app_url}' => config('app.url'),
					'{app_name}' => config('app.name'),
				]
			);
		    $data['content'] =  strtr($data['content'],
				[	'{title}' => $data['title'],
					'{name}' => $data['name'],
					'{member_id}' => $data['member_id'],
					'{phone_number}' => $data['phone_number'],
					'{email}'=>$data['email'],
					'{password}'=>$data['password'],
					'{code}'=>$data['code'],
					'{message}'=>$data['message'],
					'{date}'=>$data['date'],
					'{link}'=>$data['link'],
					'{trans_id}'=>$data['trans_id'],
					'{other}'=>$data['other'],
					'{app_url}' => config('app.url'),
					'{app_name}' => config('app.name'),
				]
			);
		    
			if($data['phone_number'] != '')
		    {
		    	$ResponseData = 1;
				try {
					$payload = [];
					if($data['template_name'] == 'otp') {
						$payload = [
							'from_phone_number_id' => '',
							'phone_number'         => '91'.$data['phone_number'],
							'template_name'        => $data['template_name'],
							'template_language'    => 'en_US',
							"field_1"    		   => $data['code'],
							"button_0"    		   => $data['code'],
							"copy_code"    		   => $data['code']
						];
					}
					if($data['template_name'] == 'welcome_message') {
						$payload = [
							'from_phone_number_id' => '',
							'phone_number'         => '91'.$data['phone_number'],
							'template_name'        => $data['template_name'],
							'template_language'    => 'en_US',
							"field_1" 			   => $data['name']
						];
					}

					if(count($payload) > 0) {
						$response = Http::withHeaders(['Content-Type' => 'application/json',])->post('https://www.flexgoapi.com/api/01e2c5c8-9929-45a4-a67d-9ff76e713c74/contact/send-template-message?token=HAYYRKiypmUl8haX1smuNh96DMpnSFmyVzuKM3fisk7jmtPqKPdRZog8kFpGGfUD', $payload);
						$ResponseData = json_encode($response->json());
					}

				} catch (\Throwable $th) {
					//throw $th;
				}


		    	SmsLog::Insert([
		    						'user_id' => $data['user_id'],
		    						'user_type' => $data['user_type'],
		    						'send_to' => $data['phone_number'],
		    						'subject' => $data['subject'],
		    						'desc' => $data['content'],
		    						'response' => $ResponseData
		    					]);
		    }
		}
	}



	public static function generate_login_log($request,$user_type,$user='')
	{
		$login_log = new Login_log();
		$response = Browser::detect();
	    unset($request['password']);
        unset($request['_token']);
        if($user == ''){ $user_id = 0; }
        else{ $user_id = $user->id; }

        $ip =$request->ip();
        $data = \Location::get($ip);
        unset($data->driver);
        unset($data->ip);

        $array = [
                    'user_id' => $user_id,
                    'user_type' => $user_type,
                    'request' => json_encode($request->all()),
                    'server' => json_encode($request->server()),
                    'device_info' => json_encode($response),
                    'location' => json_encode($data),
                    'ip_address' => $request->ip()
                ];

        return $login_log->Insert($array);
	}


	public static function sendPushNotification($deviceToken, $title, $body)
	{
		$firebase = new FirebaseService();
	    $response = $firebase->sendMessage($deviceToken,$title,$body);
	    dd(response()->json($response));
    	return response()->json($response);
	}

    public static function newNotification($user,$title,$message){
        return Notifications::insert(['user_id',$user,'title'=> $title,'message'=> $message]);
    }

    


}
