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
	    	
	    		<div id='logo'>&nbsp;&nbsp;<img src='images/SiteLogo.png' alt='No Resin Why' style='width:120px;'></div>
	    		<div id='site'>&nbsp;&nbsp;&nbsp;&nbsp;No Resin Why Operations</div>
    			<div class='menu'>";
    						if($toptab == 'EXP') {
	    						$html .= "<div class='menu' style='background-color:#C00000;'><a href='default.php?toptab=EXP'>Expenses</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#C00000;'><a href='default.php?toptab=EXP'>Expenses</a></div>";
	    					}
	    					if($toptab == 'INV') {
	    						$html .= "<div class='menu' style='background-color:#4D93D9;'><a href='default.php?toptab=INV'>Inventory</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#4D93D9;'><a href='default.php?toptab=INV'>Inventory</a></div>";
	    					}
							if($toptab == 'SAL') {
	    						$html .= "<div class='menu' style='background-color:#4EA72E;'><a href='default.php?toptab=SAL'>Sales</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#4EA72E;'><a href='default.php?toptab=SAL'>Sales</a></div>";
	    					}
							if($toptab == 'MLD') {
	    						$html .= "<div class='menu' style='background-color:#F47E28;'><a href='default.php?toptab=MLD'>Molds</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#F47E28;'><a href='default.php?toptab=MLD'>Molds</a></div>";
	    					}
							if($toptab == 'VDR') {
	    						$html .= "<div class='menu' style='background-color:#9F6CF4;'><a href='default.php?toptab=VDR'>Vendors</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#9F6CF4;'><a href='default.php?toptab=VDR'>Vendors</a></div>";
	    					}
						$html .= "
 	    		</div>
	        	
	      </div>";
	
		//======================================================================================================Body
			//---------------------------------------------------------------------Controls on the left
		$html .= "
		<div id='container'>
			<div id='controls'><br>
					
				<div class='sidemenu'>
		   			<ul>
		   					<li><a href='default.php?action=EXP&toptab=$toptab'>Add New Expense</a></li>
		   					<li><a href='default.php?acion=ITM&toptab=$toptab'>Add New Items</a></li>
							<li><a href='default.php?action=SLD&toptab=$toptab'>Mark Items as Sold</a></li>
							<li><a href='default.php?action=MLD&toptab=$toptab'>Add New Mold</a></li>
							<li><a href='default.php?action=MLD&toptab=$toptab'>Add Mold Size</a></li>
							<li><a href='default.php?actopm=VDR&toptab=$toptab'>Add New Vendor</a></li>
							<li><a href='default.php?actopm=VDR&toptab=$toptab'>Schedule Show</a></li>
							<li><a href='default.php?actopm=VDR&toptab=$toptab'>Add Calendar Event</a></li>

							
		    		</ul>
				</div>
			</div>";
			//---------------------------------------------------------------------Data based on Top Tabs
			
			$html .= "
			<div id='metrics'>
				<div class='metricsdata'> Metric Data Here</div>
				<div class='calendar'> Show Schedules and Calendar Here</div>		
				
			</div>
			
			
			
			
			<div id='data'>";
			
			switch ($toptab) {
			
				case 'EXP':
					$html .= "<div class='Expense'><div class='datascroll'>";
					$return = Expenses();
					$parts = explode("^",$return);
					$html .= $parts[0];
					$html .= "$parts[1]</div></div>";

					break;
				case 'INV':
					
					break;
				case 'SAL':
					
					break;
				case 'MLD':
					$html .= "<div class='Mold'><div class='datascroll'>";
					$html .= Molds();
					$html .= "</div></div>";

					break;
				case 'VDR':
					$html .= "<div class='Vendor'>";
					$html .= vendors();
					$html .= "</div>";
					break;
			}
	
			$html .= "
			</div>
		</div>
	</body>
</html>";

echo $html
?>
