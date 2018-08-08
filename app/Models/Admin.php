<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles;
    protected $guard_name = 'admin'; // 使用任何你想要的守卫
    use Notifiable;
    public $fillable=[
        'name','password','email','status'
    ];
}
