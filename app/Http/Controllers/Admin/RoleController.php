<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        //获取所有角色信息
        $roles=Role::all();
        //返回试图
        return view('admin.role.index',compact('roles'));
    }
    /**
     * 角色创建并添加权限
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        //判断POST提交
        if ($request->isMethod('post')){

            //接收参数:第一步要创建角色
            $role['guard_name']='admin';//指定中间件守护
            $role['name']=\request()->input('role_name');//获取角色名
            //创建角色
            $role=Role::create($role);
            //给角色添加权限
            $role->syncPermissions($request->post('name'));
            //跳转并提示
            return redirect()->route('role.index')->with('success','创建'.$role->name."成功");
        }

        //获得所有权限
        $permissions=Permission::all();;
        //显示到试图
        return view('admin.role.add',compact('permissions'));


    }
    public function edit(Request $request,$id)
    {
        //获得所有权限
        $permissions=Permission::all();;
        //获取当前角色
        $role=Role::findOrFail($id);
        //判断POST提交
        if ($request->isMethod('post')){
            //给角色添加权限
            $role->syncPermissions($request->post('name'));
            //跳转并提示
            return redirect()->route('role.index')->with('success','创建'.$role->name."成功");
        }

        //显示到试图
        return view('admin.role.edit',compact('permissions','role'));


    }



}
