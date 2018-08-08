@extends('admin.layouts.default')
@section('title','导航条菜单列表')
@section('content')
  <dv class="container-fluid">
      <table class="table table-bordered table-condensed" border="1">
          <caption>菜单列表</caption>
          <tr class="active">
              <th>一级菜单</th>
              <th>二级菜单</th>
          </tr>
          @foreach($navs as $nav)
              <tr>
                  <td class="danger">{{$nav->name}}</td>
                  <td>
                  @foreach(\App\Models\Nav::where('pid',$nav->id)->get() as $k=>$v)
                   <li class="btn btn-info"><a href="{{route('nav.edit',$v->id)}}">{{$v->name}}</a></li>
                      @endforeach
                  </td>
              </tr>

              @endforeach
      </table>

  </dv>

@stop
