<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use App\Models\Commissions;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;


class LoanController extends Controller
{
    public function loans(Request $request)
    {

        //bank associate
        $employees = User::where(['role' => 5, 'status' => 'Active'])->get(['id', 'name']);

        if ($request->ajax()) {

            $query = Loan::with(['user', 'employee', 'addedBy']);

            if (Auth::user()->role == 5) {
                $query->where('employee_id', Auth::user()->id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('trans_image', function ($row) {
                    return '<i class="menu-icon icon-base ti tabler-eye" style="cursor:pointer;" onclick="openModal(\'image\', \'' . addslashes($row->trans_image) . '\')"></i>';
                })
                ->addColumn('action', function ($row) {

                    $action = '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="icon-base ti tabler-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">';

                    if ($row->status != 'Sanctioned') {
                        $action .= '

                              <a class="dropdown-item" href="' . route('edit_loan', [$row->id]) . '"
                                ><i class="icon-base ti tabler-pencil me-1"></i> Edit</a
                              >

                              <a class="dropdown-item" href="javascript:void(0)" onclick="assignEmployee(' . $row->id . ',' . $row->employee_id . ')">
                                <i class="icon-base ti tabler-user me-1"></i> Assign Employee</a>

                              <a class="dropdown-item" href="javascript:void(0);" onclick="statusLoan(' . $row->id . ', \'' . $row->status . '\')"><i class="icon-base ti tabler-progress-check me-1"></i> Change Status</a
                              >';
                    }

                    $action .= '</div>
                          </div>';
                    return $action;
                })
                ->rawColumns(['action', 'trans_image'])
                ->make(true);
        }

        return view('loans.view', compact('employees'));
    }

    public function addLoans(Request $request)
    {

        $users = User::where(['role' => 4, 'status' => 'Active'])->get(['id', 'name', 'phone_number']);

        if ($request->method() == 'POST') {


            $request->validate([
                'user' => 'required',
                'amount' => 'required',
                // 'commission_amount' => 'required',
            ], [
                'user.required' => 'The user field is required.',
                'amount.required' => 'The amount field is required.',
                'commission_amount.required' => 'The commission amount is required.'
            ]);


            $commissionAmount = (config('loan')['commission'] / 100) * $request->amount;

            $data = [
                'user_id' => $request->user,
                'amount' => $request->amount,
                'commission_amount' => $commissionAmount,
                'added_by' => Auth::user()->id
            ];



            $insert = Loan::insert($data);
            return to_route('loans')->with(['status' => 'success', 'message' => 'Loan Added']);
        }

        return view('loans.add', compact('users'));
    }

    public function assignEmployeeLoan(Request $request)
    {

        $loan = Loan::find($request->loan_id);

        //add notification
        Helper::newNotification($request->added_by, 'Loan Assigned', 'New Loan Request Assigned to You.');

        $loan->employee_id =  $request->employee;
        $loan->save();

        return to_route('loans')->with(['status' => 'success', 'message' => 'Employee Assigned']);
    }

    public function changeLoanStatus(Request $request)
    {

        $loan = Loan::find($request->loan_id_status);


        if ($request->trans_number != null) {
            $loan->trans_number = $request->trans_number;
        }

        $loan_image = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $loan_image = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('loans'), $loan_image);
        }

        if ($loan->employee_id != null && $request->status_modal == 'Sanctioned') {

            $commissionData = [
                'type' => 'Loan',
                'user_id' => $loan->user_id,
                'employee_id' => $loan->employee_id,
                'amount' => $loan->commission_amount
            ];

            Commissions::insert($commissionData);

            $check = Helper::creadit_ledger([
                "user_id" => $loan->employee_id,
                "refrence_id" => $loan->user_id,
                "amount" => (float)$loan->commission_amount,
                "trans_id" => Helper::getTransId(3),
                "cgst" => 0,
                "sgst" => 0,
                "ledger_type" => 'WALLET CREDIT',
                "wallet_type" => 1,
                "trans_from" => 'Wallet',
                "description" => 'Credited For Loan Amount'
            ]);
        }

        $recipientId = in_array(Auth::user()->role, [1, 2]) ? $loan->employee_id : $loan->added_by;
        Helper::newNotification($recipientId, 'Loan Status changed', 'Loan Status Changed Please review.');

        $loan->trans_image = $loan_image;
        $loan->status = $request->status_modal;
        $loan->save();
        return to_route('loans')->with(['status' => 'success', 'message' => 'Status Changed']);
    }


    public function editLoan($id, Request $request)
    {
        $loan = Loan::find($id);
        $users = User::where(['role' => 4, 'status' => 'Active'])->get(['id', 'name', 'phone_number']);

        if ($request->method() == 'POST') {
            $request->validate([
                'user' => 'required',
                'amount' => 'required',
                // 'commission_amount' => 'required'
            ], [
                'user.required' => 'The user field is required.',
                'amount.required' => 'The amount field is required.',
                'commission_amount.required' => 'The commission amount is required.'
            ]);


            $commissionAmount = (config('loan')['commission'] / 100) * $request->amount;

            $data = [
                'user_id' => $request->user,
                'amount' => $request->amount,
                'commission_amount' => $commissionAmount
            ];

            $update = Loan::where('id', $id)->update($data);

            return to_route('loans')->with(['status' => 'success', 'message' => 'Loan Updated']);;
        }
        return view('loans.edit', compact('loan', 'users'));
    }
}
