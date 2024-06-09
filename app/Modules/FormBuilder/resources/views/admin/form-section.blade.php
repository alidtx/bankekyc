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
    <div class="container-fluid" v-if="mode">
        <div class="fade-in">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 style="display: inline-block">Form Section
                                Builder</h5>
                            <a href="javascript:void(0)" class="float-right text-danger" @click="closeEditor"><i class="fa fa-window-close"></i></a>
                        </div>
                        <div class="card-body">
                            <validation-observer v-slot="{ handleSubmit }">
                                <form @submit.prevent="handleSubmit(formSubmit)">
                                    {{-- <form class="form-horizontal">--}}
                                    <div class="mt-2 mb-2"></div>
                                    <div class="">
                                        <div class="card">
                                            <div class="card-header text-center p-2">
                                                <h5 style="display: inline-block">
                                                    Section</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row pt-1">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <validation-provider rules="required" v-slot="{ errors }">
                                                                <label :for="'section_title'">Section
                                                                    Name</label>
                                                                <input class="form-control" :id="'section_name'" placeholder="Enter Section Name" v-bind:class="errors[0]?'border-danger':''" type="text" v-model="section.name">
                                                            </validation-provider>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label :for="'section_form_platform_type'">Platform
                                                                Type</label>
                                                            <validation-provider rules="required" v-slot="{ errors }">
                                                                <v-select :id="'section_form_platform_type'" placeholder="Select Platform" v-bind:class="errors[0]?'border-danger':''" v-model="section.form_platform_type" :options="platformList"></v-select>
                                                            </validation-provider>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label :for="'section_class'">Section HTML
                                                                Class</label>
                                                            <input class="form-control" :id="'section_class'" placeholder="Enter Section HTML Class" type="text" v-model="section.section_class">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label :for="'section_id'">Section
                                                                HTML ID</label>
                                                            <input class="form-control" :id="'section_class'" placeholder="Enter Section HTML ID" type="text" v-model="section.section_id">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <validation-provider rules="required" v-slot="{ errors }">

                                                                <label :for="'section_sequence'">Section
                                                                    Sequence</label>
                                                                <input class="form-control" :id="'section_sequence'" v-bind:class="errors[0]?'border-danger':''" placeholder="Enter Section Sequence" type="number" v-model="section.sequence">
                                                            </validation-provider>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label :for="'section_api_endpoint'">API End
                                                                Point</label>
                                                            <input class="form-control" :id="'section_api_endpoint'" placeholder="Enter API End Point" type="text" v-model="section.api_endpoint">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label :for="'section_validation_api_url'">Validation
                                                                API URL</label>
                                                            <input class="form-control" :id="'section_validation_api_url'" placeholder="Enter Validation API URL" type="text" v-model="section.validation_api_url">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label :for="'section_verification_type'">Verification Type
                                                            </label>
                                                            <select class="form-control" :id="'section_verification_type'" v-model="section.verification_type">
                                                                <option value="" selected>
                                                                    Select Verification Type
                                                                </option>
                                                                <option value="READ_NID_BASIC">READ NID BASIC</option>
                                                                <option value="NID_OCR">NID OCR</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <validation-provider rules="required:6" v-slot="{ errors }">
                                                                <label :for="'section_section_type'">Section Type</label>
                                                                <select class="form-control" :id="'section_section_type'" type="text" v-bind:class="errors[0]?'border-danger':''" v-model="section.section_type">
                                                                    <option value="" selected>
                                                                        Select Section Type
                                                                    </option>
                                                                    <option value="uploader_form">Uploader</option>
                                                                    <option value="basic_form">Basic</option>
                                                                    <option value="both_form">Both</option>
                                                                    </option>
                                                                </select>
                                                            </validation-provider>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <validation-provider rules="required:6" v-slot="{ errors }">
                                                                <label :for="'is_show_on_tab'">Show On Tab ?</label>
                                                                <select class="form-control" :id="'is_show_on_tab'" type="text" v-bind:class="errors[0]?'border-danger':''" v-model="section.is_show_on_tab">
                                                                    <option value="" disabled>
                                                                        Select
                                                                    </option>
                                                                    <option selected value=1>Yes</option>
                                                                    <option value=0>No</option>
                                                                    </option>
                                                                </select>
                                                            </validation-provider>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" :id="'section_should_validated'" type="checkbox" v-model="section.should_validated">
                                                            <label class="form-check-label" :for="'section_should_validated'">Should
                                                                Validated</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" :id="'section_carry_forward_data'" type="checkbox" v-model="section.carry_forward_data">
                                                            <label class="form-check-label" :for="'section_carry_forward_data'">Carry Forward Data
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" :id="'section_preview_on'" type="checkbox" v-model="section.is_preview_on">
                                                            <label class="form-check-label" :for="'section_preview_on'">Preview On
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" :id="'section_preview_on'" type="checkbox" v-model="section.can_go_previous_step">
                                                            <label class="form-check-label" :for="'section_preview_on'">Go Previous Step
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions  p-2 m-0">
                                        <button class="btn btn-success float-right" type="submit">
                                            Submit Form
                                        </button>
                                    </div>
                                    {{-- </form>--}}
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
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 style="display: inline-block">{{ $selectedForm->name }} Form Section List</h5>
                            <div class="d-inline-block float-right">
                                <a href="/form/{{$id}}/form-field" class="btn btn-info"><i class="fa fa-plus-square"></i>Field</a>
                                <a href="javascript:void(0)" class="btn btn-info ml-2" v-bind:disabled="mode !== undefined||mode==='create'" @click="addForm"><i class="fa fa-plus-square"></i>Section</a>
                            </div>
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
            section: {
                form_id: "{{$id}}",
                name: undefined,
                form_platform_type: undefined,
                verification_type: undefined,
                section_type: undefined,
                section_id: undefined,
                section_class: undefined,
                api_endpoint: undefined,
                should_validated: undefined,
                carry_forward_data: undefined,
                can_go_previous_step: undefined,
                is_preview_on: undefined,
                validation_api_url: undefined,
                field_mapper_data: undefined,
                sequence: undefined,
            },
            platformList: [],
            dataTableData: [],
            dataTable: {},
            mode: undefined,
            error: undefined,
            formData: undefined,
            selectedIndex: undefined,
        },
        methods: {
            dataTableInit(data) {
                this.dataTable = $('#form-table').DataTable({
                    processing: true,
                    serverSide: true,
                    pagingType: "full_numbers",

                    ajax: {
                        url: '/api/v1/form-section?datatable=1&form_id={{$id}}',
                        type: 'GET',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            ...data
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
                            data: 'form_id',
                            name: 'form_id',
                            defaultContent: '',
                            title: 'Form ID'
                        }, {
                            className: 'details-control',
                            orderable: true,
                            data: 'name',
                            name: 'name',
                            defaultContent: '',
                            title: 'Name'
                        }, {
                            className: 'details-control',
                            orderable: true,
                            data: 'form_platform_type',
                            name: 'form_platform_type',
                            defaultContent: '',
                            title: 'From Platform Type'
                        }, {
                            className: 'details-control',
                            orderable: true,
                            data: 'verification_type',
                            name: 'verification_type',
                            defaultContent: '',
                            title: 'Verification Type'
                        },
                        {
                            className: 'details-control',
                            orderable: true,
                            data: 'section_type',
                            name: 'section_type',
                            defaultContent: '',
                            title: 'Section Type'
                        }, {
                            className: 'details-control',
                            orderable: true,
                            data: 'section_id',
                            name: 'section_id',
                            defaultContent: '',
                            title: 'Section HTML ID'
                        }, {
                            className: 'details-control',
                            orderable: true,
                            data: 'section_class',
                            name: 'section_class',
                            defaultContent: '',
                            title: 'Form HTML ID'
                        }, {
                            className: 'details-control',
                            orderable: true,
                            data: 'api_endpoint',
                            name: 'api_endpoint',
                            defaultContent: '',
                            title: 'API End Point'
                        }, {
                            className: 'details-control',
                            orderable: true,
                            data: 'should_validated',
                            render(data, type, row) {
                                return data ? `<span class='badge badge-info'>Yes</span>` : `<span class='badge badge-danger'>NO</span>`;
                            },
                            name: 'should_validated',
                            defaultContent: '',
                            title: 'Should Validated'
                        }, {
                            className: 'details-control',
                            orderable: true,
                            data: 'carry_forward_data',
                            render(data, type, row) {
                                return data ? `<span class='badge badge-info'>Yes</span>` : `<span class='badge badge-danger'>NO</span>`;
                            },
                            name: 'carry_forward_data',
                            defaultContent: '',
                            title: 'Carry Forward'
                        }, {
                            className: 'details-control',
                            orderable: true,
                            data: 'is_preview_on',
                            render(data, type, row) {
                                return data ? `<span class='badge badge-info'>Yes</span>` : `<span class='badge badge-danger'>NO</span>`;
                            },
                            name: 'is_preview_on',
                            defaultContent: '',
                            title: 'Preview On'
                        }, {
                            className: 'details-control',
                            orderable: true,
                            data: 'can_go_previous_step',
                            render(data, type, row) {
                                return data ? `<span class='badge badge-info'>Yes</span>` : `<span class='badge badge-danger'>NO</span>`;
                            },
                            name: 'can_go_previous_step',
                            defaultContent: '',
                            title: 'Gp Previous Step'
                        }, {
                            className: 'details-control',
                            orderable: true,
                            data: 'validation_api_url',
                            name: 'validation_api_url',
                            defaultContent: '',
                            title: 'Validation API URL'
                        },
                        {
                            className: 'all',
                            orderable: true,
                            data: 'id',
                            render(data, row, type) {
                                return `    <button class='badge badge-info edit_form'> <i class="fa fa-edit"></i>Edit</button>
                                                <button class='badge badge-danger delete_form'> <i class="fa fa-remove"></i>Delete</button>
                                            `;
                            },
                            defaultContent: 'Action',
                            title: 'Action'
                        }
                    ],
                    order: [
                        [1, 'asc']
                    ],
                    bDestroy: true,
                    responsive: {
                        details: {
                            type: 'column',
                        }
                    },
                });
            },
            ajaxCall: window.ajaxCall,
            responseProcess: window.responseProcess,
            reset() {
                this.section = {
                    form_id: "{{$id}}",
                    name: undefined,
                    form_platform_type: undefined,
                    verification_type: undefined,
                    section_type: undefined,
                    section_id: undefined,
                    section_class: undefined,
                    api_endpoint: undefined,
                    should_validated: undefined,
                    carry_forward_data: undefined,
                    can_go_previous_step: undefined,
                    is_preview_on: undefined,
                    validation_api_url: undefined,
                    field_mapper_data: undefined,
                    sequence: undefined,
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
                let url = '/api/v1/form-section';
                let method = 'post';
                if (this.mode === 'edit') {
                    url += '/' + this.dataTableData[+this.selectedIndex].id;
                    method = 'put';
                }
                this.ajaxCall(url, this.section, method, (data, code) => {
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
                    }
                }, true)
            },
        },
        mounted() {
            this.dataTableInit({});
            this.ajaxCall('/api/v1/form/{{$id}}/platforms', {}, 'get', (data, code) => {
                if (code === 200) {
                    this.platformList = data.platformList;
                }
            }, false);
            const that = this;
            $('#form-table tbody').on('click', '.edit_form', function() {
                that.reset();
                that.mode = 'edit';
                that.dataTableData = that.dataTable.rows().data();
                that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
                that.section = that.dataTableData[that.selectedIndex];
            });

            $('#form-table tbody').on('click', '.delete_form', function() {
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data",
                    icon: "warning",
                    showCancelButton: true,
                }).then(({
                    dismiss,
                    isConfirmed,
                    isDismissed,
                }) => {
                    if (isConfirmed) {
                        that.state = undefined;
                        that.dataTableData = that.dataTable.rows().data();
                        that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
                        that.ajaxCall('/api/v1/form-section/' + that.dataTableData[that.selectedIndex].id, {}, 'delete', (data, code) => {
                            if (code === 200) {
                                that.dataTableData.splice(that.selectedIndex, 1);
                                that.dataTable.clear();
                                that.dataTable.rows.add(that.dataTableData);
                                that.dataTable.draw();
                                that.reset();
                            }
                        }, true);
                    }
                });
            });

        }
    });
</script>
@endpush