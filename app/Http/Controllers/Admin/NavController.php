<?php

namespace App\Http\Controllers\Admin;

use App\Models\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class NavController extends Controller
{
    /**
     * 菜单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //找出所有
        $navs=Nav::where('pid',0)->orderBy('sort')->get();
       //返回视图
        return view('admin.nav.index',compact('navs'));
  }

    /**
     * 导航条菜单添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            $this->validate($request,[
                'name'=>'required',
            ]);
            if ($request->post('url')===null){
                $data=$request->except('url');
            }else{
                $data=$request->post();
            }
            $nav=Nav::create($data);
            return redirect()->refresh()->with('success','添加'.$nav->name.'成功');

        }

        //得到所有路由
        $routes=Route::getRoutes();
        //定义数组
        $urls=[];
        foreach ($routes as $k=>$value){
            //dd($value->action);
            if ($value->action['namespace']==="App\Http\Controllers\Admin"){
                if (isset($value->action['as'])){
                    $urls[]=$value->action['as'];
                }
            }
        }
        $navs=Nav::where('pid',0)->orderBy('sort')->get();
        return view('admin.nav.add',compact('navs','urls'));
   }

    public function edit(Request $request,$id)
    {
        //获取需要编辑的记录
        $na=Nav::findOrFail($id);
        //找出一级菜单
        $navs=Nav::where('pid',0)->orderBy('sort')->get();
        //判断POST提交
        if ($request->isMethod('post')){
                $na->pid=$request->input('pid');
                $na->sort=$request->input('sort');
                $na->update();
            return redirect()->refresh()->with('success','编辑'.$na->name.'成功');
        }
        //回显
        return view('admin.nav.edit',compact('na','navs'));

   }


}


