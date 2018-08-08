@extends('admin.layouts.default')
@section('title','抽奖活动奖品管理')
@section('content')
    <div class="container container-fluid">
        <h1 class="text-center">{{$event->title}}</h1>
    </div>
    <a href="{{route('event.index')}}" class="btn btn-success">返回</a>
@if(\App\Models\EventPrize::where('event_id',$event->id)->get())
        <table class="table table-bordered col-sm-3">
            <tr>
                <th>奖品等级</th>
                <th>奖品名称</th>
                <th>删除</th>
            </tr>
            @foreach(\App\Models\EventPrize::where('event_id',$event->id)->get() as $prize)
            <tr>
                <td>{{$prize->description}}</td>
                <td>{{$prize->name}}</td>
                <td><a href="{{route('event.prizeDel',$prize->id)}}" class=" btn btn-danger glyphicon glyphicon-trash"></a></td>
            </tr>
                @endforeach
        </table>
@endif

    <form class="form-horizontal " action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">奖品名称</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="name" id="inputEmail3" placeholder="请输入名称" value="{{old('name')}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">奖品数量</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="num" id="inputEmail3" placeholder="请输入名称" value="{{old('num')}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">奖品等级</label>
            <div class="col-sm-1">
                <select name="description">
                    <option>请选择将级</option>
                    <option value ="特等奖">特等奖</option>
                    <option value ="一等奖">一等奖</option>
                    <option value="二等奖">二等奖</option>
                    <option value="三等奖">三等奖</option>
                </select>
            </div>

        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>
@stop
