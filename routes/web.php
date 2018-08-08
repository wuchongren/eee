<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return "欢迎你";
//});
//平台后端
Route::domain('eleAdmin.chenxiaolong520.com')->namespace('Admin')->group(function () {
    //平台管理员管理
    Route::get('admin/index', "AdminController@index")->name('admin.index');
    Route::any('admin/add', "AdminController@add")->name('admin.add');
    Route::any('admin/edit/{id}', "AdminController@edit")->name('admin.edit');
    Route::any('admin/reset/{id}', "AdminController@reset")->name('admin.reset');
    Route::any('admin/del/{id}', "AdminController@del")->name('admin.del');
    Route::any('admin/login', "AdminController@login")->name('admin.login');
    Route::any('admin/logout', "AdminController@logout")->name('admin.logout');
    Route::any('admin/roleEdit/{id}', "AdminController@roleEdit")->name('admin.roleEdit');

    //活动管理
    Route::any('promotion/index', "PromotionController@index")->name('promotion.index');
    Route::any('promotion/add', "PromotionController@add")->name('promotion.add');
    Route::any('promotion/edit/{id}', "PromotionController@edit")->name('promotion.edit');
    Route::any('promotion/del/{id}', "PromotionController@del")->name('promotion.del');
    Route::any('promotion/show/{id}', "PromotionController@show")->name('promotion.show');


    //商家分类
    Route::get('shop_category/index', "ShopCategoryController@index")->name('shop_category.index');
    Route::any('shop_category/add', "ShopCategoryController@add")->name('shop_category.add');
    Route::any('shop_category/edit/{id}', "ShopCategoryController@edit")->name('shop_category.edit');
    Route::any('shop_category/del/{id}', "ShopCategoryController@del")->name('shop_category.del');


    //商家门店管理
    Route::get('shop/index', "ShopController@index")->name('shop.index');
    Route::any('shop/add', "ShopController@add")->name('shop.add');
    Route::any('shop/edit/{id}', "ShopController@edit")->name('shop.edit');
    Route::any('shop/check/{id}', "ShopController@check")->name('shop.check');
    Route::get('shop/del/{id}', "ShopController@del")->name('shop.del');

    //商家账户管理
    Route::any('ur/index', "UserController@index")->name('ur.index');
    Route::any('ur/edit/{id}', "UserController@edit")->name('ur.edit');
    Route::any('ur/check/{id}', "UserController@check")->name('ur.check');
    Route::any('ur/reset/{id}', "UserController@reset")->name('ur.reset');
    Route::any('ur/del/{id}', "UserController@del")->name('ur.del');

   //用户账户管理
    Route::any('member/index', "MemberController@index")->name('member.index');
    Route::any('member/check/{id}', "MemberController@check")->name('member.check');
    Route::any('member/show/{id}', "MemberController@show")->name('member.show');


    //订单统计
    Route::any('order/statistics', "OrderController@statistics")->name('order.statistics');
    Route::any('order/day', "OrderController@day")->name('order.day');
    Route::any('order/month', "OrderController@month")->name('order.month');
    //菜品销量统计
    Route::any('order/menuStatistics', "OrderController@menuStatistics")->name('order.menuStatistics');
    Route::any('order/menuDay', "OrderController@menuDay")->name('order.menuDay');
    Route::any('order/menuMonth', "OrderController@menuMonth")->name('order.menuMonth');

    //权限管理
    Route::get('permission/index', "PermissionController@index")->name('permission.index');
    Route::any('permission/add', "PermissionController@add")->name('permission.add');
    Route::any('permission/edit/{id}', "PermissionController@edit")->name('permission.edit');
    Route::any('permission/del/{id}', "PermissionController@del")->name('permission.del');
    //角色管理
    Route::get('role/index', "RoleController@index")->name('role.index');
    Route::any('role/add', "RoleController@add")->name('role.add');
    Route::any('role/edit/{id}', "RoleController@edit")->name('role.edit');
    Route::any('role/del/{id}', "RoleController@del")->name('role.del');

    //导航条管理
    Route::any('nav/add', "NavController@add")->name('nav.add');
    Route::get('nav/index', "NavController@index")->name('nav.index');
    Route::any('nav/edit/{id}', "NavController@edit")->name('nav.edit');

    //抽奖管理
    Route::any('event/add', "EventController@add")->name('event.add');
    Route::any('event/index', "EventController@index")->name('event.index');
   Route::any('event/prize/{id}', "EventController@prize")->name('event.prize');
  Route::any('event/prizeEdit/{id}', "EventController@prizeEdit")->name('event.prizeEdit');
  Route::any('event/eventSign/{id}', "EventController@eventSign")->name('event.eventSign');
  Route::any('event/show/{id}', "EventController@show")->name('event.show');
  Route::any('event/prizeDel/{id}', "EventController@prizeDel")->name('event.prizeDel');




});

