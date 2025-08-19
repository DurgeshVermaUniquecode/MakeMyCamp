@extends('layouts.app')
@section('content')
    <div class="row g-6">
        <!-- Card Border Shadow -->
        <div class="col-lg-4 col-sm-6">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="icon-base ti tabler-ad-circle icon-28px"></i></span>
                        </div>
                        <h4 class="mb-0">{{$taskCounts['Completed'] ?? 0}}</h4>
                    </div>
                    <p class="mb-1">Completed Tasks</p>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-sm-6">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="icon-base ti tabler-ad-circle-off icon-28px"></i></span>
                        </div>
                        <h4 class="mb-0">{{$taskCounts['Incompleted'] ?? 0}}</h4>
                    </div>
                    <p class="mb-1">Incompleted Tasks</p>
                </div>
            </div>
        </div>


         <div class="col-lg-4 col-sm-6">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="icon-base ti tabler-a-b-2 icon-28px"></i></span>
                        </div>
                        <h4 class="mb-0">{{($taskCounts['In Progress'] ?? 0) + ($taskCounts['Pending'] ?? 0)}}</h4>
                    </div>
                    <p class="mb-1">Pending Tasks</p>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-sm-6">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="icon-base ti tabler-ad-circle icon-28px"></i></span>
                        </div>
                        <h4 class="mb-0">{{($leadCounts['Pending'] ?? 0) + ($leadCounts['Prospecting'] ?? 0)}}</h4>
                    </div>
                    <p class="mb-1">Assigned Leads</p>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-sm-6">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="icon-base ti tabler-ad-circle icon-28px"></i></span>
                        </div>
                        <h4 class="mb-0">{{$leadCounts['Converted'] ?? 0}}</h4>
                    </div>
                    <p class="mb-1">Converted Leads</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-6">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="icon-base ti tabler-ad-circle icon-28px"></i></span>
                        </div>
                        <h4 class="mb-0">{{$leadCounts['Closed'] ?? 0}}</h4>
                    </div>
                    <p class="mb-1">Closed Leads</p>
                </div>
            </div>
        </div>

    </div>
@endsection


