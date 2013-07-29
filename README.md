#京东云存储服务PHP SDK
============
  [京东云存储服务](http://www.jcloud.com/)(Jingdong Storage Service)是京东商城对外提供海量、安全、低成本、高可用的
  云存储服务基础平台。开发者利用该工具包可以实现：
  1. 管理Bucket信息
  2. 上传与下载Object数据
  3. 生成可公开访问/私有访问的URL
  
##平台优势
  1.  <b>海量数据</b>，通过数据冗余、集中资源管理等方式将大规模的硬件整合为高可靠的海量虚拟存储资源，用户可以轻松享受多媒体分享网站、网盘、个人企业数据备份等海量数据的云存储服务。
  2.  <b>低成本</b>，无需提供服务器，也不用关心冗余系统，不必关心购买安装和维护用于数据资源的硬件，用户完全可以省下这笔成本，借助于JSS平台，就可以轻松地创建和管理数据资源。
  3.  <b>安全性</b>，平台采用数据隔离、访问控制策略来保证数据安全性，使用严格的安全措施，比如使用经过证明的加密算法对用户进行身份验证，有效防止用户信息和用户数据资源泄露。
  4.  <b>高可用性</b>，通过软件智能调度实现自动故障恢复来保证系统的高可用性，同时采用群集系统，快速消除单点故障,在任何时候都能够保证系统正常使用，对外提供云存储服务。

##系统要求

  京东云存储PHP SDK 需要 CURL 库支持，在使用前请检查您系统中安装的PHP是否已经支持 PHP CURL
##使用  
  京东云存储服务PHP SDK核心类为JingdongStorageService，开发者需通过该类提供的多种方法访问京东云存储服务。
###构建JingdongStorageService对象
  在构建JingdongStorageService时必须包含用户的AccessKeyId以及SecertAccessKeyId
```php
$storage = new JingdongStorageService("AccessKeyId", "SecertAccessKeyId");
```
###列出所有的Bucket

```php
$bucketslist = $storage->list_buckets();
foreach($bucketslist as $jss_bucket) {
  print_r("Bucket:" . $jss_bucket->get_name() . "\n");
  print_r("CTime: " . $jss_bucket->get_ctime()  . "\n\n");  
}
```
###Bucket相关操作
创建一个Bucket，请注意，京东云存储所有的Bucket都是全局唯一的，每个用户最多只能创建100个Bucket，每个Bucket在京东云存储系统中都是唯一的，不能创建2个相同名字的Bucket。
```php
$storage->put_bucket($bucket_name);
```
删除Bucket,当Bucket中没有Object的时候，该Bucket才能被删除, 否则删除会失败。
```php
$storage->delete_bucket($bucket_name);
```
###Object相关操作
上传数据
```php
// put_object()方法可以接收一个文件路径
$object_name = 'test.jpg';
$local_file = dirname(__FILE__) . '/logo.jpg';
$storage->put_object($bucket_name,$object_name, $local_file);


// put_object()方法可以接收一个stream对象作为输入
$object_name = 'test2.jpg';
$local_stream = fopen(dirname(__FILE__) . '/logo.jpg', 'rb');
$storage->put_object($bucket_name,$object_name, $local_stream);

```

下载数据
```php
//get_object()方法可以接收一个接收一个文件路径
$local_file = dirname(__FILE__) . '/tmp_logfdo.jpg';
$other_headers = array();     //可传入如Range等其他该请求可用的request header
$storage->get_object($bucket_name,$key, $local_file,$other_headers);



// get_object()方法可以接收一个stream对象作为输出
	
$local_file = dirname(__FILE__) . '/tmp_logo_stream.jpg';

$local_fp = fopen($local_file, 'wb');
if ($local_fp) {

	$auto_close_stream = false;
	$storage->get_object($bucket_name,$key,$local_fp, $auto_close_stream);

	// close the stream manual
	fclose($local_fp);
	print_r("Get object success!");

} else {
	print_r("Oops~, cannot open {$local_file}");
}


```


获取Object信息与Metadata(HEAD Object)
```php
$jss_response = $storage->head_object($bucket_name,$key);	
print_r($jss_response->get_headers()); //获得服务端返回的headers
```

删除 Object
```php
$storage->delete_object($bucket,$key);
```

获取 Bucket 下 Object 列表
```php
$options = array(
             "marker" => '',
             "maxKeys" => 100,
             "prefix" => '',
             "delimiter" => '/', 
             );
$jssentity = $storage->list_objects($bucket,$options);
$objects = $jssentity->get_object(); 
foreach($objects as $object) {
	print_r($object->get_key()."\n");
	//print_r($object->get_size()."\n");   
	//print_r($object->get_etag()."\n");
	//print_r($object->get_last_modified()."\n");
}
```

创建带预签名的URI

京东云存储提供了一种基于查询字串(Query String)的认证方式，即通过预签名(Presigned)的方式，为要发布的Object生成一个带有认证信息的URI，并将它分发给第三方用户来实现公开访问。
SDK中提供了PresigendURIBuilder来构造预签名URI。
```php
$expire = 10*60; //十分钟后失效
$url = $storage->get_object_resource($bucket,$key,$expire);
  // 产生一个链接,可以通过浏览器来下载该key，10*60秒超时后，该链接不能下载
```
生成的URI如下：
```php
http://storage.jcloud.com/bucketname/key?Expires=1371947369&AccessKey=dfa51215af4a47c086cbf77d1479c07d&Signature=F4vmVeqveYJwqCpuR8NZO6%2FIU7s%3D
```

初始化 Multipart Upload
```php
$multipartUpload = $storage->init_multipart_upload($bucket,$object_key);
echo "Bucket:".$multipartUpload->get_bucket()."\n";
echo "object key:".$multipartUpload->get_key()."\n";
echo "uploadId:".$multipartUpload->get_uploadid()."\n";
```

上传 Part

使用文件路径方式新建Upload Part
```php
//upload_part方法可以接收一个文件路径作为输入
$etag = $storage->upload_part($bucket, $key, $uploadid, $part_number, $file_path);
```

使用流的方式新建upload Part
```php 
 $local_stream = fopen($local_file, 'rb');
 $request_headers = array("Content-Length"=>1024);
 $etag = $storage->upload_part($bucket, $key, $uploadid, $part_number, $local_stream,$request_headers);	
	    
```

列出指定Multipart Upload已上传的Part 
```php
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
```


完成指定uploadId的Multipart Upload
```php
$jss_response = $storage->complete_multipartupload($bucket,$object_key,$uploadid);
echo "response code:".$jss_response->get_code()."\n";
echo "response body:".$jss_response->get_body()."\n";
```
列出指定bucket下所有正在上传的Multipart Upload
```php
$options = array(
        "key-marker"=>'',
        "upload-id-marker"=>'');
        
$multipartUploadEntity = $storage->list_multipart_upload($bucket,$options);
print_r($multipartUploadEntity->to_array());
```

## Exception
在访问云存储过程中，所有没有能够正常完成服务请求的操作，都会返回JSSError,该 Exception 是由 Exception 派生而来，JSSError的对象中，
并会得出以下由存储服务器获得到的错误返回的响应：错误码，错误信息，请求资源，请求ID。例如在创建2次Bucket时候,代码如下
```php
try {
    $storage->put_bucket($bucket_name);
    $storage->put_bucket($bucket_name);
    success("Put bucket({$bucket_name}) success!");
} catch (JSSError $e) {
   echo "HTTP Code : ".$e->getCode()."\n"; //获取http返回错误码
   echo "Error Code : ".$e->getErrorCode()."\n";  //获取错误信息码
   echo "Error Message:".$e->getErrorMessage()."\n";//获取错误信息
   echo "RequestId : ".$e->getRequestId()."\n"; //获取请求ID
   echo "requestResource : ".$e->getResource()."\n";//获取请求资源
} catch (Exception $e) {
	echo "Error Code : ".$e->getCode()."\n";
	echo "Error Message : ".$e->getMessage()."\n";
}

```


### Demo
完整的使用案例：
```php
require_once dirname(__FILE__).'/../sdk/JingdongStorageService.php';
$service = new JingdongStorageService("ACCESS_KEY","ACCESS_SECRET");
$bucket = "your bucket"
$local_file = '/path/to/your/local/file';
$key = "logo.png";
try{
	// list bucket
	$service->list_buckets();  
	//create new  bucket
	$service->put_bucket($bucket);
	//put object
	$service->put_object($bucket,$key,$local_file);
	//head object
	$service->head_object($bucket,$key);
	//get object
	$service->get_object($bucket,$key,dirname(__FILE__) . "/".$key);
	//get pre-sign url
	$url = $service->get_object_resource($bucket,$key);
        echo "url for {$bucket}/{$key} :".$url."\n";
	     
	// list objects
	$jss_entity = $service->list_objects($bucket); 
        $object_list = $jss_entity->get_object();
	foreach($object_list as $object){
		// delete object
	    $service->delete_object($bucket,$object->get_key()); 
	    echo "Delete object {$object->get_key()} success!\n";
	}
	// delete bucket
	$service->delete_bucket($bucket);
    } catch (JSSError $e) {
	   echo "HTTP Code : ".$e->getCode()."\n"; //获取http返回错误码
	   echo "Error Code : ".$e->getErrorCode()."\n";  //获取错误信息码
	   echo "Error Message:".$e->getErrorMessage()."\n";//获取错误信息
	   echo "RequestId : ".$e->getRequestId()."\n"; //获取请求ID
	   echo "requestResource : ".$e->getResource()."\n";//获取请求资源
	   
	} catch (Exception $e) {
		echo "Error Code : ".$e->getCode()."\n";
		echo "Error Message : ".$e->getMessage()."\n";
	
	}
```