//商家客户端
Route::domain('eleShop.chenxiaolong520.com')->namespace('Shop')->group(function () {
    //订单管理
    Route::any('shopOrder/index', "ShopOrderController@index")->name('shopOrder.index');
    Route::any('shopOrder/show/{id}', "ShopOrderController@show")->name('shopOrder.show');
    Route::any('shopOrder/cancel/{id}', "ShopOrderController@cancel")->name('shopOrder.cancel');
    Route::any('shopOrder/send/{id}', "ShopOrderController@send")->name('shopOrder.send');

    //商铺订单统计
    Route::any('shopOrder/statistics', "ShopOrderController@statistics")->name('shopOrder.statistics');
    Route::any('shopOrder/day', "ShopOrderController@day")->name('shopOrder.day');
    Route::any('shopOrder/month', "ShopOrderController@month")->name('shopOrder.month');
    //商铺菜品销量统计
    Route::any('shopOrder/menuMonth', "ShopOrderController@menuMonth")->name('shopOrder.menuMonth');
    Route::any('shopOrder/menuStatistics', "ShopOrderController@menuStatistics")->name('shopOrder.menuStatistics');
    Route::any('shopOrder/menuDay', "ShopOrderController@menuDay")->name('shopOrder.menuDay');

    //店家管理
    Route::any('user/index', "UserController@index")->name('user.index');
    Route::any('user/shopedit', "UserController@shopedit")->name('user.shopedit');
    Route::any('user/edit/{id}', "UserController@edit")->name('user.edit');
    Route::any('user/reset/{id}', "UserController@reset")->name('user.reset');
    Route::any('user/regist', "UserController@regist")->name('user.regist');
    Route::any('user/login', "UserController@login")->name('user.login');
    Route::any('user/logout', "UserController@logout")->name('user.logout');

    //菜品分类管理
    Route::any('menu_category/index', "MenuCategoryController@index")->name('menu_category.index');
    Route::any('menu_category/add', "MenuCategoryController@add")->name('menu_category.add');
    Route::any('menu_category/edit/{id}', "MenuCategoryController@edit")->name('menu_category.edit');
    Route::any('menu_category/del/{id}', "MenuCategoryController@del")->name('menu_category.del');
    //彩品管理
    Route::any('menus/index', "MenusController@index")->name('menus.index');
    Route::any('menus/edit/{id}', "MenusController@edit")->name('menus.edit');
    Route::any('menus/del/{id}', "MenusController@del")->name('menus.del');
    Route::any('menus/add', "MenusController@add")->name('menus.add');

    //商家端活动
    Route::any('shoppromotion/index', "PromotionController@index")->name('shoppromotion.index');
    Route::any('shoppromotion/show/{id}', "PromotionController@show")->name('shoppromotion.show');
    Route::any('shoppromotion/jionin/{id}', "PromotionController@jionin")->name('shoppromotion.jionin');

    //商铺抽奖参与
    Route::get('event/shopIndex', "EventController@shopIndex")->name('event.shopIndex');
    Route::get('event/myPrize', "EventController@myPrize")->name('event.myPrize');
    Route::get('event/myEvent', "EventController@myEvent")->name('event.myEvent');
    Route::any('event/signIn/{id}', "EventController@signIn")->name('event.signIn');
    Route::any('event/winner/{id}', "EventController@winner")->name('event.winner');





});

//Route::get('/home', 'HomeController@index')->name('home');
