@extends('admin.layouts.default')
@section('title','商家审核')
@section('content')
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">状态</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="status"   value="1" >启用
                    <input type="radio" name="status"   value="0" >禁用
                    <input type="radio" name="status"   value="-1" >待审核
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>
@stop
