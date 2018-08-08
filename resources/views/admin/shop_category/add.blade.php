@extends('admin.layouts.default')
@section('title','文章分类添加')
@section('content')
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">分类名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="inputEmail3" placeholder="请输入类名" value="{{old('name')}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">上传图片</label>
            <div class="col-sm-10">
                <input type="file" id="exampleInputFile" name="img">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">状态</label>
            <div class="col-sm-10">
                <input type="radio" name="status" id="optionsRadios2" value="1">启用
                <input type="radio" name="status" id="optionsRadios2" value="0">禁止
            </div>
        </div>
        {{--<div class="form-group">--}}
            {{--<label for="inputPassword3" class="col-sm-2 control-label">分类简介</label>--}}
            {{--<div class="col-sm-10">--}}
                {{--<input type="text" class="form-control" id="inputPassword3" name="intro" placeholder="分类简介" value="{{old('intro')}}">--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>

@stop
