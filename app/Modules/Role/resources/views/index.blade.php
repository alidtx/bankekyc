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
                                Roles
                            </h3>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create">Create Role</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="card-body">
                        <table class="table table-responsive-sm table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 200px">Name</th>
                                    <th>Permissions</th>
                                    <th style="width: 200px">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if($roles->count()>0)
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->name ?? ''}}</td>
                                    <td>
                                       @if($role->permissions)
                                       @foreach($role->permissions as $permission)
                                       <span class="label label-success mb-1" style="display:inline-block;">{{$permission->name ?? ''}}</span>
                                       @endforeach
                                       @endif
                                    </td>
                                    <td>
                                       <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit_{{$role->id}}" style="float: left;margin-right: 5px;">Edit</button>
                                        @include('Role::edit')
                                        <form action="role/delete/{{$role->id}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this role?');">Delete</button>
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
@include('Role::create')
@endsection
@section('lib-js')
@endsection

