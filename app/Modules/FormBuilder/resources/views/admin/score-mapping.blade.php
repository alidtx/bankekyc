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


    <div class="container-fluid" id="addScoreFieldDiv" style="display:none">
        <div class="fade-in">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 style="display: inline-block">Add Score Mapping</h5>
                            <a href="javascript:void(0)" class="float-right text-danger" onclick="closeEditor()"><i
                                    class="fa fa-window-close"></i></a>
                        </div>
                        <div class="card-body">
                            @include('layout.admin.errorSuccessMsg')


                            <form method="post" action="{{route('doScoreMapping')}}" id="mappingForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Form Field <span class="text-danger"> *</span></label>
                                            <select class="form-control" id="formField" name="formField" onchange="setFieldOption(this.value)">
                                                <option value="">-- Select Form Field --</option>
                                                <?php
                                                foreach ($formFields as $formField) {
                                                    ?>
                                                    <option value="{{$formField['id']}}">{{$formField['label']}} ({{$formField['field_name']}})</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Question <span class="text-danger"> *</span></label>
                                            <select class="form-control" id="question" name="question" onchange="setQuestionOption(this.value)" disabled="">
                                                <option value="">-- Select Question --</option>
                                                <?php
                                                foreach ($questions as $question) {
                                                    ?>
                                                    <option value="{{$question['questionnaire_uid']}}">{{$question['questionnaire_title']}}</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered" id="optionTable">
                                            <tr>
                                                <th>Form Field Option</th>
                                                <th>Questionnaries Option</th>
                                            </tr>
                                            <tr id="noTr"><td colspan="2" class="text-center">No Data</td></tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <br>
                                        <hr>
                                        <input type="hidden" name="formId" id="formId" value="{{$id}}">
                                        <input type="hidden" name="formFieldQuestionnairesUid" id="formFieldQuestionnairesUid">
                                        <input type="hidden" name="optionTableRowSerial" id="optionTableRowSerial">
                                        <button type="button" class="btn btn-success" type="button" onclick="saveScoreMapping()">Save Mapping</button>
                                    </div>
                                </div>
                            </form>



                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- /.row-->
        </div>
    </div>
    <div class="container-fluid" id="scoreFieldList">
        <div class="fade-in">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 style="display: inline-block">Score Mapping</h5>
                            <a href="javascript:void(0)" class="float-right text-primary" onclick="openEditor()"><i class="fa fa-plus-square"></i></a>
                        </div>
                        <div class="card-body">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Form Field</th>
                                                <th>Questionnarie</th>
                                                <th>Form Field Option</th>
                                                <th>Questionnaries Option</th>
                                            </tr>
                                            <?php
                                            foreach ($formFieldQuestionnairesLists as $formFieldQuestionnairesList) {
                                                $formFieldOptionObjArr = array();
                                                if ($formFieldQuestionnairesList['form_field']['options']) {
                                                    $formFieldOptionObjArr = json_decode($formFieldQuestionnairesList['form_field']['options']);
                                                }
                                                $formFieldOptionObjArrCount = count($formFieldOptionObjArr);
                                                ?>
                                                <tr>
                                                    <td rowspan="{{$formFieldOptionObjArrCount}}">{{$formFieldQuestionnairesList['form_field']['label']}} ({{$formFieldQuestionnairesList['form_field']['field_name']}})</td>
                                                    <td rowspan="{{$formFieldOptionObjArrCount}}">{{$formFieldQuestionnairesList['question']['questionnaire_title']}}</td>
                                                    <td>{{isset($formFieldOptionObjArr[0])?$formFieldOptionObjArr[0]->value:''}}</td>
                                                    <td>{{isset($formFieldQuestionnairesList['form_field_question_option'][0])?$formFieldQuestionnairesList['form_field_question_option'][0]['question_option_info']['option_value']:""}}</td>
                                                </tr>
                                                <?php for ($i = 1; $i < $formFieldOptionObjArrCount; $i++) { ?>
                                                    <tr>
                                                        <td>{{$formFieldOptionObjArr[$i]->value}}</td>
                                                        <td>{{isset($formFieldQuestionnairesList['form_field_question_option'][$i])?$formFieldQuestionnairesList['form_field_question_option'][$i]['question_option_info']['option_value']:""}}</td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </table>
                                    </div>
                                </div>
                            </div>
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
                                var optionTableRowSerial = 1;
                                var formFieldsDetailsObj = jQuery.parseJSON(JSON.stringify(<?php echo $formFieldsDetails ?>));
                                var formFieldQuestionnairesObj = jQuery.parseJSON(JSON.stringify(<?php echo $formFieldQuestionnaires ?>));
                                var questionsObj = jQuery.parseJSON(JSON.stringify(<?php echo json_encode($questions) ?>));
                                var questionOptionsObj = jQuery.parseJSON(JSON.stringify(<?php echo $questionOptions ?>));
                                var isAleadyMapped;

                                function openEditor() {
                                    document.body.scrollTop = 0;
                                    document.documentElement.scrollTop = 0;
                                    $('#addScoreFieldDiv').show();
                                }
                                function closeEditor() {
                                    $('#addScoreFieldDiv').hide();
                                }

                                function setFieldOption(formFieldId) {
                                    optionTableRowSerial = 1;
                                    isAleadyMapped = 0;
                                    $('#formFieldQuestionnairesUid').val("");
                                    $("#optionTable").find("tr:gt(0)").remove();
                                    if (formFieldId === "") {
                                        $('#optionTable').append('<tr id="noTr"><td colspan="2" class="text-center">No Data</td></tr>');
                                        document.getElementById("question").disabled = true;
                                    } else {
                                        document.getElementById("question").disabled = false;

                                    }

                                    if (isAleadyMapped === 0) {
                                        $("#question").prepend("<option value='' selected='selected'>-- Select Question --</option>");
                                        setMappedData(formFieldId);
                                    }
                                    removeDuplicateQuestion();
                                }

                                function setMappedData(formFieldId) {
                                    for (var i = 0; i < formFieldsDetailsObj.formFieldDetails.length; i++) {
                                        if (parseInt(formFieldsDetailsObj.formFieldDetails[i].id) === parseInt(formFieldId)) {
                                            var optionsObj = jQuery.parseJSON(formFieldsDetailsObj.formFieldDetails[i].options);
                                            if (optionsObj) {
                                                var optionTableStr = '';
                                                for (var j = 0; j < optionsObj.length; j++) {
                                                    optionTableStr += '<tr>\n\
                                                                                                <td>' + optionsObj[j].value + '<input type="hidden" id="formFieldOptionKey' + optionTableRowSerial + '" value="' + optionsObj[j].key + '" name="formFieldOptionKey' + optionTableRowSerial + '"></td>\n\
                                                                                                <td id="questionOptionTd' + optionTableRowSerial + '"></td>\n\
                                                                                        </tr>';
                                                    optionTableRowSerial++;
                                                }
                                                $('#noTr').remove();
                                                $('#optionTable').append(optionTableStr);
                                            }
                                        }
                                    }

                                    var questionnaire_uid = "";
                                    var questionnaire_title;
                                    for (var i = 0; i < formFieldQuestionnairesObj.formFieldQuestionnaires.length; i++) {
                                        if (parseInt(formFieldQuestionnairesObj.formFieldQuestionnaires[i].form_field_id) === parseInt(formFieldId)) {
                                            questionnaire_uid = formFieldQuestionnairesObj.formFieldQuestionnaires[i].questionnaire_uid;

                                            $('#formFieldQuestionnairesUid').val(formFieldQuestionnairesObj.formFieldQuestionnaires[i].form_field_questionnaires_uid)

                                            for (j = 0; j < questionsObj.length; j++) {
                                                if (questionsObj[j].questionnaire_uid === questionnaire_uid) {
                                                    questionnaire_title = questionsObj[j].questionnaire_title;
                                                }
                                            }

                                            var questionOptionStr = "<option value=''>-- Select Option --</option>";
                                            for (var m = 0; m < questionOptionsObj.questionOptions.length; m++) {
                                                if (questionOptionsObj.questionOptions[m].questionnaire_uid === questionnaire_uid) {
                                                    questionOptionStr += "<option value='" + questionOptionsObj.questionOptions[m].option_id + "'>" + questionOptionsObj.questionOptions[m].option_value + "</option>";
                                                }
                                            }

                                            var formOptionKey;
                                            var questionnaireOptionId;
                                            var optionValue;
                                            for (var k = 1; k < optionTableRowSerial; k++) {
                                                var questionOptionSelectedStr = "";
                                                for (var j = 0; j < formFieldQuestionnairesObj.formFieldQuestionnaires[i].form_field_question_option.length; j++) {
                                                    formOptionKey = formFieldQuestionnairesObj.formFieldQuestionnaires[i].form_field_question_option[j].form_option_key;
                                                    questionnaireOptionId = formFieldQuestionnairesObj.formFieldQuestionnaires[i].form_field_question_option[j].questionnaire_option_id;
                                                    optionValue = formFieldQuestionnairesObj.formFieldQuestionnaires[i].form_field_question_option[j].question_option_info.option_value;
                                                    if ($('#formFieldOptionKey' + k).val() === formOptionKey) {
                                                        questionOptionSelectedStr = "<option value='" + questionnaireOptionId + "'>" + optionValue + "</option>";
                                                    }
                                                    $('#questionOptionTd' + k).html("<select class='form-control' id='questionOptionDropDown" + k + "'  name='questionOptionDropDown" + k + "' >" + questionOptionSelectedStr + questionOptionStr + "</select>");
                                                }
                                            }

                                        }
                                    }
                                    if (questionnaire_uid !== "") {
                                        isAleadyMapped = 1;
                                        $("#question").prepend("<option value='" + questionnaire_uid + "' selected='selected'>" + questionnaire_title + "</option>");
                                    }
                                }

                                function removeDuplicateQuestion() {
                                    var a = new Array();
                                    $("#question").children("option").each(function (x) {
                                        test = false;
                                        b = a[x] = $(this).val();
                                        for (i = 0; i < a.length - 1; i++) {
                                            if (b === a[i])
                                                test = true;
                                        }
                                        if (test)
                                            $(this).remove();
                                    });
                                }
                                function saveScoreMapping() {
                                    if ($('#formField').val() === "" || $('#question').val() === "") {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oopss..',
                                            text: 'Form Field and Question are required',
                                        });
                                        return false;
                                    }

                                    $('#optionTableRowSerial').val(optionTableRowSerial);

                                    $('#mappingForm').submit();
                                }

                                function setQuestionOption(questionUid) {
                                    var formFieldId = $('#formField').val();
                                    for (var i = 0; i < formFieldQuestionnairesObj.formFieldQuestionnaires.length; i++) {
                                        if (parseInt(formFieldQuestionnairesObj.formFieldQuestionnaires[i].form_field_id) === parseInt(formFieldId)) {
                                            var questionnaire_uid = formFieldQuestionnairesObj.formFieldQuestionnaires[i].questionnaire_uid;
                                            if (questionUid === questionnaire_uid) {
                                                optionTableRowSerial = 1;
                                                $("#optionTable").find("tr:gt(0)").remove();
                                                setMappedData(formFieldId);
                                                removeDuplicateQuestion();
                                                return false;
                                            }
                                        }
                                    }
                                    var questionOptionStr = "<option value=''>-- Select Option --</option>";
                                    for (var i = 0; i < questionOptionsObj.questionOptions.length; i++) {
                                        if (questionOptionsObj.questionOptions[i].questionnaire_uid === questionUid) {
                                            questionOptionStr += "<option value='" + questionOptionsObj.questionOptions[i].option_id + "'>" + questionOptionsObj.questionOptions[i].option_value + "</option>";
                                        }
                                    }
                                    for (var i = 1; i < optionTableRowSerial; i++) {
                                        $('#questionOptionTd' + i).html("<select class='form-control' id='questionOptionDropDown" + i + "'  name='questionOptionDropDown" + i + "' >" + questionOptionStr + "</select>");
                                    }

                                }
</script>
@endpush
