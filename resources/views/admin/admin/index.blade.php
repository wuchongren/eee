@extends('admin.layouts.default')
@section('title','管理员列表')
@section('content')
    <a href="{{route('admin.add')}}" class="btn btn-primary">添加</a>
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center">分类列表</caption>

        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">管理员姓名</th>
            <th class="text-center">邮箱</th>
            <th class="text-center">是否启用</th>
            <th >操作</th>
        </tr>
        @foreach($admins as $admin)
        <tr>
            <td>{{$admin->id}}</td>
            <td>{{$admin->name}}</td>
            <td>{{$admin->email}}</td>
            <td>
                {{\App\Http\Controllers\Admin\AdminController::$status[$admin->status]}}
            </td>
            <td class="text-left">
                <a href="{{route('admin.edit',$admin->id)}}" class="btn btn-primary glyphicon glyphicon-edit"></a>
                <a href="{{route('admin.del',$admin->id)}}" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                <a href="{{route('admin.reset',$admin->id)}}" class="btn btn-danger">密码重置</a>
                <a href="{{route('admin.roleEdit',$admin->id)}}" class="btn btn-primary glyphicon glyphicon-edit">授权</a>
            </td>
        </tr>
            @endforeach

    </table>
   {{$admins->links()}}
    @stop
