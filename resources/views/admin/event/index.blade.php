@extends('admin.layouts.default')
@section('title','抽奖活动列表')
@section('content')
    <div class="container-fluid">
        {{--<form class="form-inline navbar-left">--}}
            {{--{{csrf_field()}}--}}
                {{--<div class="form-group">--}}
                    {{--<input type="radio" name="statu" value="2">未开始--}}
                    {{--<input type="radio" name="statu" value="0">已结束--}}
                    {{--<input type="radio" name="statu" value="1">进行中--}}
                {{--</div>--}}
            {{--<div class="form-group">--}}
                {{--<input type="text" class="form-control" name="search" placeholder="请输入搜素内容">--}}
            {{--</div>--}}
            {{--<button type="submit" class="btn btn-default">搜索</button>--}}
        {{--</form>--}}
    </div>
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center text-success">ELE抽奖活动列表</caption>
        <tr>
            <th class="text-center">活动名称</th>
            <th class="text-center">抽奖详情</th>
            <th class="text-center">开始报名时间</th>
            <th class="text-center">结束报名时间</th>
            <th class="text-center">开奖时间</th>
            <th class="text-center">人数限制</th>
            <th class="text-center">已报名人数</th>
            <th class="text-center">是否开奖</th>
            <th >操作</th>
        </tr>
        @foreach($events as $event)
        <tr>
            <td>{{$event->title}}</td>
            <td>{!!  $event->content !!}</td>
            <td>{{date('Y-m-d',$event->start_time)}}</td>
            <td>{{date('Y-m-d',$event->end_time)}}</td>
            <td>{{date('Y-m-d',$event->prize_time)}}</td>
            <td>{{$event->num}}</td>
            <td>{{$event->sign_num}}</td>
            <td>{{\App\Http\Controllers\Admin\EventController::$status[$event->is_prized]}}</td>
            <td class="text-left">
                @if($event->is_prized===0)
                    <a href="{{route('event.prizeEdit',$event->id)}}" class="btn btn-primary">奖品管理</a>
                    <a href="{{route('event.eventSign',$event->id)}}" class="btn btn-primary">报名查看</a>
                    <a href="{{route('event.prize',$event->id)}}" class="btn btn-danger">抽奖</a>
                    @else
                    <a href="{{route('event.show',$event->id)}}" class="btn btn-success">获奖详情</a>
                    <li class="btn btn-info">已结束</li>
                @endif

            </td>
        </tr>
            @endforeach
    </table>
    @stop
