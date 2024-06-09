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
                                System User - {{$users->count()}}
                            </h3>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create">Create System User</button>
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
                                    <th>Brnach</th>
                                    <th>Role</th>
                                    <th>Registered Since</th>
                                    <th style="width: 200px">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if($users->count()>0)
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$user->name ?? '--'}}</td>
                                    <td>{{$user->email ?? '--'}}</td>
                                    <td>{{$user->mobile_no ?? '--'}}</td>
                                    <td>{{$user->branch != '' ? $user->branch : '--' ?? '--'}}</td>
                                    <td>
                                        @if($user->getRoleNames()->count())
                                        <span class="label label-success"> {{$user->getRoleNames()[0]}} </span>
                                        @endif
                                    </td>
                                    <td>{{$user->created_at ?? ''}}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit_{{$user->id}}" style="float: left;margin-right: 5px;">Edit</a>

                                        @include('User::system.edit')
                                        
                                         <form action="{{route('system-users.destroy',$user->id)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
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
@include('User::system.create')
@endsection
@section('lib-js')
@endsection

