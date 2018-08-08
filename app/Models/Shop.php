<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
public $fillable=[
    'shop_name','shop_category_id','shop_id','shop_img',
    'shop_rating','brand','on_time','fengniao','bao','piao',
    'zhun','start_send','send_cost','notice','discount','status'
];
public function shop_categories(){
    return $this->belongsTo(ShopCategory::class,'shop_category_id');
}


}
