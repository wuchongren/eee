@extends('admin.layouts.default')
@section('title','菜品月度销售统计')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="{{route('order.menuStatistics')}}" class="btn btn-success">返回</a>
                    <div class="box-tools">

                        <form action="" class="form-inline">
                            <select name="shop_id" class="form-control" >
                                @foreach($shops as $shop)
                                    <option value="{{$shop->id}}">{{$shop->shop_name}}</option>
                                @endforeach
                            </select>
                            <input type="date" name="start" class="form-control" size="2" placeholder="开始日期"
                                   value="{{request()->input('start')}}"> -
                            <input type="date" name="end" class="form-control" size="2" placeholder="结束日期"
                                   value="{{request()->input('end')}}">
                            <input type="submit" value="搜索" class="btn btn-success">
                        </form>


                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>月份</th>
                            <th>菜品ID</th>
                            <th>菜品名称</th>
                            <th>销量</th>
                        </tr>
                        @foreach($counts as $count)
                            <tr>
                                <td>{{$count->month}}</td>
                                <td>{{$count->goods_id}}</td>
                                <td>{{$count->goods_name}}</td>
                                <td>{{$count->nums}}</td>

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
