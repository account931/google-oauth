<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>OAUTH 2</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<?php
$client_id = '45575957082dpumai16.apps.googleusercontent.com'; // Client ID
$client_secret = 'YDihhhh'; // Client secret
$redirect_uri = 'http://localhost/google-auth/index.php'; // Redirect URI  //my-> must be with final page id {index.html} or it crashes

$url = 'https://accounts.google.com/o/oauth2/auth';

$params = array(
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code',
    'client_id'     => $client_id,
    'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
);


   // if user logout it was redirected with $_GET['status']?status=OFF
   if (isset($_GET['status'])) {
	  //unset ($_SESSION['user']);
	  //header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
	  session_destroy();
	  //header('Location: '.$_SERVER['PHP_SELF']);
      //die;
  }
  
/*
  //if session exists
  if (!isset($_SESSION['user'])){
      // Link to Google OAUTH URL
      echo "<br><br><div style='width:30%; background:grey;padding:20px;margin: 0 auto;'><center>";
      echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Google</a></p>';
      echo "</center></div>";
  } 
  if (isset($_SESSION['user'])){
	  echo "<a href='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/google-auth/index.php?&status=OFF'><input type='button' id='' value='Log out if{}else'/></a><br><br>";
      echo "<br>Sure Wanna log out " . $_SESSION['user'][name]. "?";
  }  

  
  */
  
 
  
 
  
  
  

if (isset($_GET['code'])) {
    $result = false;

    $params = array(
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri'  => $redirect_uri,
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code']
    );

    $url = 'https://accounts.google.com/o/oauth2/token';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);
    $tokenInfo = json_decode($result, true);

    if (isset($tokenInfo['access_token'])) {
        $params['access_token'] = $tokenInfo['access_token'];
		
		
		
		
		//my custom function, have to use CURL instead of {file_get_content} as it has issues with SSl 
		//-------------------------------
		
		function curl_get_contents($url)
        {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            $data = curl_exec($curl);
            curl_close($curl);
            return $data;
       }
		//-----------------

        //$userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
		  $userInfo = json_decode(curl_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);

        if (isset($userInfo['id'])) {
            $userInfo = $userInfo;
            $result = true; 
			
			//creates a session with user's info
            $_SESSION['user'] = $userInfo;
			
			//echo "true <br>";
			//var_dump( $userInfo ). "<br>";
        }
    }
}

  // If we get result, we print user's account detail
  if ($result) {
    echo "<br><a href='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/google-auth/index.php?status=OFF'><input type='button' id='' value='Log out'/></a><br><br>";

    echo "Social user ID : " . $userInfo['id'] . '<br />';
    echo "User name: " . $userInfo['name'] . '<br />';
    echo "Email: " . $userInfo['email'] . '<br />';
    echo "User's profiel link: " . $userInfo['link'] . '<br />';
    echo "Gender: " . $userInfo['gender'] . '<br />';
	echo "Language: " . $userInfo['locale'] . '<br />';
    echo '<img src="' . $userInfo['picture'] . '" />'; echo "<br />";
	
  }
  // END If we get result, we print user's account detail

  
  
  
  
  
  
  
  
  //if session exists
  if (!isset($_SESSION['user'])){
      // Link to Google OAUTH URL
      echo "<br><br><div style='width:30%; background:grey;padding:20px;margin: 0 auto;'><center>";
      echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Google</a></p>';
      echo "</center></div>";
  } 
  if (isset($_SESSION['user'])){
	  echo "<a href='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/google-auth/index.php?&status=OFF'><input type='button' id='' value='Log out if{}else'/></a><br><br>";
      echo "<br>Sure Wanna log out " . $_SESSION['user'][name]. "?";
  }  

  
  
  

?>




<script>
//redirect on Log out
  /*
 var logout = function() {
    document.location.href = "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/google-auth";
}

$(document).ready(function(){
    $("#logOut").click(function(){
		logout();
        //$(this).hide();
    });
});
  */
</script>
</body>
</html>
