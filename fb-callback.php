<?php

require_once("config.php"); 
require_once 'vendor/autoload.php';
$fb = new Facebook\Facebook ([
  'app_id' => 6591072854245159, // ID ứng dụng
  'app_secret' => 'c50016b66760bd3a0e8bdc57e9bc7e5b', // Khóa bí mật của ứng dụng
  'default_graph_version' => 'v16.0', // UPDATE V MỚI NHẤT
  ]);
  
$domain = 'https://tranhoangtrung.click/fb-callback.php'; // LINK CALLBACK GỬI LÊN PHẢI TRÙNG VỚI LINK ĐÃ CẬP NHẬP TRONG FACEBOOK
$helper = $fb->getRedirectLoginHelper();
if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}
 
try {
$accessToken = $helper->getAccessToken($domain);
//$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
 
if (! isset($accessToken)) {
     
    $permissions = array('public_profile','email'); // Optional permissions
    $loginUrl = $helper->getLoginUrl($domain,$permissions);
    header("Location: ".$loginUrl);  
  exit;
}
 
try {
  // Returns a `Facebook\FacebookResponse` object
  $fields = array('id', 'name', 'email');
//  $response = $fb->get('/me?fields='.implode(',', $fields).'', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$response = $fb->get('/me?fields=id,name,email,gender', $accessToken);
$fb_name = $response->getGraphUser()['name'];
$email = $response->getGraphUser()['email'];
$fb_id = $response->getGraphUser()['id'];
$sex = $response->getGraphUser()['sex'];

$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$api = mt_rand(10000, 99999). substr(str_shuffle($chars), 0, 8);;
$api = sha1($api);
$time = time();
$passmd5 = md5($fb_id);
 

if($check_number == '1'){
   echo "tontai";
}
else{
echo "0tontai";
}
 


?>