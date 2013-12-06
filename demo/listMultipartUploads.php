<?php
/**
 * $ID: ListPartsDemo $
+------------------------------------------------------------------
 * @project JSS-PHP-SDK
 * @create Created on 2013-07-29
+------------------------------------------------------------------

 * 获取指定Bucket下所有未完成的MultipartUpload列表
×
 * 如果成功则返回MultipartUploadEntity，否则抛出异常
× 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 *
 */
require_once dirname(__FILE__).'/global.php';

function list_multipart_upload_test($bucket) {
	global $storage;
	try {
		$options = array(
                        "key-marker"=>'',
                        "upload-id-marker"=>'');
                        
		$multipartUploadEntity = $storage->list_multipart_upload($bucket,$options);
		print_r($multipartUploadEntity->to_array());

		//success("Your multipartuploads of {$bucket}", $multipartUploadEntity);

	} catch (Exception $e) {
		exception("Get all multipartuploads of {$bucket} failed!", $e);
	}
}


list_multipart_upload_test($bucket);
