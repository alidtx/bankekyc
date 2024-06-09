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
<main class="c-main" id="account_type">
    <div class="container-fluid p-2" v-if="mode">
        <div class="fade-in">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center"><h5 style="display: inline-block">Account Type</h5>
                            <a href="javascript:void(0)" class="float-right text-danger" @click="closeEditor"><i
                                    class="fa fa-window-close"></i></a>
                        </div>
                        <div class="card-body">
                            <validation-observer v-slot="{ handleSubmit }">
                                <form @submit.prevent="handleSubmit(formSubmit)" enctype="multipart/form-data">
                                    <div class="pt-2 pb-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <validation-provider rules="required"
                                                                         v-slot="{ errors }">
                                                        <label for="account_type_title">Account Title</label>
                                                        <input class="form-control" id="account_type_title"
                                                               v-bind:class="errors[0]?'border-danger':''"
                                                               placeholder="Enter Account Title"
                                                               type="text" v-model="form.account_type_title">
                                                    </validation-provider>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <validation-provider>
                                                        <label for="account_type_sub_title">Account Sub Title</label>
                                                        <input class="form-control" id="account_type_sub_title" placeholder="Enter Account Sub Title" type="text" v-model="form.account_type_sub_title">
                                                    </validation-provider>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="color">Color</label>
                                                    <input class="form-control" id="color" placeholder="Enter Color" type="text" v-model="form.color">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="icon">Icon</label>
                                                    <input class="form-control" v-on:change="onImageChange" id="icon" placeholder="" type="file">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions  p-2 m-0">
                                            <button class="btn btn-success float-right" type="submit"> Submit Form </button>
                                        </div>
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
                            <h5 style="display: inline-block">Account Type List</h5>
                            <a href="javascript:void(0)" class="float-right text-primary"
                               v-bind:disabled="mode !== undefined||mode==='create'" @click="addForm"><i
                                    class="fa fa-plus-square"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="width:100%">
                                <table id="account_type-table" class="table table-bordered table-striped" width="100%">
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

var baseUrl = '{{ url('') }}';
const account_type = new Vue({
    el: "#account_type",
    data: {
        form: {
            account_type_title: undefined,
            account_type_sub_title: null,
            color: null,
            icon: ""
        },
        dataTableData: [],
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
            this.dataTable = $('#account_type-table').DataTable({
                processing: true,
                serverSide: true,
                pagingType: "full_numbers",
                ajax: {
                    url: '/api/v1/getAccountType?datatale=1',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        ...data
                    },
                },
                columns: [
                    {
                        className: 'details-control',
                        orderable: true,
                        data: 'account_type_title',
                        name: 'account_type_title',
                        defaultContent: '',
                        title: 'Account Type Title'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'account_type_sub_title',
                        name: 'account_type_sub_title',
                        defaultContent: '',
                        title: 'Account Type Sub Title'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'icon', render(data, row, type) {
                            return data ? `<img src='${baseUrl}/${data}' height='30'>` : "";
                        },
                        name: 'icon',
                        defaultContent: '',
                        title: 'Icon'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'color',
                        name: 'color',
                        defaultContent: '',
                        title: 'Color'
                    },

                    {
                        className: 'all',
                        orderable: true,
                        data: 'is_active', render(data, row, type) {
                            return data ? `<span class='badge badge-info'>Active</span>` : `<span class='badge badge-danger'>Inactive</span>`;
                        },
                        name: 'is_active',
                        defaultContent: '',
                        title: 'Status'
                    },
                    {
                        className: 'all',
                        orderable: true,
                        data: 'is_active', render(data, row, type) {
                            var statusBtn = (data === 1) ? `<button class='badge badge-danger delete_form'> <i class="fa fa-remove"></i>Inactive</button>` : `<button class='badge badge-success delete_form'> <i class="fa fa-remove"></i>Active</button>`;
                            return `<button class='badge badge-info edit_form'> <i class="fa fa-edit"></i>Edit</button>` + statusBtn;

                        },
                        defaultContent: 'Action',
                        title: 'Action'
                    },
                    {
                        className: 'details-control',
                        orderable: true,
                        data: 'id',
                        name: 'id',
                        defaultContent: '',
                        title: 'id',
                        visible: false,
                        searchable:false
                    },
                ],
            });
        },
        reset() {
            this.form = {
                account_type_title: undefined,
                account_type_sub_title: null,
                color: null,
                icon: ""
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
        onImageChange(e) {
            console.log(e.target.files[0]);
            //this.image = e.target.files[0];
            this.form.icon = e.target.files[0];
            // this.form.append('icon', e.target.files[0]);
        },
        formSubmit() {
            let url = '/api/v1/addAccountType';
            let method = 'post';
            let formData = new FormData();
            if (this.mode === 'edit') {
                url = '/api/v1/editAccountType';
                formData.append("id", this.dataTableData[+this.selectedIndex].id);
                method = 'post';
            }
            formData.append("accountTitle", this.form.account_type_title);
            formData.append("accountSubTitle", (this.form.account_type_sub_title) ? this.form.account_type_sub_title : "");
            formData.append("color", (this.form.color) ? this.form.color : "");
            formData.append("icon", this.form.icon);
            // let alert = false;
            //.then(response => this.responseProcess(response.data, alert, (data, code) => callback(data, code)))

            axios.post(url, formData)
                    .then((response) => {
                        console.log(response);
                        if (response.data.status === 'success' || response.data.code === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Yahoo..',
                                text: response.data.message || 'Form saved successfully',
                            });
                            let data = response.data.data;
                            let code = response.data.code;
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
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.data.message || 'Something went wrong! please try again later',
                            });
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            // text: error.data.message || 'Something went wrong! please try again later',
                            text: 'Something went wrong! please try again later',
                        });
                    });

