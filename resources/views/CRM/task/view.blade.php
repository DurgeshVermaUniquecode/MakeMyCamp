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
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                                <option value="Incompleted">Incompleted</option>
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
        <h5 class="card-title mb-0">Tasks</h5>

        <a href="{{ route('add_task') }}" class="btn add-new btn-primary"><span><span
                    class="d-flex align-items-center gap-2"><i class="icon-base ti tabler-plus icon-xs"></i> <span
                        class="d-none d-sm-inline-block">Add Task</span></span></span></a>
    </div>

    <div class="card-datatable">
        <table class="table" id="data-table">
            <thead class="border-top">
                <tr>
                    <th>S.No</th>
                    <th>Employee</th>
                    <th>Title</th>
                    <th>Due Date</th>
                    <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>


    <!-- status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusLabel">Change Lead Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="statusBody">
                    <form action="{{ route('status_task') }}" method="post">
                        @csrf
                        <input type="hidden" name="task_id_status" id="task_id_status">
                        <div class="mb-6">
                            <label for="status_modal" class="form-label">Status</label>
                            <select class="form-select" id="status_modal" name="status_modal" aria-label="Select Status"
                                required>
                                <option value="">Select Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                                <option value="Incompleted">Incompleted</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-secondary">Update</button>
                    </form>
                </div>
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
                { data: 'user.name', name: 'user.name' },
                { data: 'title', name: 'title' },
                { data: 'due_date', name: 'due_date' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ];

            const table1 = initializeDataTable('#data-table', '{{ route('task_list') }}', Columns, function (d) {
                d.status = $('#status').val();
            });

            $('#status').on('change keyup', function () {
                table1.draw();
            });
        });

        function statusTask(id,status) {
            $('#task_id_status').val(id);
            $('#status_modal').val(status).trigger('change');
            $('#statusModal').modal('show');
        }
    </script>
@endpush
