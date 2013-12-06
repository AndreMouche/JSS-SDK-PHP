<?php
/**
 * $ID: ListObjectsDemo $
+------------------------------------------------------------------
 * @project JSS-PHP-SDK
 * @create Created on 2013-07-29
+------------------------------------------------------------------

 * 获取指定Bucket下所有Object列表
×
 * 如果成功则返回JSObject列表，否则抛出异常
× 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 *
 */
 
require_once dirname(__FILE__).'/global.php';

function list_objects_test($bucket) {
	global $storage;	
	try {
		$options = array(
	      "marker" => '',
	      "maxKeys" => 100,
	      "prefix" => '',
	      "delimiter" => '', 
	      );
	      $jssentity = $storage->list_objects($bucket,$options);
	      $objects = $jssentity->get_object(); 
	      foreach($objects as $object) {
	      	print_r($object->get_key()."\n");
	      	//print_r($object->get_size()."\n");   
	      	//print_r($object->get_etag()."\n");
	      	//print_r($object->get_last_modified()."\n");
	      }
	      success("Your objects of {$bucket}", $jssentity);
	} catch (Exception $e) {
		  exception("Get objects of {$bucket} failed!", $e);
	}

}

list_objects_test($bucket);