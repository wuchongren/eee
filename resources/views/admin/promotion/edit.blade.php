@extends('admin.layouts.default')
@section('title','活动修改')
@section('content')
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">活动名称</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="title" id="inputEmail3"  value="{{old('title',$promotion->title)}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">开始时间</label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="start_time" value="{{old('start_time',date('Y-m-d',$promotion->start_time))}}" >
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">结束时间</label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="end_time" value="{{old('end_time',date('Y-m-d',$promotion->end_time))}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">活动内容</label>
            <div class="col-sm-8">
                <script type="text/javascript">
                    var ue = UE.getEditor('container');
                    ue.ready(function() {
                        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
                    });
                </script>
                <!-- 编辑器容器 -->
                <script id="container" name="content" type="text/plain">{{old('content',$promotion->content)}}</script>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">状态修改</label>
            <div class="col-sm-3">
                <input type="checkbox" name="status" value="0">不启用
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>
@stop
