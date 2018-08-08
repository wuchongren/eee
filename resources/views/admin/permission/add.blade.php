@extends('admin.layouts.default')
@section('title','角色管理')
@section('content')
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">角色名</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="role_name" id="inputEmail3" placeholder="" value="{{old('role_name')}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">权限</label>
            <div class="col-sm-3">
                @foreach($permissions as $permission)
                <input type="checkbox" name="name[]" id="optionsRadios2" value="{{$permission->name}}">{{$permission->name}}
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
