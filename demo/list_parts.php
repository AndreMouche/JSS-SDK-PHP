<?php
/**
 * $ID: list parts.php $
 +------------------------------------------------------------------
 * @project JSS
 * @create Created on 2013-07-29
 +------------------------------------------------------------------

 */
require_once dirname(__FILE__).'/global.php';

/*
 * 该操作用来列出一个MUltipart Upload中已经上传的Part
×
* 如果成功则返回Part列表，否则抛出异常
× 可以通过异常对象的getCode()方法和getMessage()方法获取对应的错误码和错误信息
*/

function list_parts_test($bucket,$key,$uploadId){
	global $storage;
	try {
		$options = array(
		  "max-parts"=> 100,
		  "part-number-marker" => 0
		 );
		$listPartEntity = $storage->list_parts($bucket, $key, $uploadId,$options);
	    echo "Bucket:".$listPartEntity->get_bucket()."\n";
	    echo "ObjectKey:".$listPartEntity->get_objectKey()."\n";
	    echo "UploadId:".$listPartEntity->get_uploadId()."\n";
	    $parts_list = $listPartEntity->get_part_list();
	    foreach($parts_list as $one_part) {
	    	echo "...........................\n";
	    	echo "PartNumber:".$one_part->get_part_numer()."\n";
	    	echo "Etag:".$one_part->get_etag()."\n";
	    	echo "Last modified:".$one_part->get_last_modified()."\n";
	    	echo "...........................\n";
	    }
	    
		//success("Your parts of ({$bucket},{$key},{$uploadId})", $result->to_array());
	
	} catch (Exception $e) {
		exception("Get all parts of ({$bucket},{$key},{$uploadId}) failed!", $e);
	}
}

function list_parts_test2($bucket,$key,$uploadId){
		// parts分页
	global $storage;	
	try {
		$options = array(
		  "max-parts"=> 1,
		  "part-number-marker" => 0
		 );
	     
		$first_page_result = $storage->list_parts($bucket, $key, $uploadId,$options);
	
		success("Your parts of ({$bucket},{$key},{$uploadId})(first page)", $first_page_result->to_array());
	
		$options['part-number-marker'] = $first_page_result->get_nextPartNumberMarker(); 
		if ($options['part-number-marker'] !== '') {
			$second_page_result = $storage->list_parts($bucket, $key, $uploadId,$options);
			success("Your parts of ({$bucket},{$key},{$uploadId}) (second page)", $second_page_result->to_array());
	
		} else {
			info('There is no more parts.');
		}
	
	} catch (Exception $e) {
		exception("Get parts of ({$bucket},{$key},{$uploadId}) failed!", $e);
	}
}

$uploadid = '8f46c57290f042ea850aa2b9bf9ba0a2';
list_parts_test($bucket,$mu_object_key,$uploadid);