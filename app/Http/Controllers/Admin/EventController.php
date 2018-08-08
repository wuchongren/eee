<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventPrize;
use App\Models\EventUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;

class EventController extends BaseController
{
    //声明状态的变量
    public static  $status=[
        '0'=>'未开始',
        '1'=>'已结束'
    ];

    /**
     * 列表展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //获取所有抽奖活动数据
        $events=Event::all();
        //显示到试图
        return view('admin.event.index',compact('events'));

    }

    /**
     * 抽奖活动的添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        //判断POST提交
        if ($request->isMethod('post')){
            //验证
            $this->validate($request,[
                'title'=>'required',
                'start_time'=>'required',
                'end_time'=>'required',
                'prize_time'=>'required',
                'num'=>'required',
                'content'=>'required'
            ]);
          //将数据录入数据库
            $event=Event::create([
                'title'=>$request->post('title'),
                'num'=>$request->post('num'),
                'start_time'=>strtotime($request->post('start_time')),
                'end_time'=>strtotime($request->post('end_time')),
                'prize_time'=>strtotime($request->post('prize_time')),
                'content'=>$request->post('content')
            ]);
          //返回提示信息
            $request->session()->flash('success','和抽奖活动添加成功');
            //重定向
            return redirect()->route('event.index');
        }
        //显示视图
        return view('admin.event.add');
    }

    public function prizeEdit(Request $request,$id)
    {
        //找到需要修改奖品的活动
        $event=Event::findOrFail($id);
        //判断POST提交
        if($request->isMethod('post')){
            //验证
            $this->validate($request,[
               'name'=>'required',
               'num'=>'required',
               'description'=>'required'
            ]);
            //接收数据
            $num=$request->input('num');
            $name=$request->input('name');
            $description=$request->input('description');
            //将奖品录入数据库
            for ($i=1; $i<=$num;$i++){
                EventPrize::create([
                    'event_id'=>$event->id,
                    'name'=>$name,
                    'description'=>$description,
                ]);
            }
            //返回提示信息
            $request->session()->flash('success','奖品入库成功');
          //重返回到奖品添加页
        return view('admin.event.prizeEdit',compact('event'));
        }
        //显示到视图
        return view('admin.event.prizeEdit',compact('event'));
    }

    /**
     * 奖品删除
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function prizeDel(Request $request,$id)
    {
        //找到奖品记录
        $prize=EventPrize::findOrFail($id);
        $event_id=$prize->event_id;
        //执行删除操作
        $prize->delete();
        //返回提示信息
        $request->session()->flash('success','删除成功');
        //重定向
        return redirect()->route('event.prizeEdit',$event_id);

        
    }

    /**
     * 查看奖品
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request,$id)
    {
        //找出奖品库的信息
        $prizes= EventPrize::where('event_id',$id)->where('user_id','<>',0)->get();
        //声明一个空数组
        //循环取出中奖者
        foreach ($prizes as $prize){
            $prize->username=User::where('id',$prize->user_id)->first()->name;
        }
        //返回到视图
        return view('admin.event.show',compact('prizes'));
        
    }

    /**
     * 抽奖
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function prize(Request $request,$id)
    {
        $event=Event::findOrFail($id);//获取抽奖的活动
        //取出所有报名者
        $users=EventUser::where('event_id',$id)->pluck('user_id')->toArray();
        //取出所有该活动的奖品
        $prizes=EventPrize::where('event_id',$id)->get()->toArray();
        shuffle($prizes);//第一次打乱奖品顺序
        //抽奖
        foreach ($prizes as $prize){
            shuffle($users);//将抽奖者数组打乱
           $user=array_rand( $users);//获取随机的用户的键
          $user_id=$users[$user];//获取终奖用户ID
            //将数据入库
            EventPrize::where('id',$prize['id'])->update(['user_id'=>$user_id]);//将奖品入库
              //将中奖的用户和奖品都删除
            unset($users[$user]);
            array_shift($prizes);
            //判断用户是否抽完
            if (!$users){
                break;//跳出循环
            }
            //打乱奖品
            shuffle($prizes);
        }
        //修改活动状态
        $event->update([
            'is_prized'=>1,
        ]);
        //返回提示信息
        return redirect()->route('event.index')->with('success','抽奖圆满结束');
    }

    /**
     * 报名账户查看
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function eventSign(Request $request,$id)
    {
        //获得活动
        $event=Event::findOrFail($id);
        //从报名表中查看报名的账号
       $user_ids= EventUser::where('event_id',$id)->pluck('user_id')->toArray();
       //获得报名账户
        $users=User::findMany($user_ids);
        return view('admin.event.signCount',compact('users','event'));
    }



}
