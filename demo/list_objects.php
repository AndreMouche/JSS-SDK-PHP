<?php
/*
 * Created on 2013-7-26
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
require_once dirname(__FILE__).'/global.php';

function list_objects_test($bucket) {
	global $storage;	
	try {
		$options = array(
	      "marker" => '',
	      "maxKeys" => 100,
	      "prefix" => '',
	      "delimiter" => '', 
	      );
	      $jssentity = $storage->list_objects($bucket,$options);
	      $objects = $jssentity->get_object(); 
	      foreach($objects as $object) {
	      	print_r($object->get_key()."\n");
	      	//print_r($object->get_size()."\n");   
	      	//print_r($object->get_etag()."\n");
	      	//print_r($object->get_last_modified()."\n");
	      }
	      success("Your objects of {$bucket}", $jssentity);
	} catch (Exception $e) {
		  exception("Get objects of {$bucket} failed!", $e);
	}

}

list_objects_test($bucket);