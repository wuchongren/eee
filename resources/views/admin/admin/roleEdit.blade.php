@extends('admin.layouts.default')
@section('title','管理员角色授权')
@section('content')
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
            <div class="col-sm-3">
             {{$admin->name}}
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">授权角色</label>
            <div class="col-sm-3">
                @foreach($roles as $role)
                <input type="checkbox" name="role[]" id="optionsRadios2" value="{{$role->name}}">{{$role->name}}
                  @endforeach

            </div>
        </div>
        {{--<div class="form-group">--}}
            {{--<label for="inputPassword3" class="col-sm-2 control-label">分类简介</label>--}}
            {{--<div class="col-sm-3">--}}
                {{--<input type="text" class="form-control" id="inputPassword3" name="intro" placeholder="分类简介" value="{{old('intro')}}">--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>

@stop
