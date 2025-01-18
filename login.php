<?php

include 'functions.php';

$trys = $_GET["trys"];

if (isset($_GET['site'])) {
    $site = $_GET['site'];

}

//Build Logon Page
$html = "

<head>

<title>Logon Page</title>

<link href='NRWLogon.css' rel='stylesheet' type='text/css'/>

</head>

<body>";

//Set starting login trys to 0
if(isset($trys) === false) {
    $trys = 0;
}

//Build html based on number of trys
if ($trys > 5) {
    $html .= "<div id='lock'>Login Failed!  Your account is locked, Please try again later.</div>";
} else if ($trys > 0) {
    
    $html .= "
        <div id='frm'>
            <form action='processlogin.php' method='post'>
            <P class='logbar'>
                Customer Login
            </p>
            
            <P>
                <label>&nbsp;&nbsp;Username:</label>
                <input type='text' id='user' name='user'/>
            </p>
            <P>
                <label>&nbsp;&nbsp;Password:&nbsp;</label>
                <input type='password' id='pass' name='pass'/>
            </p>
            <P>
                <input type='hidden' id='attempts' value={$trys} name='attempts'/>
            </p>
            <P>
                <input type='submit' id='btn' value='login'/>
                
            </p>
            <br>
            <p id='fail'>Login Failed!&nbsp;&nbsp;&nbsp;Attempt Number: {$trys}&nbsp;&nbsp;of&nbsp;&nbsp;5.</p>
            </form>
        </div>

    <br>";
    

} else if ($trys == 0) {
    $html .= "
        <div id='frm'>
            <form action='processlogin.php?site=$site' method='post'>
            <P class='logbar'>
                Customer Login
            </p>
            <P>
                <label>&nbsp;&nbsp;Username:</label>
                <input type='text' id='user' name='user'/>
            </p>
            <P>
                <label>&nbsp;&nbsp;Password:&nbsp;</label>
                <input type='password' id='pass' name='pass'/>
            </p>
            <P>
                <input type='hidden' id='attempts' value={$trys} name='attempts'/>
            </p>
            <P>
                <input type='submit' id='btn' value='login'/>
            </p>
            </form>
        </div>

    <br>";
}
echo $html;







?>