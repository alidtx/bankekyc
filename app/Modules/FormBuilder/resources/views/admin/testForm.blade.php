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
                                <a href="javascript:void(0)" class="float-right text-danger" @click="closeEditor"><i class="fa fa-window-close"></i></a>
                            </div>
                            <div class="card-body">
                                
                                
                                <validation-observer v-slot="{ handleSubmit }">
                                    <form @submit.prevent="handleSubmit(formSubmit)">
                                        <div class="pt-2 pb-2">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <validation-provider rules="required"  v-slot="{ errors }">
                                                            <label for="personName">Person Name</label>
                                                            <input class="form-control" id="personName" v-bind:class="errors[0]?'border-danger':''" placeholder="Enter Form Person Name"  type="text" v-model="form.personName">
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
                                                
                                            </div>
                                        </div>
                                    </form>
                                </validation-observer>
                                
                                
                                
                            </div>
                        </div>
                    </div>
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
                el: "#form_builder",
                data: {
                    form: {
                        personName:undefined,
                        partner_uid: undefined,
                    },
                    mode: true,
                    partners: []
                },
                methods:{
                    closeEditor(){
                        this.mode = false;
                    },
                    formSubmit(){
                        
                    }
                }
            });
    </script>
@endpush
