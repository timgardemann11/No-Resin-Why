<?php

include 'functions.php';
include 'Dialogs.php';

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

If (isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "mnu";
}


if (isset($_POST['subsho'])) {
	$name = $_POST['name'];
	$date = $_POST['sdate'];
	$start = $_POST['start'];
	$finish = $_POST['finish'];
	$locaddress = $_POST['locationaddress'];
	$loccity = $_POST['locationcity'];
	$locstate = $_POST['locationstate'];
	$conname = $_POST['contactname'];
	$conemail = $_POST['contactemail'];
	$conphone = $_POST['contactphone'];
	$location = $_POST['location'];
		$result = AddShow($name,$date,$start,$finish,$locaddress,$loccity,$locstate,$conname,$conemail,$conphone,$location);
} else {
	$name = "";
	$date = "";
	$start = "";
	$finish = "";
	$locaddress = "";
	$loccity = "";
	$locstate = "";
	$conname = "";
	$conemail = "";
	$conphone = "";
	$location = "";
}


if (isset($_POST['subexpadd'])) {
	$edate = $_POST['edate'];
	$evendor = $_POST['evendor'];
	$edescription = $_POST['edescription'];
	$eamount = $_POST['eamount'];
	if($evendor == ''){
		$evendor = $_POST['evtext'];
	}
	$data = AddExpense($edate,$evendor,$edescription,$eamount);
	$parts = explode("^",$data);
	
	$result = $parts[0]; 
	$expenseid = $parts[1]; # get the ID of inserted expense
	
	$count = GetExpAcctCount();
	
	for($i=1; $i <= $count; $i++) {
		$expaccountid[$i] = $_POST['expaccountid' . $i];
		$expacctname[$i] = $_POST['expacctname' . $i];
		$amount[$i] =  $_POST['amount' . $i];
	
		AddExpenseAcctValue($expenseid,$expaccountid[$i],$expacctname[$i],$amount[$i]);
	}
	
} else {
	$edate = "";
	$evendor = "";
	$edescription = "";
	$eamount = "";
}


if(isset($_POST["lookuptxt"])) {
	$lookuptxt = $_POST["lookuptxt"];
} else {
	$lookuptxt = "";
}


if (isset($_POST['subsold'])) {
	$ItemID = $_POST['selid'];
	$price = $_POST['saleprice'];
	$showname = "Mobile Sale";
	
	$result = MarkSold($ItemID,$showname,$price);
} 




//Build Logon Page
$html = "

<head>

<title>NRW Mobile</title>

<link href='NRWMobile.css' rel='stylesheet' type='text/css'/>
<meta name='viewport' content='width=device-width, initial-scale=0.95'>
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
	function PopulateExpenseAccounts(val){
		var acct = [];
		let Total = document.getElementById('eamount').value;
		let Overhead = Total;
		for (let i = 2; i < 20; i++){
			var element =  document.getElementById('amount' + i);
			if (typeof(element) != 'undefined' && element != null)
			{
				Overhead = Overhead - document.getElementById('amount' + i).value;
			}
		}
		document.getElementById('amount1').value = Overhead;
	}
</script>



</head>

<body>";

//======================================================================================================Body
			//---------------------------------------------------------------------Mobile Page Header
		$html .= "
		<div id='container'>
			<div id='logo'>
				<table width='400'>
					<tr>
						<td rowspan='2' style='width:33%;'><img src='images/SiteLogo.png' alt='No Resin Why' style='max-width:100%;height:auto;'></td>
						<td rowspan='2' style='width:33%;text-align:right;'><img src='images/user.png'></td>
						<td class='user' style='vertical-align:bottom;'>$user</td>
					</tr>
					<tr>
						<td class='user' style='vertical-align:top;'>$title</td>
					</tr>
					<tr colspan='3'>
						<table class='siteswitcherheader'>
							<tr>
								<td class='siteswitcherheader' colspan='3' style='vertical-align:bottom;text-align:center;height:10px;'>Site Switcher</td>
							<tr class='siteswitcherheader'>
								<td><a href='mobile.php'><div class='siteswitcheractive'>Mobile</div></a></td>
								<td><a href='default.php'><div class='siteswitcher'>Operations</div></a></td>
								<td><a href='show.php'><div class='siteswitcher'>Craft Show</div></a></td>
							</tr>
						</table>
					</tr>							
				</table>";
			
			Switch ($action) {
			
				case 'mnu':	
					$html .= "	
					<div class='menu'>
							<a href='mobile.php?action=itm'><div class='button'>Sell Item<br>&nbsp;</div></a><br>
							<a href='mobile.php?action=exp'><div class='button'>Add Expense<br>&nbsp;</div></a><br>
							<a href='mobile.php?action=sho'><div class='button'>Schedule Show<br>&nbsp;</div></a><br>
					</div>";
					break;
					
				case 'itm':
					$html .= "<div class='menu'>";
							$form = Dialog('SLDMBL','','','',$lookuptxt);

							$formparts = explode("^",$form); #return "$title^$headers^$inputs^$footer^$subid^$subtxt^$top";
							
							$html .= "
							<div>
								
								<div class='formtitle'>$formparts[0]</div>
								<div class='center'>
								
									
										$formparts[1]
										
										$formparts[2]
										<br>
										<a href='mobile.php'><div class='exit'>Cancel</div></a><input class='subbutton' type='submit' id='$formparts[4]' name='$formparts[4]' value='$formparts[5]'>
										$formparts[3]					
										
							</div>
					</div>";
					break;

					
				case 'exp':
					$html .= "<div class='menu'>";
							$form = Dialog('EXPMBL','','','','');

							$formparts = explode("^",$form); #return "$title^$headers^$inputs^$footer^$subid^$subtxt^$top";
							
							$html .= "
							<div>
								
								<div class='formtitle'>$formparts[0]</div>
								<div class='center'>
								
									<form action='mobile.php?submit=show' method='post' enctype='multipart/form-data'>
										$formparts[1]
										
										$formparts[2]
										<br>
										<a href='mobile.php'><div class='exit'>Cancel</div></a><input class='subbutton' type='submit' id='$formparts[4]' name='$formparts[4]' value='$formparts[5]'>
										$formparts[3]					
									</form>	
							</div>
					</div>";
					break;
				
				case 'sho':
					$html .= "<div class='menu'>";
							$form = Dialog('SHOMBL','','','','');

							$formparts = explode("^",$form); #return "$title^$headers^$inputs^$footer^$subid^$subtxt^$top";
							
							$html .= "
							<div>
								
								<div class='formtitle'>$formparts[0]</div>
								<div class='center'>
								
									<form action='mobile.php?submit=show' method='post' enctype='multipart/form-data'>
										$formparts[1]
										
										$formparts[2]
										<br>
										<a href='mobile.php'><div class='exit'>Cancel</div></a><input class='subbutton' type='submit' id='$formparts[4]' name='$formparts[4]' value='$formparts[5]'>
										$formparts[3]					
									</form>	
							</div>
					</div>";
					break;

			
			}
			
			$html .= "
		</div>
		</div>

	</body>
</html>";

echo $html;







?>