<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Validator;

class AddressController extends BaseController
{
    /**
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function index(Request $request)
    {
        //获取用户ID
       $user_id=\request()->input('user_id');
       //查找用户的所有地址
        $addresses=Address::where('user_id',$user_id)->get();
        //返回数据
        return $addresses;
    }

    /**
     * 地址添加
     * @param Request $request
     * @return array
     */
    public function add(Request $request)
    {
        //接收数据
        $data=$request->post();
        //验证信息
        $validate=Validator::make($data,[
            'name'=>'required',
            'tel'=>[
                'required',
                'regex:/^0?(13|17|14|15|18)[0-9]{9}$/',
            ],
        ]);
        //判断验证是否通过
        if ($validate->fails()){
            return [
                "status"=>"false",
                "message"=>$validate->errors()->first()
            ];
        }
        //将数据写入数据库
      Address::create($data);
        //返回
        return [
            'status'=>'true',
            'message'=>'地址添加成功'
        ];
    }

    /**
     * 提供修改时的数据
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed|null|object
     */
    public function show(Request $request)
    {
        //找出修改的地址数据
        $address=Address::findOrFail(\request()->input('id'))->first();
        //返回数据
        return $address;
    }

    /**
     * 修改
     * @param Request $request
     */
    public function edit(Request $request)
    {
        //接收数据
        $data=$request->post();
        //找到数据库的记录
        $address=Address::findOrFail($data['id'])->first();
        //更新数据
        $re=$address->update();
        //返回信息
        if ($re){
            return [
                'status'=>'true',
                'message'=>'修改成功'
            ];
        }else{
            return [
                'status'=>'false',
                'message'=>'修改失败'
            ];
        }
    }


}
