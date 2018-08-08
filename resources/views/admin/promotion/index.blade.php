@extends('admin.layouts.default')
@section('title','平台活动列表')
@section('content')
    <div class="container-fluid">
        <form class="form-inline navbar-left">
            {{csrf_field()}}
                <div class="form-group">
                    <input type="radio" name="statu" value="2">未开始
                    <input type="radio" name="statu" value="0">已结束
                    <input type="radio" name="statu" value="1">进行中
                </div>
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="请输入搜素内容">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
        </form>
    </div>
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center text-success">ELE活动列表</caption>
        <tr>
            <th class="text-center">活动名称</th>
            <th class="text-center">活动内容</th>
            <th class="text-center">开始时间</th>
            <th class="text-center">结束时间</th>
            <th class="text-center">活动状态</th>
            <th >操作</th>
        </tr>
        @foreach($promotions as $promotion)
        <tr>
            <td>{{$promotion->title}}</td>
            <td><a href="{{route('promotion.show',$promotion->id)}}" class="btn btn-primary">查看活动详情</a></td>
            <td>{{date('Y-m-d',$promotion->start_time)}}</td>
            <td>{{date('Y-m-d',$promotion->end_time)}}</td>
            <td>{{\App\Http\Controllers\Admin\PromotionController::$status[$promotion->status]}}</td>
            <td class="text-left">
                <a href="{{route('promotion.edit',$promotion->id)}}" class="btn btn-primary glyphicon glyphicon-edit"></a>
                <a href="{{route('promotion.del',$promotion->id)}}" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
            </td>
        </tr>
            @endforeach
    </table>
    {{$promotions->links()}}
    @stop
