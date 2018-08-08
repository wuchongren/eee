@extends('admin.layouts.default')
@section('title','分类编辑')
@section('content')
    <form class="form-horizontal" action="" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">分类名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="inputEmail3" value="{{old('name',$shop_category->name)}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">状态</label>
            <div class="col-sm-10">
                <input type="radio" name="status" id="optionsRadios2" value="1" @if($shop_category->status=='1') checked @endif>启用
                <input type="radio" name="status" id="optionsRadios2" value="0" @if($shop_category->status=='0') checked @endif>禁止
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">分类图片</label>
            <div class="col-sm-10">
                <img src={{$shop_category->img}}"" alt="" width="100">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>

@stop
