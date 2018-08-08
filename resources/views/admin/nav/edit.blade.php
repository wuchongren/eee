@extends('admin.layouts.default')
@section('title','导航条菜单编辑')
@section('content')
    <form class="form-horizontal" action="" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-sm-2 control-label">菜单名称</label>
            <div class="col-sm-3">
                {{$na->name}}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">上级菜单</label>
            <div class="col-sm-3">
                <select name="pid" class="form-control">
                    <option value="0">顶级分类</option>
                    @foreach($navs as $nav)
                        <option value="{{$nav->id}}"  @if($nav->id == $na->pid) selected @endif >{{$nav->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">排序</label>
            <div class="col-sm-3">
                <input type="text" name="sort" class="form-control" >
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <button type="submit" class="btn btn-default">提交</button>
            </div>
        </div>
    </form>

@stop
