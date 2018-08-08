@extends('shop.layouts.default')
@section('title','密码修改')
@section('content')
    <div class="container-fluid">
        <form class="form-horizontal" action="" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">旧密码</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" name="oldPassword" id="inputEmail3" placeholder="请输入旧密码" value="{{old('oldPassword')}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">新密码</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" id="inputPassword3" name="newPassword" placeholder="请输入新密码" value="{{old('newPassword')}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">确认新密码</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" id="inputPassword3" name="comfirm" placeholder="再次输入新密码"  value="{{old('comfirm')}}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    <input type="submit" class="btn btn-success" value="提交">
                </div>
            </div>
        </form>
    </div>

@stop
