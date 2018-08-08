<?php

namespace App\Http\Controllers\Api;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Mrgoon\AliSms\AliSms;
use PhpParser\Node\Stmt\TraitUseAdaptation\Alias;

class MemberController extends BaseController
{
    /**
     * 会员注册功能
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reg(Request $request)
    {
        //接收参数
        $data=$request->post();
        //获取提交信息
     $validate=Validator::make($data,[
         'username'=>'required|unique:members',//名字具有唯一性
         'password'=>'required',
         'tel'=>[
             'required',
             'regex:/^0?(13|17|14|15|18)[0-9]{9}$/',
             'unique:members'
         ],
         'sms'=>'required|integer|min:111111|max:999999',
     ]);

     //判断验证是否通过
     if ($validate->fails()){
      return [
          "status"=>"false",
          "message"=>$validate->errors()->first()
      ];
     }
        //将sms从Redis中读出来
        $redisSms=Redis::get('tel_'.$data['tel']);
     //判断短信验证码是否存在
        if ($redisSms===null){
            return [
                "status"=>"false",
                "message"=>"验证码与手机号不一致"
            ];
        }
        //判断验证码是否一致
        if ($redisSms!==$data['sms']){
            return [
                "status"=>"false",
                "message"=>"验证码不对"
            ];
        }
       //处理password  hash加密
        $data['password']=password_hash($data['password'],PASSWORD_BCRYPT);
        //创建用户
        Member::create($data);
        return [
            'status'=>'true',
            'message'=>'恭喜您，注册成功'
        ];
    }

    /**
     *
     * 短信验证
     */
    public function sms(Request $request)
    {
        //接收手机号码
       $tel=$request->input('tel');
        //生成随机码
        $code=rand(111111,999999);
        //将验证码保存至缓存
        Redis::setex('tel_'.$tel,500,$code);
            return [
                'code'=>$code,
                "status"=>"true",
                "message"=>"验证码已发送"
            ];



        //验证配置
        $config = [
            'access_key' => 'LTAIY6Jhcx5Rld0y',
            'access_secret' => 'lzRFXdAVEtUP1jLBx9JJzNyW1LMu0q',
            'sign_name' => '陈小龙',
        ];
         //发送验证码
        $aliSms = new AliSms();
        $response = $aliSms->sendSms($tel, 'SMS_140690139', ['code'=> $code], $config);
        //判断短信是否返送成功
        if ($response->Message==="OK"){
            //将验证码保存至缓存
            Redis::setex('tel_'.$tel,100,$code);
            //返回数据
            return [
                "status"=>"true",
                "message"=>$response->Message,
            ];
        }else{
            return [
                "status"=>"false",
                "message"=>"验证码发送失败"
            ];
        }
    }

    /**
     * 登陆功能
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        //接收数据
        $name=$request->input('name');
        $password=$request->input('password');
        //验证用户
        $member=Member::where("username",$name)->first();
        //验证密码
        if ($member && Hash::check($password,$member->password)){
            //返回等各路成功的提示
         return [
           'status'=>"true",
           "message"=>"登陆成功",
            "user_id"=>$member->id,
             "username"=>$member->username
         ];
       }else{
            //错误返回提示
           return [
               'status'=>"false",
               "message"=>"用户名或密码正确"
           ];
       }
    }

    /**
     * 密码修改
     * @param Request $request
     */
    public function changPassword(Request $request)
    {
        //接收数据
       $id=$request->input('id');
       $oldPassword=$request->input('oldPassword');
       $newPassword=$request->input('newPassword');
      //通过Id找到用户
       $member= Member::where('id',$id)->first();
       //与数据库对比密码
       if (!Hash::check($oldPassword,$member->password)){
           //返回原密码错误提示
           return [
               'status'=>'false',
               'message'=>'您输入的旧密码不对'
           ];
       }
       //密码修改
        $member->password=password_hash($newPassword,PASSWORD_DEFAULT);
        $member->update();
        return [
          'status'=>'true',
            'message'=>'密码修改成功'
        ];

    }

    /**
     * 重置密码
     * @param Request $request
     * @return array
     */
    public function forgetPassword(Request $request)
    {
        //接收数据
        $tel=$request->post('tel');
        $sms=$request->post('sms');
        $password=$request->post('password');
        //验证短信验证码
        $redisSms=Redis::get('tel_'.$tel);
        //判断短信验证码是否存在
        if ($redisSms===null){
            return [
                "status"=>"false",
                "message"=>"验证码与手机号不一致"
            ];
        }
        //判断验证码是否一致
        if ($redisSms!==$sms){
            return [
                "status"=>"false",
                "message"=>"验证码不对"
            ];
        }
      //通过手机找到用户
        $member=Member::where('tel',$tel)->first();
       if ($member===null){
           return [
               'status'=>"false",
               'message'=>"此手机号还未注册"
           ];
       }
       //修改新的密码
        $member->password=password_hash($password,PASSWORD_DEFAULT);
        $member->update();
        return [
          'status'=>'true',
          'message'=>'密码重置成功'
        ];

    }

    /**
     * 用户信息展示
     * @param Request $request
     * @return Member|mixed
     */
    public function show(Request $request)
    {
        //找出当前用户
        $member=Member::find($request->input('user_id'));
      //返回数据
      return $member;
    }



}
