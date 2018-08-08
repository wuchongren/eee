<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;

class MemberController extends BaseController
{
    public static $status=[
      '0'=>'禁用',
      '1'=>'正常'
    ];
    /**
     * 会员列表展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //接收查询条件
        $search=$request->input('search');
        //构造初始查询
        $members=Member::where('username','like',"%{$search}%")->orWhere('id','=',$search)->paginate(4);
       //显示到视图
        return view('admin.member.index',compact('members','search'));
    }

    /**
     * 查看会员信息
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request,$id)
    {
        //找到查看的会员信息
        $member=Member::findOrFail($id);
        //展示视图
        return view('admin.member.show',compact('member'));
    }

    /**
     * 禁用账户
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function check(Request $request,$id)
    {
      $member=Member::findOrFail($id);
      $member->update(['status'=>0]);
      return redirect()->route('member.index');

    }



}
