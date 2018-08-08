@extends('shop.layouts.default')
@section('title','抽奖活动奖品管理')
@section('content')
    <div class="container container-fluid">
        <h1 class="text-center">获奖名单</h1>
    </div>
    <a href="{{route('event.index')}}" class="btn btn-success">返回</a>
        <table class="table table-bordered col-sm-3">
            <tr>
                <th>奖品等级</th>
                <th>奖品名称</th>
                <th>获奖者</th>
            </tr>
            @foreach($prizes as $prize)
            <tr>
                <td>{{$prize->description}}</td>
                <td>{{$prize->name}}</td>
                <td>{{$prize->username}}</td>
            </tr>
                @endforeach
        </table>

@stop
