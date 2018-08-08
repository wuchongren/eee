@extends('admin.layouts.default')
@section('title','活动内容')
@section('content')
    <a href="{{route('promotion.index')}}" class="btn btn-primary">返回</a>
     <table class="table table-bordered">
         <tr>
             <th>活动名称：</th>
             <th>开始时间</th>
             <th>结束时间</th>
             <th>状态</th>
         </tr>
         <tr>
             <td>{{$promotion->title}}</td>
             <td>{{date('年-月-日',$promotion->start_time)}}</td>
             <td>{{date('年-月-日',$promotion->end_time)}}</td>
             <td>{{\App\Http\Controllers\Admin\PromotionController::$status[$promotion->status]}}</td>
         </tr>
         <tr>
             <td rowspan="10">具体内容</td>
             <td colspan="3" rowspan="10">{!! $promotion->content !!}</td>
         </tr>

     </table>



@stop
