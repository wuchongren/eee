<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
  public  $fillable=[
      'title','content','status','start_time','end_time'
  ];
  public $timestamps=false;
}
