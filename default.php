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


if (isset($_GET['ametric'])) {
    $Ametric = $_GET['ametric'];

} else {
    $Ametric = "bal";
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

if (isset($_POST['subsizadd'])) {
	$size = $_POST['size'];
	$mod = $_POST['modifier'];
	$cost = $_POST['cost'];
	$markup = $_POST['markup'];
	$price = $_POST['price'];
	$result = AddSize($size,$mod,$cost,$markup,$price);
} else {
	$size = "";
	$modifier = "";
	$cost = "";
	$markup = "";
	$price = "";
}

if (isset($_POST['subsizup'])) {
	$sid = $_POST['sid'];
	$size = $_POST['size'];
	$modifier = $_POST['modifier'];
	$cost = $_POST['cost'];
	$markup = $_POST['markup'];
	$price = $_POST['price'];
	$result = UpdateSize($size,$modifier,$cost,$markup,$price,$sid);
} else {
	$size = "";
	$modifier = "";
	$cost = "";
	$markup = "";
	$price = "";
}

if (isset($_POST['subsizdel'])) {
	$sid = $_POST['sid'];
	$size = $_POST['size'];
	$modifier = $_POST['Mod'];
	$cost = $_POST['cost'];
	$markup = $_POST['markup'];
	$price = $_POST['price'];
	$result = DeleteSize($size,$modifier,$cost,$markup,$price,$sid);
} else {
	$size = "";
	$modifier = "";
	$cost = "";
	$markup = "";
	$price = "";
}


if (isset($_POST['submldadd'])) {
	$shape = $_POST['shape'];
	$description = $_POST['description'];
	$size = $_POST['size'];
		$result = AddMold($shape,$description,$size);
} else {
	$shape = "";
	$description = "";
	$size = "";
}

if (isset($_POST['submldup'])) {
	$mid = $_POST['mid'];
	$shape = $_POST['shape'];
	$description = $_POST['description'];
	$size = $_POST['size'];
		$result = UpdateMold($shape,$description,$size,$mid);
} else {
	$mid = "";
	$shape = "";
	$description = "";
	$size = "";
}

if (isset($_POST['submlddel'])) {
	$mid = $_POST['mid'];
	$shape = $_POST['shape'];
	$description = $_POST['description'];
	$size = $_POST['size'];
		$result = DeleteMold($shape,$description,$size,$mid);
} else {
	$mid = "";
	$shape = "";
	$description = "";
	$size = "";
}



if (isset($_POST['subvdradd'])) {
	$vendor = $_POST['vendor'];
	$Account = $_POST['account'];
	$Location = $_POST['loc'];
		$result = AddVendor($vendor,$Account,$Location);
} else {
	$vendor = "";
	$Account = "";
	$Location = "";
}

if (isset($_POST['subvdrup'])) {
	$vid = $_POST['vid'];
	$vendor = $_POST['vendor'];
	$Account = $_POST['account'];
	$Location = $_POST['loc'];
		$result = UpdateVendor($vendor,$Account,$Location,$vid);
} else {
	$vendor = "";
	$Account = "";
	$Location = "";
}

if (isset($_POST['subvdrdel'])) {
	$vid = $_POST['vid'];
	$vendor = $_POST['vendor'];
	$Account = $_POST['account'];
	$Location = $_POST['loc'];
		$result = DeleteVendor($vendor,$Account,$Location,$vid);
} else {
	$vendor = "";
	$Account = "";
	$Location = "";
}

if (isset($_POST['subitmadd'])) {
	$edate = $_POST['edate'];
	$mshape = $_POST['mshape'];
	$description = $_POST['description'];
	$priceadd = $_POST['priceadd'];
	$price = $_POST['price'];
	$moldid = $_POST['moldid'];
	$moldsize = $_POST['moldsize'];
	$moldshape = $_POST['moldshape'];
	$cost = $_POST['cost'];
	$tag = $_POST['tag'];
		$result = AddItem($edate,$mshape,$description,$priceadd,$price,$moldid,$moldsize,$moldshape,$cost,$tag);
} else {
	$edate = "";
	$mshape = "";
	$description = "";
	$priceadd = "";
	$price = "";
	$moldid = "";
	$moldsize = "";
	$moldshape = "";
	$cost = "";
	$tag = "";
}

if (isset($_POST['subitmup'])) {
	$iid = $_POST['iid'];
	$edate = $_POST['edate'];
	$mshape = $_POST['mshape'];
	$description = $_POST['description'];
	$priceadd = $_POST['priceadd'];
	$price = $_POST['price'];
	$moldid = $_POST['moldid'];
	$moldsize = $_POST['moldsize'];
	$moldshape = $_POST['moldshape'];
	$cost = $_POST['cost'];
	$tag = $_POST['tag'];
		$result = UpdateItem($edate,$mshape,$description,$priceadd,$price,$moldid,$moldsize,$moldshape,$cost,$tag,$iid);
} else {
	$edate = "";
	$mshape = "";
	$description = "";
	$priceadd = "";
	$price = "";
	$moldid = "";
	$moldsize = "";
	$moldshape = "";
	$cost = "";
	$tag = "";
}

if (isset($_POST['subitmdel'])) {
	$iid = $_POST['iid'];
	$edate = $_POST['edate'];
	$mshape = $_POST['mshape'];
	$description = $_POST['description'];
	$priceadd = $_POST['priceadd'];
	$price = $_POST['price'];
	$moldid = $_POST['moldid'];
	$moldsize = $_POST['moldsize'];
	$moldshape = $_POST['moldshape'];
	$cost = $_POST['cost'];
	$tag = $_POST['tag'];
		$result = DeleteItem($edate,$mshape,$description,$priceadd,$price,$moldid,$moldsize,$moldshape,$cost,$tag,$iid);
} else {
	$edate = "";
	$mshape = "";
	$description = "";
	$priceadd = "";
	$price = "";
	$moldid = "";
	$moldsize = "";
	$moldshape = "";
	$cost = "";
	$tag = "";
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
		<script>
			function ChangeValues(val) {
				let q = Number((val / 10).toFixed(2));
				let c = Number((q * 2.50).toFixed(2));
				let m = Number((c * 1.75).toFixed(2));
				let r = Number((m + c + 2).toFixed());
				let p = Number((r + .50).toFixed(2));
				document.getElementById('cost').value = c;
				document.getElementById('markup').value = m;
				document.getElementById('price').value = p;
				document.getElementById('modifier').value = q;
				
			}
			
			function PopulateItemFields(val){
				var parts = val.split(' ');
				var shape = '';
				document.getElementById('moldid').value = parts[0];
				let Total = parts.length;
				document.getElementById('moldsize').value = parts[Total-3];
				for (let i = 1; i < Total-3; i++){
					shape = shape + parts[i] + ' ';
				}
				document.getElementById('moldshape').value = shape;
				document.getElementById('price').value = parts[Total-1];
				document.getElementById('cost').value = parts[Total-2];
			}
			
			function PriceAdd(val){
				 let current = document.getElementById('price').value
				 let price = +current + +val
				 document.getElementById('price').value = price;
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
							<li><a href='default.php?action=SIZ&toptab=$toptab'>Add Mold Size</a></li>
							<li><a href='default.php?action=VDR&toptab=$toptab'>Add New Vendor</a></li>
							<li><a href='default.php?action=VDR&toptab=$toptab'>Schedule Show</a></li>
							<li><a href='default.php?action=VDR&toptab=$toptab'>Add Calendar Event</a></li>

							
		    		</ul>
				</div>
			</div>";
			//---------------------------------------------------------------------Company Metrics and Calendar
			
			
			$ProfitData = Profit();  #$return .= "$Sales0^$Other1^$TSales2^$TExpense3^$Color4^$Molds5^$Embedded6^$Resin7^$ShowFees8^$Overhead9^$Displays10";
			$Profit = explode('^',$ProfitData);	
			$TPL = $Profit[0] - $Profit[3];
			$OE = "2800.00";
			$html .= "
			<div id='metrics'>
				<div class='metricstitle'>&nbsp;&nbsp;&nbsp;&nbsp;Result of Operations";   
					if ($Ametric == 'bal'){
						$html .= "<a href='default.php?toptab=$toptab&ametric=pro'><div class='smbutton'>Profit/loss Statement</div></a>
						<a href='default.php?toptab=$toptab&ametric=bal'><div class='smbuttonactive'>Balance Sheet</div></a>
						</div><br>
						<div class='metricsdata'><br>
				
						<div style='font-size:medium;color:white;background-color:#4EA72E;width:95%;'>Assets</div>
						<span style='font-size:medium;'>Cash . . . . . . . . . . . $0.00</span><br>
						<span style='font-size:medium;'>Inventory. . . . . $2.800.00</span><br>
						<span style='font-size:medium;'>Accounts Receivable. . . . . $0.00</span><br>
						<span style='font-size:medium;font-weight:bold;'>Total Assets. . . . . . . . . . $2800.00</span><br><br>
			
						<div style='font-size:medium;color:white;background-color:#C00000;width:95%;'>Liabilities</div>
						<span style='font-size:medium;'>Accounts Payable . . . . . . . . . . . $0.00</span><br>
						<span style='font-size:medium;'>Loans. . . . . . . . . . . . $0.00</span><br>
						<span style='font-size:medium;'>Taxes . . . . . . . $0.00</span><br>
						<span style='font-size:medium;font-weight:bold;'>Total Liabilities. . . . . . . . . . $0.00</span><br><br>
						<div style='font-size:medium;color:white;background-color:#4D93D9;width:95%;'>Owner Equity</div>";
						if($OE >=0){
								$html .= "<span style='font-size:medium;font-weight:bold;'>Total Owner Equity. . . . . . . . . . $OE</span><br><br>";
							} else {
								$html .= "<span style='font-size:medium;font-weight:bold;'>Total Profit/Loss. . . . . . . . . . <span style='color:red;'>$OE</span></span><br><br>";
						}
						$html .= "
						</div>";
					} else {
						$html .= "<a href='default.php?toptab=$toptab&ametric=pro'><div class='smbuttonactive'>Profit/loss Statement</div></a>
						<a href='default.php?toptab=$toptab&ametric=bal'><div class='smbutton'>Balance Sheet</div></a>
						</div><br>
						<div class='metricsdata'><br>
				
						<div style='font-size:medium;color:white;background-color:#4EA72E;width:95%;'>Income</div>
						<span style='font-size:medium;'>Sales . . . . . . . . . . . $Profit[0]</span><br>
						<span style='font-size:medium;'>Other Income. . . . . $Profit[1]</span><br>
						<span style='font-size:medium;font-weight:bold;'>Total Income. . . . . . . . . . $Profit[2]</span><br><br>
			
						<div style='font-size:medium;color:white;background-color:#C00000;width:95%;'>Expenses</div>
						<span style='font-size:medium;'>Molds . . . . . . . . . . . $Profit[5]</span><br>
						<span style='font-size:medium;'>Color. . . . . . . . . . . . $Profit[4]</span><br>
						<span style='font-size:medium;'>Embedded . . . . . . . $Profit[6]</span><br>
						<span style='font-size:medium;'>Resin   . . . . . . . . . . . $Profit[7]</span><br>
						<span style='font-size:medium;'>Show Fees. . . . . . . $Profit[8]</span><br>
						<span style='font-size:medium;'>Overhead   . . . . . . . $Profit[9]</span><br>
						<span style='font-size:medium;'>Displays  . . . . . . . . $Profit[10]</span><br>
						<span style='font-size:medium;font-weight:bold;'>Total Expenses. . . . . . . . . . $Profit[3]</span><br><br>
						<div style='font-size:medium;color:white;background-color:#4D93D9;width:95%;'>Profit / Loss</div>";
						if($TPL >=0){
								$html .= "<span style='font-size:medium;font-weight:bold;'>Total Profit/Loss. . . . . . . . . . $TPL</span><br><br>";
							} else {
								$html .= "<span style='font-size:medium;font-weight:bold;'>Total Profit/Loss. . . . . . . . . . <span style='color:red;'>$TPL</span></span><br><br>";
						}
						$html .= "
					</div>";
					}
					$html .= "
				
				
					
					<div class='calendar'>&nbsp;&nbsp;&nbsp;&nbsp;Upcomming Events:
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
							$return = Sales($search,'table',$toptab,$operation);
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
								Total Sales of Displayed Items:  <span style='font-weight:bold;'>$parts[1]</span><br><br>
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
								<br>
								<span style='font-size:small;'>$parts[2]</span>

							</div>
						 </div>

					</div>";

					break;
				case 'VDR':
					$html .= "
					<div class='Vendor'>
						<div class='datascroll'>";
							$return = vendors($search,'table',$toptab,$operation);
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
								Count of Displayed Vendors:  <span style='font-weight:bold;'>$parts[1]</span><br><br>
								<span style='font-size:small;'>$parts[2]</span>
							</div>
						 </div>

					</div>";

					break;
					
				case 'SIZ':
					$html .= "
					<div class='Sizes'>";
							$return = Sizes($search,'table',$toptab,$operation);
							$parts = explode("^",$return);
							$html .= $parts[0];
							$html .= "
						
						<div style='float:right;display:inline-block;padding-right:20px;font-size:medium;color:white'>";
							if($search == ""){$html .= "Showing all Sizes<br>";} else {$html .= "Showing Sizes for search: <span style='font-weight:bold;'>$search</span><br>";}
							$html .= "<br>
						 	<form action='Default.php?toptab=$toptab' method='post' enctype='multipart/form-data'>
								<div class='scontainer'>
								    <div class='InputContainer'>
								    	<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='#657789' stroke-width='3' stroke-linecap='round' stroke-linejoin='round' class='feather feather-search'><circle cx='11' cy='11' r='8'/><line x1='21' y1='21' x2='16.65' y2='16.65'/></svg>
								      <input name='search' id='search' placeholder='Search Sizes...'/>
								      <input type='submit' value='Search' name='search1'>
								    </div>
								</div>
							</form><br>
							<div>
								Count of Displayed Items:  <span style='font-weight:bold;'>$parts[1]</span><br>
								<br>
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
			$footer = "";
			#------------------------------------------------get the correct variables for the form
			switch ($action){
				case 'EXP':
					$title = "Add Expense";
					$TDate = Date('m/d/Y');
					$headers = "<tr><td>Expense Date</td><td>Vendor</td><td>Description</td><td>Amount</td></tr>";
					$inputs = "<td><input type='text' id='datepicker' name='edate' value='$TDate'></td>
						 		<td><select id='evendor' name='evendor' onchange='DropDownChanged(this);'>
			                            <option value='0'>Select a Vendor</option>";
			                            $inputs .= vendors($search,'drop',$toptab,"");
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
			                            $inputs .= vendors($search,'drop',$toptab,$parts[1]);
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
					$data = GetItem($ID); #$return = "$ProdDate0^$Shape1^$Description2^$RAmount3^$Cost4^$MoldID5^$MoldSize6^$PriceAdd7^$TAG8";
					$parts = explode("^",$data);
					$selectedSMold ="$parts[5] $parts[2] $parts[6]";
					
					$headers = "<tr><td width='120'>Production Date</td><td width='300'>Mold</td><td width='300'>Description</td></tr>";
					$inputs = "<tr>
									<td><input type='text' id='datepicker' name='edate' value='$parts[0]'></td>
							 		<td width='120'><select id='mshape' name='mshape' onchange='PopulateItemFields(this.value);'>
				                            <option value='0'>Select a Mold</option>";
				                            $inputs .= Molds($search,'drop',$toptab,$operation,$selectedSMold);
				                            $inputs .= "
										</select>
									</td>
									<td><input type='text' id='description' name='description' size='30' value='$parts[2]'/></td>
								</tr>
								<tr><td colspan='4'>&nbsp;</td></tr>
								<tr><td colspan='4'>&nbsp;</td></tr>
								<tr><td width='100'>Add to Price</td><td width='100'>Retail Price</td></tr>
								<tr>
									<td><input type='number' id='priceadd' name='priceadd' step='.01' value='$parts[70]' onchange='PriceAdd(this.value);'></td>
									<td><input type='number' id='price' name='price' step='.01' value='$parts[3]'></td>
								</tr></table>
								";
								
					$footer .= "<hr /><br>
								<table>
								<tr><td>MoldID</td><td>MoldSize</td><td>MoldShape</td></tr>
								<tr>
									<td><input type='number' id='moldid' name='moldid' value='$parts[5]'></td>
									<td><input type='text' id='moldsize' name='moldsize' value='$parts[6]'></td>
									<td><input type='text' id='moldshape' name='moldshape' value='$parts[1]'></td>
								</tr>
								<tr><td>Cost</td><td>Tag Printed</td></tr>
								<tr>
									<td><input type='number' id='cost' name='cost' step='.01' value='$parts[4]'></td>
									<td><input type='text' id='tag' name='tag' value='No' value='$parts[8]'></td>
								</tr>
								<input type='hidden' id='iid' name='iid' value='$ID'>";
					$subid = 'subitmup';
					$subtxt = "Update This Item";
					$top = 'INV';
					break;
					
					
				case 'DeleteITM':
					$title = "Delete Item $ID";
					$data = GetItem($ID); #$return = "$ProdDate0^$Shape1^$Description2^$RAmount3^$Cost4^$MoldID5^$MoldSize6^$PriceAdd7^$TAG8";
					$parts = explode("^",$data);
					$selectedSMold ="$parts[5] $parts[2] $parts[6]";
					
					$headers = "<tr><td width='120'>Production Date</td><td width='300'>Mold</td><td width='300'>Description</td></tr>";
					$inputs = "<tr>
									<td><input type='text' id='datepicker' name='edate' value='$parts[0]'></td>
							 		<td width='120'><select id='mshape' name='mshape' onchange='PopulateItemFields(this.value);'>
				                            <option value='0'>Select a Mold</option>";
				                            $inputs .= Molds($search,'drop',$toptab,$operation,$selectedSMold);
				                            $inputs .= "
										</select>
									</td>
									<td><input type='text' id='description' name='description' size='30' value='$parts[2]'/></td>
								</tr>
								<tr><td colspan='4'>&nbsp;</td></tr>
								<tr><td colspan='4'>&nbsp;</td></tr>
								<tr><td width='100'>Add to Price</td><td width='100'>Retail Price</td></tr>
								<tr>
									<td><input type='number' id='priceadd' name='priceadd' step='.01' value='$parts[70]' onchange='PriceAdd(this.value);'></td>
									<td><input type='number' id='price' name='price' step='.01' value='$parts[3]'></td>
								</tr></table>
								";
								
					$footer .= "<hr /><br>
								<table>
								<tr><td>MoldID</td><td>MoldSize</td><td>MoldShape</td></tr>
								<tr>
									<td><input type='number' id='moldid' name='moldid' value='$parts[5]'></td>
									<td><input type='text' id='moldsize' name='moldsize' value='$parts[6]'></td>
									<td><input type='text' id='moldshape' name='moldshape' value='$parts[1]'></td>
								</tr>
								<tr><td>Cost</td><td>Tag Printed</td></tr>
								<tr>
									<td><input type='number' id='cost' name='cost' step='.01' value='$parts[4]'></td>
									<td><input type='text' id='tag' name='tag' value='No' value='$parts[8]'></td>
								</tr>
								<input type='hidden' id='iid' name='iid' value='$ID'>";
					$subid = 'subitmdel';
					$subtxt = "Delete This Item";
					$top = 'INV';
					break;

				
				case 'ITM':
					$title = "Add Item";
					$TDate = Date('m/d/Y');
					$headers = "<tr><td width='120'>Production Date</td><td width='300'>Mold</td><td width='300'>Description</td></tr>";
					$inputs = "<tr>
									<td><input type='text' id='datepicker' name='edate' value='$TDate'></td>
							 		<td width='120'><select id='mshape' name='mshape' onchange='PopulateItemFields(this.value);'>
				                            <option value='0'>Select a Mold</option>";
				                            $inputs .= Molds($search,'drop',$toptab,$operation,"");
				                            $inputs .= "
										</select>
									</td>
									<td><input type='text' id='description' name='description' size='30'/></td>
								</tr>
								<tr><td colspan='4'>&nbsp;</td></tr>
								<tr><td colspan='4'>&nbsp;</td></tr>
								<tr><td width='100'>Add to Price</td><td width='100'>Retail Price</td></tr>
								<tr>
									<td><input type='number' id='priceadd' name='priceadd' step='.01' onchange='PriceAdd(this.value);'></td>
									<td><input type='number' id='price' name='price' step='.01'></td>
								</tr></table>
								";
								
					$footer .= "<hr /><br>
								<table>
								<tr><td>MoldID</td><td>MoldSize</td><td>MoldShape</td></tr>
								<tr>
									<td><input type='number' id='moldid' name='moldid'></td>
									<td><input type='text' id='moldsize' name='moldsize'></td>
									<td><input type='text' id='moldshape' name='moldshape'></td>
								</tr>
								<tr><td>Cost</td><td>Tag Printed</td></tr>
								<tr>
									<td><input type='number' id='cost' name='cost' step='.01'></td>
									<td><input type='text' id='tag' name='tag' value='No'></td>
								</tr>";
					$subid = 'subitmadd';
					$subtxt = "Add This Item";
					$top = 'INV';
					break;
					
				case 'EditSIZ':
					$title = "Edit Size $ID";
					$data = GetSize($ID);
					$parts = explode("^",$data);# $return = "$SID^$Size^$Mod^$Cost^$Markup^$Price";
					$ModValue = $parts[2] * 10;
					$headers = "<tr><td>Use this Slider to Populate Form Fields</td></tr>
								<tr><td><input type='range' id='Mod' name='Mod' min='0' max='80' value=25 onchange='ChangeValues(this.value)' value ='$ModValue'></td></tr>
								<tr><td>Size Name</td><td>Modifier</td><td>Cost</td><td>Markup</td><td>Price<td></tr>";
					$inputs = "<tr><td><input type='text' id='size' name='size' value='$parts[1]' /></td>
						 		<td><input type='number' id='modifier' name='modifier' step='.01' value='$parts[2]' /></td>
								<td><input type='number' id='cost' name='cost' step='.01' value='$parts[3]'/></td>
								<td><input type='number' id='markup' name='markup' step='.01' value='$parts[4]'></td>
								<td><input type='number' id='price' name='price' step='.01' value='$parts[5]'></td></tr>
								<input type='hidden' id='sid' name='sid' value='$ID'>";
					$subid = 'subsizup';
					$subtxt = "Update This Size";
					$top = 'SIZ';
					break;
					
				case 'DeleteSIZ':
					$title = "Delete Size $ID";
					$data = GetSize($ID);
					$parts = explode("^",$data);# $return = "$SID^$Size^$Mod^$Cost^$Markup^$Price";
					$headers = "<tr><td>Size Name</td><td>Modifier</td><td>Cost</td><td>Markup</td><td>Price<td></tr>";
					$inputs = "<td><input type='text' id='size' name='size' style='display: none;'  value='$parts[1]' /></td>
						 		<td><input type='number' id='Mod' name='Mod' step='.01' value='$parts[2]' /></td>
								<td><input type='number' id='cost' name='cost' step='.01' value='$parts[3]'/></td>
								<td><input type='number' id='markup' name='markup' step='.01' value='$parts[4]'></td>
								<td><input type='number' id='price' name='price' step='.01' value='$parts[5]'></td>

								<input type='hidden' id='sid' name='sid' value='$ID'>";
					$subid = 'subsizdel';
					$subtxt = "Delete This Size";
					$top = 'SIZ';
					break;
			
			case 'SIZ':
					$title = "Add Size";
					$headers = "<tr><td>Use this Slider to Populate Form Fields</td></tr>
								<tr><td><input type='range' id='Mod' name='Mod' min='0' max='80' value=25 onchange='ChangeValues(this.value)'></td></tr>
								<tr><td>Size Name</td><td>Modifier</td><td>Cost</td><td>Markup</td><td>Price<td></tr>";
					$inputs = "<td><input type='text' id='size' name='size'/></td>
						 		<td><input type='number' id='modifier' name='modifier' step='.01'/></td>
								<td><input type='number' id='cost' name='cost' step='.01'/></td>
								<td><input type='number' id='markup' name='markup' step='.01'/></td>
								<td><input type='number' id='price' name='price' step='.01'></td>";
					$subid = 'subsizadd';
					$subtxt = "Add This Size";
					$top = 'SIZ';
					break;

			case 'MLD':
					$title = "Add Mold";
					$headers = "<tr><td>Shape</td><td>Description</td><td>Size</td></tr>";
					$inputs = "<tr><td><input type='text' id='shape' name='shape'/></td>
						 		<td><input type='text' id='description' name='description'/></td>
								<td><select id='size' name='size'>
				                            <option value='0'>Select a size</option>";
				                            $inputs .= Sizes($search,'drop',$toptab,$operation,"");
				                            $inputs .= "
										</select>
									</td></tr>";
					$subid = 'submldadd';
					$subtxt = "Add This Mold";
					$top = 'MLD';
					break;

			case 'EditMLD':
					$title = "Edit Mold $ID";
					$data = GetMold($ID);
					$parts = explode("^",$data);
					$headers = "<tr><td>Shape</td><td>Description</td><td>Size</td></tr>";
					$inputs = "<tr><td><input type='text' id='shape' name='shape' value='$parts[0]'/></td>
						 		<td><input type='text' id='description' name='description' value='$parts[1]'/></td>
								<td><select id='size' name='size' onchange='DropDownChanged(this);'>
				                            <option value='0'>Select a size</option>";
				                            $inputs .= Sizes($search,'drop',$toptab,$parts[2]);
				                            $inputs .= "
										</select>
									</td></tr>
									<input type='hidden' id='mid' name='mid' value='$ID'/>";
					$subid = 'submldup';
					$subtxt = "Update This Mold";
					$top = 'MLD';
					break;
			
			case 'DeleteMLD':
					$title = "Delete Mold $ID";
					$data = GetMold($ID);
					$parts = explode("^",$data);
					$headers = "<tr><td>Shape</td><td>Description</td><td>Size</td></tr>";
					$inputs = "<tr><td><input type='text' id='shape' name='shape' value='$parts[0]'/></td>
						 		<td><input type='text' id='description' name='description' value='$parts[1]'/></td>
								<td><select id='size' name='size' onchange='DropDownChanged(this);' value='$parts[2]'>
				                            <option value='0'>Select a size</option>";
				                            $inputs .= Sizes($search,'drop',$toptab,$parts[2]);
				                            $inputs .= "
										</select>
									</td></tr>
									<input type='hidden' id='mid' name='mid' value='$ID'/>";
					$subid = 'submlddel';
					$subtxt = "Delete This Mold";
					$top = 'MLD';
					break;
			
			case 'VDR':
					$title = "Add Vendor";
					$headers = "<tr><td>Vendor Name</td><td>Account Number</td><td>Location</td></tr>";
					$inputs = "<tr><td><input type='text' id='vendor' name='vendor'/></td>
						 		<td><input type='text' id='account' name='account'/></td>
								<td><select id='loc' name='loc'>
				                            <option value='0'>Select a location</option>
				                            <option value='Cedar Rapids'>Cedar Rapids</option>
				                            <option value='Iowa City'>Iowa City</option>
				                            <option value='Online'>Online</option>";
				                            $inputs .= "
										</select>
									</td></tr>";
					$subid = 'subvdradd';
					$subtxt = "Add This Vendor";
					$top = 'VDR';
					break;
			
			
			case 'EditVDR':
					$title = "Edit Vendor";
					$data = GetVendor($ID);
					$parts = explode("^",$data); #$return = "$VendorName^$Account^$Location";
					$headers = "<tr><td>Vendor Name</td><td>Account Number</td><td>Location</td></tr>";
					$inputs = "<tr><td><input type='text' id='vendor' name='vendor' value='$parts[0]'/></td>
						 		<td><input type='text' id='account' name='account' value='$parts[1]'/></td>
								<td><select id='loc' name='loc'>
				                            <option value='0'>Select a location</option>
				                            <option value='Cedar Rapids'";if($parts[2] == "Cedar Rapids") {$inputs .= " selected";}$inputs .= ">Cedar Rapids</option>
				                            <option value='Iowa City'";if($parts[2] == "Iowa City") {$inputs .= " selected";}$inputs .= ">Iowa City</option>
				                            <option value='Online'";if($parts[2] == "Online") {$inputs .= " selected";}$inputs .= ">Online</option>";
				                            $inputs .= "
										</select>
									</td></tr>
									<input type='hidden' id='vid' name='vid' value='$ID'/>";
					$subid = 'subvdrup';
					$subtxt = "Update This Vendor";
					$top = 'VDR';
					break;
			
			case 'DeleteVDR':
					$title = "Delete Vendor";
					$data = GetVendor($ID);
					$parts = explode("^",$data); #$return = "$VendorName^$Account^$Location";
					$headers = "<tr><td>Vendor Name</td><td>Account Number</td><td>Location</td></tr>";
					$inputs = "<tr><td><input type='text' id='vendor' name='vendor' value='$parts[0]'/></td>
						 		<td><input type='text' id='account' name='account' value='$parts[1]'/></td>
								<td><select id='loc' name='loc'>
				                            <option value='0'>Select a location</option>
				                            <option value='Cedar Rapids'";if($parts[2] == "Cedar Rapids") {$inputs .= " selected";}$inputs .= ">Cedar Rapids</option>
				                            <option value='Iowa City'";if($parts[2] == "Iowa City") {$inputs .= " selected";}$inputs .= ">Iowa City</option>
				                            <option value='Online'";if($parts[2] == "Online") {$inputs .= " selected";}$inputs .= ">Online</option>";
				                            $inputs .= "
										</select>
									</td></tr>
									<input type='hidden' id='vid' name='vid' value='$ID'/>";
					$subid = 'subvdrdel';
					$subtxt = "Delete This Vendor";
					$top = 'VDR';
					break;

			
			
			


			}	
			
			#-----------------------------------------------The Actual Form
			$html .= "<div class='action'></div>
			<div class='form'>
				
				<a href='default.php?toptab=$toptab'><div class='exit'>Cancel</div></a>
				<div class='formtitle'>$title</div><br><br>
				<div class='center'>
					<form action='Default.php?toptab=$top' method='post' enctype='multipart/form-data'>
						<table>
							$headers
							<tr>
								$inputs
							</tr>
						</table><br><br>
						<input type='submit' id='$subid' name='$subid' value='$subtxt'>";
						$html .= $footer;
						$html .= "
					</form>
			</div>";
		}
		
		
		#======================================================================================================Completing the page

		$html .= "
	</body>
</html>";

echo $html
?>
