<?php
require_once 'vendor/autoload.php';
require_once("config.php");
// init configuration 
$clientID = '479994957114-08vqe42eo7ad9vggfnm2u89irne57s4b.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/Ecommerce-Website-main/redirect-login.php';
  
// create Client Request to access Google API 
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
 
// authenticate code from Google OAuth Flow 
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);
    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();
    $email = $userInfo->email;
    $name = $userInfo->name;
    // echo $name;
    $row = get_count_user_google($email,$name);
    // echo $row;
    // echo $email;
        if($row==0){
          add_user_google($email,$name);
        }
        if($row>0){
        $_SESSION['user_id'] ='GG.'.get_id_user_google($email,$name);
				$_SESSION['username'] = $name;
        echo get_id_user_google($email,$name);
        header('location:homepage.php');
        }
    
} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
?>