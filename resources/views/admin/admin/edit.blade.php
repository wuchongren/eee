@extends('admin.layouts.default')
@section('title','管理员添加')
@section('content')
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="inputEmail3" placeholder="请输入姓名" value="{{old('name',$admin->name)}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" id="inputEmail3" placeholder="请输入密码" value="{{old('password',$admin->password)}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">邮箱</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name="email" id="inputEmail3" placeholder="邮箱" value="{{old('email',$admin->email)}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">状态</label>
            <div class="col-sm-10">
                <input type="radio" name="status" id="optionsRadios2" @if($admin->status===1) checked @endif value="1">启用
                <input type="radio" name="status" id="optionsRadios2"  @if($admin->status===0) checked @endif value="0">禁止
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>

@stop
