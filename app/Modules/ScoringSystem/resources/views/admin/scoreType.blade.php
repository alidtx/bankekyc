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
    <div class="container-fluid p-2">
        <div class="fade-in">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 style="display: inline-block">Score Type List</h5>
                            <a href="javascript:void(0)" class="float-right text-primary" onclick="showScoreTypeAdd()"><i class="fa fa-plus-square"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="width:100%">
                                <table id="score-type-table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr class="">
                                            <th>Score Type Title</th>
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
                    <h4 class="modal-title">Add Score Type</h4>
                </div>
                <div class="modal-body">
                    <form role="form" class="form-horizontal" id="scoreTypeAddForm">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Score Type Title</label>
                                    <input type="text" class="form-control" id="scoreTypeTitle" name="scoreTypeTitle">

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="addScoreType()"> Submit </button>
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
                    <h4 class="modal-title">Edit Payment Method</h4>
                </div>
                <div class="modal-body">
                    <form role="form" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Score Type Title</label>
                                    <input type="text" class="form-control" id="editScoreTypeTitle" name="editScoreTypeTitle">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="editScoreTypeId" id="editScoreTypeId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="editScoreType()"> Submit</button>
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
                            $('#score-type-table').DataTable({
                                "bDestroy": true,
                                "ajax": "{{route('getScoreTypeList')}}",
                                "deferRender": true,
                                "aaSorting": []
                            });
                        });

                        function showEdit(serial) {
                            var scoreTypeTitle = $('#scoreTypeTitle' + serial).val();
                            var scoreTypeId = $('#scoreTypeId' + serial).val();
                            $('#editScoreTypeTitle').val(scoreTypeTitle);
                            $('#editScoreTypeId').val(scoreTypeId);
                            $('#edit-modal').modal('show');
                        }

                        function editScoreType() {
                            var scoreTypeTitle = $.trim($('#editScoreTypeTitle').val());
                            if (scoreTypeTitle === "") {
                                $("#editScoreTypeTitle").addClass("border-danger");
                                return false;
                            }

                            //return false;
                            $.ajax({
                                type: 'POST',
                                data: {scoreTypeTitle: scoreTypeTitle, scoreTypeId:$.trim($('#editScoreTypeId').val()),'_token': '{{ csrf_token() }}'},
                                url: '{{route("doEditScoreType")}}',
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
                                            window.location.href = '{{route("scoreType")}}';
                                        })

                                    } else if (result === '2') {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oopss..',
                                            text: 'Score type is duplicate',
                                        });
                                        return false;
                                    } else {
                                        window.location.href = '{{route("scoreType")}}';
                                    }
                                },
                                error: function (data)
                                {
                                    window.location.href = '{{route("scoreType")}}';
                                }
                            });
                        }


                        function showScoreTypeAdd() {
                            $('#add-modal').modal('show');
                        }

                        function addScoreType() {

                            var scoreTypeTitle = $.trim($('#scoreTypeTitle').val());
                            if (scoreTypeTitle === "") {
                                $("#scoreTypeTitle").addClass("border-danger");
                                return false;
                            }

                            //return false;
                            $.ajax({
                                type: 'POST',
                                data: {scoreTypeTitle: scoreTypeTitle, '_token': '{{ csrf_token() }}'},
                                url: '{{route("doAddScoreType")}}',
                                success: function (result) {
                                    //hideLoaderModal();
                                    if (result === '1') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Yahoo..',
                                            text: 'Score type saved successfully',
                                            showCancelButton: false,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Ok'
                                        }).then((result) => {
                                            window.location.href = '{{route("scoreType")}}';
                                        })

                                    } else if (result === '2') {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oopss..',
                                            text: 'Score type is duplicate',
                                        });
                                        return false;
                                    } else {
                                        window.location.href = '{{route("scoreType")}}';
                                    }
                                },
                                error: function (data)
                                {
                                    window.location.href = '{{route("scoreType")}}';
                                }
                            });

                        }

</script>
@endpush
