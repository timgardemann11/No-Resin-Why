<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'functions.php';
session_start();

//Pull variables from URL variables
if (isset($_GET['contentURL'])) {
    $contentURL = $_GET['contentURL'];

} else {
    $contentURL = "";
}

//Get Left Tab Variable
if (isset($_GET['toptab'])) {
    $toptab = $_GET['toptab'];

} else {
    $toptab = "INV";
}


//Build html Page
//======================================================================================================Header
    $html = "
    <html>
    <head>
        <title></title>
        <link href='NRW.css' rel='stylesheet' type='text/css'/>
    </head>
    <body>
    <div id='main'>
    	<table class='top'>
    		<tr>
    			<td><img src='images/Logo.png' alt='No Resin Why' style='width:100px;'></td>
    			<td><div id='site'>No Resin Why Operations</div></td>
    			<td><div class='menu'>
    				<ul>";
    					if($toptab == 'EXP') {
	    						$html .= "<li style='background-color:#C00000;'><a href='default.php?toptab=EXP'>Expenses</a></li>";
	    					} else {
	    						$html .= "<li style='background-color:#C00000;'><a href='default.php?toptab=EXP'>Expenses</a></li>";
	    					}
	    					if($toptab == 'INV') {
	    						$html .= "<li style='background-color:#4D93D9;'><a href='default.php?toptab=INV'>Inventory</a></li>";
	    					} else {
	    						$html .= "<li style='background-color:#4D93D9;'><a href='default.php?toptab=INV'>Inventory</a></li>";
	    					}
							if($toptab == 'SAL') {
	    						$html .= "<li style='background-color:#4EA72E;'><a href='default.php?toptab=SAL'>Sales</a></li>";
	    					} else {
	    						$html .= "<li style='background-color:#4EA72E;'><a href='default.php?toptab=SAL'>Sales</a></li>";
	    					}
							if($toptab == 'MLD') {
	    						$html .= "<li style='background-color:#F47E28;'><a href='default.php?toptab=MLD'>Molds</a></li>";
	    					} else {
	    						$html .= "<li style='background-color:#F47E28;'><a href='default.php?toptab=MLD'>Molds</a></li>";
	    					}
							if($toptab == 'VDR') {
	    						$html .= "<li style='background-color:#9F6CF4;'><a href='default.php?toptab=VDR'>Vendors</a></li>";
	    					} else {
	    						$html .= "<li style='background-color:#9F6CF4;'><a href='default.php?toptab=VDR'>Vendors</a></li>";
	    					}
						$html .= "
    				</ul>
    			<td>
        		<td><div id='catchphrase'>Get Yours Today! 555.123.5555&nbsp;&nbsp;</div></td>
        		<td><div class='round'><a href='default.php?contentURL=login'>Login to Order Online</a></div><td>
        	</tr>
        </table>
    </div>";

//======================================================================================================Body
	$html .= "<div id='controls'><br>
			
       			<div class='sidemenu'>
	       			<ul>
	       					<li><a href='default.php?action=EXP&toptab=$toptab'>Add New Expense</a></li>
	       					<li><a href='default.php?acion=ITM&toptab=$toptab'>Add New Item</a></li>
	    					<li><a href='default.php?action=SLD&toptab=$toptab'>Mark Items as Sold</a></li>
	    					<li><a href='default.php?action=MLD&toptab=$toptab'>Add New Mold</a></li>
	    					<li><a href='default.php?actopm=VDR&toptab=$toptab'>Add New Vendor</a></li>
	    					
	        		</ul>
				</div>
			</div>";
        
    $html .= "</body>
</html>";

echo $html
?>
