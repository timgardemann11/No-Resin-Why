<?php

include 'functions.php';
session_start();

//Pull variables from URL variables
if (isset($_GET['contentURL'])) {
    $contentURL = $_GET['contentURL'];

} else {
    $contentURL = "";
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
    				<ul>
    					<li><a href='default.php'>Expenses</a></li>
    					<li><a href='default.php'>Inventory</a></li>
    					<li><a href='default.php'>Sales</a></li>
    					<li><a href='default.php'>Molds</a></li>
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
	    					<li><a href='default.php'>Add New Expense</a></li>
	       					<li><a href='default.php'>Add New Item</a></li>
	    					<li><a href='default.php'>Mark Items as Sold</a></li>
	    					<li><a href='default.php'>Add Mold</a></li>
	       					<li><a href='default.php'>Add Vendor</a></li>
	        		</ul>
				</div>
			</div>";
        
    $html .= "</body>
</html>";

echo $html
?>
