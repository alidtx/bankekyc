@extends('layout.admin.master')
@section('lib-css')
<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.css')}}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endsection
@push('custom-css')
<style type="text/css">

</style>
@endpush
@section('content')
<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row" id="approved-application">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center"><strong>Pending List</strong></h4>
                            <hr class="m-3">
                            <div class="row text-center">
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">Deposit Account</div>
                                    <strong>250352 Account (52%)</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 52%"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">FDR</div>
                                    <strong>78502 Application (37%)</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                            style="width: 37%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">Loan Account</div>
                                    <strong>22123 Application (11%)</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-gradient-danger" role="progressbar"
                                            style="width: 11%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive" style="width:100%">
                                    <table id="pending-application-table" class="table table-bordered table-striped"
                                        width="100%">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main>
@endsection
@section('lib-js')
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.js')}}"></script>
@endsection

@push('custom-js')
<script>
const form_builder = new Vue({
    el: "#approved-application",
    data: {
        dataTableData: [],
        dataTable: {},
        selectedIndex: undefined,
    },
    methods: {
        dataTableInit() {
            this.dataTable = $('#pending-application-table').DataTable({
                processing: true,
                // serverSide: true,
                pagingType: "full_numbers",

                ajax: {
                    url: '/api/v1/dynamic-application-list',
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "status": "pending",
                        "role": "approver"
                    },
                    dataSrc: function({
                        data
                    }) {
                        return data.form_complete_value;
                    },
                },

                columns: [{
                        className: 'control',
                        orderable: false,
                        defaultContent: '',
                        targets: 0,
                        title: ''
                    },
                    {
                        className: 'details-control',
                        orderable: true,
                        data: 'form_name',
                        name: 'form_name',
                        defaultContent: '',
                        title: 'Form Name'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'form_type',
                        name: 'form_type',
                        defaultContent: '',
                        title: 'Form Type'
                    },
                    {
                        className: 'details-control',
                        orderable: true,
                        data: 'request_tracking_uid',
                        name: 'request_tracking_uid',
                        defaultContent: '',
                        title: 'Request Tracking UID'
                    },
                    // {
                    //     className: 'details-control',
                    //     orderable: true,
                    //     data: 'form_data', render(data, type, row) {
                    //         return data.full_name?.value || "";
                    //     },
                    //     name: 'form_data',
                    //     defaultContent: '',
                    //     title: 'Applicant Name',
                    // }, 
                    {
                        className: 'details-control',
                        orderable: true,
                        data: 'unique_key',
                        name: 'unique_key',
                        defaultContent: '',
                        title: 'Unique ID No.'
                    },
                    {
                        className: 'details-control',
                        orderable: true,
                        data: 'requested_via',
                        name: 'requested_via',
                        defaultContent: '',
                        title: 'Request VIA'
                    },
                    {
                        className: 'details-control',
                        orderable: true,
                        data: 'agent_name',
                        name: 'agent_name',
                        defaultContent: '',
                        title: 'Agent Name'
                    },
                    {
                        className: 'details-control',
                        orderable: true,
                        data: 'calculated_score',
                        name: 'calculated_score',
                        defaultContent: '',
                        title: 'Score'
                    },
                    {
                        className: 'details-control',
                        orderable: true,
                        data: 'application_start_date',
                        name: 'application_start_date',
                        defaultContent: '',
                        title: 'Application Started At'
                    },
                    {
                        className: 'details-control',
                        orderable: true,
                        data: 'application_last_updated_date',
                        name: 'application_last_updated_date',
                        defaultContent: '',
                        title: 'Application Completed At'
                    },
                    {
                        className: 'details-control',
                        orderable: true,
                        data: 'allowed_platform_type',
                        name: 'allowed_platform_type',
                        defaultContent: '',
                        title: ' Allow Platform Types'
                    },
                    {
                        className: 'all',
                        orderable: true,
                        data: 'form_id',
                        render(data, type, row) {
                            return `<a class='badge badge-primary' href='/application/web/${row.request_tracking_uid}' target="_blank"> <i class="fa fa-street-view"></i>View</a>`;
                        },
                        defaultContent: 'Action',
                        title: 'Action'
                    }
                ],
                order: [
                    [10, 'desc']
                ],
                bDestroy: true,
                responsive: {
                    details: {
                        type: 'column',
                    }
                },
            });
        },
    },
    mounted() {
        this.dataTableInit({});
        const that = this;
        $('#form-table tbody').on('click', '.view_form', function() {
            that.reset();
            that.mode = 'edit';
            that.dataTableData = that.dataTable.rows().data();
            that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
        });
    },
});
</script>
@endpush