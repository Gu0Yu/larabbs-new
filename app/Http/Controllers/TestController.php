<?php
//    测试用控制器
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class TestController {

    private $data ='';
    private $format = '';
    public function __construct($data, $format)
    {
        $this->data = $data;
        $this->format = $format;
    }

    public function index()
    {
        log::info('测试日志信息');
        return 111;
    }
}