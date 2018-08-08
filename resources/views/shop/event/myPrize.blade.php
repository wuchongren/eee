@extends('shop.layouts.default')
@section('title','我的奖品库')
@section('content')
     <table class="table table-bordered">
         <caption>我的奖品库</caption>
         <tr>
             <th>奖品等级</th>
             <th>奖品</th>
         </tr>
         @foreach($prizes as $prize)
         <tr>
             <td>{{$prize->description}}</td>
             <td>{{$prize->name}}</td>
         </tr>
    @endforeach

     </table>



@stop
