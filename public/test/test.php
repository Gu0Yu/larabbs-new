<?php

require __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;     // 读取 Excel

$activity_path = '../excel/activity.xlsx';
$activities_path = '../excel/activities.xlsx';

$activity = IOFactory::load($activity_path);  //载入要读取的文件
$activities = IOFactory::load($activities_path);

$activity_sheet = $activity->getActiveSheet();
$activities_sheet = $activities->getActiveSheet();

// 设置列宽
$activities_sheet->getColumnDimension('K')->setWidth(12);
$activities_sheet->getColumnDimension('L')->setWidth(18);
$activities_sheet->getColumnDimension('M')->setWidth(18);
$activities_sheet->getColumnDimension('N')->setWidth(8);
$activities_sheet->getColumnDimension('O')->setWidth(13);
$activities_sheet->getColumnDimension('P')->setWidth(33);

$activities_sheet->setCellValue('K1', '活动id')
                    ->setCellValue('L1','上线日期')
                    ->setCellValue('M1','下线日期')
                    ->setCellValue('N1','片区')
                    ->setCellValue('O1','运营')
                    ->setCellValue('P1','域名');

for ($i = 2; $i <= 394; $i++) {
    $activities_url = 'http://';
    $activities_url .= $activities_sheet->getCell('B'. $i)->getvalue();
    for($j = 2; $j <= 300; $j++) {
        $activity_url = $activity_sheet->getCell('B'. $j)->getvalue();

        if ($activities_url == $activity_url) {
            $act_id = $activity_sheet->getCell('A'. $j)->getvalue();
            $activities_sheet->setCellValue('K'.$i, $act_id);
            $begin_time = $activity_sheet->getCell('C'. $j)->getFormattedValue();
            $activities_sheet->setCellValue('L'.$i, $begin_time);
            $end_time = $activity_sheet->getCell('D'. $j)->getFormattedValue();
            $activities_sheet->setCellValue('M'.$i, $end_time);
            $act_area = $activity_sheet->getCell('E'. $j)->getvalue();
            switch ($act_area) {
                case 1:
                    $act_area = '华东';
                    break;
                case 2:
                    $act_area = '华北';
                    break;
                case 3:
                    $act_area = '华南';
                    break;
            }
            $activities_sheet->setCellValue('N'.$i, $act_area);
            $operator = $activity_sheet->getCell('F'. $j)->getvalue();
            $activities_sheet->setCellValue('O'.$i, $operator);
            $act_url = $activity_sheet->getCell('B'. $j)->getvalue();
            $activities_sheet->setCellValue('P'.$i, $act_url);
        }
    }
}

//从当前活动的表单里读取并转成数组的形式
//$activity_to_array = $activity->getActiveSheet()->toArray();
//$activities_to_array = $activities->getActiveSheet()->toArray();
//var_dump($activity_to_array);
//var_dump($activities_to_array);

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($activities, "Xlsx");
$writer->save("../excel/互动活动.xlsx");