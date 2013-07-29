<?php
/*
 * Created on 2013-7-26
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
require_once dirname(__FILE__).'/global.php';
 
function get_object_resource($bucket,$key){
	global $storage;
	try {
		$expire = 10*60; //十分钟后失效
		$url = $storage->get_object_resource($bucket,$key,$expire);
		success("the url is:".$url."\n");
		
	} catch (Exception $e) {
		exception('Get object resource failed!', $e);
	}
}

get_object_resource($bucket,$object_key);
