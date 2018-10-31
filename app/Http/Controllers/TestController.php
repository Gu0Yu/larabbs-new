<?php
//    测试用控制器
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TestController {

    public function index()
    {
//        $res = $client->request('Get', 'http://ddmp.audi-online.cn:86/BaseInfoService.svc?wsdl');
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');
        echo $res->getStatusCode();
    }
}