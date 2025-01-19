<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'functions.php';

$result = "";
$action = "";


//Build html Page
//======================================================================================================Header
$html = "
<html>
    <head>
        <title></title>
        <link href='NRWStart.css' rel='stylesheet' type='text/css'/>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>		
				
    </head>
    <body>";
	
//======================================================================================================Body
			//---------------------------------------------------------------------Controls on the left
		$html .= "
		<div id='container'>
			<div id='logo'><img src='images/StartLogo.png' alt='No Resin Why' style='max-width:100%;height:auto;'></div><br>
			
					
			<div class='menu'>
					<a href='login.php?site=ops'><div class='button'>Operations Site</div></a>br
					<a href='login.php?site=sho'><div class='button'>Craft Show Site</div></a><br>
					<a href='login.php?site=mbl'><div class='button'>Mobile Site</div></a><br>
			</div>
		</div>

	</body>
</html>";

echo $html
?>
