<?php

namespace App\Http\Controllers\Shop;

use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Shop\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Sodium\crypto_generichash_update;

class MenuCategoryController extends BaseController
{

    public  static  $status=[
        '1'=>'默认',
        '0'=>'非默认',
    ];

    /**
     * 菜品分类列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查出商家的shop_id
        $shop_id=Auth::user()->shop_id;
        //查出所有数据
        $menu_categories=MenuCategory::where('shop_id','=',$shop_id)->paginate(3);
        //显示视图
        return view('shop.menu_category.index', compact('menu_categories') );
    }

    /**
     * 添加分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

    public function add(Request $request)
    {
        $shop_id=Auth::user()->shop_id;
        if ($request->isMethod('post')){
            //信息验证
            $this->validate($request,[
                'name'=>'required|max:30',
                'description'=>'required',
            ]);
            //接收表单数据
            $data=$request->post();
            $data['shop_id']=$shop_id;
            //dd($data);
            //录入数据库
            MenuCategory::create([
                'name'=>$request->post('name'),
                'description'=>$request->post('description'),
                'shop_id'=>$shop_id,
            ]);
            //显示成功的提示信息
            $request->session()->flash("success",'添加分类成功');
            //重定向
            return redirect()->route('menu_category.index');
        }
        //引入添加的视图
        return view('shop.menu_category.add');
    }

    /**
     * 编辑
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        //找出需要编辑的数据
        $menu_category=MenuCategory::findorfail($id);
        if($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required|max:50',
                'description'=>'required',
            ]);
            //判断是否设置默认分类
            if ($request->post('is_selected')==='1'){
                //将默认设置为非默认
                DB::table('menu_categories')->where('shop_id','=',$menu_category->shop_id)->update(['is_selected'=>0]);
            }
            //保存数据
            $menu_category->update($request->post());
            //成功的提示信息
            $request->session()->flash('success','菜品分类信息更新成功');
            //条抓首页
            return redirect()->route('menu_category.index');
        }
        //回显到视图
        return view('shop.menu_category.edit',compact('menu_category'));
    }


    /**
     * 删除功能
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function del(Request $request,$id){
        //获取删除的记录
        $menu_category=MenuCategory::findorfail($id);
        //判断是否右菜品，有则不能删除
        if ($menu_category->type_accumulation){
            $request->session()->flash('danger','有菜品，不能删除');
            //跳转
            return redirect()->route("menu_category.index");
        }
        $menu_category->delete();
        //删除成功提示信息
        $request->session()->flash('success','删除成功');
        //跳转
        return redirect()->route("menu_category.index");
    }


}
