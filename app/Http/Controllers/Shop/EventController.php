<?php

namespace App\Http\Controllers\Shop;

use App\Models\Event;
use App\Models\EventPrize;
use App\Models\EventUser;
use App\Models\Menus;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Shop\BaseController;
use Illuminate\Support\Facades\Auth;

class EventController extends BaseController
{
    public static  $status=[
        '0'=>'火热报名中',
        '1'=>'已结束'
    ];
    public function index()
    {
        //得到所有抽奖活动
        $events=Event::all();
        //返回视图
        return view('shop.event.index',compact('events'));
    }

    /**
     * 报名
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signIn(Request $request,$id)
    {
        //取得活动
        $event=Event::findOrFail($id);
        //取得当前用户的id
        $user_id=Auth::user()->id;
        //判断用户是否已报名
        if(EventUser::where('event_id',$event->id)->where('user_id',$user_id)->first()){
            //显示提示
            $request->session()->flash('danger','您已报名');
            //跳转
            return redirect()->route('event.index');
        }
        //判断报名人数是否已满
        if ($event->num<=$event->sign_num){
            //显示提示
            $request->session()->flash('danger','对不起，报名人数已满');
            //跳转
            return redirect()->route('event.index');
        }
       //将报名信息存入数据库
        $re=EventUser::create([
            'user_id'=>$user_id,
            'event_id'=>$event->id,
        ]);
        //改写活动数据库
       $event->sign_num=$event->sign_num+1;
       $event->update();
       //返回报名成功的提示信息
        $request->session()->flash('success','报名成功，敬请期待开奖');
       // dd($event->id);
        //重定向
        return redirect()->route('event.index');
    }

    /**
     * 奖品库
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function myPrize(Request $request)
    {
        //当前用户
        $user=Auth::user();
        //找出当前用户参加的活动
        $prizes=EventPrize::where('user_id',$user->id)->get();
       if ($prizes){
           //返回提示信息
           return redirect()->route('event.index')->with('danger','您还没有任何奖品');
       }
       //返回到视图
        return view('shop.event.myprize',compact('prizes'));
 }

    /**
     * 我的活动
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function myEvent(Request $request)
    {
        //当前用户
        $user=Auth::user();
        //找出当前用户参加的活动
        $event_ids=EventUser::where('user_id',$user->id)->pluck('event_id')->toArray();
        if ($event_ids===null){
            //返回提示信息
            return redirect()->route('event.index')->with('danger','您还没有参加任何抽奖活动');
        }
        //取出我的活动
        $events=Event::findMany($event_ids);
        //返回到视图
        return view('shop.event.myEvent',compact('events'));

 }


    public function winner(Request $request,$id)
    {
        //找出奖品库的信息
       $prizes= EventPrize::where('event_id',$id)->get();
       //声明一个空数组
       //循环取出中奖者
        foreach ($prizes as $prize){
            $prize->username=User::where('id',$prize->user_id)->first()->name;
        }
        //返回到视图
        return view('shop.event.winner',compact('prizes'));
 }

}
