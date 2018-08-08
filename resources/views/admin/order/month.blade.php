@extends('admin.layouts.default')
@section('title','订单按月统计')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="{{route('order.statistics')}}" class="btn btn-success">返回</a>
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
                            <th>订单数</th>
                            <th>销售额</th>
                        </tr>
                        @foreach($counts as $count)
                            <tr>
                                <td>{{$count->month}}</td>
                                <td>{{$count->count}} 个</td>
                                <td>{{$count->money}}  元</td>
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
