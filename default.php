<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'functions.php';
include 'Calendar.php';

$calendar = new Calendar('2024-12-12');
$calendar->add_event('Holiday', '2024-12-15');
session_start();

$result = "";

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

if (isset($_POST['subexpadd'])) {
	$edate = $_POST['edate'];
	$evendor = $_POST['evendor'];
	$edescription = $_POST['edescription'];
	$eamount = $_POST['eamount'];
	if($evendor == ''){
		$evendor = $_POST['evtext'];
	}
	$result = AddExpense($edate,$evendor,$edescription,$eamount);
} else {
	$edate = "";
	$evendor = "";
	$edescription = "";
	$eamount = "";
}

if (isset($_POST['subexpup'])) {
	$eid = $_POST['eid'];
	$edate = $_POST['edate'];
	$evendor = $_POST['evendor'];
	$edescription = $_POST['edescription'];
	$eamount = $_POST['eamount'];
	if($evendor == ''){
		$evendor = $_POST['evtext'];
	}
	$result = UpdateExpense($edate,$evendor,$edescription,$eamount,$eid);
} else {
	$edate = "";
	$evendor = "";
	$edescription = "";
	$eamount = "";
}

if (isset($_POST['subexpdel'])) {
	$eid = $_POST['eid'];
	$edate = $_POST['edate'];
	$evendor = $_POST['evendor'];
	$edescription = $_POST['edescription'];
	$eamount = $_POST['eamount'];
	if($evendor == ''){
		$evendor = $_POST['evtext'];
	}
	$result = DeleteExpense($edate,$evendor,$edescription,$eamount,$eid);
} else {
	$edate = "";
	$evendor = "";
	$edescription = "";
	$eamount = "";
}




