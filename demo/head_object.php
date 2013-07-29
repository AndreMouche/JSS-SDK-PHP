<?php
/*
 * Created on 2013-7-26
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once dirname(__FILE__).'/global.php';
/*
 * 获取object meta
 ×
 * 如果object存在则返回JSSResponse，否则抛出异常
 × 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 */

function head_object_test($bucket_name,$key) {
    global $storage;	
	try {
	    $jss_response = $storage->head_object($bucket_name,$key);	
	    success("Meta of {$key} is", $jss_response->get_headers());
	
	} catch (JSSError $e) { 
		jss_exception('Head object failed!',$e);
	} catch (Exception $e) {
	    exception('Head object failed!', $e);
	}
}

head_object_test($bucket,$object_key);