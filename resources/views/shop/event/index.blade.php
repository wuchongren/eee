@extends('shop.layouts.default')
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
            <th class="text-center">详情</th>
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
            @if($event->num > $event->sign_num && $event->is_prized===0)
                <td><a class="btn btn-danger" href="{{route('event.signIn',$event->id)}}">火热报名中，我要报名</a></td>
                @elseif($event->num <= $event->sign_num && $event->is_prized===0)
                <td>报名人数已满</td>
                @elseif($event->is_prized===1)
                <td>活动已结束</td>
            @endif
            <td class="text-left">
                @if($event->is_prized===0)
                    <a class="btn btn-info" href="#">未开始！！</a>
                    @else
                    <a href="{{route('event.winner',$event->id)}}" class="btn btn-success">获奖名单</a>
                @endif

            </td>
        </tr>
            @endforeach
    </table>
    @stop
