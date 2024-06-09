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
                            <h5 style="display: inline-block">Form Field
                                Builder</h5>
                            <a href="javascript:void(0)" class="float-right text-danger" @click="closeEditor"><i
                                    class="fa fa-window-close"></i></a>
                        </div>
                        <div class="card-body">
                            <validation-observer v-slot="{ handleSubmit }">
                                <form @submit.prevent="handleSubmit(formSubmit)">
                                    {{--                                <form class="form-horizontal">--}}
                                    <div class="mt-2 mb-2"></div>
                                    <div class="">
                                        <div class="card">
                                            <div class="card-header text-center p-2">
                                                <h5 style="display: inline-block">
                                                    Form Field</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row pt-1">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label :for="'section_input_element_type'">Element
                                                                Type</label>
                                                            <select class="form-control"
                                                                :id="'section_input_element_type'" type="text"
                                                                v-model="form_field.field_type">
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

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label :for="'section_input_data_type'">Data
                                                                Type</label>
                                                            <select class="form-control" :id="'section_input_data_type'"
                                                                type="text" v-model="form_field.data_type">
                                                                <option value="undefined" selected>
                                                                    Select
                                                                    Element
                                                                    Type
                                                                </option>
                                                                <option value="text"
                                                                    v-if="form_field.field_type!=='textarea'">
                                                                    Text
                                                                </option>
                                                                <option value="number"
                                                                    v-if="form_field.field_type!=='textarea'">
                                                                    Number
                                                                </option>
                                                                <option value="password"
                                                                    v-if="form_field.field_type==='input'">
                                                                    Password
                                                                </option>
                                                                <option value="checkbox"
                                                                    v-if="form_field.field_type==='input'">
                                                                    Checkbox
                                                                </option>
                                                                <option value="radiobox"
                                                                    v-if="form_field.field_type==='input'">
                                                                    Radio
                                                                </option>
                                                                <option value="file"
                                                                    v-if="form_field.field_type==='input'">
                                                                    File
                                                                </option>
                                                                <option value="date"
                                                                    v-if="form_field.field_type==='input'">
                                                                    Date
                                                                </option>
                                                                <option value="textarea"
                                                                    v-if="form_field.field_type==='textarea'">
                                                                    Textarea
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label :for="'section_input_label'">Label</label>
                                                            <validation-provider rules="required:6" v-slot="{ errors }">
                                                                <input class="form-control" :id="'section_input_label'"
                                                                    placeholder="Enter Input Label" type="text"
                                                                    v-bind:class="errors[0]?'border-danger':''"
                                                                    v-model="form_field.label">
                                                            </validation-provider>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label
                                                                :for="'section_input_placeholder'">Placeholder</label>
                                                            <input class="form-control"
                                                                :id="'section_input_placeholder'"
                                                                placeholder="Enter Input Placeholder" type="text"
                                                                v-model="form_field.placeholder">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <validation-provider rules="required:6" v-slot="{ errors }">
                                                                <label :for="'section_input_name'">Name</label>
                                                                <input class="form-control" :id="'section_input_name'"
                                                                    placeholder="Enter Input Name" type="text"
                                                                    v-bind:class="errors[0]?'border-danger':''"
                                                                    v-model="form_field.field_name">
                                                            </validation-provider>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label :for="'section_input_value'">Default
                                                                Value</label>
                                                            <input class="form-control" :id="'section_input_value'"
                                                                placeholder="Enter Input Default Value" type="text"
                                                                v-model="form_field.value">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3" v-if="form_field.element_type ==='input'">
                                                        <div class="form-group">
                                                            <validation-provider rules="required:6" v-slot="{ errors }">
                                                                <label :for="'section_input_data_type'">Data
                                                                    Type</label>
                                                                <input class="form-control"
                                                                    :id="'section_input_data_type'"
                                                                    placeholder="Enter Input Data Type" type="text"
                                                                    v-bind:class="errors[0]?'border-danger':''"
                                                                    v-model="form_field.data_type">
                                                            </validation-provider>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3" v-if="form_field.field_type !=='select'">
                                                        <div class="form-group">
                                                            <label :for="'section_input_min'">Min Length</label>
                                                            <input class="form-control" :id="'section_input_min'"
                                                                placeholder="Enter Input Min" type="text"
                                                                v-model="form_field.min_length">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3" v-if="form_field.field_type !=='select'">
                                                        <div class="form-group">
                                                            <label :for="'section_input_max'">Max Length</label>
                                                            <input class="form-control" :id="'section_input_max'"
                                                                placeholder="Enter Input Max" type="text"
                                                                v-model="form_field.max_length">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label :for="'section_input_pattern'">Pattern</label>
                                                            <input class="form-control" :id="'section_input_pattern'"
                                                                placeholder="Enter Input Pattern" type="text"
                                                                v-model="form_field.pattern">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label :for="'section_input_custom_validation'">Custom
                                                                Validation</label>
                                                            <input class="form-control"
                                                                :id="'section_input_custom_validation'"
                                                                placeholder="Enter Input Custom Validation" type="text"
                                                                v-model="form_field.custom_validation">
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label :for="'section_input_api_endpoint'">API
                                                                Endpoint</label>
                                                            <input class="form-control"
                                                                :id="'section_input_api_endpoint'"
                                                                placeholder="Enter API Endpoint" type="text"
                                                                v-model="form_field.api_endpoint">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label :for="'section_input_file_source'">File
                                                                Source</label>

                                                            <select class="form-control"
                                                                :id="'section_input_file_source'" type="text"
                                                                v-model="form_field.file_source">
                                                                <option value="undefined" selected>
                                                                    Select
                                                                    File Source
                                                                </option>
                                                                <option value="camera">Camera</option>
                                                                <option value="gallert">Gallery</option>
                                                                <option value="any">Any
                                                                </option>
                                                            </select>

                                                        </div>
                                                    </div>


                                                    <div class="col-md-3 col-form-label">
                                                        <div class="form-check form-check-inline mr-1">
                                                            <input class="form-check-input"
                                                                :id="'section_input_is_required'" type="checkbox"
                                                                v-model="form_field.is_required">
                                                            <label class="form-check-label"
                                                                for="'section_input_is_required'">Is
                                                                Required</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-form-label">
                                                        <div class="form-check form-check-inline mr-1">
                                                            <input class="form-check-input"
                                                                :id="'section_input_is_disable'" type="checkbox"
                                                                v-model="form_field.is_disabled">
                                                            <label class="form-check-label"
                                                                for="'section_input_is_disable'">Is
                                                                Disabled</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-form-label">
                                                        <div class="form-check form-check-inline mr-1">
                                                            <input class="form-check-input"
                                                                :id="'section_input_is_readonly'" type="checkbox"
                                                                v-model="form_field.is_readonly">
                                                            <label class="form-check-label"
                                                                for="'section_input_is_readonly'">Is
                                                                Readonly</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 col-form-label">
                                                        <div class="form-check form-check-inline mr-1">
                                                            <input class="form-check-input"
                                                                :id="'section_input_is_nid_verification'"
                                                                type="checkbox"
                                                                v-model="form_field.is_nid_verification">
                                                            <label class="form-check-label"
                                                                for="'section_input_is_nid_verification'">Is
                                                                NID Verification</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-form-label">
                                                        <div class="form-check form-check-inline mr-1">
                                                            <input class="form-check-input"
                                                                :id="'section_input_is_score_mapping'" type="checkbox"
                                                                v-model="form_field.is_score_mapping">
                                                            <label class="form-check-label"
                                                                for="'section_input_is_score_mapping'">Enable Score
                                                                Mapping</label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6"
                                                        v-if="form_field.field_type ==='select' || (form_field.field_type ==='input' && form_field.data_type === 'radiobox')">
                                                        <div class="card">
                                                            <div class="card-header text-center">
                                                                <h5 style="display: inline-block">Option
                                                                    (select,radio)</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row pt-1"
                                                                    v-for="(option,k) in form_field.options">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label
                                                                                :for="'section_input_option_'+k+'_key'">Key</label>
                                                                            <validation-provider rules="required:6"
                                                                                v-slot="{ errors }">
                                                                                <input class="form-control"
                                                                                    :id="'section_input_option_'+k+'_key'"
                                                                                    placeholder="Enter Input Label"
                                                                                    type="text"
                                                                                    v-bind:class="errors[0]?'border-danger':''"
                                                                                    v-model="option.key">
                                                                            </validation-provider>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label
                                                                                :for="'section_input_option_'+k+'_value'">Value</label>
                                                                            <validation-provider rules="required:6"
                                                                                v-slot="{ errors }">
                                                                                <input class="form-control"
                                                                                    :id="'section_input_option_'+k+'_value'"
                                                                                    v-bind:class="errors[0]?'border-danger':''"
                                                                                    placeholder="Enter Input Placeholder"
                                                                                    type="text" v-model="option.value">
                                                                            </validation-provider>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <a href="javascript:void(0)"
                                                                            class="float-right text-danger"
                                                                            v-if="form_field.options.length>1"
                                                                            type="button" @click="removeOption(k)"><i
                                                                                class="fa fa-window-close"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <a href="javascript:void(0)"
                                                                            v-if="form_field.options.length-1 ===k"
                                                                            @click="addOption()"
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
                                                                    v-for="(additional_attribute,k) in form_field.additional_attributes">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label
                                                                                :for="'section_input_additional_attribute_'+k+'_key'">Key</label>
                                                                            <input class="form-control"
                                                                                :id="'section_input_additional_attribute_'+k+'_key'"
                                                                                placeholder="Enter Input Label"
                                                                                type="text"
                                                                                v-model="additional_attribute.key">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label
                                                                                :for="'section_input_additional_attribute_'+k+'_value'">Value</label>
                                                                            <input class="form-control"
                                                                                :id="'section_input_additional_attribute_'+k+'_value'"
                                                                                placeholder="Enter Input Placeholder"
                                                                                type="text"
                                                                                v-model="additional_attribute.value">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <a href="javascript:void(0)"
                                                                            class="float-right text-danger"
                                                                            v-if="form_field.additional_attributes.length>1"
                                                                            type="button"
                                                                            @click="removeAdditionalAttribute(k)"><i
                                                                                class="fa fa-window-close"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <a href="javascript:void(0)"
                                                                            v-if="form_field.additional_attributes.length-1 ===k"
                                                                            @click="addAdditionalAttribute()"
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
                                        </div>
                                    </div>
                                    <div class="form-actions  p-2 m-0">
                                        <button class="btn btn-success float-right" type="submit">
                                            Submit Form Field
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
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 style="display: inline-block">{{ $selectedForm->name }} Form Field List</h5>
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
    <!-- Modal -->
    <div class="modal fade" id="field_mapper" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@{{ selectedField }}
                        Field Mapper</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="width: fit-content;">
                    <div class="row" v-for="(section,index) in sections">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="allowed_platform_type">Select Section</label>
                                <validation-provider rules="required" v-slot="{ errors }">
                                    <select class="form-control" v-bind:class="errors[0]?'border-danger':''"
                                        v-model="section.section_id">
                                        <option value=""></option>
                                        <option v-for="sec in sectionList" :value="sec.id">@{{ sec.name }}</option>
                                    </select>
                                </validation-provider>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label :for="'section_input_label'">Sequence</label>
                                <validation-provider rules="required:6" v-slot="{ errors }">
                                    <input class="form-control" :id="'section_input_label'" placeholder="Enter Sequence"
                                        type="number" v-bind:class="errors[0]?'border-danger':''"
                                        v-model="section.sequence">
                                </validation-provider>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <a href="javascript:void(0)" class="btn btn-danger" @click="removeSectionMap(index)"
                                v-if="sections.length>1" style="margin-top:26px"><i class="fa fa-minus"></i></a>
                        </div>
                        <div class="col-md-1">
                            <a href="javascript:void(0)" class="btn btn-primary" @click="addSectionMap()"
                                v-if="sections.length-1 === index && sections.length < sectionList.length"
                                style="margin-top:26px"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="sectionMapperUpdate()">Save changes
                    </button>
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
        form_field: {
            section_id: "{{$id}}",
            form_id: "{{$selectedForm->id}}",
            field_type: undefined,
            data_type: undefined,
            label: undefined,
            placeholder: undefined,
            field_name: undefined,
            field_default_value: undefined,
            min_length: undefined,
            max_length: undefined,
            pattern: undefined,
            custom_validation: undefined,
            api_endpoint: undefined,
            file_source: undefined,
            additional_attributes: [{
                key: undefined,
                value: undefined,
            }],
            options: [{
                key: undefined,
                value: undefined,
            }],
            is_required: undefined,
            is_disabled: undefined,
            is_readonly: undefined,
            is_nid_verification: undefined,
            is_score_mapping: undefined,
            is_validation_required: undefined,
            validation_api_url: undefined,
            response_required_keys: undefined,
        },
        selectedField: undefined,
        selectedFieldId: undefined,
        sections: [{
            sequence: undefined,
            section_id: undefined,
            field_id: undefined,
        }],
        sectionList: [],
        dataTableData: [],
        dataTable: {},
        mode: undefined,
        error: undefined,
        formData: undefined,
        selectedIndex: undefined,
        oldSection: undefined,
    },
    methods: {
        dataTableInit(data) {
            this.dataTable = $('#form-table').DataTable({
                processing: true,
                serverSide: true,
                pagingType: "full_numbers",

                ajax: {
                    url: '/api/v1/form-field?datatable=1&form_id={{$selectedForm->id}}',
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
                        data: 'field_type',
                        name: 'field_type',
                        defaultContent: '',
                        title: 'Field Type'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'data_type',
                        name: 'data_type',
                        defaultContent: '',
                        title: 'Data Type'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'label',
                        name: 'label',
                        defaultContent: '',
                        title: 'Label'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'placeholder',
                        name: 'placeholder',
                        defaultContent: '',
                        title: 'Place Holder'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'field_name',
                        name: 'field_name',
                        defaultContent: '',
                        title: 'Field Name'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'field_default_value',
                        name: 'field_default_value',
                        defaultContent: '',
                        title: 'Field default Value',
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'min_length',
                        name: 'min_length',
                        defaultContent: '',
                        title: 'Min Length'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'max_length',
                        name: 'max_length',
                        defaultContent: '',
                        title: 'Max Length'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'pattern',
                        name: 'pattern',
                        defaultContent: '',
                        title: 'Pattern'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'custom_validation',
                        name: 'custom_validation',
                        defaultContent: '',
                        title: 'Custom Validation'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'api_endpoint',
                        name: 'api_endpoint',
                        defaultContent: '',
                        title: 'API EndPoint'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'file_source',
                        name: 'file_source',
                        defaultContent: '',
                        title: 'File Source'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'additional_attributes',
                        render(data, row, type) {
                            return JSON.stringify(data || "");
                        },
                        name: 'additional_attributes',
                        defaultContent: '',
                        title: 'Additional Attributes'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'options',
                        render(data, row, type) {
                            return JSON.stringify(data || "");
                        },
                        name: 'options',
                        defaultContent: '',
                        title: 'Options'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'is_required',
                        render(data, row, type) {
                            return data ? `<span class='badge badge-info'>Yes</span>` :
                                `<span class='badge badge-danger'>NO</span>`;

                        },
                        name: 'is_required',
                        defaultContent: '',
                        title: 'Required'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'is_disabled',
                        render(data, row, type) {
                            return data ? `<span class='badge badge-info'>Yes</span>` :
                                `<span class='badge badge-danger'>NO</span>`;

                        },
                        name: 'is_disabled',
                        defaultContent: '',
                        title: 'Disabled Field'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'is_readonly',
                        render(data, row, type) {
                            return data ? `<span class='badge badge-info'>Yes</span>` :
                                `<span class='badge badge-danger'>NO</span>`;

                        },
                        name: 'is_readonly',
                        defaultContent: '',
                        title: 'Read Only'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'is_nid_verification',
                        render(data, row, type) {
                            return data ? `<span class='badge badge-info'>Yes</span>` :
                                `<span class='badge badge-danger'>NO</span>`;

                        },
                        name: 'is_nid_verification',
                        defaultContent: '',
                        title: 'NID Verification'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'is_score_mapping',
                        render(data, row, type) {
                            return data ? `<span class='badge badge-info'>Yes</span>` :
                                `<span class='badge badge-danger'>NO</span>`;

                        },
                        name: 'is_score_mapping',
                        defaultContent: '',
                        title: 'Enable Score Mapping'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'is_validation_required',
                        render(data, row, type) {
                            return data ? `<span class='badge badge-info'>Yes</span>` :
                                `<span class='badge badge-danger'>NO</span>`;

                        },
                        name: 'is_validation_required',
                        defaultContent: '',
                        title: 'Validation Required'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'validation_api_url',
                        name: 'validation_api_url',
                        defaultContent: '',
                        title: 'Validation API URL'
                    }, {
                        className: 'details-control',
                        orderable: true,
                        data: 'response_required_keys',
                        name: 'response_required_keys',
                        defaultContent: '',
                        title: 'Response Required Keys'
                    },
                    {
                        className: 'all',
                        orderable: true,
                        data: 'id',
                        render(data, row, type) {
                            return `
                                                <button class='badge badge-info form_section'><i class="fa fa-edit"></i>Section-Map</button>
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
        ajaxCall: window.ajaxCall,
        responseProcess: window.responseProcess,
        reset() {
            this.form_field = {
                section_id: "{{$id}}",
                form_id: "{{$selectedForm->id}}",
                field_type: undefined,
                data_type: undefined,
                label: undefined,
                placeholder: undefined,
                field_name: undefined,
                field_default_value: undefined,
                min_length: undefined,
                max_length: undefined,
                pattern: undefined,
                custom_validation: undefined,
                api_endpoint: undefined,
                file_source: undefined,
                additional_attributes: [{
                    key: undefined,
                    value: undefined,
                }],
                options: [{
                    key: undefined,
                    value: undefined,
                }],
                is_required: undefined,
                is_disabled: undefined,
                is_readonly: undefined,
                is_nid_verification: undefined,
                is_score_mapping: undefined,
                is_validation_required: undefined,
                validation_api_url: undefined,
                response_required_keys: undefined,
            };
            this.sections = [{
                sequence: undefined,
                section_id: undefined,
                field_id: undefined,
            }];
            this.selectedField = undefined;
            this.selectedFieldId = undefined;
            this.mode = undefined;
            this.error = undefined;
            this.formData = undefined;
            this.selectedIndex = undefined;
            this.oldSection = [];
        },
        addForm() {
            this.reset();
            this.mode = 'create';
        },
        closeEditor() {
            this.mode = undefined;
        },
        addOption() {
            this.form_field.options.push({
                key: undefined,
                value: undefined
            });
        },
        addAdditionalAttribute(k) {
            this.form_field.additional_attributes.push({
                key: undefined,
                value: undefined
            });
        },
        removeOption(k) {
            this.form_field.options.splice(k, 1);
        },
        removeAdditionalAttribute(k) {
            this.form_field.additional_attributes.splice(k, 1);
        },
        formSubmit() {
            let url = '/api/v1/form-field';
            let method = 'post';
            if (this.mode === 'edit') {
                url += '/' + this.dataTableData[+this.selectedIndex].id;
                method = 'put';
            }

            //                        console.log(this.form_field.api_endpoint);
            //                        return false;

            this.ajaxCall(url, this.form_field, method, (data, code) => {
                if (code === 200) {
                    this.dataTableData = this.dataTable.rows().data();
                    this.reset();
                    if (this.mode === 'edit') {
                        this.dataTableData[this.selectedIndex] = data;
                    } else {
                        this.dataTableData.push(data);
                    }
                    this.dataTable.clear();
                    this.dataTable.rows.add(this.dataTableData);
                    this.dataTable.draw();
                    this.reset();
                }
            }, true)
        },
        removeSectionMap(i) {
            this.sections.splice(i, 1);
        },
        addSectionMap() {
            this.sections.push({
                sequence: undefined,
                section_id: undefined,
                field_id: +this.selectedFieldId,
            });
        },
        sectionMapperUpdate() {
            this.sections = this.sections.map(el => {
                if (this.selectedFieldId)
                    el.field_id = +this.selectedFieldId;
                if (el.sequence)
                    el.sequence = +el.sequence;
                if (el.section_id)
                    el.section_id = +el.section_id;
                return el;
            });
            if (this.oldSection && this.oldSection.length > 0 && this.sections && this.sections.length > 0) {
                this.oldSection = this.oldSection.filter(old_section => {
                    let has_section_id = false;
                    for (const section of this.sections) {
                        if (+old_section.section_id === +section.section_id) {
                            has_section_id = true;
                            break;
                        }
                    }
                    return !has_section_id;
                });
            }

            this.ajaxCall("/api/v1/form/field/" + this.selectedFieldId + "/section-mapper", {
                field_mapper_data_delete: this.oldSection,
                field_mapper_data: this.sections
            }, 'post', (data, code) => {
                if (code === 200) {
                    $("#field_mapper").modal('hide');
                    this.dataTableData = this.dataTable.rows().data();
                    this.dataTableData[this.selectedIndex] = data;
                    this.dataTable.clear();
                    this.dataTable.rows.add(this.dataTableData);
                    this.dataTable.draw();
                    this.reset();
                }
            }, true);
        }
    },

    mounted() {
        this.dataTableInit({});
        const that = this;
        this.ajaxCall("/api/v1/form/" + "{{$id}}" + "/sections", {}, 'get', (data, code) => {
            code === 200 ? this.sectionList = data : null
        }, false);
        $('#form-table tbody').on('click', '.edit_form', function() {
            that.reset();
            that.mode = 'edit';
            that.dataTableData = that.dataTable.rows().data();
            that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
            that.form_field = that.dataTableData[that.selectedIndex];
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
                    that.ajaxCall('/api/v1/form-field/' + that.dataTableData[that.selectedIndex]
                        .id, {}, 'delete', (data, code) => {
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
        $('#form-table tbody').on('click', '.form_section', function() {
            that.state = undefined;
            that.dataTableData = that.dataTable.rows().data();
            that.selectedIndex = that.dataTable.row($(this).parent().parent()).index();
            that.selectedField = that.dataTableData[that.selectedIndex].label;
            that.sections = [...that.dataTableData[that.selectedIndex].sections && that.dataTableData[
                    that.selectedIndex].sections.length > 0 ?
                that.dataTableData[that.selectedIndex].sections : [{
                    sequence: undefined,
                    section_id: undefined,
                    field_id: undefined,
                }]
            ];
            that.oldSection = [...that.dataTableData[that.selectedIndex].sections || []];
            that.selectedFieldId = that.dataTableData[that.selectedIndex].id;
            $("#field_mapper").modal('show');
            // that.ajaxCall('/api/v1/form-field/' + that.dataTableData[that.selectedIndex].id, {}, 'delete', (data, code) => {
            //     if (code === 200) {
            //         that.dataTableData.splice(that.selectedIndex, 1);
            //         that.dataTable.clear();
            //         that.dataTable.rows.add(that.dataTableData);
            //         that.dataTable.draw();
            //         that.reset();
            //     }
            // }, true);
        });
    },
});
</script>
@endpush