<?php
session_start();
//This sccript makes log-out and redirects back to ../index.php

// if user logout it was redirected with $_GET['status']?status=OFF
	 
   if (isset($_GET['status'])) {
	   unset ($_SESSION['user']);
	  //header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
	  session_destroy();
	  
	  //gets the parent folder(i.e "localhost/google-auth") to redirect back to up folder. It gets parent folder, but not used!!!!
      $parts = explode("/",ltrim($_SERVER['SCRIPT_NAME'],"/"));
      $parent = $_SERVER['HTTP_HOST'] . "/" . $parts[0];
  
  
      //redirect to up parent folder
	  //header('Location: ' . $parent);
	  header("Location: ../index.php");
	  //echo $_SERVER['PHP_SELF'];
      die;
   }

 ?>
  