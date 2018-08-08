@extends('admin.layouts.default')
@section('title','角色管理列表')
@section('content')
    <a href="{{route('role.add')}}" class="btn btn-primary">添加</a>
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center">角色列表</caption>

        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">角色名</th>
            <th class="text-center">拥有权限</th>
            <th >操作</th>
        </tr>
        @foreach($roles as $role)
        <tr>
            <td>{{$role->id}}</td>
            <td>{{$role->name}}</td>
            <td>{{$role->guard_name}}</td>
            <td class="text-left">
                <a href="{{route('role.edit',$role->id)}}" class="btn btn-primary glyphicon glyphicon-edit"></a>
                <a href="{{route('role.del',$role->id)}}" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
            </td>
        </tr>
            @endforeach

    </table>
    @stop
