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
                                Agent - {{$agents->count()}}
                            </h3>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create">Create Agent</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="card-body">
                        
                        <table class="table table-responsive-sm table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 200px">Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Branch</th>
                                    <th>Address</th>
                                    <th>Registered Since</th>
                                    <th style="width: 200px">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if($agents->count()>0)
                                @foreach($agents as $agent)
                                <tr>
                                    <td>{{$agent->name ?? '--'}}</td>
                                    <td>{{$agent->email ?? '--'}}</td>
                                    <td>{{$agent->mobile_no ?? '--'}}</td>
                                    <td>{{$agent->branchInfo->name ?? '--'}}</td>
                                    <td>{{$agent->address ?? '--'}}</td>

                                    <td>{{$agent->created_at ?? ''}}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit_{{$agent->agent_id}}" style="float: left;margin-right: 5px;">Edit</a>

                                        @include('User::agent.edit')
                                        
                                         <form action="{{route('agents.destroy',$agent->agent_id)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this agent?');">Delete</button>
                                        </form>
                                        
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('User::agent.create')
@endsection
@section('lib-js')
@endsection

