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
<main class="c-main">
    <div class="container-fluid p-2">
        <div class="fade-in">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @include('layout.admin.errorSuccessMsg')
                            <form method="post" action="{{route('doEditQuestionnaire')}}" id="questionForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Score Type</label>
                                            <select class="form-control" onchange="setScoreQuestionGroup(this.value)" id="scoreType" name="scoreType" id="scoreType">
                                                <option value="{{$questionDetails['score_type_uid']}}">{{$questionDetails['score_type']['score_type_title']}}</option>
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
                                                    <option value="{{$questionDetails['group_id']}}">{{$questionDetails['question_group']['group_title']}}</option>
                                                    <option value="">-- Select Score Questionnaire Group --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="allQuestionDiv">
                                            <div class="card" id="questionDiv1">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <label class="control-label">Question</label>
                                                                <input type="text" class="form-control" id="question" name="question" value="{{$questionDetails['questionnaire_title']}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">Question Sequence</label>
                                                                <input type="number" class="form-control" id="questionSequence" name="questionSequence" value="{{$questionDetails['questionnaire_sequence']}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">Is Multiple Option</label>
                                                                <input type="checkbox" id="isMultipleOption" name="isMultipleOption" <?php ($questionDetails['has_multiple_option']) ? 'checked' : '' ?>>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">Is Required</label>
                                                                <input type="checkbox" id="isRequired" name="isRequired" <?php ($questionDetails['is_required']) ? 'checked' : '' ?>>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <table class="table table-bordered" id="optionTable">
                                                        <tr class="bg-gray" >
                                                            <td>Option Value</td>
                                                            <td>Option Sequence</td>
                                                            <td>Option Score</td>
                                                            <td>Remove</td>
                                                        </tr>

                                                        <?php
                                                        $optionSerial = 1;
                                                        foreach ($questionDetails['options'] as $options) {
                                                            ?>

                                                            <tr id="optionTr{{$optionSerial}}">
                                                                <td><input type="text" class="form-control" name="optionValue{{$optionSerial}}"  id="optionValue{{$optionSerial}}" value="{{$options['option_value']}}"></td>
                                                                <td><input type="number" class="form-control" name="optionSequence{{$optionSerial}}" id="optionSequence{{$optionSerial}}" value="{{$options['option_sequence']}}"></td>
                                                                <td><input type="number" class="form-control" name="optionScore{{$optionSerial}}" id="optionScore{{$optionSerial}}" value="{{$options['option_score']}}"></td>
                                                                <td>
                                                                    <input type="hidden" class="form-control" name="optionId{{$optionSerial}}" id="optionId{{$optionSerial}}" value="{{$options['option_id']}}">
                                                                    <a href="javascript:void(0)"  class="text-primary" title="Remove Option" onclick="removeOption('<?php echo $optionSerial ?>')" ></a></td>
                                                            </tr>
                                                            <?php
                                                            $optionSerial++;
                                                        }
                                                        if ($optionSerial == 1) {
                                                            ?>
                                                            <tr id="noTr">
                                                                <td colspan="4" align="center">No Option Found</td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>


                                                    </table>
                                                    <input type="hidden" name="optionCount"  id="optionCount" value="{{$optionSerial}}">
                                                    <a href="javascript:void(0)" class="float-right text-primary" title="Add Option" onclick="addOption()"><i class="fa fa-plus-square"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <br>
                                        <hr>
                                        <input type="hidden" name="deleteOptionStr" id="deleteOptionStr">
                                        <input type="hidden" name="questionnaireId" id="questionnaireId" value="{{$questionDetails['questionnaire_id']}}">
                                        <button type="button" class="btn btn-success" type="button" onclick="saveQuestion()">Update Question</button>
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

                                                question = $('#question').val();

                                                if ($.trim(question) === "") {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Oopss..',
                                                        text: 'Question is required',
                                                    });
                                                    return false;
                                                }
                                                optionCount = $('#optionCount').val();
                                                for (var j = 1; j <= optionCount; j++) {
                                                    optionValue = $('#optionValue' + j).val();
                                                    if (typeof optionValue !== 'undefined') {
                                                        optionScore = $.trim($('#optionScore' + j).val());
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
                                                $('#questionForm').submit();
                                            }


                                            function addOption() {
                                                var optionCount = ($('#optionCount').val());
                                                if (optionCount === '0') {
                                                    $('#noTr').remove();
                                                }
                                                optionCount++;
                                                var optionStr = '<tr id="optionTr' + optionCount + '">\n\
                                                                        <td><input type="text" class="form-control" name="optionValue' + optionCount + '"  id="optionValue' + optionCount + '"></td>\n\
                                                                        <td><input type="number" class="form-control" name="optionSequence' + optionCount + '" id="optionSequence' + optionCount + '"></td>\n\
                                                                        <td><input type="number" class="form-control" name="optionScore' + optionCount + '" id="optionScore' + optionCount + '"></td>\n\
                                                                        <td><input type="hidden" name="optionId' + optionCount + '" id="optionId' + optionCount + '" value="0"><a href="javascript:void(0)"  class="text-primary" title="Remove Option" onclick="removeOption(' + optionCount + ')" ><i class="fa fa-trash"></i></a></td>\n\
                                                                        </tr>';
                                                $('#optionTable').append(optionStr);
                                                $('#optionCount').val(optionCount);
                                            }

                                            function removeOption(optionSerial) {
                                                var idArr = new Array();
                                                idArr.push($('#optionId' + optionSerial).val());
                                                if ($('#deleteOptionStr').val() !== "") {
                                                    idArr.push($('#deleteOptionStr').val());
                                                }
                                                $('#deleteOptionStr').val(idArr.join());

                                                $('#optionTr' + optionSerial).remove();
                                                if ($('#optionTable tr').length === 1) {
                                                    $('#optionTable').append('<tr id="noTr">\n\
                                                            <td colspan="4" align="center">No Option Found</td>\n\
                                                        </tr>');
                                                }
                                            }



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
