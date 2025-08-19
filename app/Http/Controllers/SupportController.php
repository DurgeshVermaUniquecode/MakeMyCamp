<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Support; 
use App\Models\SupportReply;
use App\Models\User;

class SupportController extends Controller
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
     
    public function ticketList($status, Request $request)
    {   
        $employees = User::where(['role' => 3, 'status' => 'Active'])->get(['id', 'name']);

        if ($request->ajax()) {
            $query = Support::with(['user','assignee'])->where('status', $status??'Closed')->latest();

            if ($request->has('question') && !empty($request->question)) {
                $query->where('question', 'like', '%' . $request->question . '%');
            }

            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    if ($row->status == 'Closed') {
                        return '<span class="badge bg-success">'.$row->status.'</span>';
                    } elseif ($row->status == 'Pending') {
                        return '<span class="badge bg-danger">'.$row->status.'</span>';
                    } else {
                        return '<span class="badge bg-warning">' . $row->status . '</span>';
                    }
                })
                 ->addColumn('action', function ($row) {
                    $user = Auth::user();
                    $actions = '<div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="icon-base ti tabler-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">';
                                    if ($user->id === $row->assigned_to || ($user->role === 1 || $user->role === 2)) {
                                        $actions .= '<a class="dropdown-item" href="' . route('reply_ticket', [$row->id]) . '"><i class="icon-base ti tabler-message me-1"></i> Replay</a>';
                                    }
                                    if (($user->role === 1 || $user->role === 2) && $row->status != 'Closed') {
                                        $actions .= '<a class="dropdown-item" href="javascript:void(0)" onclick="assignEmployee(' . $row->id . ',' . $row->assigned_to . ')"> <i class="icon-base ti tabler-user me-1"></i> Assign Employee</a>';
                                    }
                                    if (($user->id === $row->assigned_to || ($user->role === 1 || $user->role === 2)) && $row->status != 'Closed') {
                                        $actions .= '<a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus(' . $row->id . ')"> <i class="icon-base ti tabler-progress-check me-1"></i> Change Status</a>';
                                    }

                    $actions .= '</div></div>';

                    return $actions;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('support.view',compact('status','employees'));
    }
    
    public function createTicket(Request $request)
    {
        return view('support.create_ticket');
    }

    public function storeTicket(Request $request) {

        $user_id = Auth::user()->id;

        $request->validate([
            'request_for'          => 'required|string',
            'subject'      => 'required|string|max:255',
            'description'  => 'required|string',
            'file'         => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $code = config('app.shortname').'-'.time().$user_id;

        $support = Support::create([
            "code" => $code,
            "for" => $request->request_for,
            "user_id" => $user_id,
            "subject" => $request->subject,
        ]);

        $filename = null;
        $filetype = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filetype = $file->getClientOriginalExtension(); 
            $filename = $code. '_'.date("Y-m-d H:i:s"). '.' . $filetype;
            $destinationPath = public_path('support_replies');
            $file->move($destinationPath, $filename);
        }

        SupportReply::create([
            'support_id' =>  $support->id,
            'description' => $request->description,
            'type' => Auth::user()->roles->role_type == "Admin"?"Admin":"User",
            'file' => $filename,
            'file_type' => $filetype,
            'user_id' => $user_id,
            'replay_id' => 0,
        ]);

        return redirect()->route('ticket_list', ['Pending'])->with('success', 'Support created successfully.');
    }
     
     
    public function replyTicket($id, Request $request)
    {       
        $data = Support::with(['user','assignee'])->findOrFail($id);

        $query = SupportReply::where('support_id', $id)->orderBy('created_at', 'desc');

        if ($request->has('before_id')) {
            $query->where('id', '<', $request->before_id);
        }

        $messages = $query->limit(10)->get()->reverse();

        if ($request->ajax()) {
            return view('support.partials.messages-list', compact('messages'))->render();
        }

        return view('support.messages', compact('messages', 'data'));
    }

    public function storeReplyTicket($id, Request $request)
    {
            $data = Support::findOrFail($id);
            $request->validate([
                'message' => 'required',
                'attachment_doc' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            ], [
                'message.required' => 'Message Required',
                'attachment_doc.max' => 'File must be under 10MB',
            ]);

            $filename = null;
            $filetype = null;
            if ($request->hasFile('attachment_doc')) {
                $file = $request->file('attachment_doc');
                $filetype = $file->getClientOriginalExtension(); 
                $filename = $data->code . '_' . date("Y-m-d_H-i-s") . '.' . $filetype;
                $destinationPath = public_path('support_replies');
                $file->move($destinationPath, $filename);
            }

            $insert = SupportReply::insert([
                                        'support_id' => $id, 
                                        'user_id' => Auth::user()->id, 
                                        'description' => $request->message,
                                        'type' => Auth::user()->roles->role_type == "Admin"?"Admin":"User",
                                        'file_type' => $filetype,
                                        'file' => $filename,
                                        'replay_id' => 0,
                                    ]);
            
            $count = SupportReply::groupBy('user_id')->where('support_id',$id)->count();
            
            if($count > 1 && $data->status != 'Closed') {
                $data->status = 'Open';
                $data->save();
            }

            return to_route('reply_ticket', [$id]);
    }

    public function assignEmployeeTicket(Request $request)
    {
        $update = Support::where('id', $request->lead_id)->update([
            'assigned_to' => $request->employee,
            'assign_date' => now(),
            'assigned_by' => Auth::user()->id,

        ]);

        return back()->with(['status'=>'success','message'=>'Employee Assigned']);
    }

    public function statusTicket($id, Request $request)
    {
        $data = Support::findOrFail($id);
        $data->status = 'Closed';
        return $data->save();
    }
    
}
