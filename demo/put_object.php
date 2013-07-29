<?php
/*
 * Created on 2013-7-26
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once dirname(__FILE__).'/global.php';


function put_object_test($bucket_name,$key,$local_file){

    global $storage;
	try {
	    // put_object()方法可以接收一个文件路径
	    $object_name = $key;
	    $local_file =$local_file;
	    $request_header = array('Content-Type'=>'application/x-director');
	    $storage->put_object($bucket_name,$key, $local_file,$request_header);	
	    success("Put object success!");
	
	} catch (JSSError $e) { 
		jss_exception('Put object failed!',$e);
	} catch (Exception $e) {
	    exception('Put object failed!', $e);
	}
	
}

function put_object_stream_test($bucket_name,$key,$local_file){
	// 使用stream方式新建object
	// put_object()方法可以接收一个stream对象作为输入
	global $storage;
	try {
	    $object_name = $key;
	    $local_stream = fopen($local_file, 'rb');
	    $storage->put_object($bucket_name,$object_name, $local_stream);
	
	    success("Put object success!");
	
	} catch (Exception $e) {
	    exception('Put object failed!', $e);
	}
}

put_object_test($bucket,$object_key,$local_file);
//put_object_stream_test($bucket,$object_key,$local_file);