<?php

function key_arr_to_str($param) 
{
	$arr_tmp = array();
	foreach($param as $key=>$val) {
		if($key != "sAMSToken" && $key != "sAMSSign"){
			$arr_tmp[] = "$key=$val";
		}		
	}
	$str = implode('&', $arr_tmp);
	return $str;
}

function key_arr_to_str_no_empty($param) 
{
	$arr_tmp = array();
	foreach($param as $key=>$val) {
		if($val!=='' && $key != "sAMSToken" && $key != "sAMSSign") {
			$arr_tmp[] = "$key=$val";
		}
	}
	$str = implode('&', $arr_tmp);
	return $str;
}  

function make_sig($param) 
{
	ksort($param);      
	$str = key_arr_to_str_no_empty($param)."&sAMSToken=".$param['sAMSToken'];
	return strtoupper(md5($str));
}       

function get_rand_str($len=6) {
    $chars='ABDEFGHJKLMNPQRSTVWXYabdefghijkmnpqrstvwxy23456789';  
    mt_srand((double)microtime()*1000000*getmypid());  
    $password='';  
    while(strlen($password) < $len) 
        $password .= substr($chars, (mt_rand()%strlen($chars)), 1);
    return $password;  
}
//请注意，实际生成环境的随机种子要比这个复杂，不能直接使用这个，不然会造成流水号重复
function create_ams_serial($sServiceType, $iAmsActivityId, $iFlowId) 
{
    $str = 'AMS-' . $sServiceType . '-' . date('mdHis') . '-' . get_rand_str();
    $str .= '-' . $iAmsActivityId . '-' . $iFlowId;
    return $str;
}
//关键参数，建议放到URL
$param['sAMSAppId'] = 'IEG-AMS-11084';
$param['sAMSToken'] = '08f7728e30cce7a05696de87af736702';
$param['sCloudApiName'] = 'ams.gameattr.sidip';
$param['sAMSTimestamp'] = time();
$param['sServiceType'] = 666;
$param['sAMSVersion'] = '2.0';
$param['iAmsActivityId'] = '11084';
$param['sAmsSerial'] = create_ams_serial($param['sServiceType'], $param['iAmsActivityId'], '68125');

$param['cmd'] = '10276000';
$param['gameCmd'] = '0x1001';
$param['area'] = 2;
$param['platid'] = 1;
//只有此处需要变为实际的
$param['openid'] = '7B7A5D080D7B7F8F1922282BFBFF5F91';




echo "sort before：\n";
print_r($param);  
ksort($param);
echo "sort after：\n";
print_r($param);  
//实际请求AMS的参数不一定需要排序，只是生成签名需要排序
echo 'test: curl "http://i.ams.ied.tencent-cloud.net/main?'.key_arr_to_str($param) . '&sAMSSign='. make_sig($param);