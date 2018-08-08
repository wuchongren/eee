@extends('admin.layouts.default')
@section('title','消费者管理')
@section('content')
    <div class="container-fluid">
        <form class="form-inline navbar-right">
            {{csrf_field()}}
            <div class="form-group">
                <input type="text" class="form-control" name="search" value="{{request()->input('search')}}"  placeholder="请输入搜素会员的ID或名字">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
        </form>
    </div>
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center">客户列表</caption>
        <tr>
            <th>客户ID</th>
            <th>客户名称</th>
            <th>电话</th>
            <th>创建时间</th>
            <th>更新时间</th>
            <th>操作</th>

        </tr>
        @foreach($members as $member)
            <tr>
                <td>{{$member->id}}</td>
                <td>{{$member->username}}</td>
                <td>{{$member->tel}}</td>
                <td>{{$member->created_at}}</td>
                <td>{{$member->updated_at}}</td>
                <td>
                    <a href="{{route('member.show',$member->id)}}" class="btn btn-info">查看</a>
                    <a href="{{route('member.check',$member->id)}}" class="btn btn-danger">禁用</a>
                </td>
            </tr>
        @endforeach
    </table>
    {{$members->appends($search)->links()}}
@stop