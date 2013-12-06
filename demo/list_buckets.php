<?php
/**
 * $ID: ListBucketsDemo $
+------------------------------------------------------------------
 * @project JSS-PHP-SDK
 * @create Created on 2013-07-29
+------------------------------------------------------------------

 * 获取所有bucket列表
×
 * 如果成功则返回JSBucket列表，否则抛出异常
× 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 *
 */

require_once dirname(__FILE__).'/global.php';

function list_buckets_test(){
	global $storage;
	try {
	    if($storage === null) {
	    	echo 'fdafds';
	    }
	   $bucketslist = $storage->list_buckets();
	   foreach($bucketslist as $jss_bucket) {
	   	  print_r("Bucket:" . $jss_bucket->get_name() . "\n");
	   	  print_r("CTime: " . $jss_bucket->get_ctime()  . "\n\n");  
	   }
	  // success('Your buckets', $bucketslist);
	
	} catch (Exception $e) {
	    exception('Get buckets failed!', $e);
	}
}

list_buckets_test();