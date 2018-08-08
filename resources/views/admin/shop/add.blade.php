@extends('admin.layouts.default')
@section('title','商品添加')
@section('content')
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">商家名称</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="shop_name" id="inputEmail3" placeholder="请输入名称" value="{{old('shop_name')}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">类别</label>
            <div class="col-sm-3">
            <select class="form-control" name="shop_category_id">
                @foreach($shop_categories as $shop_category)
                    <option value="<?=$shop_category->id?>"><?=$shop_category->name?></option>
                @endforeach
            </select>
            </div>
            </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">店家图片</label>
            <div class="col-sm-3">
                <input type="file" class="form-control" name="shop_img" >
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否品牌</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="brand"    value="1" >是
                    <input type="radio" name="brand"  value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否准时送达</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="on_time"    value="1" >是
                    <input type="radio" name="on_time"  value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否蜂鸟</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="fengniao"    value="1" >是
                    <input type="radio" name="fengniao"  value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否保标记</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="bao"    value="1" >是
                    <input type="radio" name="bao"  value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否票标记</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="piao"    value="1" >是
                    <input type="radio" name="piao"  value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否准标记</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="zhun"    value="1" >是
                    <input type="radio" name="zhun"  value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">起送金额</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{old('start_send')}}" name="start_send">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">配送费用</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{old('send_cost')}}" name="send_cost">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">店家公告</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{old('notice')}}" name="notice">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">优惠信息</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{old('discount')}}" name="discount">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">状态</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="status"    value="1" >启用
                    <input type="radio" name="status"  value="0" >禁用
                    <input type="radio" name="status"  value="-1" >待审核
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
