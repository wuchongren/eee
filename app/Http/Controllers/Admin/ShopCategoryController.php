<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;

class ShopCategoryController extends BaseController
{

    public  static  $status=[
        '1'=>'启用',
        '0'=>'禁用',
    ];

    public function index(Request $request)
    {
//        return 111;
        //查出所有数据
        $shop_categries=ShopCategory::paginate(3);
        //显示视图
        return view('admin.shop_category.index',['shop_categories'=>$shop_categries]);

    }


    public function add(Request $request)
    {
        //处理添加的数据
        if ($request->isMethod('post')){
            //信息验证
            $this->validate($request,[
                'name'=>'required|max:30',
//                'intro'=>'required|min:6',
            ]);
             //接收表单数据
            $data=$request->post();
            //图片上传判断
           $date['img']='';
            //处理上传图片
            if($request->file('img')){
                $fileName=$request->file('img')->store('shop_category','images');

                    //上传图片处理后，将路径压入数组
                    $data['img']=$fileName;
            }
            //录入数据库
            ShopCategory::create($data);
            //显示成功的提示信息
            $request->session()->flash("success",'添加分类成功');
            //重定向
            return redirect()->route('shop_category.index');
        }
        //引入添加的视图
        return view('admin.shop_category.add');
    }

    /**
     * 分类编辑
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

    public function edit(Request $request,$id)
    {
        //找出需要编辑的数据
        $shop_category=ShopCategory::findorfail($id);
        if($request->isMethod('post')){
            //
            $this->validate($request, [
                'name' => 'required|max:50',
            ]);
            //保存数据
            $shop_category->update($request->post());
            //成功的提示信息
            $request->session()->flash('success','文章分类信息更新成功');
            //条抓首页
            return redirect()->route('shop_category.index');
        }
        //回显到视图
        return view('admin.shop_category.edit',['shop_category'=>$shop_category]);
    }

    /**
     * 分类删除
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function del(Request $request,$id){
        //获取删除的记录
        $shop_category=ShopCategory::findorfail($id);
        $shop_category->delete();
        //删除成功提示信息
        $request->session()->flash('success','删除成功');
        //跳转
        return redirect()->route("shop_category.index");
    }
}
