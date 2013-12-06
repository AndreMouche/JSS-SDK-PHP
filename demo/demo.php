<?php
/**
 * $ID: SimpleDemo $
+------------------------------------------------------------------
 * @project JSS-PHP-SDK
 * @create Created on 2013-06-18
+------------------------------------------------------------------
 * 该文件为使用JSS主要功能的简单案例，需详细了解各个案例的详细用法请查看文档或各个单独案例。
 * 注意：运行前请在相应位置填入您的AccessKey和AccessSecret
 *
 */
require_once dirname(__FILE__).'/../sdk/JingdongStorageService.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Shanghai');

define('ACCESS_KEY', ''); // 请在此处输入您的AccessKey
define('ACCESS_SECRET', ''); // 请在此处输入您的AccessSecret
					    

function test_total(){
	$service = new JingdongStorageService(ACCESS_KEY,ACCESS_SECRET);
	$bucket = 'test'.substr(md5(uniqid(mt_rand(), true)),0,5);
	$local_file = dirname(__FILE__) . '/logo.png';
	try{
		
		$buckets_list = $service->list_buckets();  // list bucket
		echo "list bucket result:\n";
		print_r($buckets_list);
		
		$service->put_bucket($bucket); //create new  bucket
		echo "\nput bucket {$bucket} success.\n";
		
		echo "\nstart object service test..\n";
		foreach(range(0,10) as $i) {     // put object
			$key = "test_".$i.".logo.png";
		    $service->put_object($bucket,$key,$local_file);
		    $service->head_object($bucket,$key);
		    $service->get_object($bucket,$key,dirname(__FILE__) . "/".$key);
		    $url = $service->get_object_resource($bucket,$key);
		    echo "url for {$bucket}/{$key} :".$url."\n";
		}
		
		echo "put/head/get/source object success\n";
	      
	    while(true) {
	    	$jss_entity = $service->list_objects($bucket);  // list objects
	    	$object_list = $jss_entity->get_object();
	    	if(empty($object_list)) {
	    		echo "{$bucket} is empty now\n";
	    		break;
	    	}
	    	
	    	foreach($object_list as $object){
	    		$service->delete_object($bucket,$object->get_key()); 
	    		echo "Delete object {$object->get_key()} success!\n";
	    	}
	    }
	    
	    echo "list and delete object success\n";
	    
	    $service->delete_bucket($bucket);
	    echo "Delete bucket {$bucket} success.\n";
	    
	    echo "Finished all tests successfully.";
	    
	} catch (JSSError $e) {
	   echo "HTTP Code : ".$e->getCode()."\n"; //获取http返回错误码
	   echo "Error Code : ".$e->getErrorCode()."\n";  //获取错误信息码
	   echo "Error Message:".$e->getErrorMessage()."\n";//获取错误信息
	   echo "RequestId : ".$e->getRequestId()."\n"; //获取请求ID
	   echo "requestResource : ".$e->getResource()."\n";//获取请求资源
	} catch (Exception $e) {
		echo "Error Code : ".$e->getCode()."\n";
		echo "Error Message : ".$e->getMessage()."\n";
	}
}

test_total();





