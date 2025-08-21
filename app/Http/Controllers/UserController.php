<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Countrie;
use App\Models\State;
use App\Models\Citie;
use App\Models\User;
use App\Models\Packages;
use App\Models\UserPackage;
use App\Models\OnlinePayment;
use App\Models\Wallet;
use App\Models\Courses;
use App\Models\DocumentType;
use App\Models\BusinessCategory;
use App\Models\UserDocument;
use App\Models\Steps;
use App\Models\UserSteps;
use App\Models\Kyc;
use App\Models\Tasks;
use App\Models\BankDetail;
use App\Models\Address;
use App\Models\Leads;
use App\Models\Loan;
use App\Models\Blog;
use App\Models\Support;
use App\Models\Commissions;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Razorpay\Api\Api;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 1 || Auth::user()->role == 2) {
            $userCount = User::count();
            $userInactiveCount = User::where('status', 'Inactive')->count();

            $packagesCount = Packages::count();
            $packagesInactiveCount = Packages::where('status', 'Inactive')->count();

            $businessCategoryCount = BusinessCategory::count();
            $businessCategoryInactiveCount = BusinessCategory::where('status', 'Inactive')->count();

            $coursesCount = Courses::count();
            $coursesInactiveCount = Courses::where('status', 'Inactive')->count();

            $usersPerRole = User::join('roles', 'users.role', '=', 'roles.id')
                ->select('roles.role_name', \DB::raw('count(*) as count'))
                ->groupBy('roles.role_name')
                ->get();

            $userRoleCount = json_encode([
                'labels' => $usersPerRole->pluck('role_name')->toArray(),
                'series' => $usersPerRole->pluck('count')->toArray(),
                'colors' => [
                    '#0d6efd',
                    '#6610f2',
                    '#d63384',
                    '#ffc107'
                ]
            ]);


            $leadsPerStatus = Leads::select('status', DB::raw('COUNT(*) as count'))
                ->groupBy('status')
                ->get();

            $leadStatusChart = json_encode([
                'labels' => $leadsPerStatus->pluck('status')->toArray(),
                'series' => $leadsPerStatus->pluck('count')->toArray(),
                'colors' => [
                    '#0d6efd',
                    '#198754',
                    '#ffc107',
                    '#dc3545'
                ]
            ]);

            $taskStatuses = ['Pending', 'In Progress', 'Completed', 'Incompleted'];
            $taskCounts = Tasks::select('status', DB::raw('COUNT(*) as count'))
                ->whereIn('status', $taskStatuses)
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
            $taskSeries = array_map(fn($status) => $taskCounts[$status] ?? 0, $taskStatuses);
            $taskChart = json_encode([
                'labels' => $taskStatuses,
                'series' => $taskSeries,
                'colors' => ['#0d6efd', '#ffc107', '#198754', '#dc3545']
            ]);

            // Loans by approval status
            $loanStatuses = ['Pending', 'Approved', 'Sanctioned'];
            $loanCounts = Loan::select('status', DB::raw('COUNT(*) as count'))
                ->whereIn('status', $loanStatuses)
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
            $loanSeries = array_map(fn($status) => $loanCounts[$status] ?? 0, $loanStatuses);
            $loanChart = json_encode([
                'labels' => $loanStatuses,
                'series' => $loanSeries,
                'colors' => ['#ffc107', '#198754', '#dc3545']
            ]);

            // Blogs by status
            $blogStatuses = ['Pending', 'Schedule', 'Publish', 'Unpublish'];
            $blogCounts = Blog::select('status', DB::raw('COUNT(*) as count'))
                ->whereIn('status', $blogStatuses)
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
            $blogSeries = array_map(fn($status) => $blogCounts[$status] ?? 0, $blogStatuses);
            $blogChart = json_encode([
                'labels' => $blogStatuses,
                'series' => $blogSeries,
                'colors' => ['#dc3545', '#6f42c1', '#0d6efd', '#adb5bd']
            ]);

            // Support tickets by status
            $supportStatuses = ['Pending', 'Open', 'Closed'];
            $supportCounts = Support::select('status', DB::raw('COUNT(*) as count'))
                ->whereIn('status', $supportStatuses)
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
            $supportSeries = array_map(fn($status) => $supportCounts[$status] ?? 0, $supportStatuses);
            $supportChart = json_encode([
                'labels' => $supportStatuses,
                'series' => $supportSeries,
                'colors' => ['#0dcaf0', '#ffc107', '#198754']
            ]);

            // User Packages by plan type
            $userRCount = User::where('role', 4)->count();
            $userPackageCount = UserPackage::count();
            $planChart = json_encode([
                'labels' => ['Buy', 'Not Buy'],
                'series' => [$userPackageCount, $userRCount],
                'colors' => ['#fd7e14', '#6610f2']
            ]);

            $verifiedUserIds = UserDocument::select('user_id')
                ->whereNull('deleted_at')
                ->where('status', 'Approved')
                ->groupBy('user_id')
                ->pluck('user_id')
                ->toArray();

            $totalDocUsers = UserDocument::select('user_id')
                ->whereNull('deleted_at')
                ->groupBy('user_id')
                ->pluck('user_id')
                ->toArray();

            $verifiedCount = count($verifiedUserIds);
            $notVerifiedCount = count(array_diff($totalDocUsers, $verifiedUserIds));

            $documentVerificationChart = json_encode([
                'labels' => ['Verified', 'Not Verified'],
                'series' => [$verifiedCount, $notVerifiedCount],
                'colors' => ['#198754', '#dc3545']
            ]);


            return view('dashboard.admin', compact('documentVerificationChart', 'taskChart', 'loanChart', 'blogChart', 'supportChart', 'planChart', 'leadStatusChart', 'userCount', 'userInactiveCount', 'packagesCount', 'packagesInactiveCount', 'businessCategoryCount', 'businessCategoryInactiveCount', 'coursesCount', 'coursesInactiveCount', 'userRoleCount'));
        } elseif (Auth::user()->role == 4) {

            $steps = UserSteps::where('user_id', Auth::user()->id)->orderBy('order', 'asc')->get();
            $package = UserPackage::with('business_category')->where('user_id', Auth::user()->id)->whereNull('deleted_at')->first();

            return view('dashboard.user', compact('steps', 'package'));
        } elseif (Auth::user()->role == 3) {

            $leadCounts = Leads::select('status', DB::raw('count(*) as total'))
                ->where('assigned_to', Auth::id())
                ->whereIn('status', ['Pending', 'Prospecting', 'Converted', 'Closed'])
                ->groupBy('status')
                ->pluck('total', 'status');

            $taskCounts = Tasks::select('status', DB::raw('count(*) as total'))
                ->where('user_id', Auth::id())
                ->whereIn('status', ['Completed', 'Incompleted', 'In Progress', 'Pending'])
                ->groupBy('status')
                ->pluck('total', 'status');



            return view('dashboard.employee', compact('taskCounts', 'leadCounts'));
        } elseif (Auth::user()->role == 5) {

            $loanStatusCounts = Loan::select('status', DB::raw('count(*) as total'))
                ->where('employee_id', Auth::id())
                ->whereIn('status', ['Pending', 'Approved', 'Sanctioned'])
                ->groupBy('status')
                ->pluck('total', 'status');

            $loanSums = Loan::select(
                DB::raw('SUM(commission_amount) as total_commission'),
                DB::raw('SUM(amount) as total_amount')
            )
                ->where('employee_id', Auth::id())
                ->where('status', 'Sanctioned')
                ->first();

            return view('dashboard.bank', compact('loanStatusCounts', 'loanSums'));
        }
    }


    public function profile(Request $request)
    {
        $user = User::with(['address', 'address.country', 'address.state', 'address.city', 'kyc', 'bank', 'bank.bank'])->where('id', Auth::user()->id)->first();

        $countries = Countrie::all();
        $banks = Bank::all();

        if ($request->method() == 'POST') {
            $request->validate([
                'fullname'         => 'required|string|max:255',
                'father_name'      => 'nullable|string|max:255',
                'mother_name'      => 'nullable|string|max:255',
                'dob'              => 'required|date|before:today',
                'gender'           => 'required|in:Male,Female,Other',
                'country'          => 'required|integer|exists:countries,id',
                'state'            => 'required|integer|exists:states,id',
                'city'             => 'required|integer|exists:cities,id',
                'zipcode'          => 'required|digits_between:4,10',
                'address'          => 'required|string|max:500',
                'bank'             => 'required|integer|exists:banks,id',
                'account_number'   => 'required|digits_between:8,20',
                'ifsc'             => 'required',
                'profile_image'    => 'nullable|mimes:jpg,jpeg,png|max:2048',
                'proof_type'       => 'required',
                'identification_number'       => 'required',
                'identification_image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            ], [
                'fullname.required' => 'Full name is required.',

                'dob.required' => 'Date of birth is required.',
                'dob.before' => 'Date of birth must be before today.',

                'gender.required' => 'Gender is required.',
                'gender.in' => 'Gender must be Male, Female or Other.',

                'country.required' => 'Country selection is required.',
                'country.exists' => 'Selected country is invalid.',
                'state.required' => 'State selection is required.',
                'state.exists' => 'Selected state is invalid.',
                'city.required' => 'City selection is required.',
                'city.exists' => 'Selected city is invalid.',

                'zipcode.required' => 'Zipcode is required.',
                'zipcode.digits_between' => 'Zipcode must be between 4 to 10 digits.',

                'address.required' => 'Address is required.',

                'bank.required' => 'Bank selection is required.',
                'bank.exists' => 'Selected bank is invalid.',
                'account_number.required' => 'Account number is required.',
                'account_number.digits_between' => 'Account number must be between 8 to 20 digits.',

                'ifsc.required' => 'IFSC code is required.',
                'ifsc.regex' => 'IFSC code format is invalid.',

                // 'profile_image.required' => 'Profile image is required.',
                'profile_image.image' => 'The file must be an image.',
                'profile_image.mimes' => 'Image must be in jpg, jpeg, or png format.',
                'profile_image.max' => 'Image size must not exceed 2MB.',

                'proof_type.required' => 'Proof TYpe is required',
                'identification_number.required' => 'Identification Type required',
                'identification_image.required' => 'Identification image is required.',
                'identification_image.image' => 'The file must be an image.',
                'identification_image.mimes' => 'Image must be in jpg, jpeg, or png format.',
                'identification_image.max' => 'Image size must not exceed 2MB.'

            ]);

            //user data
            $userData = [
                'name' => $request->fullname,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'gender' => $request->gender,
                'dob' => $request->dob
            ];

            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $profile_image = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('profile_images'), $profile_image);
                $userData['image'] = $profile_image;
            }


            User::where('id', Auth::user()->id)->update($userData);

            //kyc details
            $kycData = [
                'user_id' => Auth::user()->id,
                'id_proof_type' => $request->proof_type,
                'id_proof_no' => $request->identification_number
            ];

            $identification_image = null;

            if ($request->hasFile('identification_image')) {
                $image = $request->file('identification_image');
                $identification_image = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('identification_images'), $identification_image);
                $kycData['id_proof_img'] = $identification_image;
            }

            Kyc::where('user_id', Auth::user()->id)->update($kycData);


            //bank details
            BankDetail::where('user_id', Auth::user()->id)->update([
                'bank_id' => $request->bank,
                'user_name_at_bank' => $request->account_number,
                'account_number' => $request->account_number,
                'ifscode' => $request->ifsc
            ]);

            //address details
            Address::where('user_id', Auth::user()->id)->update([
                'address' => $request->address,
                'city_id' => $request->city,
                'state_id' => $request->state,
                'country_id' => $request->country,
                'zip' => $request->zipcode
            ]);

            return to_route('view_profile');
        }

        return view('account.profile', compact('user', 'countries', 'banks'));
    }

    public function edit_profile()
    {
        $user = User::with(['address', 'address.country', 'address.state', 'address.city', 'kyc', 'bank', 'bank.bank'])->where('id', auth()->user()->id)->first();
        return view('account.edit_profile', compact('user'));
    }

    public function change_password(Request $request)
    {

       if($request->method() == 'POST'){
            $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Please enter a new password.',
            'password.string' => 'The new password must be a valid string.',
            'password.min' => 'The new password must be at least 8 characters long.',
            'password.confirmed' => 'The new password and confirmation do not match.',
        ]);

        $update = User::where('id',Auth::user()->id)->update(['password'=>Hash::make($request->password)]);
        return to_route('change_password')->with(['status'=>'success','message'=>'Password Updated']);
       }


        return view('account.chnage_password');
    }

    public function notifications()
    {
        $user = User::with(['address', 'address.country', 'address.state', 'address.city', 'kyc', 'bank', 'bank.bank'])->where('id', auth()->user()->id)->first();
        return view('account.notifications', compact('user'));
    }

    public function business_plan()
    {
        $user = User::with(['address', 'address.country', 'address.state', 'address.city', 'kyc', 'bank', 'bank.bank'])->where('id', auth()->user()->id)->first();
        return view('account.business_plan', compact('user'));
    }






    public function userList($type, Request $request)
    {

        $roleMap = config('app.roles');
        $user_type = $roleMap[$type] ?? null;

        if (!$user_type) {
            return back();
        }

        if ($request->ajax()) {
            $query = User::where('role', $user_type);

            if ($request->has('name') && !empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->has('email') && !empty($request->email)) {
                $query->where('email', 'like', '%' . $request->email . '%');
            }


            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    if ($row->status == 'Active') {
                        return '<span class="badge bg-success">Active</span>';
                    } elseif ($row->status == 'Inactive') {
                        return '<span class="badge bg-danger">Inactive</span>';
                    } else {
                        return '<span class="badge bg-secondary">' . $row->status . '</span>';
                    }
                })
                ->addColumn('action', function ($row) {



                    return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="icon-base ti tabler-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('view_user', [$row->id]) . '"
                                ><i class="icon-base ti tabler-eye me-1"></i> View</a
                              >
                              <a class="dropdown-item" href="' . route('edit_user', [$row->role, $row->id]) . '"
                                ><i class="icon-base ti tabler-pencil me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);" onclick="deleteUser(' . $row->id . ')"
                                ><i class="icon-base ti tabler-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>';
                    // return '<a href="' . route('users.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                    // return '<a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen"></i> Edit</a>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('users_list.view', compact('type'));
    }


    public function viewUser($id)
    {
        $user = User::with(['address', 'address.country', 'address.state', 'address.city', 'kyc', 'bank', 'bank.bank'])->where('id', $id)->first();
        return view('users_list.single', compact('user'));
    }


    public function addUsers($type, Request $request)
    {
        $countries = Countrie::where('status', 'Active')->get();
        $banks = Bank::where('status', 'Active')->get();
        $vendors = User::with(['roles'])->whereIn('role', [5,1])->get(['id','name']);

        if ($request->method() == 'POST') {

            $request->validate([
                'fullname'         => 'required|string|max:255',
                'email'            => 'required|email|unique:users,email',
                'phone'            => 'required|digits:10',
                'father_name'      => 'nullable|string|max:255',
                'mother_name'      => 'nullable|string|max:255',
                'password'         => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                ],
                'dob'              => 'required|date|before:today',
                'gender'           => 'required|in:Male,Female,Other',
                'country'          => 'required|integer|exists:countries,id',
                'state'            => 'required|integer|exists:states,id',
                'city'             => 'required|integer|exists:cities,id',
                'zipcode'          => 'required|digits_between:4,10',
                'address'          => 'required|string|max:500',
                'bank'             => 'required|integer|exists:banks,id',
                'account_number'   => 'required|digits_between:8,20',
                'ifsc'             => 'required',
                'profile_image'    => 'nullable|mimes:jpg,jpeg,png|max:2048',
                'proof_type'       => 'required',
                'identification_number'       => 'required',
                'identification_image'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'parent_id' =>'nullable|required_if:type,employee'

            ], [
                'fullname.required' => 'Full name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already taken.',
                'phone.required' => 'Phone number is required.',
                'phone.digits' => 'Phone number must be 10 digits.',

                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.regex' => 'Password must contain uppercase, lowercase, number, and special character.',

                'dob.required' => 'Date of birth is required.',
                'dob.before' => 'Date of birth must be before today.',

                'gender.required' => 'Gender is required.',
                'gender.in' => 'Gender must be Male, Female or Other.',

                'country.required' => 'Country selection is required.',
                'country.exists' => 'Selected country is invalid.',
                'state.required' => 'State selection is required.',
                'state.exists' => 'Selected state is invalid.',
                'city.required' => 'City selection is required.',
                'city.exists' => 'Selected city is invalid.',

                'zipcode.required' => 'Zipcode is required.',
                'zipcode.digits_between' => 'Zipcode must be between 4 to 10 digits.',

                'address.required' => 'Address is required.',

                'bank.required' => 'Bank selection is required.',
                'bank.exists' => 'Selected bank is invalid.',
                'account_number.required' => 'Account number is required.',
                'account_number.digits_between' => 'Account number must be between 8 to 20 digits.',

                'ifsc.required' => 'IFSC code is required.',
                'ifsc.regex' => 'IFSC code format is invalid.',

                // 'profile_image.required' => 'Profile image is required.',
                'profile_image.image' => 'The file must be an image.',
                'profile_image.mimes' => 'Image must be in jpg, jpeg, or png format.',
                'profile_image.max' => 'Image size must not exceed 2MB.',

                'proof_type.required' => 'Proof TYpe is required',
                'identification_number.required' => 'Identification Type required',
                'identification_image.required' => 'Identification image is required.',
                'identification_image.image' => 'The file must be an image.',
                'identification_image.mimes' => 'Image must be in jpg, jpeg, or png format.',
                'identification_image.max' => 'Image size must not exceed 2MB.',

                'parent_id.required_if' => 'Parent is Required'

            ]);

            $roleMap = config('app.roles');

            $user_type = $roleMap[$type] ?? null;

            if (!$user_type) {
                return back();
            }

            $profile_image = null;
            $identification_image = null;

            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $profile_image = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('profile_images'), $profile_image);
            }

            if ($request->hasFile('identification_image')) {
                $image = $request->file('identification_image');
                $identification_image = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('identification_images'), $identification_image);
            }

            $steps = Steps::where('status', 'Active')->get();

            try {

                DB::beginTransaction();

                $userData = [
                    'code' => config('app.shortname') . rand(0000000, 9999999),
                    'name' => $request->fullname,
                    'email' => $request->email,
                    'father_name' => $request->father_name,
                    'mother_name' => $request->mother_name,
                    'role' => $user_type,
                    'parent_id' => 0,
                    'referral_id' => 0,
                    'phone_number' => $request->phone,
                    'gender' => $request->gender,
                    'password' => Hash::make($request->password),
                    'image' => $profile_image,
                    'dob' => $request->dob
                ];

                if($type == 'employee'){
                    $userData['parent_id'] = $request->parent_id;
                }

                $user = User::create($userData);

                Wallet::create([
                    'user_id' => $user->id
                ]);

                Kyc::create([
                    'user_id' => $user->id,
                    'id_proof_type' => $request->proof_type,
                    'id_proof_no' => $request->identification_number,
                    'id_proof_img' => $identification_image
                ]);

                BankDetail::create([
                    'user_id' => $user->id,
                    'bank_id' => $request->bank,
                    'user_name_at_bank' => $request->account_number,
                    'account_number' => $request->account_number,
                    'ifscode' => $request->ifsc
                ]);

                Address::create([
                    'user_id' => $user->id,
                    'address' => $request->address,
                    'city_id' => $request->city,
                    'state_id' => $request->state,
                    'country_id' => $request->country,
                    'zip' => $request->zipcode
                ]);


                foreach ($steps as $step) {
                    UserSteps::insert([
                        'user_id' => $user->id,
                        'step' => $step->title,
                        'order' => $step->order,
                        'icon' => $step->icon
                    ]);
                }

                DB::commit();
                return to_route('user_list', [$type])->with(['status' => 'success', 'message' => 'User create successfuly.']);
            } catch (\Exception $e) {
                DB::rollBack();
                // return 'Error: ' . $e->getMessage();
                return back();
            }
        }

        return view('users_list.add', compact('type', 'countries', 'banks','vendors'));
    }

    public function editUser($type, $id, Request $request)
    {
        $user = User::with(['address', 'kyc', 'bank'])->where('id', $id)->first();
        $countries = Countrie::where('status', 'Active')->get();
        $banks = Bank::where('status', 'Active')->get();
        $vendors = User::with(['roles'])->whereIn('role', [5,1])->get(['id','name']);

        if ($request->method() == 'POST') {


            $request->validate([
                'fullname'         => 'required|string|max:255',
                'email'            => 'required|email|unique:users,email,' . $id,
                'phone'            => 'required|digits:10',
                'father_name'      => 'nullable|string|max:255',
                'mother_name'      => 'nullable|string|max:255',
                'password'         => [
                    'nullable',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                ],
                'dob'              => 'required|date|before:today',
                'gender'           => 'required|in:Male,Female,Other',
                'country'          => 'required|integer|exists:countries,id',
                'state'            => 'required|integer|exists:states,id',
                'city'             => 'required|integer|exists:cities,id',
                'zipcode'          => 'required|digits_between:4,10',
                'address'          => 'required|string|max:500',
                'bank'             => 'required|integer|exists:banks,id',
                'account_number'   => 'required|digits_between:8,20',
                'ifsc'             => 'required',
                'profile_image'    => 'nullable|mimes:jpg,jpeg,png|max:2048',
                'proof_type'       => 'required',
                'identification_number'       => 'required',
                'identification_image'       => 'nullable|mimes:jpg,jpeg,png|max:2048',
                'parent_id' =>'nullable|required_if:type,3'


            ], [
                'fullname.required' => 'Full name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already taken.',
                'phone.required' => 'Phone number is required.',
                'phone.digits' => 'Phone number must be 10 digits.',

                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.regex' => 'Password must contain uppercase, lowercase, number, and special character.',

                'dob.required' => 'Date of birth is required.',
                'dob.before' => 'Date of birth must be before today.',

                'gender.required' => 'Gender is required.',
                'gender.in' => 'Gender must be Male, Female or Other.',

                'country.required' => 'Country selection is required.',
                'country.exists' => 'Selected country is invalid.',
                'state.required' => 'State selection is required.',
                'state.exists' => 'Selected state is invalid.',
                'city.required' => 'City selection is required.',
                'city.exists' => 'Selected city is invalid.',

                'zipcode.required' => 'Zipcode is required.',
                'zipcode.digits_between' => 'Zipcode must be between 4 to 10 digits.',

                'address.required' => 'Address is required.',

                'bank.required' => 'Bank selection is required.',
                'bank.exists' => 'Selected bank is invalid.',
                'account_number.required' => 'Account number is required.',
                'account_number.digits_between' => 'Account number must be between 8 to 20 digits.',

                'ifsc.required' => 'IFSC code is required.',
                'ifsc.regex' => 'IFSC code format is invalid.',

                // 'profile_image.required' => 'Profile image is required.',
                'profile_image.image' => 'The file must be an image.',
                'profile_image.mimes' => 'Image must be in jpg, jpeg, or png format.',
                'profile_image.max' => 'Image size must not exceed 2MB.',

                'proof_type.required' => 'Proof TYpe is required',
                'identification_number.required' => 'Identification Type required',
                'identification_image.required' => 'Identification image is required.',
                'identification_image.image' => 'The file must be an image.',
                'identification_image.mimes' => 'Image must be in jpg, jpeg, or png format.',
                'identification_image.max' => 'Image size must not exceed 2MB.',

                'parent_id.required_if' => 'Parent is Required'
            ]);

            $roleMap = config('app.roles');

            $user_type = array_search($type, $roleMap);;

            // if (!$user_type) {
            //     return back();
            // }

            $profile_image = null;
            $identification_image = null;

            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $profile_image = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('profile_images'), $profile_image);
            }

            if ($request->hasFile('identification_image')) {
                $image = $request->file('identification_image');
                $identification_image = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('identification_images'), $identification_image);
            }

            try {

                DB::beginTransaction();

                $user = User::find($id);
                $user->name = $request->fullname;
                $user->phone_number = $request->phone;
                $user->father_name = $request->father_name;
                $user->mother_name = $request->mother_name;
                $user->password = Hash::make($request->password);
                $user->image = $profile_image;
                $user->gender = $request->gender;
                $user->dob = $request->dob;

                if($type == 3){
                    $user->parent_id = $request->parent_id;
                }

                $user->update();

                Kyc::where('user_id', $user->id)->update([
                    'id_proof_type' => $request->proof_type,
                    'id_proof_no' => $request->identification_number,
                    'id_proof_img' => $identification_image
                ]);

                BankDetail::where('user_id', $user->id)->update([
                    'bank_id' => $request->bank,
                    'user_name_at_bank' => $request->account_number,
                    'account_number' => $request->account_number,
                    'ifscode' => $request->ifsc
                ]);

                Address::where('user_id', $user->id)->update([
                    'address' => $request->address,
                    'city_id' => $request->city,
                    'state_id' => $request->state,
                    'country_id' => $request->country,
                    'zip' => $request->zipcode
                ]);


                DB::commit();

                return to_route('user_list', [$user_type])->with(['status' => 'success', 'message' => 'User updated successfuly.']);
            } catch (\Exception $e) {
                DB::rollBack();
                // dd($e->getMessage());
                // return 'Error: ' . $e->getMessage();
                return back()->withInput();
            }
        }

        return view('users_list.edit', compact('user', 'countries', 'banks', 'type','vendors'));
    }

    public function statusUser($id)
    {
        $user = User::find($id);
        $user->status = $user->status === 'Active' ? 'Inactive' : 'Active';
        $user->save();
    }


    public function userPackageList(Request $request)
    {
        if ($request->ajax()) {
            $query = UserPackage::with(['package', 'user', 'business_category'])->where('deleted_at', null);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="icon-base ti tabler-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="' . route('edit_user_package', [$row->id]) . '"><i class="icon-base ti tabler-pencil me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);" onclick="deletePackage(' . $row->id . ')"
                                ><i class="icon-base ti tabler-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user_package.view');
    }

    public function addUserPackage(Request $request)
    {


        $users = User::where(['role' => 4, 'status' => 'Active'])->orderBy('name', 'asc')->get();
        $categories = BusinessCategory::where(['status' => 'Active'])->get();

        if ($request->method() == 'POST') {

            $request->validate([
                'business_category' => 'required',
                'user'            => 'required'
            ], [
                'business_category.required' => 'Business Category Required',
                'user.required' => 'User is required'
            ]);

            $check = UserPackage::where(['business_category_id' => $request->business_category, 'user_id' => $request->user])->exists();

            if ($check) {
                return back()->with(['status' => 'error', 'message' => 'Package already exists on User']);
            }

            $category = BusinessCategory::where(['status' => 'Active', 'id' => $request->business_category])->first();
            $package = Packages::find($category->package_id);



            $data = [
                'user_id' => $request->user,
                'package_id' => $category->package_id,
                'business_category_id' => $request->business_category,
                'amount' => $package->amount,
                'added_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id
            ];

            $insert = UserPackage::insert($data);


            $documentTypes = DocumentType::whereIn('id', explode(',', $request->business_category))->get();


            foreach ($documentTypes as $documentType) {

                $data = [
                    'user_id' => Auth::user()->id,
                    'document_type_id' => $documentType->id,
                    'name' => '',
                    'package_id' => $category->package_id,
                    'business_category_id' => $request->business_category,
                    'path' => '',
                    'added_by' => Auth::user()->id
                ];

                UserDocument::insert($data);
            }

            if ($insert) {

                $lead = Leads::where(['user_id' => $request->user])->first();
                if ($lead) {
                    $commissionData = [
                        'type' => 'Package',
                        'user_id' => $request->user,
                        'package_id' => $package->id,
                        'employee_id' => $lead->assigned_to,
                        'amount' => $package->comission_amount
                    ];

                    Commissions::insert($commissionData);

                    $check = Helper::creadit_ledger([
                        "user_id" => $lead->assigned_to,
                        "refrence_id" => $request->user,
                        "amount" => (float)$package->comission_amount,
                        "trans_id" => Helper::getTransId(3),
                        "cgst" => 0,
                        "sgst" => 0,
                        "ledger_type" => 'WALLET CREDIT',
                        "wallet_type" => 1,
                        "trans_from" => 'Wallet',
                        "description" => 'Credited For Package Amount'
                    ]);
                }
            }

            return to_route('user_package_list')->with(['status' => 'success', 'message' => 'Package Added Successfully']);
        }

        return view('user_package.add', compact('users', 'categories'));
    }

    public function editUserPackage($id, Request $request)
    {

        $userPackage = UserPackage::find($id);
        $categories = BusinessCategory::where(['status' => 'Active'])->get();


        if ($request->method() == 'POST') {

            $request->validate([
                'business_category'         => 'required'
            ], [
                'business_category.required' => 'Business Category is required'
            ]);

            $category = BusinessCategory::where(['status' => 'Active', 'id' => $request->business_category])->first();
            $package = Packages::find($category->package_id);


            $data = [
                'package_id' => $package->id,
                'business_category_id' => $request->business_category,
                'amount' => $package->amount,
                'updated_by' => Auth::user()->id
            ];

            $insert = UserPackage::where('id', $id)->update($data);

            return to_route('user_package_list')->with(['status' => 'success', 'message' => 'Package Updated Successfully']);
        }

        return view('user_package.edit', compact('categories', 'userPackage'));
    }

    public function statusUserPackage($id)
    {
        $delete = UserPackage::where('id', $id)->update(['deleted_at' => now()]);
    }

    public function commission(Request $request)
    {

        if ($request->ajax()) {
            $query = Commissions::with(['package', 'user', 'employee'])->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->make(true);
        }



        return view('commission.view');
    }

    public function userStep(Request $request)
    {

        $message = 'Enter User Code Or Phone Number To Search';
        $steps = [];
        $searchParam = '';
        if ($request->method() == "POST") {
            $searchParam = $request->code;
            $user = User::where('code', $searchParam)->orWhere('phone_number', $searchParam)->where('role', 4)->first('id');

            if (isset($user) && !empty($user)) {
                $steps = UserSteps::with('user')->where('user_id', $user->id)->orderBy('order', 'asc')->get();
            } else {
                $message = 'User Not Found';
            }
        }

        return view('users_steps.view', compact('message', 'steps', 'searchParam'));
    }

    public function editStep($id)
    {
        $update = UserSteps::where('id', $id)->update(['status' => 'Completed']);
    }

    public function packagesList()
    {
        $packages = BusinessCategory::with('package')->where('status', 'active')->get();
        $userPackage = UserPackage::with('business_category')->where(['user_id' => Auth::user()->id])->whereNull('deleted_at')->first();
        foreach ($packages as $package) {
            $isActive = 0;
            if (isset($userPackage->business_category_id) && $package->id == $userPackage->business_category_id) {
                $isActive = 1;
            }
            $package->isActive = $isActive;
        }
        return view('user_package_list', compact('packages', 'userPackage'));
    }

    public function userDocumentsList(Request $request)
    {

        $userDocuments = UserDocument::with('document_type')->where('user_id', Auth::user()->id)->get();

        if ($request->method() == 'POST') {

            $request->validate([
                'document_id'   => 'required',
                'name'            => 'required',
                'file_upload'     => 'required'
            ], [
                'document_id.required' => 'Please select a document id.',
                'name.required'          => 'Please enter the document name.',
                'file_upload.required'   => 'Please upload a file.'
            ]);

            $uploadDocument = UserDocument::where('id', $request->document_id)->first();

            $file = $request->file('file_upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('user_documents'), $filename);

            $uploadDocument->name = $request->name;
            $uploadDocument->path = $filename;
            $uploadDocument->added_by = Auth::user()->id;
            $uploadDocument->save();

            return back()->with(['status' => 'success', 'message' => 'Uploaded Successfully']);
        }
        return view('user_documents_list', compact('userDocuments'));
    }

    public function userCoursesList()
    {

        $package = UserPackage::where('user_id', Auth::user()->id)->whereNull('deleted_at')->latest()->first(['package_id', 'business_category_id']);
        $courses = [];

        if ($package) {
            $businessCategory = BusinessCategory::where(['id' => $package->business_category_id, 'status' => 'Active'])->pluck('id')->toArray();
            if ($businessCategory) {
                $courses = Courses::whereIn('business_category_id', $businessCategory)->where('status', 'Active')->get();
            }
        }

        return view('courses.user_courses', compact('courses'));
    }

    public function buyPackage(Request $request)
    {

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $payment = $api->payment->fetch($request->input('razorpay_payment_id'));
        $createOnlinePayment = OnlinePayment::insertGetId([
            'user_id' => Auth::user()->id,
            'gateway_order_id' => $request->input('razorpay_payment_id'),
            'gateway_request' => json_encode($request->all())
        ]);

        $updateOnlinePaymentData = [
            'amount' => $payment->amount / 100,
            'gateway_response' => json_encode($payment)
        ];

        if ($payment->capture(['amount' => $payment->amount])) {

            $updateOnlinePaymentData['status'] = 'Completed';
            OnlinePayment::where('id', $createOnlinePayment)->update($updateOnlinePaymentData);

            $updateUserPackage = UserPackage::where('user_id', Auth::user()->id)->update(['deleted_at' => now()]);

            $createUserPackage = UserPackage::insert([
                'user_id' => Auth::user()->id,
                'package_id' => $request->package_id,
                'business_category_id' => $request->business_id,
                'amount' => $payment->amount / 100,
                'added_by'  => Auth::user()->id
            ]);

            $businessCategory = BusinessCategory::where('id', $request->business_id)->first();
            $documentTypes = DocumentType::whereIn('id', explode(',', $businessCategory->document_type))->get();


            foreach ($documentTypes as $documentType) {

                $data = [
                    'user_id' => Auth::user()->id,
                    'document_type_id' => $documentType->id,
                    'name' => '',
                    'package_id' => $request->package_id,
                    'business_category_id' => $request->business_id,
                    'path' => '',
                    'added_by' => Auth::user()->id
                ];

                UserDocument::insert($data);
            }


            return redirect()->back()->with(['status' => 'success', 'message' => 'Payment Successfull']);
        } else {
            $updateOnlinePaymentData['status'] = 'Failed';
            OnlinePayment::where('id', $createOnlinePayment)->update($updateOnlinePaymentData);
        }



        return redirect()->back()->with(['status' => 'error', 'message' => 'Payment Failed!']);
    }


    public function readNotifications()
    {
        Notifications::where(['user_id' => Auth::user()->id])->whereNull('read_at')->update(['read_at' => now()]);
        return back();
    }
}
