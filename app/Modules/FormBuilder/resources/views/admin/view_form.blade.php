@extends('layout.admin.master')
@section('lib-css')
@endsection
@push('custom-css')
    <style type="text/css">

    </style>
@endpush
@section('content')
    <main class="c-main" id="form_builder">
        <div class="container-fluid p-2">
            <div class="fade-in">
                <div class="row">
                    <div class="col-lg-12">
                        @if($formDetails)
                            <form method="{{$formDetails->method}}" action="{{$formDetails->action_url}}"
                                  id="{{$formDetails->id}}" class="{{$formDetails->form_class}}">
                                @foreach($formDetails->form_section as $section)
                                    <div class="card">
                                        <div class="card-header text-center"><h5>{{$section->name}}</h5></div>
                                        <div class="card-body">
                                            <div class="row pt-2 pb-2">
                                                @foreach($section->form_section_fields as $field)
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            @php
                                                                $is_required = $field->is_required  ? 'required="required"' : '';
                                                                $is_readonly = $field->is_readonly  ? 'readonly="readonly"' : '';
                                                                $is_disabled = $field->is_disabled  ? 'disabled="disabled"' : '';
                                                            @endphp
                                                            @if($field->field_type == 'input')
                                                                <label>
                                                                    {{$field->label}}
                                                                    @if($field->is_required)
                                                                        <sup>*</sup>
                                                                    @endif
                                                                </label>
                                                                @if($field->data_type == 'radio')
                                                                    <br/>
                                                                    @foreach($field->options as $params)
                                                                            
                                                                           <label class="radio-inline"><input type="{{$field->data_type}}"
                                                                           name="{{$field->field_name}}"
                                                                           value="{{$params->key}}"
                                                                           {{$is_required .' '.$is_readonly.' '. $is_disabled}}>{{$params->value}}</label>
                                                                    @endforeach
                                                                @else
                                                                <input type="{{$field->data_type}}"
                                                                       name="{{$field->field_name}}"
                                                                       placeholder="{{$field->placeholder}}"
                                                                       value="{{$field->field_default_value}}"
                                                                       class="form-control" {{$is_required .' '.$is_readonly.' '. $is_disabled}}>
                                                                @endif
                                                            @elseif($field->field_type == 'select')
                                                                <label>
                                                                    {{$field->label}}
                                                                    @if($field->is_required)
                                                                        <sup>*</sup>
                                                                    @endif
                                                                </label>
                                                                <select class="form-control"
                                                                        name="{{$field->field_name}}">

                                                                    @foreach($field->options as $params)
                                                                        <option
                                                                            value="{{$params->value}}">{{$params->key}}</option>
                                                                    @endforeach
                                                                </select>
                                                            @elseif($field->field_type == 'textarea')
                                                                <textarea></textarea>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="form-actions  p-2 m-0 text-center">
                                    <button class="btn btn-success"
                                            type="submit">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        @else
                            <h3 class="text-center text-danger">Please Complete the form</h3>
                        @endif
                    </div>
                    <!-- /.col-->
                </div>
                <!-- /.row-->
            </div>
        </div>
    </main>
@endsection
@section('lib-js')
@endsection
