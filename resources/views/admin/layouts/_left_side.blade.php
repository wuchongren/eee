<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">饿了吗点餐</li>

            @foreach(\App\Models\Nav::where('pid',0)->get() as $k1=>$v1)
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>{{$v1->name}}</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @foreach(\App\Models\Nav::where('pid',$v1->id)->get() as $k2=>$v2)
                        @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->can($v2->url))
                    <li class="active"><a href="{{route($v2->url)}}"><i class="fa fa-circle-o"></i>{{$v2->name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @endforeach







            {{--<li class="active treeview">--}}
                {{--<a href="">--}}
                    {{--<i class="fa fa-dashboard"></i> <span>商家管理</span>--}}
                    {{--<span class="pull-right-container">--}}
              {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li class="active"><a href="{{route('shop_category.index')}}"><i class="fa fa-circle-o"></i> 商家分类</a></li>--}}
                    {{--<li><a href="{{route('shop.index')}}"><i class="fa fa-circle-o"></i> 商家门店管理</a></li>--}}
                    {{--<li><a href="{{route('ur.index')}}"><i class="fa fa-circle-o"></i> 商家账户管理</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="active treeview">--}}
                {{--<a href="">--}}
                    {{--<i class="fa fa-dashboard"></i> <span>用户管理</span>--}}
                    {{--<span class="pull-right-container">--}}
              {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li class="active"><a href="{{route('member.index')}}"><i class="fa fa-circle-o"></i> 用户列表</a></li>--}}
                    {{--<li><a href="#"><i class="fa fa-circle-o"></i> 用户的其他管理</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="treeview">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-files-o"></i>--}}
                    {{--<span>管理员</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="{{route('admin.index')}}"><i class="fa fa-circle-o"></i> 管理员列表</a></li>--}}
                    {{--<li><a href="{{route('role.add')}}"><i class="fa fa-circle-o"></i> 管理员权限管理</a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="treeview">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-files-o"></i>--}}
                    {{--<span>活动管理</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="{{route('promotion.index')}}"><i class="fa fa-circle-o"></i> 活动列表</a></li>--}}
                    {{--<li><a href="{{route('promotion.add')}}"><i class="fa fa-circle-o"></i> 活动发布</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
