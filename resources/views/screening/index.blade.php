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
                                Screening List - {{$screeningList->total()}}
                            </h3>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#import">Update List</button>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create">Add Item</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="card-body">
                        <table class="table table-responsive-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Country</th>
                                    <th>Nationality</th>
                                    <th>DOB</th>
                                    <th>Document Type</th>
                                    <th>Document Number</th>
                              </tr>
                            </thead>
                            <tbody>
                                @if($screeningList->count()>0)
                                    @foreach($screeningList as $screen)
                                      <tr>
                                        <td>{{ $screen->name ?? '' }}</td>
                                        <td>{{ $screen->designation ?? '' }}</td>
                                        <td>{{ $screen->country ?? '' }}</td>
                                        <td>{{ $screen->nationality ?? '' }}</td>
                                        <td>{{ $screen->dob ?? '' }}</td>
                                        <td>{{ $screen->type_of_document ?? '' }}</td>
                                        <td>{{ $screen->document_number ?? '' }}</td>
                                      </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                        <div class="text-center">
                          {{ $screeningList->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('screening.create')
@include('screening.import')
@endsection
@section('lib-js')
@endsection

