@extends('layouts.app')
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
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" aria-label="Select Status"
                                    required>
                                    <option value="">Select Status</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Not Approved">Not Approved</option>
                                </select>
                            </div>

                        </div>



                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-0">{{ $status }} Tickets</h5>
            <a href="{{ route('create_ticket') }}" class="btn add-new btn-primary">
                <span>
                    <span class="d-flex align-items-center gap-2">
                        <i class="icon-base ti tabler-plus icon-xs"></i> 
                        <span class="d-none d-sm-inline-block">Request</span>
                    </span>
                </span>
            </a>
        </div>

        <div class="card-datatable">
            <table class="table" id="data-table">
                <thead class="border-top">
                    <tr>
                        <th>S.No</th>
                        <th>Request No.</th>
                        <th>Request For</th>
                        <th>Subject</th>
                        <th>User Name</th>
                        <th>User Phone</th>
                        <th>Assigned To Name</th>
                        <th>Assigned To Phone</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- assign Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Assign Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="assignModalBody">
                    <form action="{{ route('assign_employee_ticket') }}" method="post">
                        @csrf
                        <input type="hidden" name="lead_id" id="lead_id">
                        <div class="mb-6">
                            <label for="employee" class="form-label">Employee</label>
                            <select class="form-select" id="employee" name="employee" aria-label="Select Employee"
                                required>
                                <option value="">Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-secondary">Update</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const Columns = [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'code', name: 'code' },
                { data: 'for', name: 'for' },
                { data: 'subject', name: 'subject' },
                { data: 'user.name', name: 'user.name'},
                { data: 'user.phone_number', name: 'user.phone_number'},
                { data: 'assignee.name', name: 'assignee.name' },
                { data: 'assignee.phone_number', name: 'assignee.phone_number' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ];

            const table1 = initializeDataTable("#data-table", "{{ route('ticket_list', [$status]) }}", Columns, function (d) {
                d.status = $('#status').val();
            });

            $('#status').on('change keyup', function () {
                table1.draw();
            });
        });

        function assignEmployee(id,assigned_to){
            $('#lead_id').val(id);
            $('#employee').val(assigned_to).trigger('change');
            $('#assignModal').modal('show');
        }

        function changeStatus(fileId){
            Swal.fire({
                title: 'Are you sure to close ticket?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('status_support', ':id') }}".replace(':id', fileId);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            Swal.fire('Changed!', 'Ticket close successfully.', 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Failed to change status.', 'error');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }


        function deleteFile(fileId) {
            Swal.fire({
                title: 'Are you sure to delete file?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('delete_user_document', ':id') }}".replace(':id', fileId);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            Swal.fire('Deleted!', 'File Deleted.', 'success').then(() => {
                                location.reload(); // or remove row from table dynamically
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Failed to delete file.', 'error');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }
    </script>
@endpush
  
