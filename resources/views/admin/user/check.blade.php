@extends('admin.layouts.default')
@section('title','商家账户编辑')
@section('content')
    <form class="form-horizontal" action="" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-3">
                {{$user->name}}
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">邮箱</label>
            <div class="col-sm-3">
                {{$user->email}}
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">商店ID</label>
            <div class="col-sm-3">
                {{$user->shops->shop_name}}
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">商店状态</label>
            <div class="col-sm-3">
                <input type="radio" name="status" @if($user->shops->status===1) checked @endif value="1">启用
                <input type="radio" name="status" @if($user->shops->status===0) checked @endif value="0">禁用
                <input type="radio" name="status" @if($user->shops->status===-1) checked @endif value="-1">待审核
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>

@stop
