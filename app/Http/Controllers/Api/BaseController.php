<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    //跨域处理
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
    }
}
