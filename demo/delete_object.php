<?php
/*
 * Created on 2013-7-26
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

require_once dirname(__FILE__).'/global.php';
/*
 * 删除object
 ×
 * 如果删除成功则返回true，否则抛出异常
 × 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 */

function delete_object_test($bucket,$key) {
	global $storage;
	try {
	    $storage->delete_object($bucket,$key);
	    //$storage->delete_object();
	    success("Delete object success!");
	
	} catch (JSSError $e) {
		jss_exception('Delete object failed!',$e);
	} catch (Exception $e) {
	    exception('Delete object failed!', $e);
	}
}

delete_object_test($bucket,$object_key);
