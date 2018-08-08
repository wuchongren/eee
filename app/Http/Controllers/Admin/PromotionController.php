<?php

namespace App\Http\Controllers\Admin;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;

class PromotionController extends BaseController
{
    public static $status = [
        '1' => '正在进行中',
        '0' => '已结束',
        '2' => '未开始',
    ];

    /**
     * 活动列表页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //取出所有数据
        $query = Promotion::orderBy('id');
        //设置当前时间
        $time = time();
        //初始化搜索条件
        $statu = request()->input('statu');
        $search = request()->input('search');
        if ($statu !== null) {
            //搜索正在进行中的活动
            if ($statu === '1') {
                $query = $query->where('status', '=', 1);
            }
            //搜索结束的活动或未开始的活动
            if ($statu === '0') {
                $query = $query->where('status', '=', 0);
            }
            //搜索未开始的活动
            if ($statu === '2') {
                $query = $query->where('start_time', '>', $time);
            }

        }
        //标题的模糊搜索
        if ($search !== null) {
            $query = $query->where('title', 'like', "%{$search}%");
        }
        //获取最后的结果
        $promotions = $query->paginate(3);
        //显示列表视图
        return view('Admin.promotion.index', compact('promotions'));
    }

    /**
     * 活动的添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        //判断POST提交
        if ($request->isMethod('post')) {
            //验证信息
            $this->validate($request, [
                'title' => 'required|max:30',
                'content' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);
            //接收数据
            $data = $request->post();
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
            //创建数据
            Promotion::create($data);
            //成功的提示信息
            $request->session()->flash('success', '添加活动成功');
            //跳转列表展示
            return redirect()->route('promotion.index');
        }
        //引入添加视图
        return view('admin.promotion.add');
    }

    /**
     * 活动编辑功能
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        //取出当前数据
        $promotion=Promotion::findOrFail($id);
        //判断POST提交
        if ($request->isMethod('post')){
            //验证信息
            $this->validate($request,[
                'title' => 'required|max:30',
                'content' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);
            //处理时间
            $promotion->update([
                'title'=>$request->post('title'),
                'content'=>$request->post('title'),
                 'start_time'=>strtotime($request->post('start_time')),
                 'end_time'=>strtotime($request->post('end_time')),
                 'status'=>$request->post('status')??$promotion->status,
            ]);
           //提示信息
            $request->session()->flash('success','修改成功');
            //跳转
            return redirect()->route('promotion.index');
        }
        //显示到示图
        return view('admin.promotion.edit',compact('promotion'));
    }

    /**
     * 删除功能
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function del(Request $request,$id)
    {
        //查出数据
        $promotion=Promotion::findOrFail($id);
        //删除
        $promotion->delete();
        //提示
        $request->session()->flash('success','删除成功');
        //跳转
        return redirect()->route('promotion.index');
    }

    public function show(Request $request,$id)
    {
        //查出数据
        $promotion=Promotion::findOrFail($id);
        //显示视图
        return view('admin.promotion.show',compact('promotion'));
    }

}
