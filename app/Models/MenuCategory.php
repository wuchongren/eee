<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    public $fillable=[
        'name','is_selected','description','type_accumulation','shop_id'
    ];
}
