@extends('admin.layouts.default')
@section('title','用户编辑')
@section('content')
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center">商家账户列表</caption>

        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">名称</th>
            <th class="text-center">邮箱</th>
            <th class="text-center">状态</th>
            <th class="text-center">商店ID</th>
            <th >操作</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    {{\App\Http\Controllers\Admin\UserController::$status[$user->status]}}
                </td>
                <td>{{$user->shops->shop_name}}</td>
                <td class="text-left">
                    <a href="{{route('ur.check',$user->id)}}" class="btn btn-primary">资料审核</a>
                    <a href="{{route('ur.reset',$user->id)}}" class="btn btn-primary">密码重置</a>
                    <a href="{{route('ur.del',$user->id)}}" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{$users->links()}}
@stop