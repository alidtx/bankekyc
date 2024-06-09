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
                        <div class="card-header text-center">
                            <h5 style="display: inline-block">Form Builder</h5>
                            <a href="javascript:void(0)" class="float-right text-danger" @click="closeEditor"><i
                                    class="fa fa-window-close"></i></a>
                        </div>
                        <div class="card-body">
                            <validation-observer v-slot="{ handleSubmit }">
                                <form @submit.prevent="handleSubmit(formSubmit)">
                                    {{--                                <form class="form-horizontal">--}}
                                    <div class="row pt-2 pb-2">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <validation-provider rules="required" v-slot="{ errors }">
                                                    <label for="name">Form Name</label>
                                                    <input class="form-control" id="name"
                                                        v-bind:class="errors[0]?'border-danger':''"
                                                        placeholder="Enter Form Name" type="text" v-model="form.name">
                                                </validation-provider>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <validation-provider rules="required:6" v-slot="{ errors }">

                                                    <label for="type">Form Type</label>
                                                    <input class="form-control" id="type"
                                                        v-bind:class="errors[0]?'border-danger':''"
                                                        placeholder="Enter Form Type" type="text" v-model="form.type">
                                                </validation-provider>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <validation-provider rules="required:6" v-slot="{ errors }">
                                                    <label for="method">Form Method</label>
                                                    <input class="form-control" id="method"
                                                        v-bind:class="errors[0]?'border-danger':''"
                                                        placeholder="Enter Form Method (GET,POST..etc)" type="text"
                                                        v-model="form.method">
                                                </validation-provider>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <validation-provider rules="required:6" v-slot="{ errors }">

                                                    <label for="action_url">Form Action URL</label>
                                                    <input class="form-control" id="action_url"
                                                        v-bind:class="errors[0]?'border-danger':''"
                                                        placeholder="Enter Form Action URL" type="text"
                                                        v-model="form.action_url">
                                                </validation-provider>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="id">Form HTML IDL</label>
                                                <input class="form-control" id="id" placeholder="Enter Form HTML ID"
                                                    type="text" v-model="form.id">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="class">HTML Class</label>
                                                <input class="form-control" id="class"
                                                    placeholder="Enter Form HTML Class" type="text"
                                                    v-model="form.class">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 mb-2"></div>
                                    <div class="">
                                        <div class="card" v-for="(section,i) in form.sections">
                                            <div class="card-header text-center p-2">
                                                <h5 style="display: inline-block">
                                                    Section</h5>
                                                <a href="javascript:void(0)" class="float-right text-danger"
                                                    type="button" v-if="form.sections.length>1"
                                                    @click="removeSection(i)"><i class="fa fa-window-close"></i>
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <div class="row pt-1">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <validation-provider rules="required:6" v-slot="{ errors }">
                                                                <label :for="'section_'+i+'_title'">Section
                                                                    Title</label>
                                                                <input class="form-control" :id="'section_'+i+'_title'"
                                                                    placeholder="Enter Section Title"
                                                                    v-bind:class="errors[0]?'border-danger':''"
                                                                    type="text" v-model="section.title">
                                                            </validation-provider>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label :for="'section_'+i+'_class'">Section
                                                                Class</label>
                                                            <input class="form-control" :id="'section_'+i+'_class'"
                                                                placeholder="Enter Section Class" type="text"
                                                                v-model="section.class">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <validation-provider rules="required" v-slot="{ errors }">

                                                                <label :for="'section_'+i+'_sequence'">Section
                                                                    Sequence</label>
                                                                <input class="form-control"
                                                                    :id="'section_'+i+'_sequence'"
                                                                    v-bind:class="errors[0]?'border-danger':''"
                                                                    placeholder="Enter Section Sequence" type="number"
                                                                    v-model="section.sequence">
                                                            </validation-provider>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card" v-for="(input,j) in section.form_fields">
                                                    <div class="card-header text-center">
                                                        <h5 style="display: inline-block">Form Input Element</h5>
                                                        <a href="javascript:void(0)" class="float-right text-danger"
                                                            v-if="section.form_fields.length>1"
                                                            @click="removeInputElement(i,j)" type="button"><i
                                                                class="fa fa-window-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row pt-1">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <validation-provider rules="required:6"
                                                                        v-slot="{ errors }">
                                                                        <label
                                                                            :for="'section_'+i+'_input_'+j+'_element_type'">Element
                                                                            Type</label>
                                                                        <select class="form-control"
                                                                            :id="'section_'+i+'_input_'+j+'_element_type'"
                                                                            type="text"
                                                                            v-bind:class="errors[0]?'border-danger':''"
                                                                            v-model="input.element_type">
                                                                            <option value="undefined" selected>
                                                                                Select
                                                                                Element
                                                                                Type
                                                                            </option>
                                                                            <option value="input">Input</option>
                                                                            <option value="select">Select</option>
                                                                            <option value="textarea">Textarea
                                                                            </option>
                                                                        </select>
                                                                    </validation-provider>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        :for="'section_'+i+'_input_'+j+'_label'">Label</label>
                                                                    <input class="form-control"
                                                                        :id="'section_'+i+'_input_'+j+'_label'"
                                                                        placeholder="Enter Input Label" type="text"
                                                                        v-model="input.label">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        :for="'section_'+i+'_input_'+j+'_placeholder'">Placeholder</label>
                                                                    <input class="form-control"
                                                                        :id="'section_'+i+'_input_'+j+'_placeholder'"
                                                                        placeholder="Enter Input Placeholder"
                                                                        type="text" v-model="input.placeholder">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <validation-provider rules="required:6"
                                                                        v-slot="{ errors }">
                                                                        <label
                                                                            :for="'section_'+i+'_input_'+j+'_name'">Name</label>
                                                                        <input class="form-control"
                                                                            :id="'section_'+i+'_input_'+j+'_name'"
                                                                            placeholder="Enter Input Name" type="text"
                                                                            v-bind:class="errors[0]?'border-danger':''"
                                                                            v-model="input.name">
                                                                    </validation-provider>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        :for="'section_'+i+'_input_'+j+'_value'">Default
                                                                        Value</label>
                                                                    <input class="form-control"
                                                                        :id="'section_'+i+'_input_'+j+'_value'"
                                                                        placeholder="Enter Input Default Value"
                                                                        type="text" v-model="input.value">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3" v-if="input.element_type ==='input'">
                                                                <div class="form-group">
                                                                    <validation-provider rules="required:6"
                                                                        v-slot="{ errors }">
                                                                        <label
                                                                            :for="'section_'+i+'_input_'+j+'_data_type'">Data
                                                                            Type</label>
                                                                        <input class="form-control"
                                                                            :id="'section_'+i+'_input_'+j+'_data_type'"
                                                                            placeholder="Enter Input Data Type"
                                                                            type="text"
                                                                            v-bind:class="errors[0]?'border-danger':''"
                                                                            v-model="input.data_type">
                                                                    </validation-provider>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3" v-if="input.element_type !=='select'">
                                                                <div class="form-group">
                                                                    <label
                                                                        :for="'section_'+i+'_input_'+j+'_min'">Min</label>
                                                                    <input class="form-control"
                                                                        :id="'section_'+i+'_input_'+j+'_min'"
                                                                        placeholder="Enter Input Min" type="text"
                                                                        v-model="input.min">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3" v-if="input.element_type !=='select'">
                                                                <div class="form-group">
                                                                    <label
                                                                        :for="'section_'+i+'_input_'+j+'_max'">Max</label>
                                                                    <input class="form-control"
                                                                        :id="'section_'+i+'_input_'+j+'_max'"
                                                                        placeholder="Enter Input Max" type="text"
                                                                        v-model="input.max">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        :for="'section_'+i+'_input_'+j+'_pattern'">Pattern</label>
                                                                    <input class="form-control"
                                                                        :id="'section_'+i+'_input_'+j+'_pattern'"
                                                                        placeholder="Enter Input Pattern" type="text"
                                                                        v-model="input.pattern">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        :for="'section_'+i+'_input_'+j+'_custom_validation'">Custom
                                                                        Validation</label>
                                                                    <input class="form-control"
                                                                        :id="'section_'+i+'_input_'+j+'_custom_validation'"
                                                                        placeholder="Enter Input Custom Validation"
                                                                        type="text" v-model="input.custom_validation">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <validation-provider rules="required:6"
                                                                        v-slot="{ errors }">
                                                                        <label
                                                                            :for="'section_'+i+'_input_'+j+'_sequence'">Sequence</label>
                                                                        <input class="form-control"
                                                                            :id="'section_'+i+'_input_'+j+'_sequence'"
                                                                            placeholder="Enter Input Sequence"
                                                                            type="number"
                                                                            v-bind:class="errors[0]?'border-danger':''"
                                                                            v-model="input.sequence">
                                                                    </validation-provider>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-form-label">
                                                                <div class="form-check form-check-inline mr-1">
                                                                    <input class="form-check-input"
                                                                        :id="'section_'+i+'_input_'+j+'_is_required'"
                                                                        type="checkbox" v-model="input.is_required">
                                                                    <label class="form-check-label"
                                                                        for="'section_'+i+'_input_'+j+'_is_required'">Is
                                                                        Required</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-form-label">
                                                                <div class="form-check form-check-inline mr-1">
                                                                    <input class="form-check-input"
                                                                        :id="'section_'+i+'_input_'+j+'_is_disable'"
                                                                        type="checkbox" v-model="input.is_disable">
                                                                    <label class="form-check-label"
                                                                        for="'section_'+i+'_input_'+j+'_is_disable'">Is
                                                                        Disable</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-form-label">
                                                                <div class="form-check form-check-inline mr-1">
                                                                    <input class="form-check-input"
                                                                        :id="'section_'+i+'_input_'+j+'_is_readonly'"
                                                                        type="checkbox" v-model="input.is_readonly">
                                                                    <label class="form-check-label"
                                                                        for="'section_'+i+'_input_'+j+'_is_readonly'">Is
                                                                        Readonly</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6" v-if="input.element_type ==='select'">
                                                                <div class="card">
                                                                    <div class="card-header text-center">
                                                                        <h5 style="display: inline-block">Option
                                                                            (select,radio)</h5>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row pt-1"
                                                                            v-for="(option,k) in input.options">
                                                                            <div class="col-md-5">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        :for="'section_'+i+'_input_'+j+'_option_'+k+'_key'">Key</label>

                                                                                    <input class="form-control"
                                                                                        :id="'section_'+i+'_input_'+j+'_option_'+k+'_key'"
                                                                                        placeholder="Enter Input Label"
                                                                                        type="text"
                                                                                        v-model="option.key">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-5">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        :for="'section_'+i+'_input_'+j+'_option_'+k+'_value'">Value</label>
                                                                                    <input class="form-control"
                                                                                        :id="'section_'+i+'_input_'+j+'_option_'+k+'_value'"
                                                                                        placeholder="Enter Input Placeholder"
                                                                                        type="text"
                                                                                        v-model="option.value">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                <a href="javascript:void(0)"
                                                                                    class="float-right text-danger"
                                                                                    v-if="input.options.length>1"
                                                                                    type="button"
                                                                                    @click="removeOption(i,j,k)"><i
                                                                                        class="fa fa-window-close"></i>
                                                                                </a>
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                <a href="javascript:void(0)"
                                                                                    v-if="input.options.length-1 ===k"
                                                                                    @click="addOption(i,j)"
                                                                                    class="text-primary float-right"><i
                                                                                        class="fa fa-plus-square"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card">
                                                                    <div class="card-header text-center">
                                                                        <h5 style="display: inline-block">Additional
                                                                            Attributes</h5>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row pt-1"
                                                                            v-for="(additional_attribute,k) in input.additional_attributes">
                                                                            <div class="col-md-5">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        :for="'section_'+i+'_input_'+j+'_additional_attribute_'+k+'_key'">Key</label>
                                                                                    <input class="form-control"
                                                                                        :id="'section_'+i+'_input_'+j+'_additional_attribute_'+k+'_key'"
                                                                                        placeholder="Enter Input Label"
                                                                                        type="text"
                                                                                        v-model="additional_attribute.key">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-5">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        :for="'section_'+i+'_input_'+j+'_additional_attribute_'+k+'_value'">Value</label>
                                                                                    <input class="form-control"
                                                                                        :id="'section_'+i+'_input_'+j+'_additional_attribute_'+k+'_value'"
                                                                                        placeholder="Enter Input Placeholder"
                                                                                        type="text"
                                                                                        v-model="additional_attribute.value">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                <a href="javascript:void(0)"
                                                                                    class="float-right text-danger"
                                                                                    v-if="input.additional_attributes.length>1"
                                                                                    type="button"
                                                                                    @click="removeAdditionalAttribute(i,j,k)"><i
                                                                                        class="fa fa-window-close"></i>
                                                                                </a>
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                <a href="javascript:void(0)"
                                                                                    v-if="input.additional_attributes.length-1 ===k"
                                                                                    @click="addAdditionalAttribute(i,j)"
                                                                                    class="text-primary float-right"><i
                                                                                        class="fa fa-plus-square"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions p-2 m-0">
                                                        <button class="btn btn-info float-right"
                                                            v-if="section.form_fields.length-1===j"
                                                            @click="addInputElement(i)">+ Input
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions p-2 m-0">
                                                <button class="btn btn-info float-right" type="button"
                                                    v-if="form.sections.length-1 === i" @click="addSection()">+ Section
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions  p-2 m-0">
                                        <button class="btn btn-success float-right" type="submit">
                                            Submit Form
                                        </button>
                                    </div>
                                    {{--                                </form>--}}
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
            name: undefined, // 1
            type: undefined, // 1
            method: undefined, // 1
            action_url: undefined, // 1
            id: undefined,
            class: undefined,
            form_id: undefined,
            sections: [{
                title: undefined, // 1
                class: undefined,
                sequence: undefined, //1
                id: undefined, // db_id
                sequence_id: undefined, //1
                form_fields: [{
                    label: undefined,
                    placeholder: undefined,
                    name: undefined,
                    sequence: undefined,
                    value: undefined,
                    element_type: undefined, //1 select box > input , select, text-area
                    data_type: undefined, // 1 if element_type is input
                    min: undefined, // 0 if element_type is input
                    max: undefined, // 0 if element_type is input
                    id: undefined, // db_id
                    pattern: undefined,
                    custom_validation: undefined,
                    is_required: true,
                    is_disable: false,
                    is_readonly: false,
                    options: [ // 1 if element_type is select
                        {
                            key: undefined,
                            value: undefined
                        },
                    ],
                    additional_attributes: [{
                        key: undefined,
                        value: undefined
                    }]
                }]
            }]
        },
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
                    url: '/api/v1/form-builder',
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
                        data: 'name',
                        name: 'name',
                        render(data, type, row) {
                            return data;
                        },
                        defaultContent: '',
                        title: 'Name'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'type',
                        name: 'type',
                        defaultContent: '',
                        title: 'Type'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'method',
                        name: 'method',
                        render(data, type, row) {
                            return data;
                        },
                        defaultContent: '',
                        title: 'Method'
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
                        data: 'form_id',
                        name: 'form_id',
                        defaultContent: '',
                        title: 'ID'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'class',
                        name: 'class',
                        defaultContent: '',
                        title: 'Class'
                    },
                    //{
                    //     className: 'all',
                    //     orderable: true,
                    //     data: 'status', render(data, row, type) {
                    //         return data ? `<span class='badge badge-info'>Active</span>` : `<span class='badge badge-danger'>Inactive</span>`;
                    //     },
                    //     name: 'status',
                    //     defaultContent: '',
                    //     title: 'Status'
                    // },
                    {
                        className: 'all',
                        orderable: true,
                        data: 'id',
                        render(data, row, type) {
                            return `<button class='badge badge-primary view_form'> <i class="fa fa-street-view"></i>View</button>
                                                <button class='badge badge-info edit_form'> <i class="fa fa-edit"></i>Edit</button>
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
        ajaxCall(api, data, method, callback, alert = false, base_url = '') {
            (async () => {
                if (method === 'get')
                    await axios.get(base_url + api, {
                        ...data
                    })
                    .then(response => this.responseProcess(response, alert, (data, code) => callback(
                        data, code)))
                    .catch(function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! please try again later',
                        });
                    })
                else
                    await axios.post(base_url + api, {
                        ...data
                    })
                    .then(response => this.responseProcess(response, alert, (data, code) => callback(
                        data, code)))
                    .catch(function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! please try again later',
                        });
                    })
            })();

        },
        addOption(i, j) {
            this.form.sections[i].form_fields[j].options.push({
                key: undefined,
                value: undefined
            });
        },
        addAdditionalAttribute(i, j) {
            this.form.sections[i].form_fields[j].additional_attributes.push({
                key: undefined,
                value: undefined
            });
        },
        addInputElement(i) {
            this.form.sections[i].form_fields.push({
                label: undefined,
                placeholder: undefined,
                sequence: undefined,
                name: undefined,
                value: undefined,
                element_type: undefined,
                data_type: undefined,
                min: undefined,
                max: undefined,
                // id: undefined,
                // class: undefined,
                pattern: undefined,
                custom_validation: undefined,
                is_required: undefined,
                is_disable: undefined,
                is_readonly: undefined,
                options: [{
                    key: undefined,
                    value: undefined
                }, ],
                additional_attributes: [{
                    key: undefined,
                    value: undefined
                }]
            });
        },
        addSection() {
            this.form.sections.push({
                title: undefined,
                class: undefined,
                sequence: undefined,
                form_fields: [{
                    label: undefined,
                    placeholder: undefined,
                    name: undefined,
                    sequence: undefined,
                    value: undefined,
                    element_type: undefined,
                    data_type: undefined,
                    min: undefined,
                    max: undefined,
                    // id: undefined,
                    // class: undefined,
                    pattern: undefined,
                    custom_validation: undefined,
                    is_required: true,
                    is_disable: false,
                    is_readonly: false,
                    options: [{
                        key: undefined,
                        value: undefined
                    }, ],
                    additional_attributes: [{
                        key: undefined,
                        value: undefined
                    }]
                }]
            });
        },
        removeOption(i, j, k) {
            this.form.sections[i].form_fields[j].options.splice(k, 1);
        },
        removeAdditionalAttribute(i, j, k) {
            this.form.sections[i].form_fields[j].additional_attributes.splice(k, 1);
        },
        removeInputElement(i, j) {
            this.form.sections[i].form_fields.splice(j, 1);
        },
        removeSection(i) {
            this.form.sections.splice(i, 1);
        },
        responseProcess(response, alert, callback) {
            {
                if (response.status === 'success' || response.code === 200) {
                    if (alert)
                        Swal.fire({
                            icon: 'success',
                            title: 'Yahoo..',
                            text: response.message || 'Form stored successfully',
                        });
                    callback(response.data, response.code);
                } else {
                    if (alert)
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message || 'Something went wrong! please try again later',
                        });
                    callback(response.data, response.code);
                }
            }
        },

        reset() {
            this.form = {
                name: undefined, // 1
                type: undefined, // 1
                method: undefined, // 1
                action_url: undefined, // 1
                id: undefined,
                class: undefined,
                sections: [{
                    title: undefined, // 1
                    class: undefined,
                    sequence: undefined, //1
                    form_fields: [{
                        label: undefined,
                        placeholder: undefined,
                        name: undefined,
                        sequence: undefined,
                        value: undefined,
                        element_type: undefined, //1 select box > input , select, text-area
                        data_type: undefined, // 1 if element_type is input
                        min: undefined, // 0 if element_type is input
                        max: undefined, // 0 if element_type is input
                        // id: undefined,
                        // class: undefined,
                        pattern: undefined,
                        custom_validation: undefined,
                        is_required: true,
                        is_disable: false,
                        is_readonly: false,
                        options: [ // 1 if element_type is select
                            {
                                key: undefined,
                                value: undefined
                            },
                        ],
                        additional_attributes: [{
                            key: undefined,
                            value: undefined
                        }]
                    }]
                }]
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
            let url = '/form-builder';
            if (this.mode === 'edit') {
                url += '/' + this.dataTableData[+this.selectedIndex].id;
            }
            this.ajaxCall('form/submit', this.form, 'post', (data, code) => {
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
            }, true, 'http://localhost:8001/api/v1/')
        }
    },
    mounted() {
        this.dataTableInit({});
        const that = this;
        $('#form-table tbody').on('click', '.view_form', function() {
            that.reset();
            that.mode = 'edit';
            that.dataTableData = that.dataTable.rows().data();
            that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
            that.form = that.dataTableData[that.selectedIndex];
        });
        $('#form-table tbody').on('click', '.edit_form', function() {
            that.reset();
            that.mode = 'edit';
            that.dataTableData = that.dataTable.rows().data();
            that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
            console.log(that.dataTableData[that.selectedIndex]);
            that.form = that.dataTableData[that.selectedIndex];
        });

        $('#form-table tbody').on('click', '.delete_form', function() {
            swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    that.state = undefined;
                    that.dataTableData = that.dataTable.rows().data();
                    that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
                    that.ajaxCall('form-builder/' + that.dataTableData[that.selectedIndex]
                        .id, {}, 'DELETE', (data, code) => {
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
});
</script>
@endpush