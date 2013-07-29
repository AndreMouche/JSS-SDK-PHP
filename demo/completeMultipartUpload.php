<?php
/*
 * $ID: complete multipart upload $
 +------------------------------------------------------------------
 * @project JSS
 * @create Created on 2013-07-29
 +------------------------------------------------------------------

 */
require_once dirname(__FILE__).'/global.php';

/*
 * 初始化一个MUltipart upload对象
 ×
 * 如果添加成功则返回该对象的基本信息（bucket,key,uploadid），否则抛出异常
 */
 
function completeMultipartUpload_test($bucket,$object_key,$uploadid){
	global $storage;
	try {
	    $jss_response = $storage->complete_multipartupload($bucket,$object_key,$uploadid);
	    echo "response code:".$jss_response->get_code()."\n";
	    echo "response body:".$jss_response->get_body()."\n";
	    //do something..
	    success("Complete multipart upload({$bucket},{$object_key},{$uploadid}) success !",$jss_response);
	
	} catch (Exception $e) {
	    exception("Complete multipart upload({$bucket},{$object_key},{$uploadid}) failed !", $e);
	}
}

$uploadid = '8f46c57290f042ea850aa2b9bf9ba0a2';
completeMultipartUpload_test($bucket,$mu_object_key,$uploadid);