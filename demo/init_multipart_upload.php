<?php
/*
 * Created on 2013-7-26
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
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
