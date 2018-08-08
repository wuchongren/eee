@extends('shop.layouts.default')
@section('title','活动列表')
@section('content')
    <div class="container-fluid">
        <form class="form-inline navbar-left">
            {{csrf_field()}}
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
            <th class="text-center">开始时间</th>
            <th class="text-center">结束时间</th>
            <th class="text-center">活动状态</th>
            <th class="text-center">查看</th>
            <th >操作</th>
        </tr>
        @foreach($promotions as $promotion)
        <tr>
            <td>{{$promotion->title}}</td>

            <td>{{date('Y-m-d',$promotion->start_time)}}</td>
            <td>{{date('Y-m-d',$promotion->end_time)}}</td>
            <td>{{\App\Http\Controllers\Admin\PromotionController::$status[$promotion->status]}}</td>
            <td><a href="{{route('shoppromotion.show',$promotion->id)}}" class="btn btn-primary">查看活动详情</a></td>
        </tr>
            @endforeach
    </table>
    {{$promotions->links()}}
    @stop
