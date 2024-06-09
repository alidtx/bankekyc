@extends('layout.admin.master')
@section('lib-css')
@endsection
@push('custom-css')
<style type="text/css">

</style>
@endpush
@section('content')
<main class="c-main">
    <div class="container-fluid p-2">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <h3 class="panel-title txt-dark">
                                Search in Screening List
                            </h3>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="card-body">
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('error') }}
                        </div>
                        @elseif(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('success') }}
                        </div>
                        @endif
                        <form method="post" action="{{route('doSearch')}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="control-label mb-10">Name :  <span style="color:red">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label mb-10">Document Number :</label>
                                <input type="text" name="document_number" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('lib-js')
@endsection

