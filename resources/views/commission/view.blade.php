@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between">
        <h5 class="card-title mb-0">Commssions</h5>

    </div>

    <div class="card-datatable">
        <table class="table" id="data-table">
            <thead class="border-top">
                <tr>
                    <th>S.No</th>
                    <th>Type</th>
                    <th>User Name</th>
                    <th>Employee Name</th>
                    <th>Package Name</th>
                    <th>Amount</th>
                    <th>Date</th>
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
                            url: '{{ route('commission') }}',
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'type',
                                name: 'type'
                            },
                            {
                                data: 'user.name',
                                name: 'user.name'
                            },
                            {
                                data: 'employee.name',
                                name: 'employee.name'
                            },
                            {
                                data: 'package.name',
                                name: 'package.name'
                            }
                            ,{
                                data: 'amount',
                                name: 'amount'
                            },{
                                data: 'created_at',
                                name: 'created_at'
                            }

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



        </script>
    @endpush
