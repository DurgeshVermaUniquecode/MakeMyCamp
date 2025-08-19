@extends('layouts.app')
@section('content')
    <div class="row g-6">
        <!-- Card Border Shadow -->
        <div class="col-lg-4 col-sm-6">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-warning"><i
                                    class="icon-base ti tabler-building-bank icon-28px"></i></span>
                        </div>
                        <h4 class="mb-0">{{ $loanStatusCounts['Pending'] ?? 0 }}</h4>
                    </div>
                    <p class="mb-1">Pending Loans</p>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-sm-6">
            <div class="card card-border-shadow-danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-danger"><i
                                    class="icon-base ti tabler-building-bank icon-28px"></i></span>
                        </div>
                        <h4 class="mb-0">{{ $loanStatusCounts['Approved'] ?? 0 }}</h4>
                    </div>
                    <p class="mb-1">Approved Loans</p>
                </div>
            </div>
        </div>



        <div class="col-lg-4 col-sm-6">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-success"><i
                                    class="icon-base ti tabler-building-bank icon-28px"></i></span>
                        </div>
                        <h4 class="mb-0">{{ $loanStatusCounts['Sanctioned'] ?? 0 }}</h4>
                    </div>
                    <p class="mb-1">Sanctioned Loans</p>
                </div>
            </div>
        </div>

         <div class="col-lg-4 col-sm-6">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-success"><i
                                    class="icon-base ti tabler-cash-banknote icon-28px"></i></span>
                        </div>
                        <h4 class="mb-0">{{ $loanSums->total_commission ?? 0 }}</h4>
                    </div>
                    <p class="mb-1">Loan Commission</p>
                </div>
            </div>
        </div>

         <div class="col-lg-4 col-sm-6">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-success"><i
                                    class="icon-base ti tabler-cash-banknote icon-28px"></i></span>
                        </div>
                        <h4 class="mb-0">{{ $loanSums->total_amount ?? 0 }}</h4>
                    </div>
                    <p class="mb-1">Loan Amount</p>
                </div>
            </div>
        </div>



    </div>
@endsection
