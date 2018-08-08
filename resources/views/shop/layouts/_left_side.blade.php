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
            <li class="header">我的管理</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>我的订单管理</span>
                    <span class="pull-right-container">
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('shopOrder.index')}}"><i class="fa fa-circle-o"></i>订单列表</a></li>
                    <li><a href="{{route('shopOrder.statistics')}}"><i class="fa fa-circle-o"></i>订单统计</a></li>
                    <li><a href="{{route('shopOrder.menuStatistics')}}"><i class="fa fa-circle-o"></i>菜品销量统计</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>我的店铺管理</span>
                    <span class="pull-right-container">
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('menu_category.index')}}"><i class="fa fa-circle-o"></i>菜品分类管理</a></li>
                    <li><a href="{{route('menus.index')}}"><i class="fa fa-circle-o"></i>菜品管理</a></li>
                    <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                    <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed
                            Sidebar</a></li>
                </ul>
            </li>
            <li class="active treeview">
                <a href="">
                    <i class="fa fa-dashboard"></i> <span>我的店铺</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{route('user.index')}}"><i class="fa fa-circle-o"></i>我的店铺信息</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>我的申请</a></li>
                </ul>
            </li>
            <li class="active treeview">
                <a href="">
                    <i class="fa fa-dashboard"></i> <span>平台活动</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{route('event.shopIndex')}}"><i class="fa fa-circle-o"></i>抽奖活动</a></li>
                    <li><a href="{{route('event.myPrize')}}"><i class="fa fa-circle-o"></i>我的奖品库</a></li>
                    <li><a href="{{route('event.myEvent')}}"><i class="fa fa-circle-o"></i>我参加的活动</a></li>
                </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
