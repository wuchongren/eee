@extends('admin.layouts.default')
@section('title','权限管理列表')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">权限列表</h3>
                        <a href="{{route('permission.add')}}" class="btn btn-info">列表更新</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr class="active">
                                <th>ID</th>
                                <th>权限标识</th>
                                <th>守护</th>
                                <th>创建时间</th>
                                <th>修改时间</th>
                                <th>操作</th>
                            </tr>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission['id'] }}</td>
                                <td>{{ $permission['name'] }}</td>
                                <td>{{ $permission['guard_name'] }}</td>
                                <td>{{ $permission['created_at'] }}</td>
                                <td>{{ $permission['updated_at'] }}</td>
                                <td>
                                    <a href="{{route('permission.edit',$permission->id)}}" class="btn btn-primary">编辑</a>
                                    <a href="{{route('permission.del',$permission->id)}}" class="btn btn-danger" >删除</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @stop
