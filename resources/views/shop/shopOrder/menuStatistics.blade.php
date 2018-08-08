@extends('shop.layouts.default')
@section('title','店铺菜品销量统计')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="{{route('shopOrder.menuDay')}}" class="btn btn-success">按日统计</a>
                    <a href="{{route('shopOrder.menuMonth')}}" class="btn btn-info">按月统计</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <caption class="text-center">菜品历史销售统计</caption>
                        <tbody>
                        <tr>
                            <th>菜品ID</th>
                            <th>菜品名称</th>
                            <th>总销售数量</th>
                        </tr>
                        @foreach($counts as $count)
                            <tr>
                                <td>{{$count->goods_id}}</td>
                                <td>{{$count->goods_name}}</td>
                                <td>{{$count->nums}} 个</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
