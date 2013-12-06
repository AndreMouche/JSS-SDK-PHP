<?php
/**
 * $ID: DeleteBucketDemo $
 +------------------------------------------------------------------
 * @project JSS-PHP-SDK
 * @create Created on 2013-07-29
 +------------------------------------------------------------------
 * 删除bucket
 ×
 * 如果删除成功则返回true，否则抛出异常
 × 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 *
 * 注意：如果bucket内容非空则无法删除！！！
 */

 
require_once dirname(__FILE__).'/global.php';
 

/**
 * 删除空的bucket
 */  
function delete_bucket_test($bucket_name) {
    global $storage;
	try {
	    $jss_response = $storage->delete_bucket($bucket_name);
	
	    success("Delete bucket({$bucket_name}) success!");
	    print_r($jss_response->to_array());
	
	} catch (JSSError $e) {
		jss_exception("Delete bucket({$bucket_name}) failed!",$e);
	} catch (Exception $e) {
	    exception("Delete bucket({$bucket_name}) failed!", $e);
	}
}

/**
 * 强制删除bucket
 * 若bucket非空，则先删除bucket下的object再删bucket
 */
function delete_bucket_force($bucket) {
	global $storage;
	try {
	   while(true) {
	    	$jss_entity = $storage->list_objects($bucket);
	    	$object_list = $jss_entity->get_object();
	    	if(empty($object_list)) {
	    		echo "{$bucket} is empty now\n";
	    		break;
	    	}
	    	
	    	foreach($object_list as $object){
	    		$storage->delete_object($bucket,$object->get_key());
	    		echo "Delete object {$object->get_key()} success!\n";
	    	}
	    }
	    $jss_response = $storage->delete_bucket($bucket);
	
	    success("Delete bucket({$bucket}) success!");
	    print_r($jss_response->to_array());
	
	} catch (JSSError $e) {
		jss_exception("Delete bucket({$bucket}) failed!",$e);
	} catch (Exception $e) {
	    exception("Delete bucket({$bucket}) failed!", $e);
	}
}

delete_bucket_test($bucket);
//delete_bucket_force($bucket);