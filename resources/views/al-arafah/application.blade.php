@extends('layout.admin.master')
@section('lib-css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endsection
@push('custom-css')
    <style type="text/css">
        .card.card-custom > .card-body {
            padding: 2.5rem 2.25rem !important;
        }

        .btn-custom {
            background-color: #11a5134a;
            color: green;
        }

        .form-group label {
            font-weight: 600 !important;
        }

        .post-services .post-services-detail-1 {
            margin-bottom: 30px !important;
        }
    </style>
@endpush
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row" id="approved-application">
                    <div class="col-lg-12 text-right mb-5">
                        <button @click="cib_verify=true" type="" class="btn btn-primary mr-2">Verify CIB</button>
                        <img v-if="cib_verify" src="/img/green-tick.png" width="30px">

                    </div>
                    <div class="col-lg-12">

                        <!-- POST SERVICES DERAIL 1-->
                        @foreach($formDetails->form_section as $sections)
                            <section class="post-services post-services-detail-1 mb-4">
                                <!--begin::Card-->
                                <div class="card card-custom gutter-b example example-compact ">
                                    <!--begin::Form-->
                                    <form class="form">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <h4 class="d-block">{{$sections->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                @foreach($sections->form_section_fields as $field)
                                                    <div class="col-lg-3 mb-3">
                                                        <label>{{$field->label ?? ''}}</label>
                                                        @if(isset($field->mime_type) && $field->mime_type != null && in_array($field->mime_type, ['image/png', 'image/jpg', 'image/jpeg','image/x-ms-bmp']))
                                                            <p><img class="img-fluid"
                                                                    src="/{{$field->user_input_value ?? '--'}}">
                                                        @elseif(isset($field->mime_type) && $field->mime_type != null)
                                                            <p>
                                                                <a href="/{{$field->user_input_value ? $field->user_input_value : '#'}}">{{$field->user_input_value ? $field->user_input_value : '--'}}</a>
                                                            </p>
                                                        @else
                                                            <p>{{$field->user_input_value ? $field->user_input_value : '--'}}</p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>


                                        </div>
                                    </form>
                                    <!--end::Form-->

                                    @if($sections->name == 'Nominee Information')
                                    <div class="col-lg-12 text-right">
                                        <button class="btn btn-info mb-4" @click="verifyNominee('{{$formRequest->request_tracking_uid}}','{{$formRequest->form_id}}')">Verify Nominee</button>
                                    </div>
                                        
                                    @endif

                                </div>
                                <!--end::Card-->
                            </section>

                        @endforeach

                        @if(count($dependantForms) > 0)
                            @foreach($dependantForms as $form)
                                <section class="post-services post-services-detail-1 mb-4">
                                    <!--begin::Card-->
                                    <div class="card card-custom gutter-b example example-compact ">
                                        <h4 class="text-center" style="padding: 5px;">For Checker Use Only</h4>
                                        <!--begin::Form-->
                                        <form class="form" method="{{$form->method}}"
                                              action="/application/checker/submit/{{$form->id}}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="request_tracking_id"
                                                   value="{{$formRequest->request_tracking_uid}}">
                                            @foreach($form->form_section as $section)
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-lg-12">
                                                            <h4 class="d-block">{{$section->name}}</h4>
                                                            <input type="hidden" name="section_ids[]"
                                                                   value="{{$section->id}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        @foreach($section->form_section_fields as $field)
                                                            <div class="col-lg-3 mb-3">
                                                                <label>{{$field->label ?? ''}}</label>
                                                                <input type="hidden" name="field_ids[]"
                                                                       value="{{$field->id}}" {{$formRequest->status != 'submitted' ? 'disabled' : '' }}>
                                                                @if($field->field_type == 'input')
                                                                    <input type="{{$field->data_type}}"
                                                                           name="field_value_{{$field->id}}"
                                                                           class="form-control"
                                                                           placeholder="{{$field->placeholder}}"
                                                                           value="{{$field->user_input_value ?? ''}}" {{$field->is_required ? 'required' : ''}} {{$formRequest->status != 'submitted' ? 'disabled' : '' }}>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach

                                            @if($formRequest->status == 'submitted')
                                                <div class="card-footer">
                                                    <div class="row">
                                                        <div class="col-lg-12 text-right">
                                                            <!-- <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                                                            <input type="submit" class="btn btn-info"
                                                                   style="margin: 5px;" name="save_draft"
                                                                   value="Save Draft">
                                                            <input type="submit" class="btn btn-primary"
                                                                   style="margin: 5px;" name="save" value="Save">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Card-->
                                </section>
                            @endforeach
                        @endif

                        <section class="post-services post-services-detail-1 mb-4">
                            <div class="card card-custom gutter-b example example-compact">
                                <!--begin::Form-->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 offset-5 pull-right">
                                            <h4><strong>Previous Score</strong>: @{{previous_score}}</h4>
                                        </div>
                                        <div class="col-md-3 pull-right">
                                            <button class="btn btn-info" @click="regenerateScoreHandler" v-if="previous_score!=0">
                                                Regenerate Score
                                            </button>
                                        </div>

                                    </div>
                                    
                                    <hr v-if="score_form">
                                    <div v-if="score_form">
                                        <h4 class="display text-center font-weight-bold"><u>RISK GRADING SCORE SHEET</u>
                                        </h4>
                                        @if(count($getQuestionnaire->questionnaire_groups) > 0)
                                            <form class="form" id="scoreGeneratorForm" @submit="scoreGeneratorHandler">
                                                <div class="row">
                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="score_type_uid"
                                                           value="{{$getScorTypeUid}}">
                                                    @php $i=1; @endphp

                                                    @foreach($getQuestionnaire->questionnaire_groups as $groups)
                                                        @if($groups->is_display_title == 1)
                                                            <div class="col-lg-12">
                                                                <h5 class="text-center font-weight-bold">{{ $groups->group_title }}</h5>
                                                            </div>
                                                        @endif

                                                        @foreach($groups->questionnaire as $question)
                                                            <div class="col-lg-6" style="padding: 10px;border: 1px solid #e9e9e9;margin: 10px 0 10px;">
                                                                <p>{{$question->questionnaire_title}} {!!$question->is_required == 1 ? '<sup style="color: red;font-weight: bolder;">*</sup>' : '' !!}</p>
                                                                <input type="hidden" name="questions_{{$i}}"
                                                                       value="{{$question->questionnaire_uid}}">

                                                                @foreach($question->options as $option)
                                                                    <div>
                                                                        <div class="form-check">
                                                                            <input
                                                                                type="{{$question->has_multiple_option ? 'checkbox' : 'radio'}}"
                                                                                class="form-check-input"
                                                                                name="options_{{$i}}[]"
                                                                                value="{{$option->option_id}}">

                                                                            <label class="form-check-label"
                                                                                   for="exampleCheck1">{{$option->option_value}}</label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <hr>
                                                            @php $i++; @endphp
                                                        @endforeach
                                                        <hr>

                                                    @endforeach
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mt-3">
                                                        <button id="btn btn-success" type="submit"
                                                                class="btn btn-primary pull-right">
                                                            Submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </div>

                                </div>

                                {{--                                <div class="card-footer">--}}

                                {{--                                </div>--}}
                            </div>
                            <!--end::Form-->
                        </section>
                        @can('Checker Management')
                        @if($formRequest->status == 'submitted')
                        <section class="post-services post-services-detail-1 mb-4" v-if="previous_score > 0">
                            <div class="card card-custom gutter-b example example-compact">
                                <!--begin::Form-->

<!--                                 <div class="card-body">
                                    <div class="checkbox-list">
                                        <label class="checkbox">
                                            <input type="checkbox" name="Checkboxes1">
                                            <span></span>
                                            I have read and accept the terms and conditions
                                        </label>
                                    </div>
                                </div> -->

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <button id="btn-success" type=""
                                                    class="btn btn-primary mr-2" @click="confirmStatus('checked', 'checker')">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Form-->
                        </section>
                        @endif
                        @endcan

                        @can('Approver Management')
                        @if($formRequest->status == 'checked')
                        <section class="post-services post-services-detail-1 mb-4" v-if="previous_score > 0">
                            <div class="card card-custom gutter-b example example-compact">
                                <!--begin::Form-->

                                <!-- <div class="card-body">
                                    <div class="checkbox-list">
                                        <label class="checkbox">
                                            <input type="checkbox" name="Checkboxes1">
                                            <span></span>
                                            I have read and accept the terms and conditions
                                        </label>
                                    </div>
                                </div> -->

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <button id="btn-success" type=""
                                                    class="btn btn-primary mr-2" @click="confirmStatus('approved', 'approver')">Approve
                                            </button>
                                            <button id="btn-error" type="reset"
                                                    class="btn btn-secondary" @click="confirmStatus('declined', 'approver')">Decline
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Form-->
                        </section>
                        @endif
                        @endcan
                        <!-- END POST SERVICES DERAIL 1-->
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('lib-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
@endsection

@push('custom-js')
    <script>
        const form_builder = new Vue({
            el: "#approved-application",
            data: {
                cib_verify: false,
                score_form: "{{ $formRequest->calculated_score == 0 }}",
                previous_score: '{{$formRequest->calculated_score}}',
                dataTableData: [],
                dataTable: {},
                selectedIndex: undefined,
            },
            methods: {
                ajaxCall: window.ajaxCall,
                responseProcess: window.responseProcess,
                scoreGeneratorHandler(e) {
                    e.preventDefault();
                    let body = [];
                    const formData = $("#scoreGeneratorForm").serializeArray() || [];
                    formData.forEach(el => {
                        el.name = el.name.replace('[]', '');
                        if (body[el.name]) {
                            if (typeof body[el.name] === 'object')
                                body[el.name] = [...body[el.name], el.value];
                            else
                                body[el.name] = [body[el.name], el.value];
                        } else {
                            body[el.name] = el.value;
                        }
                    });
                    this.ajaxCall('/application/question/submit/{{$formRequest->request_tracking_uid}}', body, 'post', (data, status) => {
                            if(status == 200){
                                this.previous_score = data ? data.score : 0;
                                this.score_form = false;
                                $(':input', '#scoreGeneratorForm')
                                    .not(':button, :submit, :reset, :hidden')
                                    .val('')
                                    .removeAttr('checked')
                                    .removeAttr('selected');

                                Swal.fire({
                                    icon: 'success',
                                    title: "Success!",
                                    text: "Generated score is: "+ data.score,
                                    showConfirmButton: true,
                                });
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: "Failed!",
                                    text: "Please make sure that you gave answers of all questions.",
                                    showConfirmButton: true,
                                });
                            }

                    }, false)
                },

                // for nominee verification. should be updated later
                verifyNominee(request_tracking_uid,form_id){
                    $('#loading').fadeIn(500);
                    this.ajaxCall('/api/v1/application/nominee-nid-verification', {request_tracking_uid,form_id}, 'post', (data, status) => {
                            $('#loading').fadeOut(500);
                            if(status == 200){
                                window.location.reload();
                            }else{
                                
                            }

                    }, true)
                },
                // nominee verification ends
                regenerateScoreHandler() {
                    // this.score_form = false;
                    this.score_form = true;
                    console.log(this.score_form);
                },

                confirmStatus(status, verifier){
                    Swal.fire({
                            title: "Are you sure?",
                            text: "You want to do this action ?",
                            showCancelButton: true,
                            showConfirmButton: true,
                        }).then((willDelete) => {
                            // console.log(willDelete);
                            if (willDelete.isConfirmed == true) {
                                $('#loading').fadeIn(500);
                                this.ajaxCall(`/api/v1/application/${verifier}/submit/confirm`, {'status' : status, 'request_tracking_uid' : "{{$formRequest->request_tracking_uid}}" }, 'post', (data, code) => {
                                    $('#loading').fadeOut(500);
                                    if(code == 200){
                                        if(verifier == 'checker'){
                                            window.location.href = "/checker/approved-application";
                                        }else{
                                            if(verifier == 'approver' && status == 'approved'){
                                                window.location.href = "/approver/approved-application";
                                            }else{
                                                window.location.href = "/approver/declined-application";
                                            }
                                        }
                                    }
                                }, true);
                            }
                        });
                }
                
            },
            mounted() {
                $(document).ready(function () {

                    // $("#btn-error").click(function (e) {
                    //     Swal.fire({
                    //         title: 'Declined',
                    //         html: 'Form submission <strong style="color:red;" id="#decline">Declined</strong>!',
                    //         icon: 'error',
                    //     }).then((result) => {
                    //         if (window.location.href.indexOf('checker') !== -1)
                    //             window.location.href = "../checker/declined-application";
                    //         else
                    //             window.location.href = "../approver/declined-application";
                    //     })
                    // });
                    // $("#btn-success").click(function (e) {
                    //     Swal.fire({
                    //         title: 'Approved',
                    //         html: 'Your Form has been submitted <strong style="color:green;"  id="#approve">Successfully </strong> !',
                    //         icon: 'success',
                    //     }).then((result) => {
                    //         if (window.location.href.indexOf('checker') !== -1)
                    //             window.location.href = "../checker/declined-application";
                    //         else
                    //             window.location.href = "../approver/declined-application";
                    //     })
                    // });
                });
            },
        });
    </script>
@endpush
