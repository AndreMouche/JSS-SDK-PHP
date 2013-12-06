<?php
/**
 * $ID: GetObjectDemo $
+------------------------------------------------------------------
 * @project JSS-PHP-SDK
 * @create Created on 2013-07-29
+------------------------------------------------------------------

 * 获取object
×
 * 如果获取成功则返回true，否则抛出异常
× 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 *
 * 注意：首先，确保脚本对本地文件系统具有可写权限；其次，如果本地已存在同名文件，该操作将会覆盖本地文件内容！！！
 *
 */
 
require_once dirname(__FILE__).'/global.php';

function get_object_test($bucket_name,$key) {
	
	global $storage;
	try {
	    // 这里我们将put_object示例中创建的test.jpg对象保存为本地tmp_logo.jpg文件，
	    // 这样就能正确的浏览本地文件了。
	    $local_file = dirname(__FILE__) . '/tmp_logfdo.jpg';
	    $other_headers = array();     //可传入如Range等其他该请求可用的request header
	    $storage->get_object($bucket_name,$key, $local_file,$other_headers);
	
	    success("Get object success!");
	
	} catch (Exception $e) {
	    exception('Get object failed!', $e);
	}
	
	
	// 使用stream方式新建object
	// get_object()方法可以接收一个stream对象作为输出
	try {
	    $local_file = dirname(__FILE__) . '/tmp_logo_stream.jpg';
	
	    $local_fp = fopen($local_file, 'wb');
	    if ($local_fp) {
	        $auto_close_stream = false;
	
	        $storage->get_object($bucket_name,$key,$local_fp, $auto_close_stream);
	
	        // close the stream manual
	        fclose($local_fp);
	
	        success("Get object success!");
	    } else {
	        info("Oops~, cannot open {$local_file}");
	    }
	
	} catch (Exception $e) {
	    exception('Get object failed!', $e);
	}
	
}

get_object_test($bucket,$object_key);
