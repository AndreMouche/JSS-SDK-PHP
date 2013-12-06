<?php
/**
 * $ID: CompleteMultipartUploadDemo $
 +------------------------------------------------------------------
 * @project JSS-PHP-SDK
 * @create Created on 2013-07-29
 +------------------------------------------------------------------
 * 完成一个MUltipart upload
 ×
 * 如果成功则返回JSS_Response，否则抛出异常
 */
require_once dirname(__FILE__).'/global.php';

 
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

$uploadid = '???';
completeMultipartUpload_test($bucket,$mu_object_key,$uploadid);