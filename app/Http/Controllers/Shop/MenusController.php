<?php

namespace App\Http\Controllers\Shop;

use App\Models\MenuCategory;
use App\Models\Menus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MenusController extends Controller
{
   //状态变量
    public static $status = [
        "1" => "上架",
        "0" => "下架",
    ];

    /**
     * 列表展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user=Auth::user();
        //设置搜索条件
        $minPrice=\request()->input('min_price');
        $maxPrice=\request()->input('max_price');
        $search=\request()->input('search');
        $cate=\request()->input('menu_category_id');
        //初始搜索
        $query=$request->query();
        $re=Menus::orderBy('id');
        //最低价格
        if ($minPrice!==null){
            $re->where('goods_price',">=",$minPrice);
        }
        //最高价格
        if ($maxPrice!==null){
            $re->where('goods_price',"<=",$maxPrice);
        }
        //菜品名搜索
        if ($search!==null){
            $re->where('goods_name','like',"%{$search}%");
        }
        //菜品分类搜索
        if ($cate!==null){
            $re->where('menu_category_id',"=","{$cate}");
        }
        //获取最终数据
        $menuses=$re->where('shop_id','=',$user->shop_id)->paginate(2);
        //获取菜品分类
        $menu_categories=MenuCategory::where('shop_id','=',$user->shop_id)->get();
        //显示视图
        return view('shop.menus.index', compact('menuses','menu_categories','query'));
    }

    /**
     * 添加菜品
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        $user=Auth::user();
        //取出所有菜品分类
        $menus_categories=MenuCategory::where('shop_id','=',$user->shop_id)->get();
        //判断post提交
        if ($request->isMethod('post')) {
            //验证提交信息
            $this->validate($request, [
                'goods_name' => 'required|max:20',
                'goods_price' => 'required',
                'description' => 'required',
                'tips' => 'required',
                'menu_category_id' => 'required',
            ]);
            //接收表单数据
            $data = $request->post();
            $data['shop_id']=$user->shop_id;
            $date['goods_img'] = '';
            //处理上传图片
            if ($request->file('goods_img')) {
                //用变量将oss域名存起来
                $oss=env('ALIYUN_OSS_URL');
                $file = $request->file('goods_img')->store('shop/'.$user->name, 'oss');
                $fileName=$oss.'/'.$file;//最终的地址
                //上传图片处理后，将路径压入数组
                $data['goods_img'] = $fileName;
            }
            //录入数据库
            Menus::create($data);
            //显示成功的提示信息
            $request->session()->flash("success", '添加菜品成功');
            //重定向
            return redirect()->route('menus.index');
        }
        //显示视图
        return view('shop.menus.add', compact('menus_categories'));
    }



//    public function show(Request $request, $id)
//    {
//        //取出数据
//        $menus = Menus::findorfail($id);
//        //点击一次，将浏览次数增加一次
//        $menus->look++;
//        $menus->save();
//        //展示视图
//        return view('shop.show', compact('shop'));
//    }

    /**
     * 菜品编辑
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $user=Auth::user();
        //取出所有菜品分类
        $menus_categories=MenuCategory::where('shop_id','=',$user->shop_id)->get();
        //取出需要编辑的菜品
        $menus = Menus::findorfail($id);
        //判断postti提交
        if ($request->isMethod('post')) {
            //验证提交信息
            $this->validate($request, [
                'goods_name' => 'required|max:20',
                'goods_price' => 'required',
                'description' => 'required',
                'tips' => 'required',
                'menu_category_id' => 'required',
            ]);
            //接收表单数据
            $file = $menus['goods_img'];//先将原图片路径赋值

            //处理上传图片
            if ($request->file('goods_img')) {
                $fileName = $request->file('goods_img')->store('shop/'.$user->name, 'images');
                //上传图片处理后，将路径压入数组
                $menus->goods_img = $fileName;
                //将原来的图片删除
                File::delete("images/".$file);
            }
            //录入数据库
            $menus->update();
            //显示成功的提示信息
            $request->session()->flash("success", '菜品修改成功');
            //重定向
            return redirect()->route('menus.index');
        }
        //显示视图
        return view('shop.menus.edit', compact('menus_categories', 'menus'));
    }

    /**
     * 删除菜品
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function del(Request $request, $id)
    {
        //先取出数据
        $menus = Menus::findorfail($id);
        //删除图片
        File::delete('images/'.$menus->goods_img);
        //删除数据库数据
        $menus->delete();
        //删除成功提示信息
        $request->session()->flash("success", "删除成功");
        //跳转首页
        return redirect()->route("menus.index");
    }
}
