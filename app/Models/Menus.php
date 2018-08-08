<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    //设置可操作字段
    public $fillable=[
        'goods_name','rating','shop_id','menu_category_id',
        'goods_price','description','month_count','rating_count',
        'tips','satisfy_count','satisfy_rate','goods_img','status'
    ];
    //设置外键访问菜单分类名
    public function menu_categories(){
        return $this->belongsTo(MenuCategory::class,'menu_category_id');
    }

}
