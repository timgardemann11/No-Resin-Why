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
        <link href='NRW.css' rel='stylesheet' type='text/css'/>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>		
				
    </head>
    <body>";
	
//======================================================================================================Body
			//---------------------------------------------------------------------Controls on the left
		$html .= "
		<div id='startcontainer'>
			<div id='startlogo'>&nbsp;<img src='images/SiteLogo.png' alt='No Resin Why' style='width:180px;height:120px;'></div><br><br>
			<div id='startsite'><span style='font-size:medium;'>Where Resin Meets Inspiration</span></div>
					
			<div class='bigmenu'>
	   			<ul>
	   					<a href='login.php?site=ops'><li><br><br>Operations<br>Site</li></a>
	   					<a href='login.php?site=sho'><li><br><br>Craft Show<br>Site</li></a>
						<a href='login.php?site=mbl'><li><br><br>Moble<br>Site</li></a>	
	    		</ul>
			</div>
		</div>

	</body>
</html>";

echo $html
?>
