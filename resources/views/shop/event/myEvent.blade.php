@extends('shop.layouts.default')
@section('title','我参加的活动')
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
        <caption class="text-center text-success">我参加的活动</caption>
        <tr>
            <th class="text-center">活动名称</th>
            <th class="text-center">详情</th>
            <th class="text-center">开奖时间</th>
            <th class="text-center">已报名人数/总数</th>
            <th class="text-center">是否开奖</th>
        </tr>
        @foreach($events as $event)
        <tr>
            <td>{{$event->title}}</td>
            <td>{!!  $event->content !!}</td>
            <td>{{date('Y-m-d',$event->prize_time)}}</td>
            <td>   {{$event->sign_num}}人  /  {{$event->num}}人</td>
            <td>{{$event->sign_num}}</td>
                @if($event->is_prized===0)
                <td>还未开始</td>
                @elseif($event->is_prized===1)
                <td>活动已结束</td>
            @endif
        </tr>
            @endforeach
    </table>
    @stop