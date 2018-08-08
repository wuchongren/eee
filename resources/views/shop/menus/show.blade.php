@extends('admin.layouts.default')
@section('title','商品查看')
@section('contents')
    <a href="{{route('good.index')}}" class="btn btn-warning">返回</a>
    <table class="table table-bordered">
        <caption class="text-center text-danger"><h1>{{$good->name}}</h1></caption>
        <tr>
            <th>分类:{{$good->goodCategory->name}}</th>
            <th>价格:{{$good->price}}</th>
            <th>上架:
                @if($good->is_onsale)
                是
                    @else
                否
                    @endif
            </th>
            <th>已浏览:{{$good->look}}次</th>
        </tr>
        <tr>
            <td colspan="4">
                <p>
                    {{$good->intro}}
                </p>
                <p>
                    <img src="/{{$good->logo}}" alt="">

                </p>
                <p>
                    {{$good->intro}}
                </p> <p>
                    {{$good->intro}}
                </p>
            </td>
        </tr>


    </table>
@stop
