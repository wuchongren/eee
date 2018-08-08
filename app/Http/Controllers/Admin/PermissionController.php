<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class PermissionController extends BaseController
{
//    protected $modelName = 'App\Models\Role';
//    protected $errorMsg = [
//        'name.required'                 => '角色标识必填',
//        'name.unique'                   => '角色标识已存在',
//        'display_name.required'         => '角色名称必填',
//        'display_name.max'              => '角色名称最多255个字符',
//        'description.required'          => '角色描述必填',
//        'description.max'               => '角色描述最多255个字符',
//    ];
//
//    public function show()
//    {
//        return view('admin.role.item');
//    }
//    public function edit($id)
//    {
//        $role = new Role();
//        $item = $role->find($id);
//        return view('admin.role.item', compact('item'));
//    }
//    protected function _updateModel(Model $role, Array $inputs, $type)
//    {
//        if (ConfigUtils::inConfigIds($role->id, "admin.role_table_cannot_manage_ids", false))
//            return $this->retError(403, '该角色禁止修改!');
//        $role->name = Input::get('name');
//        $role->display_name = Input::get('display_name');
//        $role->description = Input::get('description', '');
//        if (!$role->save()) {
//            return $this->retJson(503, '操作出错!');
//        }
//        return $this->retJson(200, '操作成功!');
//    }
//    public function destroy($id)
//    {
//        if (ConfigUtils::inConfigIds($id, "admin.role_table_cannot_manage_ids", false))
//            return $this->retError(403, '该角色禁止修改!');
//        $role = new Role();
//        $role->id = $id;
//        $role->exists = true;
//        if (!$role->delete()) {
//            return $this->retJson(503, '操作出错!');
//        }
//        $this->appOpLog("更新数据ID:$id", $role->getAttributes());
//        return $this->retJson(200, '操作成功!');
//    }
//    public function permissionEdit($id)
//    {
//        $role = new Role();
//        $role = $role->find($id);
//        $pager = Permission::all();
//        return view('admin.role.permission', compact('pager', 'role'));
//    }
//    public function permissionStore(Request $request, $id)
//    {
//        try {
//            $role = new Role();
//            $role = $role->find($id);
//            $this->validate($request, [
//                'perms' => 'array'
//            ]);
//            $role->savePermissions(Input::get('perms'));
//            if (!$role->save()) {
//                return $this->retJson(503, '操作出错!');
//            }
//            $this->appOpLog("修改权限ID:$id", $role->getAttributes());
//            return $this->retJson(200, '操作成功!');
//        } catch (Exception $e) {
//            return $this->retJson(503, '操作出错2!');
//        }
//    }
    public function index()
    {
        $permissions=Permission::all();

        //返回到视图
        return  view('admin.permission.index',compact('permissions'));
   }

    /**
     * 权限的添加
     */
    public function add()
    {
        //获得所有路由
        $routes=Route::getRoutes();
        //声明一个空数组
        $urls=[];
        foreach ($routes as $k=>$v){
            if ($v->action['namespace']==="App\Http\Controllers\Admin"){
                //判断有没有别名
                if(isset($v->action['as'])){
                    //存入数组
                    $urls[]=$v->action['as'];
                }
            }
        }
        //取出所有权限
        $permissions=Permission::all()->pluck('name')->toArray();
        //找出还没有注册的权限
        $urls=array_diff($urls,$permissions);

        foreach ($urls as $url){
            //将权限注册
            $permission= Permission::create(['name'=>$url,'guard_name'=>'admin']);
        }
        //返回列表展示
        return redirect()->route('permission.index');
    }
}
