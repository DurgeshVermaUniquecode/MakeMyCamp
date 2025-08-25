@extends('layouts.app')

@section('title', 'User List')

@section('content')



    <div class="accordion mt-4 mb-4" id="accordionFilter">
        <div class="accordion-item active">
            <h2 class="accordion-header" id="headingOne">
                <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#filterAccordian"
                    aria-expanded="false" aria-controls="filterAccordian">
                    <i class="fa-solid fa-filter"></i> &nbsp;<h5 class="card-title mb-0">Assign Lead To Manager</h5>
                </button>
            </h2>

            <div id="filterAccordian" class="accordion-collapse collapse show" data-bs-parent="#accordionFilter">
                <div class="accordion-body">
                    <form action="{{ route('assign_lead_vendor', [$lead_id]) }}" method="post">
                        <div class="row">

                            @csrf
                            <div class="col-sm-3">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="icon-base ti tabler-user"></i></span>
                                    <input type="text" class="form-control" name="code"
                                        placeholder="Search By Code/Mobile No." value="" aria-label="John Doe"
                                        aria-describedby="basic-icon-default-fullname2" />
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-sm btn-primary">Assign</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @if (count($assigned_to))
        <div class="card">
            <table class="table">
                <thead class="border-top">
                    <tr>
                        <th>S.No</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($assigned_to as $key => $lead)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $lead->user->code }}</td>
                            <td>{{ $lead->user->name }}</td>
                            <td>{{ $lead->user->email }}</td>
                            <td>{{ $lead->user->phone_number }}</td>
                            <td>{{ $lead->created_at }}</td>
                            <td>{{ $lead->status }}</td>
                            @if ($lead->status == 'Pending')
                                <td><a href="{{route('remove_lead_vendor',[$lead->lead_id,$lead->user->id])}}"><i class="icon-base ti tabler-trash"></i></a></td>
                            @else
                                <td>-</td>
                            @endif
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @else
        <div class="card text-center">
            <h5 class="mt-3">No Manager is Assigned</h5>
        </div>
    @endif


@endsection
