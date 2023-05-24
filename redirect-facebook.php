<?php
require_once 'vendor/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '6591072854245159', // Replace {app-id} with your app id
  'app_secret' => 'c50016b66760bd3a0e8bdc57e9bc7e5b',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://tranhoangtrung.click/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>