if (isset($_GET['operation'])) {
	$operation = $_GET['operation'];
} else {
	$operation = "";
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
		
		<script>
		function DropDownChanged(oDDL) {
		    var oTextbox = oDDL.form.elements['evtext'];
		    if (oTextbox) {
		        oTextbox.style.display = (oDDL.value == '') ? '' : 'none';
		        if (oDDL.value == '')
		            oTextbox.focus();
		    }
		}
		</script>
		
    </head>
    <body>

	    <div id='main'>
	    	
	    		<div id='logo'>&nbsp;&nbsp;<img src='images/SiteLogo.png' alt='No Resin Why' style='width:120px;'></div>
	    		<div id='site'>&nbsp;&nbsp;&nbsp;&nbsp;No Resin Why Operations&nbsp;&nbsp;&nbsp;<span style='font-size:medium;'>$result</span></div>
    			<div class='menu'>";
    						if($toptab == 'EXP') {
	    						$html .= "<div class='menuactive' style='background-color:#C00000;'><a style='color:white' href='default.php?toptab=EXP'>Expenses</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#C00000;'><a href='default.php?toptab=EXP'>Expenses</a></div>";
	    					}
	    					if($toptab == 'EXA') {
	    						$html .= "<div class='menuactive' style='background-color:#B67070;'><a style='color:white' href='default.php?toptab=EXA'>Exp Accounts</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#B67070;'><a href='default.php?toptab=EXA'>Exp Accounts</a></div>";
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
	    					if($toptab == 'SIZ') {
	    						$html .= "<div class='menuactive' style='background-color:#C0C000;'><a style='color:white' href='default.php?toptab=SIZ'>Sizes</a></div>";
	    					} else {
	    						$html .= "<div class='menu' style='background-color:#C0C000;'><a href='default.php?toptab=SIZ'>Sizes</a></div>";
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
		   					<li><a href='default.php?action=ITM&toptab=$toptab'>Add New Items</a></li>
							<li><a href='default.php?action=SLD&toptab=$toptab'>Mark Items as Sold</a></li>
							<li><a href='default.php?action=MLD&toptab=$toptab'>Add New Mold</a></li>
							<li><a href='default.php?action=MLD&toptab=$toptab'>Add Mold Size</a></li>
							<li><a href='default.php?action=VDR&toptab=$toptab'>Add New Vendor</a></li>
							<li><a href='default.php?action=VDR&toptab=$toptab'>Schedule Show</a></li>
							<li><a href='default.php?action=VDR&toptab=$toptab'>Add Calendar Event</a></li>

							
		    		</ul>
				</div>
			</div>";
			//---------------------------------------------------------------------Company Metrics and Calendar
			
			$html .= "
			<div id='metrics'>
				<div class='metricsdata'>Result of Operations<br><br>
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
				$edate 
				$evendor 
				$edescription 
				$eamount 
				<br>
				$result

					
				</div>	
				
	
				
			</div>
			
			
			
			
			<div id='data'>";
			//---------------------------------------------------------------------Top Tabs Data Sections
			switch ($toptab) {
			
				case 'EXP':
					$html .= "
					<div class='Expense'>";
							$return = Expenses($search,'table',$toptab,$operation);
							$parts = explode("^",$return);
							$html .= $parts[0];
							$html .= "
						
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
								Total of Displayed Expenses:  <span style='font-weight:bold;'>$parts[1]</span><br><br>
								<span style='font-size:small;'>$parts[2]</span>
							</div>
							
						 </div>
						
						
					</div>";

					break;
				case 'INV':
					$html .= "
					<div class='Inventory'>";
							$return = Inventory($search,'table',$toptab,$operation);
							$parts = explode("^",$return);
							$html .= $parts[0];
							$html .= "
						
						<div style='float:right;display:inline-block;padding-right:20px;font-size:medium;color:white'>";
							if($search == ""){$html .= "Showing all Items<br>";} else {$html .= "Showing Items for search: <span style='font-weight:bold;'>$search</span><br>";}
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
								Count of Displayed Items:  <span style='font-weight:bold;'>$parts[3]</span><br>
								Retail Value of Displayed Items:  <span style='font-weight:bold;'>$parts[1]</span><br><br>
								<span style='font-size:small;'>$parts[2]</span>
							</div>
							
						 </div>
						
						
					</div>";

					break;

				case 'SAL':
					$html .= "
					<div class='Sales'>";
							$return = Inventory($search,'table',$toptab,$operation);
							$parts = explode("^",$return);
							$html .= $parts[0];
							$html .= "
						
						<div style='float:right;display:inline-block;padding-right:20px;font-size:medium;color:white'>";
							if($search == ""){$html .= "Showing all Items<br>";} else {$html .= "Showing Items for search: <span style='font-weight:bold;'>$search</span><br>";}
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
								Count of Displayed Items:  <span style='font-weight:bold;'>$parts[3]</span><br>
								Retail Value of Displayed Items:  <span style='font-weight:bold;'>$parts[1]</span><br><br>
								<span style='font-size:small;'>$parts[2]</span>
							</div>
							
						 </div>
						
						
					</div>";

					break;
					
					
				case 'MLD':
					$html .= "
					<div class='Mold'>
						<div class='datascroll'>";
							$return = Molds($search,'table',$toptab,$operation,"");
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
							$return = vendors($search,'table',"");
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
					
				case 'SIZ':
					$html .= "
					<div class='Sizes'>";
							$return = Inventory($search,'table',$toptab,$operation);
							$parts = explode("^",$return);
							$html .= $parts[0];
							$html .= "
						
						<div style='float:right;display:inline-block;padding-right:20px;font-size:medium;color:white'>";
							if($search == ""){$html .= "Showing all Items<br>";} else {$html .= "Showing Items for search: <span style='font-weight:bold;'>$search</span><br>";}
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
								Count of Displayed Items:  <span style='font-weight:bold;'>$parts[3]</span><br>
								Retail Value of Displayed Items:  <span style='font-weight:bold;'>$parts[1]</span><br><br>
								<span style='font-size:small;'>$parts[2]</span>
							</div>
							
						 </div>
						
						
					</div>";

					break;
					
				case 'EXA':
					$html .= "
					<div class='Accounts'>";
							$return = Inventory($search,'table',$toptab,$operation);
							$parts = explode("^",$return);
							$html .= $parts[0];
							$html .= "
						
						<div style='float:right;display:inline-block;padding-right:20px;font-size:medium;color:white'>";
							if($search == ""){$html .= "Showing all Items<br>";} else {$html .= "Showing Items for search: <span style='font-weight:bold;'>$search</span><br>";}
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
								Count of Displayed Items:  <span style='font-weight:bold;'>$parts[3]</span><br>
								Retail Value of Displayed Items:  <span style='font-weight:bold;'>$parts[1]</span><br><br>
								<span style='font-size:small;'>$parts[2]</span>
							</div>
							
						 </div>
						
						
					</div>";

					break;


			}
	
			$html .= "
			</div>
		</div>";
		
		
		#======================================================================================================Hidden Form
		
		if($action <> ""){
			If (strlen($action) > 3) {
				$data = explode("z",$action);
				$action = $data[0];
				$ID = $data[1];
			}
			
			#------------------------------------------------get the correct variables for the form
			switch ($action){
				case 'EXP':
					$title = "Add Expense";
					$TDate = Date('m/d/Y');
					$headers = "<tr><td>Expense Date</td><td>Vendor</td><td>Description</td><td>Amount</td></tr>";
					$inputs = "<td><input type='text' id='datepicker' name='edate' value='$TDate'></td>
						 		<td><select id='evendor' name='evendor' onchange='DropDownChanged(this);'>
			                            <option value='0'>Select a Vendor</option>";
			                            $inputs .= vendors($search,'drop',"");
			                            $inputs .= "
			                            <option value=''>Other..</option>
									</select>
									<input type='text' id='evtext' name='evtext' style='display: none;' /></td>
								<td><input type='text' id='edescription' name='edescription' size='30'/></td>
								<td><input type='number' id='eamount' name='eamount' step='.01'></td>";
					$subid = 'subexpadd';
					$subtxt = "Add This Expense";
					$top = 'EXP';
					break;
				
				case 'EditEXP':
					$title = "Edit Expense $ID";
					$data = GetExpense($ID);
					$parts = explode("^",$data);
					$headers = "<tr><td>Expense Date</td><td>Vendor</td><td>Description</td><td>Amount</td></tr>";
					$inputs = "<td><input type='text' id='datepicker' name='edate' value='$parts[0]'></td>
						 		<td><select id='evendor' name='evendor' onchange='DropDownChanged(this);' value='$parts[1]'>
			                            <option value='0'>Select a Vendor</option>";
			                            $inputs .= vendors($search,'drop',$parts[1]);
			                            $inputs .= "
			                            <option value=''>Other..</option>
									</select>
									<input type='text' id='evtext' name='evtext' style='display: none;'  value='$parts[1]' /></td>
								<td><input type='text' id='edescription' name='edescription' size='30' value='$parts[2]'/></td>
								<td><input type='number' id='eamount' name='eamount' step='.01' value='$parts[3]'></td>
								<input type='hidden' id='eid' name='eid' value='$ID'>";
					$subid = 'subexpup';
					$subtxt = "Update This Expense";
					$top = 'EXP';
					break;
					
				case 'DeleteEXP':
					$title = "Delete Expense $ID";
					$data = GetExpense($ID);
					$parts = explode("^",$data);
					$headers = "<tr><td>Expense Date</td><td>Vendor</td><td>Description</td><td>Amount</td></tr>";
					$inputs = "<td><input type='text' id='datepicker' name='edate' value='$parts[0]'></td>
						 		<td><select id='evendor' name='evendor' onchange='DropDownChanged(this);' value='$parts[1]'>
			                            <option value='0'>Select a Vendor</option>";
			                            $inputs .= vendors($search,'drop',$parts[1]);
			                            $inputs .= "
			                            <option value=''>Other..</option>
									</select>
									<input type='text' id='evtext' name='evtext' style='display: none;'  value='$parts[1]' /></td>
								<td><input type='text' id='edescription' name='edescription' size='30' value='$parts[2]'/></td>
								<td><input type='number' id='eamount' name='eamount' step='.01' value='$parts[3]'></td>
								<input type='hidden' id='eid' name='eid' value='$ID'>";
					$subid = 'subexpdel';
					$subtxt = "Delete This Expense";
					$top = 'EXP';
					break;
					
				case 'EditITM':
					$title = "Edit Item $ID";
					$data = GetItem($ID);
					$parts = explode("^",$data);
					$selectedID = $parts[5];
					
					$headers = "<tr><td>Production Date</td><td>Mold</td><td>Description</td><td>Amount to Add to Price</td></tr>";
					$inputs = "</tr>
								<td><input type='text' id='datepicker' name='edate' value='$parts[0]'></td>
						 		<td><select id='evendor' name='evendor' onchange='DropDownChanged(this);'>
			                            <option value='0'>Select a Vendor</option>";
			                            $inputs .= Molds($search,'drop',$toptab,$operation,$parts[5]);
			                            $inputs .= "
									</select>
								</td>
								<td><input type='text' id='description' name='description' size='30' value='$parts[2]'/></td>
								<td><input type='number' id='priceadd' name='priceadd' step='.01' value='$parts[3]'></td>
							</tr>
							<tr><td colspan='4'>&nbsp;</td>";
					$subid = 'subitmup';
					$subtxt = "Update This Item";
					$top = 'EXP';
					break;
				
				case 'ITM':
					$title = "Add Item";
					$TDate = Date('m/d/Y');
					$headers = "<tr><td>Production Date</td><td>Mold</td><td>Description</td><td>Amount to Add to Price</td></tr>";
					$inputs = "<tr>
									<td><input type='text' id='datepicker' name='edate' value='$TDate'></td>
							 		<td><select id='mshape' name='mshape' onchange='DropDownChanged(this);'>
				                            <option value='0'>Select a Mold</option>";
				                            $inputs .= Molds($search,'drop',$toptab,$operation,"");
				                            
				                            $inputs .= "
										</select>
									</td>
									<td><input type='text' id='description' name='description' size='30'/></td>
									<td><input type='number' id='priceadd' name='priceadd' step='.01'></td>
								</tr>
								<tr><td colspan='4'>&nbsp;</td>";
					$subid = 'subitm';
					$subtxt = "Add This Item";
					$top = 'ITM';
					break;



			}	
			
			#-----------------------------------------------The Actual Form
			$html .= "<div class='action'></div>
			<div class='form'>
				
				<div class='exit'><a href='default.php?toptab=$toptab'>Exit</a></div>
				<div class='formtitle'>$title</div>
				<div>
					<form action='Default.php?toptab=$top' method='post' enctype='multipart/form-data'>
						<table>
							$headers
							<tr>
								$inputs
							</tr>
						</table><br>
						<input type='submit' id='$subid' name='$subid' value='$subtxt'>
					</form>
			</div>";
		}
		
		
		#======================================================================================================Completing the page

		$html .= "
	</body>
</html>";

echo $html
?>
