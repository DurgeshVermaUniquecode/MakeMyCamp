<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\Leads;
use App\Models\Tasks;
use App\Models\User;
use App\Models\Steps;
use App\Models\DocumentType;
use App\Models\UserPackage;
use App\Models\UserDocument;
use App\Models\BusinessCategory;
use App\Models\Wallet;
use App\Models\Kyc;
use App\Models\BankDetail;
use App\Models\Address;
use App\Models\UserSteps;
use App\Models\Notifications;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CRMController extends Controller
{
    public function leadsList(Request $request)
    {
        $employees = User::where(['role' => 3, 'status' => 'Active'])->get(['id', 'name']);

        if ($request->ajax()) {
            $query = Leads::with('user');

            if (Auth::user()->role == 3) {
                $query->where('assigned_to', Auth::user()->id);
            }

            if ($request->has('status') && !empty($request->status)) {
                $query->where('status',  $request->status);
            }


            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $user = Auth::user();
                    $actions = '<div class="dropdown">
        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
            <i class="icon-base ti tabler-dots-vertical"></i>
        </button>
        <div class="dropdown-menu">';

                    // Show Follow Up for all users
                    $actions .= '<a class="dropdown-item" href="' . route('lead_follow_up', [$row->id]) . '">
        <i class="icon-base ti tabler-message me-1"></i> Follow UP</a>';

                    // Show Edit only to admin or who has created lead
                    if ($user->id === $row->created_by || ($user->role === 1 || $user->role === 2)) {
                        $actions .= '<a class="dropdown-item" href="' . route('edit_lead', [$row->id]) . '">
            <i class="icon-base ti tabler-pencil me-1"></i> Edit</a>';
                    }

                    // Assign Employee for admin only
                    if ($user->role === 1 || $user->role === 2) {
                        $actions .= '<a class="dropdown-item" href="javascript:void(0)" onclick="assignEmployee(' . $row->id . ',' . $row->assigned_to . ')">
            <i class="icon-base ti tabler-user me-1"></i> Assign Employee</a>';
                    }

                    // Status change for admin and teamlead
                    if ($user->id === $row->created_by || ($user->role === 1 || $user->role === 2)) {
                        $actions .= '<a class="dropdown-item" href="javascript:void(0);" onclick="statusLead(' . $row->id . ',\'' . addslashes($row->status) . '\')">
            <i class="icon-base ti tabler-progress-check me-1"></i> Change Status</a>';
                    }

                    $actions .= '</div></div>';

                    return $actions;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('CRM.leads.view', compact('employees'));
    }

    public function addLeads(Request $request)
    {

        if ($request->method() == 'POST') {

            $request->validate([
                'name'         => 'required|string|max:255',
                'email'       => 'required|email',
                'phone'       => 'required|numeric|digits:10',
                'lead_source'  => 'required'

            ], [
                'name.required' => 'The name field is required.',
                'name.string'   => 'The name must be a valid string.',
                'name.max'      => 'The name must not exceed 255 characters.',

                'email.required' => 'The email field is required.',
                'email.email'    => 'Please enter a valid email address.',

                'phone.required' => 'The phone number is required.',
                'phone.numeric'  => 'The phone number must contain only numbers.',
                'phone.digits'   => 'The phone number must be exactly 10 digits.',

                'lead_source.required' => 'Please select a lead source.',

            ]);

            $user = Auth::user();

            $data = [
                'user_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'source' => $request->lead_source,
                'source_description' => $request->description,
                'created_by' => Auth::user()->id
            ];

            if ($user->role == 3) {
                $data['assigned_to'] = $user->id;
            }

            $insert = Leads::insert($data);
            return to_route('lead_list')->with(['status' => 'success', 'message' => 'Lead Added']);
        }

        return view('CRM.leads.add');
    }

    public function editLeads($id, Request $request)
    {
        $lead = Leads::find($id);
        if ($request->method() == 'POST') {

            // dd($request->all());
            $request->validate([
                'name'         => 'required|string|max:255',
                'email'       => 'required|email',
                'phone'       => 'required|numeric|digits:10',
                'lead_source'  => 'required'

            ], [
                'name.required' => 'The name field is required.',
                'name.string'   => 'The name must be a valid string.',
                'name.max'      => 'The name must not exceed 255 characters.',
                'email.required' => 'The email field is required.',
                'email.email'    => 'Please enter a valid email address.',
                'phone.required' => 'The phone number is required.',
                'phone.numeric'  => 'The phone number must contain only numbers.',
                'phone.digits'   => 'The phone number must be exactly 10 digits.',
                'lead_source.required' => 'Please select a lead source.',
            ]);


            $data = [
                'user_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'source' => $request->lead_source,
                'source_description' => $request->description
            ];

            $update = Leads::where('id', $id)->update($data);
            return to_route('lead_list')->with(['status' => 'success', 'message' => 'Lead Updated']);
        }
        return view('CRM.leads.edit', compact('lead'));
    }

    public function assignEmployeeLead(Request $request)
    {

        $update = Leads::where('id', $request->lead_id)->update(['assigned_to' => $request->employee]);

        //add notification
        Helper::newNotification($request->employee, 'Lead Assigned', 'New Lead Assigned');

        return to_route('lead_list')->with(['status' => 'success', 'message' => 'Employee Assigned']);
    }

    public function statusLead(Request $request)
    {

        $lead = Leads::find($request->lead_id_status);
        if ($request->status_modal == 'Converted') {
            $steps = Steps::where('status', 'Active')->get();


            try {

                DB::beginTransaction();

                $user = User::create([
                    'code' => config('app.shortname') . rand(0000000, 9999999),
                    'name' => $lead->user_name,
                    'email' => $lead->email,
                    'role' => 4,
                    'phone_number' => $lead->phone,
                    'password' => Hash::make('12345678')
                ]);

                Wallet::create([
                    'user_id' => $user->id
                ]);

                Kyc::create([
                    'user_id' => $user->id
                ]);

                BankDetail::create([
                    'user_id' => $user->id
                ]);

                Address::create([
                    'user_id' => $user->id
                ]);


                foreach ($steps as $step) {
                    UserSteps::insert([
                        'user_id' => $user->id,
                        'step' => $step->title,
                        'order' => $step->order,
                        'icon' => $step->icon
                    ]);
                }

                Leads::where('id', $request->lead_id_status)->update(['status' => $request->status_modal, 'user_id' => $user->id]);

                DB::commit();

                //add notification
                Helper::newNotification($lead->assigned_to, 'Lead Status', $lead->user_name . ' Lead status changed to ' . $request->status_modal);
                return back()->with(['status' => 'success', 'message' => 'Status Updated Successfully']);
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with(['status' => 'error', 'message' => 'Some error occured.']);
            }
        } else {
            Leads::where('id', $request->lead_id_status)->update(['status' => $request->status_modal]);
            //add notification
            Helper::newNotification($lead->assigned_to, 'Lead Status', $lead->user_name . ' Lead status changed to ' . $request->status_modal);
            return to_route('lead_list');
        }
    }

    public function leadFollowUp($lead_id, Request $request)
    {

        if ($request->isMethod('post')) {

            $request->validate([
                'message' => 'required',
                'activity_time' => 'required',
                'follow_up_type' => 'required',
                'attachment_doc' => 'nullable|file|max:10240',
            ], [
                'message.required' => 'Message Required',
                'attachment_doc.max' => 'File must be under 10MB',
            ]);

            $filename = '';

            if ($request->hasFile('attachment_doc')) {
                $file = $request->file('attachment_doc');
                $filename = $lead_id . '_' . time() . '_' . $file->getClientOriginalName();
                $destination = public_path('follow_ups_doc');
                $file->move($destination, $filename);
            }

            $insert = FollowUp::insert([
                'lead_id' => $lead_id,
                'user_id' => Auth::user()->id,
                'message' => $request->message,
                'activity_time' => $request->activity_time,
                'type' => $request->follow_up_type,
                'file' => $filename
            ]);

            return to_route('lead_follow_up', [$lead_id]);
        }


        $lead = Leads::with('user')->where('id', $lead_id)->first();


        $query = FollowUp::where('lead_id', $lead_id)->orderBy('created_at', 'desc');

        if ($request->has('before_id')) {
            $query->where('id', '<', $request->before_id);
        }

        $messages = $query->limit(10)->get()->reverse();

        if ($request->ajax()) {
            return view('CRM.leads.partials.follow-up-messages', compact('messages'))->render();
        }

        return view('CRM.leads.follow_up', compact('messages', 'lead'));
    }


    public function taskList(Request $request)
    {
        if ($request->ajax()) {
            $query = Tasks::with('user');

            if (Auth::user()->role == 3) {
                $query->where('user_id', Auth::user()->id);
            }

            if ($request->has('status') && !empty($request->status)) {
                $query->where('status',  $request->status);
            }


            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="icon-base ti tabler-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="' . route('edit_task', [$row->id]) . '"
                                ><i class="icon-base ti tabler-pencil me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);" onclick="statusTask(' . $row->id . ',\'' . addslashes($row->status) . '\')"
                                ><i class="icon-base ti tabler-progress-check me-1"></i> Change Status</a
                              >
                            </div>
                          </div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('CRM.task.view');
    }

    public function addTasks(Request $request)
    {
        $employees = User::where(['role' => 3, 'status' => 'Active'])->get(['id', 'name']);

        if ($request->method() == 'POST') {

            $request->validate([
                'employee'         => 'required',
                'title'       => 'required',
                'due_date'       => 'required|date',
                'remark'  => 'required',
                'description'  => 'required'

            ], [
                'employee.required'    => 'Please select an employee.',
                'title.required'       => 'The title field is required.',
                'due_date.required'    => 'The due date is required.',
                'due_date.date'        => 'Please enter a valid date for the due date.',
                'remark.required'      => 'The remark field is required.',
                'description.required' => 'The description field is required.'
            ]);

            $data = [
                'user_id' => $request->employee,
                'title' => $request->title,
                'description' => $request->description,
                'remark' => $request->remark,
                'due_date' => $request->due_date,
                'added_by' => Auth::user()->id
            ];

            //add notification
            Helper::newNotification($request->employee, 'Task Added',  $request->title . ' Task Added to you.');

            $insert = Tasks::insert($data);
            return to_route('task_list')->with(['status' => 'success', 'message' => 'Task Created']);
        }

        return view('CRM.task.add', compact('employees'));
    }

    public function editTask($id, Request $request)
    {
        $task = Tasks::find($id);
        $employees = User::where(['role' => 3, 'status' => 'Active'])->get(['id', 'name']);

        if ($request->method() == 'POST') {

            $request->validate([
                'employee'         => 'required',
                'title'       => 'required',
                'due_date'       => 'required|date',
                'remark'  => 'required',
                'description'  => 'required'

            ], [
                'employee.required'    => 'Please select an employee.',
                'title.required'       => 'The title field is required.',
                'due_date.required'    => 'The due date is required.',
                'due_date.date'        => 'Please enter a valid date for the due date.',
                'remark.required'      => 'The remark field is required.',
                'description.required' => 'The description field is required.'
            ]);

            $data = [
                'user_id' => $request->employee,
                'title' => $request->title,
                'description' => $request->description,
                'remark' => $request->remark,
                'due_date' => $request->due_date
            ];

            $insert = Tasks::where('id', $id)->update($data);
            return to_route('task_list')->with(['status' => 'success', 'message' => 'Task Updated']);
        }

        return view('CRM.task.edit', compact('employees', 'task'));
    }

    public function statusTask(Request $request)
    {
        $task = Tasks::find($request->task_id_status);

        //add notification
        Helper::newNotification($task->added_by, 'Task Status',  $request->title . ' Task status changed.');

        $task->status = $request->status_modal;
        $task->save();

        return to_route('task_list');
    }

    public function documentTypeList(Request $request)
    {
        if ($request->ajax()) {
            $query = DocumentType::with('business_category');


            if ($request->has('status') && !empty($request->status)) {
                $query->where('status',  $request->status);
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
                              <a class="dropdown-item" href="' . route('edit_document_type', [$row->id]) . '"
                                ><i class="icon-base ti tabler-pencil me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);" onclick="deleteType(' . $row->id . ')"
                                ><i class="icon-base ti tabler-progress-check me-1"></i> Change Status</a
                              >
                            </div>
                          </div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('Document.Type.view');
    }

    public function addDocumentType(Request $request)
    {

        $businessCategories = BusinessCategory::where('status', 'Active')->get();

        if ($request->method() == 'POST') {

            $request->validate([
                'business_category' => 'required',
                'name'         => 'required',
                'document_type'       => 'required'

            ], [
                'business_category.required' => 'Business Category Required',
                'name.required'    => 'Name Required',
                'document_type.required'       => 'Type Required'
            ]);

            $data = [
                'business_category_id' => $request->business_category,
                'name' => $request->name,
                'type' => $request->document_type
            ];

            $insert = DocumentType::insert($data);
            return to_route('document_type_list')->with(['status' => 'success', 'message' => 'Document Added']);
        }

        return view('Document.Type.add', compact('businessCategories'));
    }

    public function editDocumentType($id, Request $request)
    {
        $type = DocumentType::find($id);

        $businessCategories = BusinessCategory::where('status', 'Active')->get();

        if ($request->method() == 'POST') {


            $request->validate([
                'business_category' => 'required',
                'name'         => 'required',
                'document_type'       => 'required'

            ], [
                'business_category.required' => 'Business Category Required',
                'name.required'    => 'Name Required',
                'document_type.required'       => 'Type Required'
            ]);

            $data = [
                'business_category_id' => $request->business_category,
                'name' => $request->name,
                'type' => $request->document_type
            ];

            $update = DocumentType::where('id', $id)->update($data);
            return to_route('document_type_list')->with(['status' => 'success', 'message' => 'Document Updated']);
        }

        return view('Document.Type.edit', compact('type', 'businessCategories'));
    }

    public function statusDocumentType($id)
    {

        $type = DocumentType::find($id);
        $type->status = $type->status === 'Active' ? 'Inactive' : 'Active';
        $type->save();
    }


    public function userDocument(Request $request)
    {
        if ($request->ajax()) {

            $query = UserDocument::with(['user', 'package', 'document_type'])->whereNull('deleted_at');

            if ($request->has('status') && !empty($request->status)) {
                $query->where('status',  $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    if ($row->status == 'Approved') {
                        return '<span class="badge bg-success">Approved</span>';
                    } elseif ($row->status == 'Not Approved') {
                        return '<span class="badge bg-danger">Not Approved</span>';
                    } else {
                        return '<span class="badge bg-secondary">' . $row->status . '</span>';
                    }
                })
                ->editColumn('path', function ($row) {
                    return '<a href="' . asset('user_documents/' . $row->path) . '" download style="cursor:pointer;"><i class="icon-base ti tabler-download"></i></a>';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="icon-base ti tabler-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus(' . $row->id . ')"
                                ><i class="icon-base ti tabler-progress-check me-1"></i> Change Status</a
                              >
                               <a class="dropdown-item" href="javascript:void(0);" onclick="deleteFile(' . $row->id . ')"
                                ><i class="icon-base ti tabler-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>';
                })
                ->rawColumns(['action', 'status', 'path'])
                ->make(true);
        }


        // <a class="dropdown-item" href="' . route('edit_user_document', [$row->id]) . '"
        //                         ><i class="icon-base ti tabler-pencil me-1"></i> Edit</a
        //                       >
        return view('Document.User.view');
    }

    public function addUserDocument(Request $request)
    {

        $types = DocumentType::where('status', 'Active')->orderBy('name', 'desc')->get();
        $users = User::where(['status' => 'Active', 'role' => 4])->orderBy('name', 'desc')->get();

        if ($request->method() == 'POST') {

            $request->validate([
                'document_type'   => 'required',
                'user'            => 'required',
                'name'            => 'required',
                'file_upload'     => 'required'

            ], [
                'document_type.required' => 'Please select a document type.',
                'user.required'          => 'Please select a user.',
                'name.required'          => 'Please enter the document name.',
                'file_upload.required'   => 'Please upload a file.'
            ]);


            $packageType = UserPackage::where(['user_id' => $request->user])->whereNull('deleted_at')->latest()->first(['package_id', 'business_category_id']);

            if (!$packageType) {
                return back()->with(['status' => 'error', 'message' => 'No package assigned to user']);
            }

            $documentType = DocumentType::where('id', $request->document_type)->first('type');



            $file = $request->file('file_upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('user_documents'), $filename);


            $data = [
                'user_id' => $request->user,
                'document_type_id' => $request->document_type,
                'name' => $request->name,
                'package_id' => $packageType->package_id,
                'business_category_id' => $packageType->business_category_id,
                'path' => $filename,
                'added_by' => Auth::user()->id
            ];

            // if ($file->getMimeType() === 'application/pdf') {

            //     // It's a PDF
            // } elseif (str_starts_with($file->getMimeType(), 'image/')) {
            //     // It's an image
            // }

            $insert = UserDocument::insert($data);
            return to_route('user_document_list')->with(['status' => 'success', 'message' => 'Document Added Successfully']);
        }

        return view('Document.User.add', compact('types', 'users'));
    }

    public function deleteUserDocument($id)
    {
        $delete = UserDocument::where('id', $id)->update(['deleted_at' => now()]);
    }

    public function statusUserDocument($id)
    {
        $document = UserDocument::findOrFail($id);
        $document->status = $document->status === 'Approved' ? 'Not Approved' : 'Approved';
        $document->save();
    }
}
