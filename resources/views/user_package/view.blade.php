@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-0">User Packages</h5>

            <a href="{{route('add_user_package')}}"  class="btn add-button btn-primary"><span><span
                        class="d-flex align-items-center gap-2"><i class="icon-base ti tabler-plus icon-xs"></i> <span
                            class="d-none d-sm-inline-block">Add Package</span></span></span></a>
        </div>

        <div class="card-datatable">
            <table class="table" id="data-table">
                <thead class="border-top">
                    <tr>
                        <th>S.No</th>
                        <th>User Name</th>
                        <th>User Phone No</th>
                        <th>Business Category</th>
                        <th>Package Name</th>
                        <th>Package Amount</th>
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
                { data: 'business_category.name', name: 'business_category.name' },
                { data: 'package.name', name: 'package.name' },
                { data: 'package.amount', name: 'package.amount' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ];

            const table1 = initializeDataTable("#data-table", "{{ route('user_package_list') }}", Columns, function (d) {
                d.name = $('#search-name').val();
                d.status = $('#status').val();
            });

            $('#search-name, #status').on('change keyup', function () {
                table1.draw();
            });
        });

        function deletePackage(package) {
            Swal.fire({
                title: 'Are you sure to Delete User Package?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('status_user_package', ':id') }}".replace(':id', package);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            Swal.fire('Deleted!', 'Package Deleted.', 'success').then(() => {
                                location.reload(); // or remove row from table dynamically
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Failed to delete Package.', 'error');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }


    </script>
@endpush
