<?php
/**
 * $ID: InitMultipartUploadDemo $
+------------------------------------------------------------------
 * @project JSS-PHP-SDK
 * @create Created on 2013-07-29
+------------------------------------------------------------------

 * 初始化一个MultipartUpload对象，
 * 若成功返回对象基本信息，否则抛出异常。
× 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 *
 */

require_once dirname(__FILE__).'/global.php';

function init_multipart_upload_test($bucket,$object_key) {
    global $storage;
	try {
	    $multipartUpload = $storage->init_multipart_upload($bucket,$object_key);
	    echo "Bucket:".$multipartUpload->get_bucket()."\n";
	    echo "object key:".$multipartUpload->get_key()."\n";
	    echo "uploadId:".$multipartUpload->get_uploadid()."\n";
	    success("Init Multipart upload ({$bucket}) success!",$multipartUpload->to_array());
	} catch (JSSError $e) {
	    jss_exception("Init Multipart upload({$bucket},{$object_key}) failed!",$e);
	} catch (Exception $e) {
	    exception("Init Multipart upload({$bucket},{$object_key}) failed!",$e);
	}
}


init_multipart_upload_test($bucket,$mu_object_key);
