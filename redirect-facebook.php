<?php
require_once 'vendor/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '859231911843080', // Replace {app-id} with your app id
  'app_secret' => '5e9ed4eae289701f86863d273f1ffd90',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://localhost/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';?>