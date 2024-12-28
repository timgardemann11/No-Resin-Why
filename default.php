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
    $html = "
    <html>
    <head>
        <title></title>
        <link href='KatiesDoughnuts.css' rel='stylesheet' type='text/css'/>
    </head>
    <body>
    <div id='main'>
    	<table class='top'>
    		<tr>
    			<td><img src='Doughnut.png' alt='Love Doughnuts' style='width:100px;'></td>
    			<td><div id='site'>Katie&apos;s Doughnuts</div></td>
    			<td><div class='menu'>
    				<ul>
    					<li><a href='default.php'>Toppings</a></li>
    					<li><a href='default.php'>Specialty Doughnuts</a></li>
    					<li><a href='default.php'>About Us</a></li>
    				</ul>
    			<td>
        		<td><div id='catchphrase'>Get Yours Today! 555.123.5555&nbsp;&nbsp;</div></td>
        		<td><div class='round'><a href='default.php?contentURL=login'>Login to Order Online</a></div><td>
        	</tr>
        </table>
    </div>";

	if ($contentURL != "") {
        $html .= "<iframe class='iframeclass' id='content' name='content' seamless src='{$contentURL}.php' frameborder='0' marginheight='0' marginwidth='0' runat='server' z-index: 1000>
				    Your browser does not support inline frames or is currently configured not to display inline frames.
	    </iframe>";
    }   

        
    $html .= "</body>
</html>";

echo $html
?>
