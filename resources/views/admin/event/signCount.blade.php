@extends('admin.layouts.default')
@section('title','报名账户查看')
@section('content')
    <div class="container container-fluid">
        <h1 class="text-center">报名账户列表</h1>
    </div>
    <a href="{{route('event.index')}}" class="btn btn-success">返回</a>
        <table class="table table-bordered col-sm-3">
            <tr>
                <th>活动ID</th>
                <th>活动名称</th>
                <th>报名账户ID</th>
                <th>姓名</th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>{{$event->id}}</td>
                <td>{{$event->title}}</td>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
            </tr>
                @endforeach
        </table>

@stop
