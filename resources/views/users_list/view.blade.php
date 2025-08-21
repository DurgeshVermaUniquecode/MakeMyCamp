@extends('layouts.app')

@section('title', 'User List')

@section('content')
<div class="accordion mt-4 mb-4" id="accordionFilter">
    <div class="accordion-item active">
        <h2 class="accordion-header" id="headingOne">
            <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#filterAccordian"
                aria-expanded="false" aria-controls="filterAccordian">
                <i class="fa-solid fa-filter"></i> &nbsp;Filter
            </button>
        </h2>

        <div id="filterAccordian" class="accordion-collapse collapse hide" data-bs-parent="#accordionFilter">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="mb-6">
                            <label class="form-label" for="basic-icon-default-fullname">Name</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class="icon-base ti tabler-user"></i></span>
                                <input type="text" class="form-control" id="search-name"
                                    placeholder="Search By Name" aria-label="John Doe"
                                    aria-describedby="basic-icon-default-fullname2" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="mb-6">
                            <label class="form-label" for="basic-icon-default-email">Email</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base ti tabler-mail"></i></span>
                                <input type="text" id="search-email" class="form-control"
                                    placeholder="Search By Email" aria-label="john.doe"
                                    aria-describedby="basic-icon-default-email2" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between">
        <h5 class="card-title mb-0">User List ({{ ucfirst($type) }})</h5>

        <a href="{{ route('add_user', $type) }}" class="btn add-new btn-primary"><span><span
                    class="d-flex align-items-center gap-2"><i class="icon-base ti tabler-plus icon-xs"></i> <span
                        class="d-none d-sm-inline-block">Add {{ ucfirst($type) }}</span></span></span></a>
    </div>

    <div class="card-datatable">
        <table class="table" id="data-table">
            <thead class="border-top">
                <tr>
                    <th>S.No</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Status</th>
                    <th>Join Date</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

</div>
@endsection
@push('scripts')
    <script>        
    $(document).ready(function() {

            const Columns = [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'code', name: 'code' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'phone_number', name: 'phone_number' },
                        { data: 'gender', name: 'gender' },
                        { data: 'dob', name: 'dob' },
                        { data: 'status', name: 'status' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'updated_at', name: 'updated_at' },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                    ];
   
            const table1 = initializeDataTable("#data-table", "{{ route('user_list', $type) }}", Columns, function (d) {
                d.name = $('#search-name').val();
                d.status = $('#status').val();
            });

            $('#search-name, #status').on('change keyup', function () {
                table1.draw();
            });

        });

        function deleteUser(userId) {
            Swal.fire({
                title: 'Are you sure to change status?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('status_user', ':id') }}".replace(':id', userId);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            Swal.fire('Deleted!', 'User status changed.', 'success').then(() => {
                                location.reload(); // or remove row from table dynamically
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Failed to delete user.', 'error');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }
    </script>
@endpush
