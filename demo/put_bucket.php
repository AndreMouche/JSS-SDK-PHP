<?php
/**
 * $ID: PutBucketDemo $
+------------------------------------------------------------------
 * @project JSS-PHP-SDK
 * @create Created on 2013-12-05
+------------------------------------------------------------------

 * 新建bucket
 *
 * 如果创建成功则返回JSSResponse，否则抛出异常
 * 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 *
 * 注意：bucket名称全局唯一，当名称已存在时则抛出异常
 *
 */
require_once dirname(__FILE__).'/global.php';

function put_bucket_test($bucket_name) {
    global $storage;
	try {
	   // $storage->put_bucket($bucket_name);
	    $storage->put_bucket($bucket_name);
	    success("Put bucket({$bucket_name}) success!");
	} catch (JSSError $e) {
	   jss_exception('Put bucket failed!',$e);
	} catch (Exception $e) {
		exception('Put bucket failed!',$e);
	}
}

put_bucket_test($bucket);