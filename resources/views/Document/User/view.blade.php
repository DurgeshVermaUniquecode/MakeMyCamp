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
            <h5 class="card-title mb-0">User Document</h5>

            <a href="{{ route('add_user_document') }}" class="btn add-new btn-primary"><span><span
                        class="d-flex align-items-center gap-2"><i class="icon-base ti tabler-plus icon-xs"></i> <span
                            class="d-none d-sm-inline-block">Add Document</span></span></span></a>
        </div>

        <div class="card-datatable">
            <table class="table" id="data-table">
                <thead class="border-top">
                    <tr>
                        <th>S.No</th>
                        <th>User Name</th>
                        <th>User Phone No</th>
                        <th>Package</th>
                        <th>Document Name</th>
                        <th>Document Type</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Created At</th>
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
                { data: 'user.name', name: 'user.name' },
                { data: 'user.phone_number', name: 'user.phone_number' },
                { data: 'package.name', name: 'package.name' },
                { data: 'name', name: 'name' },
                { data: 'document_type.name', name: 'document_type.name' },
                { data: 'path', name: 'path' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ];

            const table1 = initializeDataTable("#data-table", "{{ route('user_document_list') }}", Columns, function (d) {
                d.status = $('#status').val();
            });

            $('#status').on('change keyup', function () {
                table1.draw();
            });
        });

        function changeStatus(fileId){
            Swal.fire({
                title: 'Are you sure to change file status?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('status_user_document', ':id') }}".replace(':id', fileId);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            Swal.fire('Changed!', 'File Status Changed.', 'success').then(() => {
                                location.reload(); // or remove row from table dynamically
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
  
