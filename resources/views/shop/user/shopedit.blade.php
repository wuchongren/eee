@extends('shop.layouts.default')
@section('title','商家编辑')
@section('content')
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">商家名称</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="shop_name" id="inputEmail3" placeholder="请输入名称" value="{{old('shop_name',$shop->shop_name)}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">类别</label>
            <div class="col-sm-3">
            <select class="form-control" name="shop_category_id">
                @foreach($shop_categories as $shop_category)
                    <option value="<?=$shop_category->id?>" @if($shop_category->id===$shop->shop_category_id)  selected @endif ><?=$shop_category->name?></option>
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
                    <input type="radio" name="brand"  @if($shop->brand===1) checked @endif value="1" >是
                    <input type="radio" name="brand" @if($shop->brand===0) checked @endif value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否准时送达</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="on_time"  @if($shop->on_time===1) checked @endif  value="1" >是
                    <input type="radio" name="on_time" @if($shop->on_time===0) checked @endif value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否蜂鸟</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="fengniao"  @if($shop->fengniao===1) checked @endif  value="1" >是
                    <input type="radio" name="fengniao" @if($shop->fengmniao===0) checked @endif  value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否保标记</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="bao"  @if($shop->bao===1) checked @endif  value="1" >是
                    <input type="radio" name="bao"   @if($shop->bao===0) checked @endif value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否票标记</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="piao"   @if($shop->piao===1) checked @endif value="1" >是
                    <input type="radio" name="piao"  @if($shop->piao===0) checked @endif value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">是否准标记</label>
            <div class="col-sm-3">
                <label>
                    <input type="radio" name="zhun"  @if($shop->zhun===1) checked @endif value="1" >是
                    <input type="radio" name="zhun"  @if($shop->zhun===0) checked @endif value="0" >否
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">起送金额</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{old('start_send',$shop->start_send)}}" name="start_send">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">配送费用</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{old('send_cost',$shop->send_cost)}}" name="send_cost">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">店家公告</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{old('notice',$shop->notice)}}" name="notice">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">优惠信息</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{old('discount',$shop->discount)}}" name="discount">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>
@stop
