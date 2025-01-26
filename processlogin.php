<?php

    include 'functions.php';

    session_start();

	//Get values passed from form in login.php file
	$username = $_POST['user'];
	$password = $_POST['pass'];
    

    $attempts = $_POST['attempts'];
    $attempts = $attempts + 1;

	// to prevent sql injection
	$username = stripcslashes($username);
	$password = Stripcslashes($password);

    $result = logindata($username,$password);
    
    $resultparts = explode("^",$result);
    
    if (isset($_GET['site'])) {
    	$site = $_GET['site'];
	} else {
		$site = 'ops';
	}
	
    if (isset($result)) {
 
       $_SESSION["user"]=$resultparts[0];
       $_SESSION['title']=$resultparts[1];

       switch ($site) {
       	case 'ops':
       		header("location:default.php");
       		break;
       	case 'sho':
       		header("location:show.php");
       		break;
		case 'mbl':
       		header("location:mobile.php");
       		break;
		}
       //echo "$result";
    } else {
        
        header("location:login.php?site=$site&trys={$attempts}&data=$result");
        //echo "$user $attempts";   ?storesowned={$result}
    }
?>