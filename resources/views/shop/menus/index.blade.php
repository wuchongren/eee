@extends('shop.layouts.default')
@section('title','我的菜单列表')
@section('content')
    <div class="container-fluid">
        <a href="{{route('menus.add')}}" class="btn btn-primary">添加</a>
        <form class="form-inline navbar-right">
            {{csrf_field()}}
            <div class="form-group">
                <div class="form-group">
                    按类 <select name="menu_category_id">
                        <option value="">菜品类</option>
                        @foreach($menu_categories as $menu_category)
                            <option  size="4" value="{{$menu_category->id}}"   @if($menu_category->id==request()->input('menu_category_id')) selected @endif
                                >{{$menu_category->name}}</option>
                        @endforeach
                    </select>
                </div>
                按价格区间：<input type="text" size="4" name="min_price" value="{{old('min_price')}}">元 ---<input type="text" name="max_price"   size="4" value="{{old('max_price')}}">元
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="search" value="{{request()->input('search')}}"  placeholder="请输入搜素内容">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
        </form>
    </div>
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center text-success">我的所有菜品</caption>

        <tr>
            <th class="text-center">名称</th>
            <th class="text-center">菜品图片</th>
            <th class="text-center">菜品分类</th>
            <th class="text-center">价格</th>
            <th class="text-center">描述</th>
            <th class="text-center">月销量</th>
            <th class="text-center">评分</th>
            <th class="text-center">评分数量</th>
            <th class="text-center">提示信息</th>
            <th class="text-center">满意度数量</th>
            <th class="text-center">满意度评分</th>
            <th class="text-center">是否上架</th>
            <th >操作</th>
        </tr>
        @foreach($menuses as $menus)
        <tr>
            <td>{{$menus->goods_name}}</td>
            <td>
              @if($menus->goods_img)
                    <img src="{{$menus->goods_img}}" style="height: 50px" alt="">
              @endif
            </td>
            <td>{{$menus->menu_categories->name}}</td>
            <td>{{$menus->goods_price}}</td>
            <td>{{$menus->description}}</td>
            <td>{{$menus->month_count}}</td>
            <td>{{$menus->rating}}</td>
            <td>{{$menus->rating_count}}</td>
            <td>{{$menus->tips}}</td>
            <td>{{$menus->satisfy_count}}</td>
            <td>{{$menus->satisfy_rating}}</td>
            <td>
              {{\App\Http\Controllers\Shop\MenusController::$status[$menus->status]}}
            </td>

            <td class="text-left">
                <a href="{{route('menus.edit',$menus->id)}}" class="btn btn-primary glyphicon glyphicon-edit"></a>
                <a href="{{route('menus.del',$menus->id)}}" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>

            </td>
        </tr>
            @endforeach
    </table>
    {{$menuses->appends($query)->links()}}
    @stop
