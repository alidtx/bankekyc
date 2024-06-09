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
    .bg-gray{
        background-color: #ddd;
        color: black
    }
</style>
@endpush
@section('content')
<main class="c-main" id="score_question">
    <div class="container-fluid p-2">
        <div class="fade-in">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @include('layout.admin.errorSuccessMsg')
                            <form method="post" action="{{route('doAddQuestionnaire')}}" id="questionForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Score Type</label>
                                            <select class="form-control" onchange="setScoreQuestionGroup(this.value)" id="scoreType" name="scoreType" id="scoreType">
                                                <option value="">-- Select Score Type --</option>
                                                <?php
                                                foreach ($scoreTypes as $scoreType) {
                                                    echo "<option value='" . $scoreType['score_type_uid'] . "'>" . $scoreType['score_type_title'] . "</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Score Questionnaire Group</label>
                                            <div id="scoreQuestionGroupDiv">
                                                <select class="form-control" id="scoreQuestionGroup" name="scoreQuestionGroup">  
                                                    <option value="">-- Select Score Questionnaire Group --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="allQuestionDiv">
                                            
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm" @click="addQuestion()" >Add Question</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <br>
                                        <hr>
                                        <input type="hidden" name="questionCount" id="questionCount">
                                        <button type="button" class="btn btn-success" type="button" onclick="saveQuestion()">Save Question</button>
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
<script type="text/javascript">

                                            const score_question = new Vue({
                                                el: "#score_question",
                                                data: {
                                                    questions: [
                                                        {
                                                            question_title: undefined,
                                                            question_sequesnce: undefined
                                                        }
                                                    ],
                                                }
                                            });

                                            /*
                                             var questionCount = 1;
                                             
                                             function saveQuestion() {
                                             if ($('#scoreType').val() === "" || $('#scoreQuestionGroup').val() === "") {
                                             Swal.fire({
                                             icon: 'error',
                                             title: 'Oopss..',
                                             text: 'Score Type and Score Questionnaire Group are required',
                                             });
                                             return false;
                                             }
                                             var optionCount;
                                             var question;
                                             var optionValue;
                                             var optionScore;
                                             var questionFlag = 0;
                                             for (var i = 1; i < questionCount; i++) {
                                             question = $('#question' + i).val();
                                             if (typeof question === 'undefined') {
                                             continue;
                                             }
                                             questionFlag = 1;
                                             
                                             if ($.trim(question) === "") {
                                             Swal.fire({
                                             icon: 'error',
                                             title: 'Oopss..',
                                             text: 'Question is required',
                                             });
                                             return false;
                                             }
                                             optionCount = $('#optionCount' + i).val();
                                             for (var j = 1; j <= optionCount; j++) {
                                             optionValue = $('#optionValue' + i + '' + j).val();
                                             if (typeof optionValue !== 'undefined') {
                                             optionScore = $.trim($('#optionScore' + i + '' + j).val());
                                             if (optionValue === "" || optionScore === "") {
                                             Swal.fire({
                                             icon: 'error',
                                             title: 'Oopss..',
                                             text: 'Option value and score are required',
                                             });
                                             return false;
                                             }
                                             }
                                             }
                                             }
                                             $('#questionCount').val(questionCount);
                                             if (questionFlag === 0) {
                                             Swal.fire({
                                             icon: 'error',
                                             title: 'Oopss..',
                                             text: 'Please provide at least one question'
                                             });
                                             return false;
                                             } else {
                                             $('#questionForm').submit();
                                             }
                                             
                                             }
                                             
                                             function addQuestion() {
                                             var questionStr = '<div class="card" id="questionDiv' + questionCount + '">\n\
                                             <div class="card-body">\n\
                                             <div class="row">\n\
                                             <div class="col-md-12 text-right">\n\
                                             <a href="javascript:void(0)" class="float-right text-danger" title="Remove" onclick="removeQuestion(' + questionCount + ')"><i class="fa fa-trash"></i></a>\n\
                                             </div>\n\
                                             </div>\n\
                                             <div class="row">\n\
                                             <div class="col-md-10">\n\
                                             <div class="form-group">\n\
                                             <label class="control-label">Question</label>\n\
                                             <input type="text" class="form-control" id="question' + questionCount + '" name="question' + questionCount + '">\n\
                                             </div>\n\
                                             </div>\n\
                                             <div class="col-md-2">\n\
                                             <div class="form-group">\n\
                                             <label class="control-label">Question Sequence</label>\n\
                                             <input type="number" class="form-control" id="questionSequence' + questionCount + '" name="questionSequence' + questionCount + '">\n\
                                             </div>\n\
                                             </div>\n\
                                             </div>\n\
                                             <div class="row">\n\
                                             <div class="col-md-4">\n\
                                             <div class="form-group">\n\
                                             <label class="control-label">Is Multiple Option</label>\n\
                                             <input type="checkbox" id="isMultipleOption' + questionCount + '" name="isMultipleOption' + questionCount + '">\n\
                                             </div>\n\
                                             </div>\n\
                                             <div class="col-md-4">\n\
                                             <div class="form-group">\n\
                                             <label class="control-label">Is Required</label>\n\
                                             <input type="checkbox" id="isRequired' + questionCount + '" name="isRequired' + questionCount + '">\n\
                                             </div>\n\
                                             </div>\n\
                                             </div>\n\
                                             <table class="table table-bordered" id="optionTable' + questionCount + '">\n\
                                             <tr class="bg-gray" >\n\
                                             <td>Option Value</td>\n\
                                             <td>Option Sequence</td>\n\
                                             <td>Option Score</td>\n\
                                             <td>Remove</td>\n\
                                             </tr>\n\
                                             <tr id="noTr' + questionCount + '">\n\
                                             <td colspan="4" align="center">No Option Found</td>\n\
                                             </tr>\n\
                                             </table>\n\
                                             <input type="hidden" name="optionCount' + questionCount + '"  id="optionCount' + questionCount + '" value="0">\n\
                                             <a href="javascript:void(0)" class="float-right text-primary" title="Add Option" onclick="addOption(' + questionCount + ')"><i class="fa fa-plus-square"></i></a>\n\
                                             </div>\n\
                                             </div>';
                                             $('#allQuestionDiv').append(questionStr);
                                             questionCount++;
                                             }
                                             
                                             function addOption(questionSerial) {
                                             var optionCount = ($('#optionCount' + questionSerial).val());
                                             
                                             console.log(optionCount);
                                             
                                             if (optionCount === '0') {
                                             $('#noTr' + questionSerial).remove();
                                             }
                                             optionCount++;
                                             var optionStr = '<tr id="optionTr' + questionSerial + '' + optionCount + '">\n\
                                             <td><input type="text" class="form-control" name="optionValue' + questionSerial + '' + optionCount + '"  id="optionValue' + questionSerial + '' + optionCount + '"></td>\n\
                                             <td><input type="number" class="form-control" name="optionSequence' + questionSerial + '' + optionCount + '" id="optionSequence' + questionSerial + '' + optionCount + '"></td>\n\
                                             <td><input type="number" class="form-control" name="optionScore' + questionSerial + '' + optionCount + '" id="optionScore' + questionSerial + '' + optionCount + '"></td>\n\
                                             <td><a href="javascript:void(0)"  class="text-primary" title="Remove Option" onclick="removeOption(' + questionSerial + ',' + optionCount + ')" ><i class="fa fa-trash"></i></a></td>\n\
                                             </tr>';
                                             $('#optionTable' + questionSerial).append(optionStr);
                                             $('#optionCount' + questionSerial).val(optionCount);
                                             }
                                             
                                             function removeOption(questionSerial, optionSerial) {
                                             $('#optionTr' + questionSerial + optionSerial).remove();
                                             if ($('#optionTable' + questionSerial + ' tr').length === 1) {
                                             $('#optionTable' + questionSerial).append('<tr id="noTr' + questionSerial + '">\n\
                                             <td colspan="4" align="center">No Option Found</td>\n\
                                             </tr>');
                                             }
                                             }
                                             
                                             function removeQuestion(questionSerial) {
                                             $('#questionDiv' + questionSerial).remove();
                                             }
                                             */
                                            var scoreQuestionGroupObj = jQuery.parseJSON(JSON.stringify(<?php echo $scoreQuestionGroup ?>));
                                            function setScoreQuestionGroup(scoreType) {
                                                var optionStr = "<option value=''></option>";
                                                for (var i = 0; i < scoreQuestionGroupObj.scoreQuestionGroupData.length; i++) {
                                                    if (scoreQuestionGroupObj.scoreQuestionGroupData[i].score_type_uid === scoreType) {
                                                        optionStr += "<option value='" + scoreQuestionGroupObj.scoreQuestionGroupData[i].group_id + "'>" + scoreQuestionGroupObj.scoreQuestionGroupData[i].group_title + "</option>";
                                                    }
                                                }
                                                $('#scoreQuestionGroupDiv').html('<select class="form-control" name="scoreQuestionGroup" id="scoreQuestionGroup">' + optionStr + '</select>');
                                            }

</script>
@endpush
