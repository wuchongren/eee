<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends  BaseController
{
    /**
     * 声明一个静态变量
     * @var array
     */
    public  static  $status=[
        '1'=>'启用',
        '0'=>'禁用',
    ];

    /**
     * 管理员列表展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查出所有管理员
        $admins=Admin::where('id',"<>",1)->paginate(3);
        //展示视图
        return view('admin.admin.index',compact('admins'));

    }

    /**
     * 管理员添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        //处理添加的数据
        if ($request->isMethod('post')){
            //信息验证
            $this->validate($request,[
                'name'=>'required|max:30',
            ]);
            //接收表单数据
            $data=$request->post();
            //录入数据库
           $admin= Admin::create([
                'name'=>$request->post('name'),
                'password'=>bcrypt($request->post('password')),
                'email'=>$request->post('email'),
                'status'=>$request->post('status'),
            ]);
            //显示成功的提示信息
            $request->session()->flash("success",'添加管理员成功');
            //重定向
            return redirect()->route('admin.index');
        }
        //引入添加的视图
        return view('admin.admin.add');
    }


    /**
     * 管理员编辑
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        //排除超级管理员
        if($id==="1"){
            return redirect()->route('admin.index');
        }
        //找出需要编辑的数据
        $admin=Admin::findorfail($id);
        if($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required|max:50',
            ]);
            //保存数据
            $admin->update($request->post());
            //成功的提示信息
            $request->session()->flash('success','管理员信息更新成功');
            //条抓首页
            return redirect()->route('admin.index');
        }
        //回显到视图
        return view('admin.admin.edit',compact('admin'));
    }

    /**
     * 管理员删除
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function del(Request $request,$id){
        //排除超级管理员
        if($id==="1"){
            return redirect()->route('admin.index');
        }
        //获取删除的记录
        $admin=Admin::findorfail($id);
        $admin->delete();
        //删除成功提示信息
        $request->session()->flash('success','删除成功');
        //跳转
        return redirect()->route("admin.index");
    }

    public function login(Request $request)
    {
        //判断POST提交
        if ($request->isMethod('post')){
            //验证登陆信息
            if(Auth::guard('admin')->attempt(['name'=>$request->post('name'),'password'=>$request->post('password'),'status'=>1])){
                //提示
                $request->session()->flash("success","登录成功");
                return redirect()->route('admin.index');
            }else{
                //提示
                $request->session()->flash("danger","账号或密码错误");
                //跳转
                return redirect()->back()->withInput();
            }
        }
        //调用登陆视图
        return view("admin.admin.login");

    }

    /**
     * 注销功能
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flash("danger","已注销");
        return redirect()->route('admin.login');
    }

    /**
     * 密码重置
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request,$id)
    {
        //找出数据
        $admin=Admin::findorfail($id);
        //修改密码
        $admin->update(['password'=>bcrypt('123456')]);
        $request->session()->flash("danger","密码重置成功");
        return redirect()->route('admin.index');
    }

    /**
     * 管理员角色授权
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function roleEdit(Request $request,$id)
    {
        //得到需要授角色的ID
        $admin=Admin::findOrFail($id);
        //取出所有角色
        $roles=Role::all();
        //判断POST提交
        if($request->isMethod('post')){
            //给用户对象添加角色 同步角色
            $admin->syncRoles($request->post('role'));
            //提示信息
            $request->session()->flash('success','角色授权成功');
            //重定向
            return redirect()->route('admin.index');
        }
        //显示数据到试图
         return view('admin.admin.roleEdit',compact('roles','admin'));


    }




}
