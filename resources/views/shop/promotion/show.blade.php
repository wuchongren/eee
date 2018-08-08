@extends('shop.layouts.default')
@section('title','活动内容')
@section('content')
    <div class="container-fluid">
        <a href="{{route('shoppromotion.index')}}" class="btn btn-primary">返回</a>
        <a href="{{route('shoppromotion.jionin',$promotion->id)}}" class="btn btn-primary navbar-right">申请加入</a>
    </div>

     <table class="table table-bordered">
         <tr>
             <th>活动名称：</th>
             <th>开始时间</th>
             <th>结束时间</th>
             <th>状态</th>
         </tr>
         <tr>
             <td>{{$promotion->title}}</td>
             <td>{{date('Y年m月d日',$promotion->start_time)}}</td>
             <td>{{date('Y年m月d日',$promotion->end_time)}}</td>
             <td>{{\App\Http\Controllers\Shop\PromotionController::$status[$promotion->status]}}</td>
         </tr>
         <tr>
             <td rowspan="2">具体内容</td>
             <td colspan="2" rowspan="10">{!! $promotion->content !!}</td>
         </tr>

     </table>



@stop
