<?php

namespace App\Http\Controllers\Shop;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Shop\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends BaseController
{
    public static  $status=[
        '1'=>'YES',
        '0'=>'NO'
    ];
    /**
     * 商家个人信息展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user=Auth::user();
        //读取数据
        $shop=Shop::find($user->shop_id);
        if ($shop===null){
            $request->session()->flash('danger','店铺申请未成功');
            return redirect()->route('user.login');
        }
        //显示视图
        return view('shop.user.index',compact('user','shop'));
    }

    /**
     * 商家账户注册
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function regist(Request $request)
    {
        //判断post提交
        if ($request->isMethod('post')){

           DB::transaction(function () use ($request){
               //创建商家账户
               $user=User::create([
                   'password' => bcrypt($request->input('password')),
                   'name' => $request->input('name'),
                   'email' => $request->input('email'),
               ]);
               //创建店铺
               if ($user){
                   $shop=Shop::create($request->post());
                   if ($shop){
                       //更新商家账户的商店ID
                       $user['shop_id']=$shop['id'];
                       $user->save();
                   }
               }

           });

            //提示信息
            $request->session()->flash('success','注册成功');
            //条抓首页
            return redirect()->route('user.login');
        }
        //取出商家分类信息

        $shop_categories=ShopCategory::where('status','=',1)->get();
        //展示注册视图
        return view('shop.user.regist',compact('shop_categories'));
   }

    public function shopEdit(Request $request)
    {
        //获取当前用户信息
        $user=Auth::user();
        //当前用户的商铺
        $shop=Shop::findOrFail($user->shop_id);
        //店铺分类
        $shop_categories = ShopCategory::all();
    //判断POST提交
        if ($request->isMethod('post')){
            //处理上传图片
            if ($request->file('shop_img')) {
                //用变量将oss域名存起来
                $oss=env('ALIYUN_OSS_URL');
                $file = $request->file('shop_img')->store('shop/'.$user->name, 'oss');
                $fileName=$oss.'/'.$file;//最终的地址
                //上传图片处理后，将路径压入数组
                $shop->shop_img=$fileName;
            }
            //更新信息
            $shop->update($request->post());
           //提示信息
            $request->session()->flash('success','更新成功');
            //跳转
            return redirect()->route('user.index');

        }



        //显示到视图
     return view('shop.user.shopedit',compact('shop','user','shop_categories'));


   }


    /**
     * 商家重置密码
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

    public function edit(Request $request,$id)
    {
        //找出需要编辑的数据
        $user=User::findorfail($id);
        //错误提示
        if($request->isMethod('post')){
            //验证信息
            $this->validate($request, [
                'oldPassword' => 'required|max:50',
                'newPassword' => 'required|max:50',
                'comfirm' => 'required|same:newPassword',
            ]);
            //Hash验证并保存
            if (Hash::check($request->oldPassword,$user->password)) {
                $request->user()->fill(['password' => Hash::make($request->newPassword)])->save();
                //成功的提示信息
                $request->session()->flash('success','密码重置成功');
                //首页
                return redirect()->route('user.index');
            }
            return redirect()->route('user.edit',$user->id);
        }
        //回显到视图
        return view('shop.user.edit');
    }

    /**
     * 登陆功能
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        //判断POST提交
        if ($request->isMethod('post')){
            //验证登陆信息
            if (Auth::attempt(['name'=>$request->post('name'),'password'=>$request->post('password'),'status'=>1])) {
                //提示
            $request->session()->flash("success","登录成功");
                return redirect()->route('user.index');
            }else{
                //提示
                $request->session()->flash("danger","账号或密码错误");
                //跳转
                return redirect()->back()->withInput();
            }
        }
        return view("shop.user.login");
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
        return redirect()->route('user.login');
    }

    /**
     * 修改密码
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

}
