<?php
/*
 * Created on 2013-7-26
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once dirname(__FILE__).'/../sdk/JingdongStorageService.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Shanghai');
//public
define('ACCESS_KEY', ''); // 请在此处输入您的AccessKey
define('ACCESS_SECRET', ''); // 请在此处输入您的AccessSecret
#define('DEBUG',true);
define('HOST_DEFAULT', 'http://storage.jcloud.com');

$bucket = "andremouche21multipart";
$object_key = "logo.png";
$mu_object_key = "multipartupload"; //通过multipart upload 上传的object key
$local_file = dirname(__FILE__) ."/logo.png";

$storage = new JingdongStorageService(ACCESS_KEY,ACCESS_SECRET);

function info($title) {
    echo "========= {$title} =========\n";
}

function success($message, $data=null) {
    $dt = date('c');
    if ($data === null) {
        echo "[{$dt}] - {$message}\n\n";
    } else {
        echo "[{$dt}] - {$message} => \n";
        print_r($data);
        echo "\n";
    }
}

function jss_exception($message,$e) {
	$dt = date('c');
    $space = str_pad('', (strlen("[{$dt}] - ") - strlen("[Errno] - ")));
    echo "[{$dt}] - {$message}\n";
    echo "{$space}[HTTP Code] : ".$e->getCode()."\n"; //获取http返回错误码
	echo "{$space}[Error Code] : ".$e->getErrorCode()."\n";  //获取错误信息码
	echo "{$space}[Error Message]:".$e->getErrorMessage()."\n";//获取错误信息
	echo "{$space}[RequestId] : ".$e->getRequestId()."\n"; //获取请求ID
	echo "{$space}[requestResource] : ".$e->getResource()."\n";//获取请求资源
}

function exception($message, $e) {
    $dt = date('c');
    $space = str_pad('', (strlen("[{$dt}] - ") - strlen("[Errno] - ")));
 
    echo "[{$dt}] - {$message}\n";
    echo "{$space}[Errno] - " . $e->getCode() . "\n";
    echo "{$space}[Error] - " . $e->getMessage() . "\n\n";
   // print_r($e->to_array());
}
