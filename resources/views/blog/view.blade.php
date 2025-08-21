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
                                <label class="form-label" for="basic-icon-default-title">Title</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-title2" class="input-group-text"><i
                                            class="icon-base ti tabler-user"></i></span>
                                    <input type="text" class="form-control" id="search-title"
                                        placeholder="Search By Title" aria-label="Blog Title"
                                        aria-describedby="basic-icon-default-title2" />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="mb-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" aria-label="Select Status"
                                    required>
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
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
            <h5 class="card-title mb-0">Blog List</h5>

            <a href="{{ route('blog_create') }}" class="btn add-new btn-primary"><span><span
                        class="d-flex align-items-center gap-2"><i class="icon-base ti tabler-plus icon-xs"></i> <span
                            class="d-none d-sm-inline-block">Add Blog</span></span></span></a>
        </div>

        <div class="card-datatable">
            <table class="table" id="data-table">
                <thead class="border-top">
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Publish Date</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamicModalLabel">Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="dynamicModalBody">
                    <!-- Content will be inserted here -->
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
                { data: 'title', name: 'title' },
                { data: 'category_name',  name: 'category_name' },
                { data: 'image', name: 'image' },
                { data: 'status', name: 'status' },
                { data: 'publish_datetime', name: 'publish_datetime' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ];

            const table1 = initializeDataTable("#data-table", "{{ route('blog_list') }}", Columns, function (d) {
                d.name = $('#search-name').val();
                d.status = $('#status').val();
            });

            $('#search-name, #status').on('change keyup', function () {
                table1.draw();
            });

        });


        function deleteBlog(Id) {
            Swal.fire({
                title: 'Are you sure to delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('blog_destroy', ':id') }}".replace(':id', Id);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            Swal.fire('Deleted!', 'Blog deleted successfully.', 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Failed to deleted!', 'error');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }

        function openModal(type, value) {
            var content = '';

            if (type === 'image') {
                content = `<img src="{{ asset('blog') }}/${value}" alt="Image" class="img-fluid" style="width: 100%;">`;
            } else if (type === 'description') {
                content = `<p>${value}</p>`;
            } else {
                return;
            }

            $('#dynamicModalBody').html(content);
            $('#dynamicModal').modal('show');
        }
    </script>
@endpush
