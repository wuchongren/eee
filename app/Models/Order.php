<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable=[
        'user_id','shop_id','sn','provence','city',
        'area','detail_address','tel','name','total',
        'status','out_trade_no'
    ];

    public function status()
    {
        $status= [
            '-1'=>'已取消',
            '0'=>'代付款',
            '1'=>'待发货',
            '2'=>'待确认',
            '3'=>'完成',
        ];
        return $status[$this->status];
    }

}
