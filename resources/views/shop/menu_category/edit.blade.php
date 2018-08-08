@extends('shop.layouts.default')
@section('title','菜品分类编辑')
@section('content')
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">分类名</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="name" id="inputEmail3" placeholder="请输入类名" value="{{old('name',$menu_category->name)}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">分类描述</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="description" id="inputEmail3" placeholder="描述" value="{{old('description',$menu_category->description)}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">是否为默认分类</label>
            <div class="col-sm-3">
                <input type="radio"  name="is_selected"   value="1" @if($menu_category->is_selected===1)  checked @endif>设为默认
                <input type="radio"  name="is_selected"  value="0" @if($menu_category->is_selected===0)  checked @endif>不默认
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>

@stop
