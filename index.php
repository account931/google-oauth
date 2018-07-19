<?php
session_start();
//for server edition change  -> // $redirect_uri + If we get result, we print user's account detail
// URL to set URL permission
//https://console.developers.google.com/apis/credentials?project=my-projecttrue-1528741703164&folder&organizationId


// Turn off error reporting
error_reporting(0);

//works on Local, crashed on ZZZ, was transferred to example2.esy.es as ZZZ doesnot support CURL for free
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>OAUTH 2</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>        <!--Bootstrap-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><!--Bootstrap-->
	<link rel="stylesheet" type="text/css" media="all" href="css/myOauth.css">
	
	 <!--Favicon-->
     <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>

<?php
//include Google credentails in separate file to easily manipulate with localhost/Hostinger Server settings
include 'oauth_credentials/credentials.php';

include 'Classes/autoload.php';//uses autoload instead of manual includin each class-> Error if it is included in 2 files=only1 is accepted



//Bellow credentials are moved  to {oauth_credentials/credentials.php}
/* 
$client_id = '4557tent.com'; // Client ID
$client_secret = 'YXE'; // Client secret
$redirect_uri = 'http://localhost/google-oauth/index.php'; // Redirect URI  //my-> must be with final page id {index.html} or it crashes
*/

$url = 'https://accounts.google.com/o/oauth2/auth';


//setting array with params
$params = array(
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code',
    'client_id'     => $client_id,
    'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
);


 
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
  
 
  
 
  
  
  
//if u clicked the link to authorize and Google returned your url with attached Google code
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

// END OAUTH API SECTION----------------------------------------------------------------------------------------------------











// DISPLAY SECTION----------------------------------------------------------------------------------------------------
   
  
 // LOGGED USER SECTION------------------------------
 //LOG-OUT button (redirects after Google log-out to php_scripts/log_out.php), only appears/visible if Session is set
  //DispalyUserInfo::showLogOutButton();
  
  
  if (isset($_SESSION['user'])){
	  echo "<div class='col-md-6 col-xs-6'>";
	  echo "<br> &nbsp;Hello, " . $_SESSION['user']['name']. "!";
	  echo "<br><a href=" . $link_to_back_after_log_out . "><input type='button' id='' class='btn btn-large' value='Log out, " . $_SESSION['user']['name'] . "'?/></a><br><br>";
      
  }  
  
  //END LOG-OUT button (redirects after Google log-out to php_scripts/log_out.php), only appears/visible if Session is set


  
  

   //USER"S PROFILE
  // If we get result, we print user's account fields, instead of array $userInfo, we use Session $_SESSION['user'], so data won't disappear on reload
  //DispalyUserInfo::showUserInfo();
  
  if ($result) {
	//log out button (redirects after Google log-out to php_scripts/log_out.php)
    //echo "<br><a href='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/google-auth/php_scripts/log_out.php?status=OFF'><input type='button' id='' value='Log out'/></a><br><br>";

    echo "Social user ID : " . $_SESSION['user']['id'] . '<br />';             // $userInfo['id'] 
    echo "User name: " . $_SESSION['user']['name'] . '<br />';                 // $userInfo['name'] 
    echo "Email: " . $_SESSION['user']['email'] . '<br />';                    // $userInfo['email'] 
    echo "User's profiel link: " . $_SESSION['user']['link'] . '<br />';       // $userInfo['link']
    echo "Gender: " . $_SESSION['user']['gender'] . '<br />';                  // $userInfo['gender']
	echo "Language: " . $_SESSION['user']['locale'] . '<br />';                // $userInfo['locale'] 
    echo '<img src="' . $_SESSION['user']['picture'] . '" />'; echo "<br />";  // $userInfo['picture'] 
	
  
  // END If we get result, we print user's account detail
 //END USER"S PROFILE
  
  echo "</div>";
  
  //right div with img
  echo  "<div class='col-md-6 col-xs-6'>";
      echo "<img src='images/g5.jpg' alt='' align='right' style='width:40%;margin-right:35%;margin-top:85px;'/>";
	  
  echo "</div>";
  }
  
  // END LOGGED USER SECTION------------------------------
  
  
  
  
  
  // UNLOGGED USER SECTION-------------------------------
  //if  NO session exists, display LOG IN button SIGN BAnner
   if ((!$_GET)|| ($_GET['status']=="OFF")) { // if (!isset($_SESSION['user'])){
      // Link to Google OAUTH URL
      echo "<br><br><center><div class='myShadow' style='width:30%; background:grey;padding:20px;margin: 0 auto;'>";
      echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Go oAuth 2.0 via Google</a></p>';
      echo "</div>";
	  echo "<img src='images/g1.jpg' alt='' style='width:30%;margin-top:32px;'/></center>";
  } 
  // END UNLOGGED USER SECTION-------------------------------
  
 
  
  
  
  
  
  
  
  
 

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
