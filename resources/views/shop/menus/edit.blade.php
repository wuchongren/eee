@extends('shop.layouts.default')
@section('title','菜品编辑')
@section('content')
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">菜品名称</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="goods_name" id="inputEmail3" placeholder="请输入名称" value="{{old('goods_name',$menus->goods_name)}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">菜品类别</label>
            <div class="col-sm-3">
            <select class="form-control" name="menu_category_id">
                @foreach($menus_categories as $menus_category)
                    <option value="<?=$menus_category->id?>"  @if($menus_category->id===$menus->menu_category_id) selected @endif><?=$menus_category->name?></option>
                @endforeach
            </select>
            </div>
            </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">菜品图片</label>
            <div class="col-sm-3">
                <input type="file" class="form-control" name="goods_img" >
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否上架</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="status"  value="1" @if($menus->status===1) checked @endif >是
                    <input type="radio" name="status"  value="0" @if($menus->status===0) checked @endif>否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">售卖价格</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{old('goods_price',$menus->goods_price)}}" name="goods_price">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">提示</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{old('tips',$menus->tips)}}" name="tips">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">菜品描述</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{old('description',$menus->description)}}" name="description">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>
@stop
