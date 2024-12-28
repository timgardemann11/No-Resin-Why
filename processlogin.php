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

    if (isset($result)) {
       $_SESSION["owned"]=$result;
       header("location:breakFrame.php");
       //header("location:Default.php");
       //echo "$result";
    } else {
        
        header("location:login.php?trys={$attempts}");
        //echo "$user $attempts";   ?storesowned={$result}
    }
?>