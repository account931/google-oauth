Google OAUTH API, authorization elsewhere using Google account
#folder {oauth_credentials} contains fields data, like Client ID, secret, redirection URI, to more easily manipulate with localhost/Hostinger Server settings
#

How it works
1. On start, appears a LOG IN button, URL to which is created by string "https://accounts.google.com/o/oauth2/auth" + $params[] (that includes Client ID, secret, redirection URI)
2. After clicking the button, Google Api returns back to Start URL + $_GET['code'].
3. If $_GET['code'] is isset, we add $_GET['code'] to array $params[], then php uses CURL to address new URL {https://accounts.google.com/o/oauth2/token} + updated $params[] (that now contains $_GET['code'] + Client ID, secret, redirection URI)
4. If $tokenInfo['access_token'] is returned, we add access_token to array $params[], then we use CURL to address {https://www.googleapis.com/oauth2/v1/userinfo} + updated $params[](that now includes access_token $_GET['code'] + Client ID, secret, redirection URI) 

------------------------------------
REDIRECT URLs to your page(from /oauth_credentials/)  must be added to console in 2 sections. Section 2->(https://console.developers.google.com/apis/credentials/oauthclient/455*******-********50rp2dpumai16.apps.googleusercontent.com?project=455*******9)
Redirect URL must ends with  http://*********/index.php
------------------------------------

Due to cURL crash is not supported on zzz. Therefore moved to http://dimmm931.000webhostapp.com/google-oauth