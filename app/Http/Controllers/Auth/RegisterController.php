<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kyc;
use App\Models\Wallet;
use App\Models\Address;
use App\Models\Steps;
use App\Helpers\Helper;
use App\Models\BankDetail;
use App\Models\UserSteps;
use App\Models\UsersRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showRegistrationForm()
    {
        // $var = "3";
        // dd(Helper::shortEncrypt($var));
        // $type = Helper::shortDecrypt(request()->type);

        // $typeError = false;
        // if((int)$type != 2 && (int)$type != 3) {
        //     $typeError = true;

        // }

        // $referral = '';
        // if(request()->referral != ''){
        //     // $referral = Helper::shortDecrypt(request()->referral);
        //     $referral = request()->query('referral_code');
        // }
        // dd($referral);

        session()->forget(['otp', 'otp_phone', 'otp_expires_at']);
        return view('auth.register');
    }

    public function registerVerification()
    {
        if (!session('otp') || !session('otp_phone') || now()->gt(session('otp_expires_at'))
        ) {
            session()->forget(['otp', 'otp_phone', 'otp_expires_at']);
            return redirect()->route('register')->withErrors(['name' => 'expired OTP.'])->withInput();
        }

        $data = UsersRequest::where('phone_number', session('otp_phone'))->where('opt_active', 'No')->latest()->first();
        if($data) {
            return view('auth.verify-register');
        } else {
            session()->forget(['otp', 'otp_phone', 'otp_expires_at']);
            return redirect()->route('register')->withErrors(['name' => 'expired OTP.'])->withInput();
        }
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['code'] = config('app.shortname').rand(0000000,9999999);
        $data['role'] = 4;//request()->role_id;
        $referral = (string)request()->referral_code;
        $user = User::where('code', $referral)->first();
        $data['referral_id'] = $user->id??1;

        request()->merge(['code' => $data['code']]);
        request()->merge(['role' => $data['role']]);
        request()->merge(['referral_id' => $data['referral_id']]);

        return Validator::make($data, [
            'code' => ['required', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'role' => ['required', 'in:2,3'],
            'terms' => ['required'],
        ],[
            'phone_number.regex' => 'Please enter a valid 10-digit Indian mobile number.'
        ]);
    }


     // Request OTP (Step 1)
    public function registerOtp(Request $request)
    {
        $this->validator($request->all())->validate();

        $otp = rand(100000, 999999);

        $userRequest = UsersRequest::create([
            'reg_number' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'phonecode' => '+91',
            'phone_number' => $request->phone_number,
            'password' => $request->password,
            'role' => $request->role,
            'referral_id' => $request->referral_id,
            'inteducior_id' => $request->referral_id,
            'user_otp' => $otp,
            'device_id' => $request->device_id ?? null,
            'opt_active' => 'No',
            'country' => $request->country ?? null,
            'state' => $request->state ?? null,
            'city' => $request->city ?? null,
        ]);

        if($userRequest) {
            
            Helper::send_sms([   
                    'template_name' =>  'otp',
                    'user_id'       =>  0,
                    'user_type'     =>  'User',
                    'title'         =>  'Send OTP',
                    'name'          =>  $request->name,
                    'member_id'     =>  $request->code,
                    'phone_number'  =>  $request->phone_number,
                    'email'         =>  $request->email,
                    'password'      =>  $request->password,
                    'code'          =>  $otp,
                    'message'       =>  '',
                    'date'          =>  '',
                    'link'          =>  '',
                    'trans_id'      =>  '',
                    'other'         =>  ''
                ]); 

            session([
                'otp' => $otp,
                'otp_phone' => $request->phone_number,
                'otp_expires_at' => now()->addMinutes(10),
            ]);

            return redirect()->route('register.verification');
        } else {
            return back()->withErrors(['name' => 'invalid request.'])->withInput();
        }
    }

     // Submit Registration (Step 2)
    public function register(Request $request)
    {
        $requestData = UsersRequest::where('phone_number', session('otp_phone'))->where('opt_active', 'No')->latest()->first();
        
        if($requestData) {

            if ($request->otp != $requestData->user_otp) {
                return back()->withErrors(['otp' => 'Invalid or expired OTP.'])->withInput();
            }
            
            $data = [
                "code" => $requestData['reg_number'],
                "name" => $requestData['name'],
                "email" => $requestData['email'],
                "phone_number" => $requestData['phone_number'],
                "password" => $requestData['password'],
                "role" => $requestData['role'],
                "referral_id" => $requestData['referral_id'],
                "parent_id" => $requestData['inteducior_id'],
            ];

            Validator::make($data, [
                'code' => ['required', 'unique:users'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone_number' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                // 'role' => ['required', 'in:2,3'],
                'terms' => ['required'],
            ],[
                'phone_number.regex' => 'Please enter a valid 10-digit Indian mobile number.'
            ]);

            // Create user
            event(new Registered($user = $this->create($data)));
            Auth::login($user);
            UsersRequest::where('phone_number', session('otp_phone'))->update(['opt_active' => 'Yes']);
            // Clear OTP session
            session()->forget(['otp', 'otp_phone', 'otp_expires_at']);
            return redirect('/dashboard');

        } else {
            session()->forget(['otp', 'otp_phone', 'otp_expires_at']);
            return redirect()->route('register')->withErrors(['name' => 'expired OTP.'])->withInput();
        }
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'parent_id' => $data['referral_id'],
            'referral_id' => $data['referral_id'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
        ]);

        if($user) {

            $steps = Steps::where('status', 'Active')->get();

            Wallet::create(['user_id' => $user->id]);
            Kyc::create(['user_id' => $user->id]);
            BankDetail::create(['user_id' => $user->id]);
            Address::create(['user_id' => $user->id]);

            foreach ($steps as $step) {
                UserSteps::insert([
                    'user_id' => $user->id,
                    'step' => $step->title,
                    'order' => $step->order,
                    'icon' => $step->icon
                ]);
            }

            Helper::send_sms([   
                'template_name' =>  'welcome_message',
                'user_id'       =>  0,
                'user_type'     =>  'User',
                'title'         =>  'Welcome Message',
                'name'          =>  $data['name'],
                'member_id'     =>  $data['code'],
                'phone_number'  =>  $data['phone_number'],
                'email'         =>  $data['email'],
                'password'      =>  $data['password'],
                'code'          =>  '',
                'message'       =>  '',
                'date'          =>  '',
                'link'          =>  '',
                'trans_id'      =>  '',
                'other'         =>  ''
            ]); 
        }

        return $user;
    }

    protected function redirectTo()
    {
        // if (auth()->user()->role == 1) {

        // } elseif (auth()->user()->role == 2 || auth()->user()->role == 3) {
        //     return '/home';
        // }
        return redirect('/dashboard');

        // Auth::logout();
        // return redirect('/login');
    }
}
