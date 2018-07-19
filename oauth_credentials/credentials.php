<?php
//Credentials for Google OAUTH API

$client_id = '4557ent.com'; // Client ID
$client_secret = 'YDivXE'; // Client secret

//THE URL to redirect after Google authorization
$redirect_uri = 'http://localhost/google-oauth/index.php'; // Redirect URI  //my-> must be with final page id {index.html} or it crashes(if u specify it with final page in console)

//The URL to go after log out of Google
$link_to_back_after_log_out ='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/google-oauth/php_scripts/log_out.php?status=OFF';
?>
