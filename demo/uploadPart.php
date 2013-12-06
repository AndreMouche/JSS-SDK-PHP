<?php
/**
 * $ID: UploadPartDemo $
 +------------------------------------------------------------------
 * @project JSS-php-sdk
 * @create Created on 2013-07-29
 +------------------------------------------------------------------
 * 上传Multipart upload的一个Part
×
 * 如果上传成功则返回true，否则抛出异常
× 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
 *
 * 注意：同一MultipartUpload下相同partid的Part将会覆盖已经存在的Part内容！！！
 */

require_once dirname(__FILE__).'/global.php';


/*
 * 使用流的方式新建Upload part
 */
function upload_part_test($bucket,$key,$uploadid,$part_number,$local_file){
	global $storage;
	try {
	    // upload_part()方法还可以接收一个stream对象
	   
	    $local_stream = fopen($local_file, 'rb');
	    $request_headers = array("Content-Length"=>1024);
	    $etag = $storage->upload_part($bucket, $key, $uploadid, $part_number, $local_stream,$request_headers);
	
	    success("Upload part success and the etag is {$etag}");
	
    } catch (JSSError $e) {
		jss_exception("Delete bucket({$bucket}) failed!",$e);
	} catch (Exception $e) {
	    exception("Delete bucket({$bucket}) failed!", $e);
	}
}

/* 
 * 使用文件路径方式新建Upload Part
 * upload_part方法可以接收一个文件路径作为输入
 */
function upload_part_by_path_test($bucket,$key,$uploadid,$part_number,$file_path) {	
	
	global $storage;
	try {
	    $etag = $storage->upload_part($bucket, $key, $uploadid, $part_number, $file_path);
	    //do something..
	    success("Upload part success and the etag is {$etag}!");
	
    } catch (JSSError $e) {
		jss_exception("Delete bucket({$bucket}) failed!",$e);
	} catch (Exception $e) {
	    exception("Delete bucket({$bucket}) failed!", $e);
	}
}

$uploadid = '8f46c57290f042ea850aa2b9bf9ba0a2';
upload_part_test($bucket,$mu_object_key,$uploadid,3,$local_file);
//upload_part_by_path_test($bucket,$mu_object_key,$uploadid,2,$local_file);