//            axios.post(url, this.form)
//
//
//
//            this.ajaxCall(url, this.form, method, (data, code) => {
//                if (code === 200) {
//                    this.dataTableData = this.dataTable.rows().data();
//                    this.reset();
//                    if (this.mode === 'edit') {
//                        this.dataTableData[this.selectedIndex] = data;
//                        this.mode = 'edit';
//                    } else {
//                        this.dataTableData.push(data);
//                        this.mode = 'create';
//                    }
//                    this.dataTable.clear();
//                    this.dataTable.rows.add(this.dataTableData);
//                    this.dataTable.draw();
//                    this.reset();
//                }
//            }, true)
        }
    },
    mounted() {
        this.dataTableInit({});
        const that = this;
        $('#account_type-table tbody').on('click', '.view_form', function () {
            that.reset();
            that.mode = 'edit';
            that.dataTableData = that.dataTable.rows().data();
            that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
            that.form = that.dataTableData[that.selectedIndex];
        });
        $('#account_type-table tbody').on('click', '.edit_form', function () {
            that.reset();
            that.mode = 'edit';
            that.dataTableData = that.dataTable.rows().data();
            that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
            that.form = that.dataTableData[that.selectedIndex];
// that.form.allowed_platform_type = that.dataTableData[that.selectedIndex].allowed_platform_type ? that.dataTableData[that.selectedIndex].allowed_platform_type.split(',') : [];
        });
        $('#account_type-table tbody').on('click', '.delete_form', function () {
            swal.fire({
                title: "Are you sure?",
                text: "",
                icon: "warning",
                showCancelButton: true,
            }).then(({dismiss, isConfirmed, isDismissed, }) => {
                if (isConfirmed) {
                    that.state = undefined;
                    that.dataTableData = that.dataTable.rows().data();
                    that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
                    that.ajaxCall('/api/v1/statusChangeAccountType?id=' + that.dataTableData[that.selectedIndex].id, {}, 'get', (data, code) => {
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
    },
    computed: {
        platforms: () => ['WEB', 'ANDROID', 'IOS', 'KIOSK'],
    }
})
        ;
</script>
@endpush
