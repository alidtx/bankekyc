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
    <main class="c-main" id="form_builder">
        <div class="container-fluid p-2" v-if="mode">
            <div class="fade-in">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header text-center"><h5 style="display: inline-block">Form Builder</h5>
                                <a href="javascript:void(0)" class="float-right text-danger" @click="closeEditor"><i
                                        class="fa fa-window-close"></i></a>
                            </div>
                            <div class="card-body">
                                <validation-observer v-slot="{ handleSubmit }">
                                    <form @submit.prevent="handleSubmit(formSubmit)">
                                        <div class="pt-2 pb-2">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <validation-provider rules="required"
                                                                             v-slot="{ errors }">
                                                            <label for="name">Form Name</label>
                                                            <input class="form-control" id="name"
                                                                   v-bind:class="errors[0]?'border-danger':''"
                                                                   placeholder="Enter Form Name"
                                                                   type="text" v-model="form.name">
                                                        </validation-provider>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <validation-provider rules="required:6"
                                                                             v-slot="{ errors }">
                                                            <label for="type">Partner</label>
                                                            <select class="form-control" id="type"
                                                                    v-bind:class="errors[0]?'border-danger':''"
                                                                    v-model="form.partner_uid">
                                                                <option value=""></option>
                                                                <option v-for="partner in partners"
                                                                        :value="partner.partner_uid">
                                                                    @{{partner.name}}
                                                                </option>
                                                            </select>
                                                        </validation-provider>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <validation-provider rules="required:6"
                                                                             v-slot="{ errors }">
                                                            <label for="type">Form Type</label>
                                                            <select class="form-control" id="type"
                                                                    v-bind:class="errors[0]?'border-danger':''"
                                                                    v-model="form.form_type_code">
                                                                <option value=""></option>
                                                                <option v-for="form in formType"
                                                                        :value="form.type_code">
                                                                    @{{form.title}}
                                                                </option>
                                                            </select>
                                                        </validation-provider>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="type">Parent Form</label>
                                                        <select class="form-control" id="type"
                                                                v-model="form.parent_form_id">
                                                            <option value=""></option>
                                                            <option v-for="partnerForm in partnerForms"
                                                                    :value="partnerForm.is">
                                                                @{{partnerForm.name}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="type">Action URL</label>
                                                        <input class="form-control" id="action_url"
                                                               placeholder="Enter Form Action URL" type="text"
                                                               v-model="form.action_url">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="method">Form Method</label>
                                                        <input class="form-control" id="method"
                                                               placeholder="Enter Form Method (GET,POST..etc)"
                                                               type="text"
                                                               v-model="form.method">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="allowed_platform_type">Allowed Platform</label>
                                                        <validation-provider rules="required"
                                                                             v-slot="{ errors }">
                                                            <v-select
                                                                multiple
                                                                v-bind:class="errors[0]?'border-danger':''"
                                                                placeholder="Select Platform Type"
                                                                label="title"
                                                                v-model="form.allowed_platform_type"
                                                                :options="platforms"></v-select>
                                                        </validation-provider>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="type">Score Type</label>
                                                        <select class="form-control" id="type"
                                                                v-model="form.score_type_uid">
                                                            <option value=""></option>
                                                            <option v-for="score_type in scoreType"
                                                                     :value="score_type.score_type_uid">
                                                                @{{score_type.score_type_title}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="id">Form HTML ID</label>
                                                        <input class="form-control" id="id"
                                                               placeholder="Enter Form HTML ID" type="text"
                                                               v-model="form.form_id">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="class">HTML Class</label>
                                                        <input class="form-control" id="class"
                                                               placeholder="Enter Form HTML Class" type="text"
                                                               v-model="form.form_class">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="kyc_type">KYC Type</label>

                                                         <select class="form-control"
                                                                    id="kyc_type"
                                                                    type="text"

                                                                    v-model="form.kyc_type">
                                                                 <option value="undefined" selected>
                                                                    Select KYC Type
                                                                </option>
                                                                <option value="simplified">Simplified</option>
                                                                <option value="regular">Regular</option>
                                                               
                                                            </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="is_form_step_multiple"
                                                               type="checkbox"
                                                               v-model="form.is_form_step_multiple">
                                                        <label class="form-check-label" for="is_form_step_multiple">IS
                                                            Multiple Step</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="is_layer_type_multiple"
                                                               type="checkbox"
                                                               v-model="form.is_layer_type_multiple">
                                                        <label class="form-check-label" for="is_layer_type_multiple">IS
                                                            Multiple Layer Type</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="is_scoring_enable"
                                                               type="checkbox"
                                                               v-model="form.is_scoring_enable">
                                                        <label class="form-check-label" for="is_scoring_enable">IS
                                                            Scoring Enable</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="status"
                                                               type="checkbox"
                                                               v-model="form.status">
                                                        <label class="form-check-label" for="status">IS Active</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions  p-2 m-0">
                                            <button class="btn btn-success float-right"
                                                    type="submit">
                                                Submit Form
                                            </button>
                                        </div>
                                    </form>
                                </validation-observer>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>
                <!-- /.row-->
            </div>
        </div>
        <div class="container-fluid p-2">
            <div class="fade-in">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <h5 style="display: inline-block">Form List</h5>
                                <a href="javascript:void(0)" class="float-right text-primary"
                                   v-bind:disabled="mode !== undefined||mode==='create'" @click="addForm"><i
                                        class="fa fa-plus-square"></i></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" style="width:100%">
                                    <table id="form-table" class="table table-bordered table-striped" width="100%">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>
                <!-- /.row-->
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
                el: "#form_builder",
                data: {
                    form: {
                        id: undefined,
                        partner_uid: undefined,
                        name: undefined,
                        form_id: undefined,
                        action_url: undefined,
                        form_class: undefined,
                        kyc_type:undefined,
                        parent_form_id: undefined,
                        form_type_code: undefined,
                        is_form_step_multiple: false,
                        is_layer_type_multiple: false,
                        is_scoring_enable: false,
                        status: true,
                        score_type_uid: undefined,
                        allowed_platform_type: [],
                        method: undefined,
                    },
                    partners: [],
                    formType: [],
                    scoreType: [],
                    dataTableData: [],
                    partnerForms: [],
                    dataTable: {},
                    mode: undefined,
                    error: undefined,
                    formData: undefined,
                    selectedIndex: undefined,
                },
                methods: {
                    ajaxCall: window.ajaxCall,
                    responseProcess: window.responseProcess,
                    dataTableInit(data) {
                        this.dataTable = $('#form-table').DataTable({
                            processing: true,
                            serverSide: true,
                            pagingType: "full_numbers",

                            ajax: {
                                url: '/api/v1/form?datatale=1',
                                type: 'GET',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    ...data
                                },
                            },
                            columns: [
                                {
                                    className: 'control',
                                    orderable: false,
                                    defaultContent: '',
                                    targets: 0,
                                    title: ''
                                },
                                {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'partner_name',
                                    name: 'partner_name',
                                    defaultContent: '',
                                    title: 'Parent Name'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'name',
                                    name: 'name', render(data, type, row) {
                                        return data;
                                    },
                                    defaultContent: '',
                                    title: 'Name'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'form_id',
                                    name: 'form_id', render(data, type, row) {
                                        return data;
                                    },
                                    defaultContent: '',
                                    title: 'Form HTML ID'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'action_url',
                                    name: 'action_url',
                                    defaultContent: '',
                                    title: 'Action URL'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'form_class',
                                    name: 'form_class',
                                    defaultContent: '',
                                    title: 'Form HTML Class'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'kyc_type',
                                    name: 'kyc_type',
                                    defaultContent: '',
                                    title: 'KYC Type'
                                },
                                
                                {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'parent_form_id',
                                    name: 'parent_form_id', render(data, type, row) {
                                        return data ? data : `<span class='badge badge-danger'>Parent</span>`;

                                    },
                                    defaultContent: '',
                                    title: 'Parent Form ID'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'form_type_title',
                                    name: 'form_type_title',
                                    defaultContent: '',
                                    title: 'Form Type Title'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'is_form_step_multiple',
                                    name: 'is_form_step_multiple', render(data, type, row) {
                                        return data ? `<span class='badge badge-info'>Yes</span>` : `<span class='badge badge-danger'>NO</span>`;

                                    },
                                    defaultContent: '',
                                    title: 'Name'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'is_layer_type_multiple',
                                    name: 'is_layer_type_multiple', render(data, type, row) {
                                        return data ? `<span class='badge badge-info'>Yes</span>` : `<span class='badge badge-danger'>NO</span>`;
                                    },
                                    defaultContent: '',
                                    title: 'Layer Type Multiple'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'is_scoring_enable',
                                    name: 'is_scoring_enable', render(data, type, row) {
                                        return data ? `<span class='badge badge-info'>Enable</span>` : `<span class='badge badge-danger'>Disable</span>`;
                                    },
                                    defaultContent: '',
                                    title: 'Scoring'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'score_type_uid',
                                    name: 'score_type_uid',
                                    defaultContent: '',
                                    title: 'Score Type UID'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'allowed_platform_type', render(data, type, row) {
                                        return data?data.map(el=>{
                                            return `<span class="badge badge-info ml-1">${el}</span>`;
                                        }).join(''):'';
                                    },
                                    name: 'allowed_platform_type',
                                    defaultContent: '',
                                    title: 'Allow Platform Type'
                                }, {
                                    className: 'details-control',
                                    orderable: true,
                                    data: 'method',
                                    name: 'method',
                                    defaultContent: '',
                                    title: 'HTTP Method'
                                },
                                {
                                    className: 'all',
                                    orderable: true,
                                    data: 'status', render(data, row, type) {
                                        return data ? `<span class='badge badge-info'>Active</span>` : `<span class='badge badge-danger'>Inactive</span>`;
                                    },
                                    name: 'status',
                                    defaultContent: '',
                                    title: 'Status'
                                },
                                {
                                    className: 'all',
                                    orderable: true,
                                    data: 'id', render(data, row, type) {
                                        return `<a class='badge badge-primary' href="/form/${data}" target="_blank"> <i class="fa fa-street-view"></i>View</a>
                                                <a class='badge badge-primary' href="/form/${data}/form-field" target="_blank"> <i class="fa fa-plus"></i>Field</a>
                                                <a class='badge badge-success' href="/form/${data}/form-section"> <i class="fa fa-plus"></i> Section</a>
                                                <a class='badge badge-primary' href="/form/${data}/score-mapping"> <i class="fa fa-edit"></i> Score Mapping</a>
                                                <button class='badge badge-info edit_form'> <i class="fa fa-edit"></i>Edit</button>
                                                <button class='badge badge-danger delete_form'> <i class="fa fa-remove"></i>Delete</button>
                                            `;
                                    },
                                    defaultContent: 'Action',
                                    title: 'Action'
                                }
                            ],
                            order: [[15, 'desc']],
                            bDestroy: true,
                            responsive: {
                                details: {
                                    type: 'column',
                                }
                            },
                        });
                    },
                    reset() {
                        this.form = {
                            id: undefined,
                            partner_uid: undefined,
                            name: undefined,
                            form_id: undefined,
                            action_url: undefined,
                            form_class: undefined,
                            kyc_type:undefined,
                            parent_form_id: undefined,
                            form_type_code: undefined,
                            is_form_step_multiple: undefined,
                            is_layer_type_multiple: undefined,
                            is_scoring_enable: undefined,
                            score_type_uid: undefined,
                            allowed_platform_type: [],
                            method: undefined,
                        };
                        this.mode = undefined;
                        this.error = undefined;
                        this.formData = undefined;
                        this.selectedIndex = undefined;
                    },
                    addForm() {
                        this.reset();
                        this.mode = 'create';
                    },
                    closeEditor() {
                        this.mode = undefined;
                    },
                    formSubmit() {
                        let url = '/api/v1/form';
                        let method = 'post';
                        if (this.mode === 'edit') {
                            url += '/' + this.dataTableData[+this.selectedIndex].id;
                            method = 'put';
                        }
                        this.ajaxCall(url, this.form, method, (data, code) => {
                            if (code === 200) {
                                this.dataTableData = this.dataTable.rows().data();
                                this.reset();
                                if (this.mode === 'edit') {
                                    this.dataTableData[this.selectedIndex] = data;
                                    this.mode = 'edit';
                                } else {
                                    this.dataTableData.push(data);
                                    this.mode = 'create';
                                }
                                this.dataTable.clear();
                                this.dataTable.rows.add(this.dataTableData);
                                this.dataTable.draw();
                                this.reset();
                                this.parentFormList();
                            }
                        }, true)
                    },
                    parentFormList() {
                        this.ajaxCall('/api/v1/parent-forms', {}, 'get', (data, code) => {
                            if (code === 200) {
                                this.partnerForms = data;
                            }
                        }, false);
                    }
                },
                mounted() {
                    this.ajaxCall('/api/v1/form-types-admin', {}, 'get', (data, code) => {
                        console.log(data);
                        if (code === 200) {
                            this.formType = data;
                        }
                    }, false);
                    this.ajaxCall('/api/v1/partners', {}, 'get', (data, code) => {
                        if (code === 200) {
                            this.partners = data;
                        }
                    }, false);
                    this.ajaxCall('/api/v1/score-type', {}, 'get', (data, code) => {
                        if (code === 200) {
                            this.scoreType = data.score_type||[];
                        }
                    }, false);

                    this.parentFormList();
                    this.dataTableInit({});
                    const that = this;
                    $('#form-table tbody').on('click', '.view_form', function () {
                        that.reset();
                        that.mode = 'edit';
                        that.dataTableData = that.dataTable.rows().data();
                        that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
                        that.form = that.dataTableData[that.selectedIndex];
                    });
                    $('#form-table tbody').on('click', '.edit_form', function () {
                        that.reset();
                        that.mode = 'edit';
                        that.dataTableData = that.dataTable.rows().data();
                        that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
                        that.form = that.dataTableData[that.selectedIndex];
                        // that.form.allowed_platform_type = that.dataTableData[that.selectedIndex].allowed_platform_type ? that.dataTableData[that.selectedIndex].allowed_platform_type.split(',') : [];
                    });

                    $('#form-table tbody').on('click', '.delete_form', function () {
                        swal.fire({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover this data",
                            icon: "warning",
                            showCancelButton: true,
                        }).then(({dismiss, isConfirmed, isDismissed,}) => {
                            if (isConfirmed) {
                                that.state = undefined;
                                that.dataTableData = that.dataTable.rows().data();
                                that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
                                that.ajaxCall('/api/v1/form/' + that.dataTableData[that.selectedIndex].id, {}, 'delete', (data, code) => {
                                    if (code === 200) {
                                        that.dataTableData.splice(that.selectedIndex, 1);
                                        that.dataTable.clear();
                                        that.dataTable.rows.add(that.dataTableData);
                                        that.dataTable.draw();
                                        that.reset();
                                        that.parentFormList();
                                    }
                                }, true);
                            }
                        });
                    });

                },
                computed: {
                    platforms: () => ['WEB', 'ANDROID', 'IOS', 'KIOSK'],
                }
            })
        ;
    </script>
@endpush
