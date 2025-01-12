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
    
    if (isset($_GET['site'])) {
    	$site = $_GET['site'];
	}


    if (isset($result)) {
       //$_SESSION["owned"]=$result;
       $_SESSION["user"]=$result;
       //header("location:breakFrame.php");
       switch ($site) {
       	case 'ops':
       		header("location:Default.php");
       		break;
       	case 'sho':
       		header("location:Default.php");
       		break;
		case 'mbl':
       		header("location:Default.php");
       		break;
		}
       //echo "$result";
    } else {
        
        header("location:login.php?site=$site&trys={$attempts}&data=$result");
        //echo "$user $attempts";   ?storesowned={$result}
    }
?>