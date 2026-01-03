<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'functions2.php';



session_start();

//############################################################################################################################################Get results of Posts and Gets

$result = "";

if (isset($_SESSION["user"])) {
	$user = $_SESSION["user"];
	$title = $_SESSION["title"];

} else {
	$user = "";
	$title = "";
}

if (isset($_GET['toptab'])) {
    $toptab = $_GET['toptab'];

} else {
    $toptab = "EXP";
}

//#############################################################################################################################################Build html Page

//=====================================================================================================================Page Headers and script

$html = "
<html>
    <head>
        <title></title>
        <link href='LHR.css' rel='stylesheet' type='text/css'/>
        <link rel='stylesheet' href='//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
        
        <script src='https://code.jquery.com/jquery-1.12.4.js'></script>
		<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>

        <script>
			$( function() {
			$( '#datepicker' ).datepicker();
			$( '#datepicker2' ).datepicker();
			} );
		</script>
		
				
    </head>";

//=====================================================================================================================Page Top and tabs

	$html .= "
 
    <body>
		<div id='left'>
			<div id='logo'>&nbsp;&nbsp;<img src='LHRimages/Logo.jpg' alt='No Resin Why' style='width:180px;'></div><br><br>
			<div class='sidemenu'>
	   			<ul>
	   					<li><a href='default.php?action=PRJ&toptab=$toptab'>Manage Projects</a></li>
	   					<li><a href='default.php?action=VND&toptab=$toptab'>Manage Vendors</a></li>
	   					<li><a href='default.php?action=SNT&toptab=$toptab'>Manage Contractors</a></li>
					
	    		</ul>
	    		$result
			</div>
		</div>
		
	    <div id='top'>
	    	
    		<div class='login'>
    			<table style='float:right;font-size:12px;'>
					<tr>
						<td rowspan='2'><img src='LHRimages/user.png' alt='No Resin Why' style='width:35px;'></td>
						<td>$user&nbsp;</td>
					</tr>
					<tr>
						<td>$title</td>
					</tr>
				</table>
	    	</div>
	    	
	    	<div id='site'>&nbsp;&nbsp;&nbsp;Legacy Home Renewal&nbsp;&nbsp;&nbsp;</div>
    			
			<div class='menu'>";
						if($toptab == 'COMP') {
    						$html .= "<div class='menuactive' style='background-color:#e8cf9e;'><a style='color:black' href='default2.php?toptab=COMP'>Comps & ARV</a></div>";
    					} else {
    						$html .= "<div class='menu'><a href='default2.php?toptab=COMP'>Comps & ARV</a></div>";
    					}
    					if($toptab == 'MAO') {
    						$html .= "<div class='menuactive' style='background-color:#e8cf9e;'><a style='color:black' href='default2.php?toptab=MAO'>Offer Calc MAO</a></div>";
    					} else {
    						$html .= "<div class='menu'><a href='default2.php?toptab=MAO'>Offer Calc MAO</a></div>";
    					}
    					if($toptab == 'BUD') {
    						$html .= "<div class='menuactive' style='background-color:#e8cf9e;'><a style='color:black' href='default2.php?toptab=BUD'>Repair Budget</a></div>";
    					} else {
    						$html .= "<div class='menu'><a href='default2.php?toptab=BUD'>Repair Budget</a></div>";
    					}
    					
    					
						if($toptab == 'HOL') {
    						$html .= "<div class='menuactive' style='background-color:#e8cf9e;'><a style='color:black' href='default2.php?toptab=HOL'>Holding & Selling Costs</a></div>";
    					} else {
    						$html .= "<div class='menu'><a href='default2.php?toptab=HOL'>Holding & Selling Costs</a></div>";
    					}
						if($toptab == 'FUND') {
    						$html .= "<div class='menuactive' style='background-color:#e8cf9e;'><a style='color:black' href='default2.php?toptab=FUND'>Molds</a></div>";
    					} else {
    						$html .= "<div class='menu'><a href='default2.php?toptab=FUND'>Funding</a></div>";
    					}
						if($toptab == 'TAX') {
    						$html .= "<div class='menuactive' style='background-color:#e8cf9e;'><a style='color:black' href='default2.php?toptab=TAX'>Taxes</a></div>";
    					} else {
    						$html .= "<div class='menu'><a href='default2.php?toptab=TAX'>Taxes</a></div>";
    					}
    					if($toptab == 'EXP') {
    						$html .= "<div class='menuactive' style='background-color:#e8cf9e;'><a style='color:black' href='default2.php?toptab=EXP'>Expenses</a></div>";
    					} else {
    						$html .= "<div class='menu'><a href='default2.php?toptab=EXP'>Expenses</a></div>";
    					}
    					

					$html .= "
   	    			
			</div>

	    </div>
	    
	    <div id='main'>
	    	<div id='project'>
	    		<select id='project' name='project' onchange='DropDownChanged(this);'>
			    	<option value='0'>Select a Project</option>
			    </select>
	    	</div>
	    	
	    	<div id='tabdata'>";
	    		$html .= TopTab($toptab);
	    		$html .= "
	    	
	    	</div>
	    </div>";
	    		
	    		#=======================================================================================================================Completing the page

		$html .= "
	</body>
</html>";

//#############################################################################################################################################echo html Page to screen

echo $html
?>
