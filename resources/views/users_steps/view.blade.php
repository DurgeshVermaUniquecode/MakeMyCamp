@extends('layouts.app')

@section('title', 'User List')

@section('content')
    <div class="accordion mt-4 mb-4" id="accordionFilter">
        <div class="accordion-item active">
            <h2 class="accordion-header" id="headingOne">
                <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#filterAccordian"
                    aria-expanded="false" aria-controls="filterAccordian">
                    <i class="fa-solid fa-filter"></i> &nbsp;<h5 class="card-title mb-0">User Steps</h5>
                </button>
            </h2>

            <div id="filterAccordian" class="accordion-collapse collapse show" data-bs-parent="#accordionFilter">
                <div class="accordion-body">
                    <form action="{{ route('user_step_list') }}" method="post">
                        <div class="row">

                            @csrf
                            <div class="col-sm-3">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="icon-base ti tabler-user"></i></span>
                                    <input type="text" class="form-control" name="code"
                                        placeholder="Search By Code/Mobile No." value="{{ $searchParam }}"
                                        aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-sm btn-primary">Search</button>
                            </div>



                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @if (count($steps))
        <div class="card">
            <table class="table">
                <thead class="border-top">
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Step</th>
                        <th>Status</th>
                        <th>Updated At</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($steps as $key => $step)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $step->user->name }}</td>
                            <td>{{ $step->step }}</td>
                            <td><span
                                    class="badge bg-{{ $step->status == 'Completed' ? 'success' : 'danger' }}">{{ $step->status }}</span>
                            </td>
                            <td>{{ $step->created_at }}</td>
                            <td>{{ $step->updated_at }}</td>
                            <td>
                                @if ($step->status == 'Pending')
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="icon-base ti tabler-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="approveStep('{{ $step->id }} ')"><i
                                                    class="icon-base ti tabler-circle-dashed-check me-1"></i>Approve</a>
                                        </div>
                                    </div>
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @else
        <div class="card text-center">
            <h5 class="mt-3">{{ $message }}</h5>
        </div>
    @endif

    @push('scripts')
        <script>
            function approveStep(id) {
                Swal.fire({
                    title: 'Are you sure to makr this as completed?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = "{{ route('edit_user_step', ':id') }}".replace(':id', id);

                        $.ajax({
                            url: url,
                            method: 'GET',
                            success: function(response) {
                                Swal.fire('Completed!', 'Step status changed.', 'success').then(() => {
                                    location.reload(); // or remove row from table dynamically
                                });
                            },
                            error: function(xhr) {
                                Swal.fire('Error', 'Failed.', 'error');
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            }
        </script>
    @endpush

@endsection
