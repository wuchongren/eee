<?php

namespace App\Http\Controllers\Admin;

use App\Mail\OrderShipped;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class ShopController extends BaseController
{
    public static $status = [
        "1" => "启用",
        "0" => "禁用",
        "-1" => "待审核",
    ];

    public function index(Request $request)
    {
        //接收搜索条件
        // $search=$request->query("search")??"";
        //获取数据
        $shops = Shop::paginate(3);
        //$shops=Shop::where("shop_name","like","%{$search}%")->paginate(3);
        //显示视图
        return view('admin.shop.index', compact('shops'));
    }


    public function add(Request $request)
    {
        //判断post提交
        if ($request->isMethod('post')) {
            //验证提交信息

            $this->validate($request, [
                'shop_name' => 'required|max:20',
                'shop_category_id' => 'required',
            ]);
            //接收表单数据
            $data = $request->post();
            $date['shop_img'] = '';
            //处理上传图片
            if ($request->file('shop_img')) {
                $fileName = $request->file('shop_img')->store('shop', 'images');
                //上传图片处理后，将路径压入数组
                $data['shop_img'] = $fileName;
            }
            //录入数据库
            Shop::create($data);
            //显示成功的提示信息
            $request->session()->flash("success", '添加商品成功');
            //重定向
            return redirect()->route('shop.index');
        }
        //取出所有分类
        $shop_categories = ShopCategory::where('status','=',1)->get();
        //显示视图
        return view('admin.shop.add', compact('shop_categories'));
    }

    /**
     * 商品显示
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function show(Request $request, $id)
    {
        //取出数据
        $shop = Shop::findorfail($id);
        //点击一次，将浏览次数增加一次
        $shop->look++;
        $shop->save();
        //展示视图
        return view('shop.show', compact('shop'));
    }


    public function edit(Request $request, $id)
    {
        //取出所有分类
        $shop_categories = ShopCategory::all();
        //取出需要编辑的记录
        $shop = Shop::findorfail($id);
        //判断postti提交
        if ($request->isMethod('post')) {
            //验证提交信息
            $this->validate($request, [
                'shop_name' => 'required|max:20',
                'shop_category_id' => 'required',
            ]);
            //接收表单数据
            $file = $shop['shop-img'];//先将原图片路径赋值
            //处理上传图片
            if ($request->file('shop_img')) {
                $fileName = $request->file('shop_img')->store('shop', 'images');
                //上传图片处理后，将路径压入数组
                $shop->shop_img = $fileName;
            }
            //录入数据库
            $shop->update();
            //将原来的图片删除
            File::delete($file);
            //显示成功的提示信息
            $request->session()->flash("success", '商品修改成功');
            //重定向
            return redirect()->route('shop.index');
        }
        //显示视图
        return view('admin.shop.edit', compact('shop_categories', 'shop'));
    }

    public function check(Request $request,$id)
    {
        $shop=Shop::findOrFail($id);
        if ($request->isMethod('post')){
            $shop->status=$request->post('status');
            $shop->update();
            //发送邮件
            $user=User::where('shop_id',$shop->id)->first();
            Mail::to($user)->send(new OrderShipped('mail.shopCheck',$user));
            //成功的提示信息
            $request->session()->flash("success", '审核完毕');
            //重定向
            return redirect()->route('shop.index');
        }

        return view('admin.shop.check',compact('shop'));


   }
    public function del(Request $request, $id)
    {
        //先取出数据
        $shop = Shop::findorfail($id);
        //删除图片
        File::delete($shop->shop_img);
        //删除数据库数据
        $shop->delete();
        //删除成功提示信息
        $request->session()->flash("success", "删除成功");
        //跳转首页
        return redirect()->route("shop.index");
    }





}
