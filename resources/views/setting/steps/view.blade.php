@extends('layouts.app')
@section('content')


    <!-- Content -->
    {{-- <div class="container-xxl flex-grow-1 container-p-y">


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
                                        <option value="Prospecting">Prospecting</option>
                                        <option value="Converted">Converted</option>
                                        <option value="Closed">Closed</option>
                                    </select>
                                </div>

                            </div>

                    </div>
                </div>
            </div>
        </div>


    </div> --}}

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-0">Steps</h5>

            <a href="{{ route('add_step') }}" class="btn add-new btn-primary"><span><span
                        class="d-flex align-items-center gap-2"><i class="icon-base ti tabler-plus icon-xs"></i> <span
                            class="d-none d-sm-inline-block">Add Steps</span></span></span></a>
        </div>

        <div class="card-datatable">
            <table class="table" id="data-table">
                <thead class="border-top">
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Icon</th>
                        <th>Order</th>
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

            const datatable = document.querySelector('#data-table');
            let table;

            if (datatable) {

                table = new DataTable(datatable, {
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('steps_list') }}',
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'icon',
                            name: 'icon'
                        },
                        {
                            data: 'order',
                            name: 'order'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    layout: {
                        topStart: {
                            rowClass: 'row m-3 my-0 justify-content-between',
                            features: [{
                                pageLength: {
                                    menu: [10, 25, 50, 100],
                                    text: '_MENU_'
                                }
                            }]
                        },
                        topEnd: {
                            features: [{
                                    search: {
                                        placeholder: 'Search here',
                                        text: '_INPUT_'
                                    }
                                },
                                {
                                    buttons: [{
                                        extend: 'collection',
                                        className: 'btn btn-label-secondary dropdown-toggle',
                                        text: '<span class="d-flex align-items-center gap-2"><i class="icon-base ti tabler-upload icon-xs"></i> <span class="d-none d-sm-inline-block">Export</span></span>',
                                        buttons: [{
                                                extend: 'print',
                                                text: `<span class="d-flex align-items-center"><i class="icon-base ti tabler-printer me-1"></i>Print</span>`,
                                                className: 'dropdown-item',
                                                exportOptions: {
                                                    columns: [0, 1, 2, 5],

                                                },

                                            },
                                            {
                                                extend: 'csv',
                                                text: `<span class="d-flex align-items-center"><i class="icon-base ti tabler-file-text me-1"></i>Csv</span>`,
                                                className: 'dropdown-item',
                                                exportOptions: {
                                                    columns: [0, 1, 2, 5],

                                                }
                                            },
                                            {
                                                extend: 'excel',
                                                text: `<span class="d-flex align-items-center"><i class="icon-base ti tabler-file-spreadsheet me-1"></i>Excel</span>`,
                                                className: 'dropdown-item',
                                                exportOptions: {
                                                    columns: [0, 1, 2, 5],

                                                }
                                            },
                                            {
                                                extend: 'pdf',
                                                text: `<span class="d-flex align-items-center"><i class="icon-base ti tabler-file-description me-1"></i>Pdf</span>`,
                                                className: 'dropdown-item',
                                                exportOptions: {
                                                    columns: [0, 1, 2, 5],

                                                }
                                            },
                                            {
                                                extend: 'copy',
                                                text: `<i class="icon-base ti tabler-copy me-1"></i>Copy`,
                                                className: 'dropdown-item',
                                                exportOptions: {
                                                    columns: [0, 1, 2, 5],

                                                }
                                            }
                                        ]
                                    }, ]
                                }
                            ]
                        },
                        bottomStart: {
                            rowClass: 'row mx-3 justify-content-between',
                            features: ['info']
                        },
                        bottomEnd: 'paging'
                    },
                    language: {
                        paginate: {
                            next: '<i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-18px"></i>',
                            previous: '<i class="icon-base ti tabler-chevron-left scaleX-n1-rtl icon-18px"></i>',
                            first: '<i class="icon-base ti tabler-chevrons-left scaleX-n1-rtl icon-18px"></i>',
                            last: '<i class="icon-base ti tabler-chevrons-right scaleX-n1-rtl icon-18px"></i>'
                        }
                    },

                });


            }

        });


       function deleteStep(stepId) {
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
                    let url = "{{ route('status_steps', ':id') }}".replace(':id', stepId);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            Swal.fire('Deleted!', 'Step status changed.', 'success').then(() => {
                                location.reload(); // or remove row from table dynamically
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Failed to delete step.', 'error');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }

    </script>
@endpush
