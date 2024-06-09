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
<main class="c-main">
    <div class="container-fluid p-2">
        <div class="fade-in">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 style="display: inline-block">Score Questionnaire Group</h5>
                            <a href="javascript:void(0)" class="float-right text-primary" onclick="showQuestionnaireAdd()"><i class="fa fa-plus-square"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="width:100%">
                                <table id="score-questionnaire-table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr class="">
                                            <th>Score Type</th>
                                            <th>Group Title</th>
                                            <th>Group Sequence</th>
                                            <th>Is Display Title</th>
                                            <th class="no-sort">Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
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
    <div class="modal fade" id="add-modal">
        <div class="overlay2" style="display: none"><div class="loader-2"></div></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Questionnaire Group</h4>
                </div>
                <div class="modal-body">
                    <form role="form" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Score Type</label>
                                    <select  class="form-control" id="scoreType">
                                        <option></option>
                                        <?php
                                        foreach ($scoreTypes as $scoreType) {
                                            echo "<option value='" . $scoreType['score_type_uid'] . "'>" . $scoreType['score_type_title'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Group Title</label>
                                    <input type="text" class="form-control" id="groupTitle">
                                </div> 
                            </div> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Group Sequence</label>
                                    <input type="number" min="0" class="form-control" id="groupSequence">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Is Display Title</label>
                                    <input type="checkbox" id="isDisplayTitle">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="addGroup()"> Submit </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit-modal">
        <div class="overlay2" style="display: none"><div class="loader-2"></div></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit Questionnaire Group</h4>
                </div>
                <div class="modal-body">
                    <form role="form" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Score Type</label>
                                    <select  class="form-control" id="editScoreType">
                                        <option></option>
                                        <?php
                                        foreach ($scoreTypes as $scoreType) {
                                            echo "<option value='" . $scoreType['score_type_uid'] . "'>" . $scoreType['score_type_title'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Group Title</label>
                                    <input type="text" class="form-control" id="editGroupTitle">
                                </div>
                            </div>   
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Group Sequence</label>
                                    <input type="text" class="form-control" id="editGroupSequence">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Is Display Title</label>
                                    <input type="checkbox" id="editIsDisplayTitle">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="editGroupId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="editGroup()"> Submit</button>
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
<script type="text/javascript">
                        $(document).ready(function () {
                            $('#score-questionnaire-table').DataTable({
                                "bDestroy": true,
                                "ajax": "{{route('getQuestionnaireGroupList')}}",
                                "deferRender": true,
                                "aaSorting": []
                            });
                        });

                        function showEdit(serial) {
                            $("#editIsDisplayTitle").prop("checked", false);
                            var scoreTypeTitle = $('#scoreTypeTitle' + serial).val();
                            var scoreTypeUId = $('#scoreTypeUId' + serial).val();
                            var groupTitle = $('#groupTitle' + serial).val();
                            var groupSequence = $('#groupSequence' + serial).val();
                            var isDisplayTitle = $('#isDisplayTitle' + serial).val();
                            var groupId = $('#groupId' + serial).val();

                            $('#editGroupTitle').val(groupTitle);
                            $('#editGroupSequence').val(groupSequence);
                            $('#editGroupId').val(groupId);
                            if (isDisplayTitle === '1') {
                                $("#editIsDisplayTitle").prop("checked", true);
                            }

                            $("#editScoreType").prepend("<option value='" + scoreTypeUId + "' selected='selected'>" + scoreTypeTitle + "</option>");

                            $('#edit-modal').modal('show');
                        }
                        function editGroup() {
                            var scoreType = $.trim($('#editScoreType').val());
                            var groupTitle = $.trim($('#editGroupTitle').val());
                            if (scoreType === "") {
                                $("#editScoreType").addClass("border-danger");
                                return false;
                            }
                            if (groupTitle === "") {
                                $("#editGroupTitle").addClass("border-danger");
                                return false;
                            }

                            $.ajax({
                                type: 'POST',
                                data: {scoreType: scoreType, groupTitle: groupTitle, groupSequence: $('#editGroupSequence').val(), isDisplayTitle: $('#editIsDisplayTitle').val(),groupId:$('#editGroupId').val(), '_token': '{{ csrf_token() }}'},
                                url: '{{route("doEditQuestionnaireGroup")}}',
                                success: function (result) {
                                   
                                    //hideLoaderModal();
                                    if (result === '1') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Yahoo..',
                                            text: 'Score type edited successfully',
                                            showCancelButton: false,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Ok'
                                        }).then((result) => {
                                            window.location.href = '{{route("scoreQuestionnariesGroup")}}';
                                        })

                                    } else if (result === '2') {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oopss..',
                                            text: 'Score type is duplicate',
                                        });
                                        return false;
                                    } else {
                                        window.location.href = '{{route("scoreQuestionnariesGroup")}}';
                                    }
                                },
//                                error: function (data)
//                                {
//                                    window.location.href = '{{route("scoreQuestionnariesGroup")}}';
//                                }
                            });
                        }


                        function showQuestionnaireAdd() {
                            $('#add-modal').modal('show');
                        }

                        function addGroup() {
                            var scoreType = $.trim($('#scoreType').val());
                            var groupTitle = $.trim($('#groupTitle').val());
                            if (scoreType === "") {
                                $("#scoreType").addClass("border-danger");
                                return false;
                            }
                            if (groupTitle === "") {
                                $("#groupTitle").addClass("border-danger");
                                return false;
                            }
                            $.ajax({
                                type: 'POST',
                                data: {scoreType: scoreType, groupTitle: groupTitle, groupSequence: $('#groupSequence').val(), isDisplayTitle: $('#isDisplayTitle').val(), '_token': '{{ csrf_token() }}'},
                                url: '{{route("doAddQuestionnaireGroup")}}',
                                success: function (result) {
                                    //hideLoaderModal();
                                    if (result === '1') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Yahoo..',
                                            text: 'Questionnaire group saved successfully',
                                            showCancelButton: false,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Ok'
                                        }).then((result) => {
                                            window.location.href = '{{route("scoreQuestionnariesGroup")}}';
                                        })

                                    } else if (result === '2') {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oopss..',
                                            text: 'Questionnaire group is duplicate',
                                        });
                                        return false;
                                    } else {
                                        window.location.href = '{{route("scoreQuestionnariesGroup")}}';
                                    }
                                },
                                error: function (data)
                                {
                                    window.location.href = '{{route("scoreQuestionnariesGroup")}}';
                                }
                            });

                        }

</script>
@endpush
