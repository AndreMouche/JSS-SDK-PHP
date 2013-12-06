<?php
/**
 * $ID: GetObjectResourceDemo $
+------------------------------------------------------------------
 * @project JSS-PHP-SDK
 * @create Created on 2013-07-29
+------------------------------------------------------------------

 * 获取object外链
×
 * 如果获取成功则返回外链地址，否则抛出异常
× 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 *
 */
 
require_once dirname(__FILE__).'/global.php';
 
function get_object_resource($bucket,$key){
	global $storage;
	try {
		$expire = 10*60; //十分钟后失效
		$url = $storage->get_object_resource($bucket,$key,$expire);
		success("the url is:".$url."\n");
		
	} catch (Exception $e) {
		exception('Get object resource failed!', $e);
	}
}

get_object_resource($bucket,$object_key);
