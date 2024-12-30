<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'functions.php';
include 'Calendar.php';

$calendar = new Calendar('2024-12-12');
$calendar->add_event('Holiday', '2024-12-15');
session_start();


//Get Left Tab Variable
if (isset($_GET['toptab'])) {
    $toptab = $_GET['toptab'];

} else {
    $toptab = "INV";
}

//Get search Post
if (isset($_POST['search'])) {
    $search = $_POST['search'];

} else {
    $search = "";
}


//Get Action Variables
if (isset($_GET['action'])) {
    $action = $_GET['action'];

} else {
    $action = "";
}



//Build html Page
//======================================================================================================Header
$html = "
<html>
    <head>
        <title></title>
        <link href='NRW.css' rel='stylesheet' type='text/css'/>
        <link rel='stylesheet' href='//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
        
        <script src='https://code.jquery.com/jquery-1.12.4.js'></script>
		<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>

        <script>
			$( function() {
			$( '#datepicker' ).datepicker();
			$( '#datepicker2' ).datepicker();
			} );
		</script>

    </head>
    <body>

	    <div id='main'>
	    	
	    		<div id='logo'>&nbsp;&nbsp;<img src='images/SiteLogo.png' alt='No Resin Why' style='width:120px;'></div>
	    		<div id='site'>&nbsp;&nbsp;&nbsp;&nbsp;No Resin Why Operations</div>
    			<div class='menu'>";
    						if($toptab == 'EXP') {
	    						$html .= "<div class='menuactive' style='background-color:#C00000;'><a style='color:white' href='default.php?toptab=EXP'>Expenses</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#C00000;'><a href='default.php?toptab=EXP'>Expenses</a></div>";
	    					}
	    					if($toptab == 'INV') {
	    						$html .= "<div class='menuactive' style='background-color:#4D93D9;'><a style='color:white' href='default.php?toptab=INV'>Inventory</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#4D93D9;'><a href='default.php?toptab=INV'>Inventory</a></div>";
	    					}
							if($toptab == 'SAL') {
	    						$html .= "<div class='menuactive' style='background-color:#4EA72E;'><a style='color:white' href='default.php?toptab=SAL'>Sales</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#4EA72E;'><a href='default.php?toptab=SAL'>Sales</a></div>";
	    					}
							if($toptab == 'MLD') {
	    						$html .= "<div class='menuactive' style='background-color:#F47E28;'><a style='color:white' href='default.php?toptab=MLD'>Molds</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#F47E28;'><a href='default.php?toptab=MLD'>Molds</a></div>";
	    					}
							if($toptab == 'VDR') {
	    						$html .= "<div class='menuactive' style='background-color:#9F6CF4;'><a style='color:white' href='default.php?toptab=VDR'>Vendors</a></div>";
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
			//---------------------------------------------------------------------Company Metrics and Calendar
			
			$html .= "
			<div id='metrics'>
				<div class='metricsdata'>Result of Operations<br>
				<div style='font-size:medium;color:white;background-color:#4EA72E;width:95%;'>Income</div>
				<span style='font-size:medium;'>Sales . . . . . . . . . . . $500.00</span><br>
				<span style='font-size:medium;'>Other Income. . . . . $500.00</span><br>
				<span style='font-size:medium;font-weight:bold;'>Total Income. . . . . . . . . . $500.00</span><br><br>
				
				<div style='font-size:medium;color:white;background-color:#C00000;width:95%;'>Expenses</div>
				<span style='font-size:medium;'>Molds . . . . . . . . . . . $500.00</span><br>
				<span style='font-size:medium;'>Color. . . . . . . . . . . . $500.00</span><br>
				<span style='font-size:medium;'>Embedded . . . . . . . $500.00</span><br>
				<span style='font-size:medium;'>Resin . . . . . . . . . . . $500.00</span><br>
				<span style='font-size:medium;'>Show Fees. . . . . . . $500.00</span><br>
				<span style='font-size:medium;'>Overhead. . . . . . . . $500.00</span><br>
				<span style='font-size:medium;'>Displays. . . . . . . . . $500.00</span><br>
				<span style='font-size:medium;font-weight:bold;'>Total Expenses. . . . . . . . . . $500.00</span><br><br>
				<div style='font-size:medium;color:white;background-color:#4D93D9;width:95%;'>Profit / Loss</div>
				<span style='font-size:medium;font-weight:bold;'>Total Profit/Loss. . . . . . . . . . $500.00</span><br><br>
				</div>
				<div class='calendar'>Upcomming Events:
				
					
				</div>	
				
	
				
			</div>
			
			
			
			
			<div id='data'>";
			//---------------------------------------------------------------------Data based on Top Tabs
			switch ($toptab) {
			
				case 'EXP':
					$html .= "
					<div class='Expense'>
						<div class='datascroll'>";
							$return = Expenses($search);
							$parts = explode("^",$return);
							$html .= $parts[0];
							$html .= "
						</div>
						<div style='float:right;display:inline-block;padding-right:20px;font-size:medium;color:white'>";
							if($search == ""){$html .= "Showing all Expenses<br>";} else {$html .= "Showing Expenses for search: <span style='font-weight:bold;'>$search</span><br>";}
							$html .= "<br>
						 	<form action='Default.php?toptab=$toptab' method='post' enctype='multipart/form-data'>
								<div class='scontainer'>
								    <div class='InputContainer'>
								    	<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='#657789' stroke-width='3' stroke-linecap='round' stroke-linejoin='round' class='feather feather-search'><circle cx='11' cy='11' r='8'/><line x1='21' y1='21' x2='16.65' y2='16.65'/></svg>
								      <input name='search' id='search' placeholder='Serch Expenses...'/>
								      <input type='submit' value='Search' name='search1'>
								    </div>
								</div>
							</form><br>
							<div>
								Total of Displayed Expenses:  <span style='font-weight:bold;'>$parts[1]</span>
							</div>
						 </div>
						
						
					</div>";

					break;
				case 'INV':
					
					break;
				case 'SAL':
					
					break;
				case 'MLD':
					$html .= "
					<div class='Mold'>
						<div class='datascroll'>";
							$return = Molds($search);
							$parts = explode("^",$return);
							$html .= $parts[0];
							$html .= "
						</div>
						<div style='float:right;display:inline-block;padding-right:20px;font-size:medium;color:white'>";
							if($search == ""){$html .= "Showing all Molds<br>";} else {$html .= "Showing Molds for search: <span style='font-weight:bold;'>$search</span><br>";}
							$html .= "<br>
						 	<form action='Default.php?toptab=$toptab' method='post' enctype='multipart/form-data'>
								<div class='scontainer'>
								    <div class='InputContainer'>
								    	<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='#657789' stroke-width='3' stroke-linecap='round' stroke-linejoin='round' class='feather feather-search'><circle cx='11' cy='11' r='8'/><line x1='21' y1='21' x2='16.65' y2='16.65'/></svg>
								      <input name='search' id='search' placeholder='Serch Molds...'/>
								      <input type='submit' value='Search' name='search1'>
								    </div>
								</div>
							</form><br>
							<div>
								Count of Displayed Molds:  <span style='font-weight:bold;'>$parts[1]</span>
							</div>
						 </div>

					</div>";

					break;
				case 'VDR':
					$html .= "
					<div class='Vendor'>
						<div class='datascroll'>";
							$return = vendors($search);
							$parts = explode("^",$return);
							$html .= $parts[0];
							$html .= "
						</div>
						<div style='float:right;display:inline-block;padding-right:20px;font-size:medium;color:white'>";
							if($search == ""){$html .= "Showing all Vendors<br>";} else {$html .= "Showing Vendors for search: <span style='font-weight:bold;'>$search</span><br>";}
							$html .= "<br>
						 	<form action='Default.php?toptab=$toptab' method='post' enctype='multipart/form-data'>
								<div class='scontainer'>
								    <div class='InputContainer'>
								    	<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='#657789' stroke-width='3' stroke-linecap='round' stroke-linejoin='round' class='feather feather-search'><circle cx='11' cy='11' r='8'/><line x1='21' y1='21' x2='16.65' y2='16.65'/></svg>
								      <input name='search' id='search' placeholder='Serch Vendors...'/>
								      <input type='submit' value='Search' name='search1'>
								    </div>
								</div>
							</form><br>
							<div>
								Count of Displayed Vendors:  <span style='font-weight:bold;'>$parts[1]</span>
							</div>
						 </div>

					</div>";

					break;
			}
	
			$html .= "
			</div>
		</div>";
		
		
		#======================================================================================================Hidden Forms
		
		if($action <> ""){
			$html .= "<div class='action'></div>
			<div class='form'>
				
				<div class='exit'><a href='default.php?toptab=$toptab'>Exit</a></div>
				<div class='formtitle'>Add Expenses</div>
				<div>
					<form action='Default.php?toptab=$toptab' method='post' enctype='multipart/form-data'>
						<input type='text' id='datepicker'>
					</form>	
			</div>";
		}
		
		$html .= "
	</body>
</html>";

echo $html
?>
