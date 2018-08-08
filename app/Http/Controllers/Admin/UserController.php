<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;

class UserController extends BaseController
{
    public static  $status=[
        '1'=>'正常',
        '0'=>'禁用',
        '-1'=>'审核中'
    ];
    /**
     * 商家账户列表展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //获取商家账户数据
        $users=User::paginate(3);
        //显示视图
        return view('admin.user.index',compact('users'));
    }

    public function check(Request $request,$id)
    {
        //找到编辑商户的信息
        $user=User::findOrFail($id);
        $shop=Shop::findOrFail($user->shop_id);
        if ($request->isMethod('post')){
            //获取状态值
             $status=\request()->input('status');
             //修改用户的状态值
            $user->update([
                'status'=>$status
            ]);
            //修改商店状态
            $shop->update([
                'status'=>$status
            ]);
            //显示提示信息
            $request->session()->flash('success','状态修改成功');
            //重定向
            return redirect()->route('ur.index');
        }
        //显示视图
        return view('admin.user.check',compact('user'));
    }

    /**
     * 商户账号的密码重置
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request,$id)
    {
        //找到编辑商户的信息
        $user=User::findOrFail($id);
        //重置密码
        $user->password=password_hash("123456",PASSWORD_DEFAULT);
        $user->save();
        //提示信息
        $request->session()->flash('success','密码重置成功');
        //重定向
        return redirect()->route('ur.index');
    }

    /**
     * 删除用户
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function del(Request $request,$id)
    {
        //找出账户信息
        $user=User::findOrFail($id);
        //删除该账户下的店铺
        $shop=Shop::findOrFail($user['shop_id']);
        //执行删除操作，这里是伪操作，只改变状态值，不真删除
        $shop->update(['status'=>0]);
        $user->update(['status'=>0]);
        //删除成功后的提示信息
        $request->session()->flash('success','删除成功');
        //重定向
        return redirect()->route('ur.index');
  }





}
