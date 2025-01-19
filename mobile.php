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


//Build Logon Page
$html = "

<head>

<title>Logon Page</title>

<link href='NRWMobile.css' rel='stylesheet' type='text/css'/>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
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
							<a href='mobile.php?action=itm'><div class='button'>Sell Item</div></a><br>
							<a href='mobile.php?action=exp'><div class='button'>Add Expense</div></a><br>
							<a href='mobile.php?action=sho'><div class='button'>Schedule Show</div></a><br>
					</div>";
					break;
					
				case 'itm':
					$html .= "	
					<div class='menu'>
							<a href='mobile.php?action=itm'><div class='button'>itm</div></a><br>
							<a href='mobile.php?action=exp'><div class='button'>pExpense</div></a><br>
							<a href='mobile.php?action=sho'><div class='button'>exp</div></a><br>
					</div>";
					break;

					
				case 'exp':
					$html .= "	
					<div class='menu'>
							<a href='mobile.php?action=itm'><div class='button'>exp</div></a><br>
							<a href='mobile.php?action=exp'><div class='button'>pExpense</div></a><br>
							<a href='mobile.php?action=sho'><div class='button'>exp</div></a><br>
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