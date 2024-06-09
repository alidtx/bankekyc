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
                        @include('layout.admin.errorSuccessMsg')
                        <div class="card-header text-center">
                            <h5 style="display: inline-block">Score Questionnaire</h5>
                            <a href="{{url('/addScoreQuestionnaries')}}" class="float-right text-primary" ><i class="fa fa-plus-square"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="width:100%">
                                <table id="score-questionnaire-table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr class="">
                                            <th>Questionnaire Group</th>
                                            <th>Score Type</th>
                                            <th>Question Title</th>
                                            <th>Question Sequence</th>
                                            <th>Is Multiple Option</th>
                                            <th>Is Required</th>
                                            <th>Option</th>
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
                                "ajax": "{{route('getQuestionnaireList')}}",
                                "deferRender": true,
                                "aaSorting": []
                            });
                        });

                   

</script>
@endpush
