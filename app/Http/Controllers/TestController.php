<?php
//    测试用控制器
namespace App\Http\Controllers;

class TestController {
    public function index()
    {
        phpinfo();
    }
}