<?php
/**
 * $ID: AbortMultipartUploadDemo $
 +------------------------------------------------------------------
 * @project JSS-PHP-SDK
 * @create Created on 2013-07-29
 +------------------------------------------------------------------
 *
 * 终止一个MultipartUpload
 ×
 * 如果成功则返回true，否则抛出异常
 × 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 *
 */
require_once dirname(__FILE__).'/global.php';

function abort_multipart_uploadtest($bucket,$object_key,$uploadId) {
	global $storage;
	try {
	    $storage->abortMultipartUpload($bucket,$object_key,$uploadId);
	    // do something ..
	    success("Abort multipartupload success!");

	} catch (Exception $e) {
	    exception('Abort multipartupload failed!', $e);
	}
}


$uploadId = "8f46c57290f042ea850aa2b9bf9ba0a2";
abort_multipart_uploadtest($bucket,$mu_object_key,$uploadId);