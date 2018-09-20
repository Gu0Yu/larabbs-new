<?php

require __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$time = strtotime('2018-10-08 24:00:00');
echo $time;
exit;

$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0);
$sheet = $spreadsheet->getActiveSheet();
$data = $sheet->getCell('A1')->getvalue();
var_dump($data);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->setCellValue('A1', '编号')
        ->setCellValue('B1','用户名')
        ->setCellValue('C1','昵称')
        ->setCellValue('D1','年龄');

//要写入的数据
$data = [
    [
        'uid' => 1,
        'username' => 'lisi',
        'nickname' => '李四',
        'age' => 18
    ],
    [
        'uid' => 2,
        'username' => 'wangwu',
        'nickname' => '王五',
        'age' =>21
    ],
    [
        'uid' => 3,
        'username' => 'maliu',
        'nickname' => '马六',
        'age' => 33
    ]
];
$sheet->fromArray($data,null,'A2'); //从A2行开始写入数据
$writer = new Xlsx($spreadsheet);
$writer->save('../excel/WriteData.xlsx'); //设置保存文件名称