@extends('admin.layouts.default')
@section('title','会员信息')
@section('content')
    <div class="container-fluid">
        <a href="{{route('member.index')}}" class="btn btn-primary">返回</a>
    </div>
     <table class="table table-bordered">
         <tr>
             <th>会员名称：</th>
             <th>电话</th>
             <th>账户余额</th>
             <th>积分</th>
             <th>账户状态</th>
             <th>创建时间</th>

         </tr>
         <tr>
             <td>{{$member->username}}</td>
             <td>{{$member->tel}}</td>
             <td>{{$member->money}}</td>
             <td>{{$member->jifen}}</td>
             <td>{{\App\Http\Controllers\Admin\MemberController::$status[$member->status]}}</td>
             <td>{{date('Y年m月d日',strtotime($member->created_at))}}</td>

         </tr>

     </table>
@stop
