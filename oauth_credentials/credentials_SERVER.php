<?php
//Credentials for Google OAUTH API, strictly for HOSTINGER.COM

$client_id = '455759570869-sfbuti1gc4np3556sua50rp2dpumai16.apps.googleusercontent.com'; // Client ID
$client_secret = 'YDivYuAd3hOQF4o9RBNj9WXE'; // Client secret

//THE URL to redirect after Google authorization
$redirect_uri = 'http://example2.esy.es/google-oauth/index.php'; // Redirect URI  //my-> must be with final page id {index.html} or it crashes(if u specify it with final page in console)

//The URL to go after log out of Google
$link_to_back_after_log_out ='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://example2.esy.es/google-oauth/php_scripts/log_out.php?status=OFF';
?>