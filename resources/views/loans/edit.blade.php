@extends('layouts.app')
@section('content')
    <!-- Basic Layout -->
    <div class="row mb-6 gy-6">

        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Loan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('edit_loan',[$loan->id]) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="row">



                            <div class="col-sm-6">
                                <div class="mb-6">
                                    <label for="user" class="form-label">User</label>
                                    <select class="form-select" id="user" name="user" aria-label="Select user"
                                        required>
                                        <option value="">Select user</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('user',$loan->user_id) == $user->id)>
                                                {{ $user->name }} - {{ $user->phone_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label class="form-label" for="amount">Amount <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="amount2" class="input-group-text"><i
                                                class="icon-base ti tabler-currency-rupee"></i></span>
                                        <input type="text" class="form-control" id="amount" name="amount"
                                            placeholder="Amount" aria-label="Amount" required value="{{ old('amount',$loan->amount) }}"
                                            aria-describedby="amount2" />
                                    </div>
                                    @error('amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="col-sm-3">
                                <div class="mb-6">
                                    <label class="form-label" for="commission_amount">Commission Amount <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="commission_amount2" class="input-group-text"><i
                                                class="icon-base ti tabler-currency-rupee"></i></span>
                                        <input type="text" class="form-control" id="commission_amount"
                                            name="commission_amount" placeholder="Commission Amount"
                                            aria-label="Commission Amount" required value="{{ old('commission_amount',$loan->commission_amount) }}"
                                            aria-describedby="commission_amount2" />
                                    </div>
                                    @error('commission_amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label class="form-label" for="trans_number">Transaction Number</label>
                                    <div class="input-group input-group-merge">
                                        <span id="trans_number2" class="input-group-text"><i
                                                class="icon-base ti tabler-currency-rupee"></i></span>
                                        <input type="text" class="form-control" id="trans_number" name="trans_number"
                                            placeholder="Transaction Number" aria-label="Transaction Number"
                                            value="{{ old('trans_number',$loan->trans_number) }}" aria-describedby="trans_number2" />
                                    </div>
                                    @error('trans_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label for="image" class="form-label">Transaction Image</label>
                                    <input class="form-control" type="file" id="image" name="image"
                                        accept="image/*" />
                                </div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>


                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
