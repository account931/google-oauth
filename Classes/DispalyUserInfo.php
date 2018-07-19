<?php
 Class DispalyUserInfo
 {
	 
	 
  // Shows User's Google profile info
  // **************************************************************************************
  // **************************************************************************************
  //                                                                                     **  
   
    public static function showUserInfo()
    { 
	    
         //USER"S PROFILE
        // If we get result, we print user's account fields, instead of array $userInfo, we use Session $_SESSION['user'], so data won't disappear on reload
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
	}
   
  // **                                                                                  **
  // **************************************************************************************
  // **************************************************************************************
 

 
 
 
 
 
  
   // display Log OUT Button
  // **************************************************************************************
  // **************************************************************************************
  //                                                                                     **  
   
    public static function showLogOutButton()
    { 
	    
         // LOGGED USER SECTION------------------------------
        //LOG-OUT button (redirects after Google log-out to php_scripts/log_out.php), only appears/visible if Session is set
       if (isset($_SESSION['user'])){
	       echo "<div class='col-md-6 col-xs-6'>";
	       echo "<br> &nbsp;Hello, " . $_SESSION['user']['name']. "!";
	       echo "<br><a href=" . $link_to_back_after_log_out . "><input type='button' id='' class='btn btn-large' value='Log out, " . $_SESSION['user']['name'] . "'?/></a><br><br>";
           echo "<br>Link " . $link_to_back_after_log_out;
       }  
       //END LOG-OUT button (redirects after Google log-out to php_scripts/log_out.php), only appears/visible if Session is set
	}
   
  // **                                                                                  **
  // **************************************************************************************
  // **************************************************************************************


}
?>