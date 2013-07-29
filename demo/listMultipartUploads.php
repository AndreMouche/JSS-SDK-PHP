<?php

require_once dirname(__FILE__).'/global.php';

/*
 * 获取bucket下所有MultipartUploads列表
×
* 如果成功则返回GCBucket列表，否则抛出异常
× 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
*/

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
