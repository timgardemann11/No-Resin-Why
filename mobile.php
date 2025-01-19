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


//Build Logon Page
$html = "

<head>

<title>Logon Page</title>

<link href='NRWMobile.css' rel='stylesheet' type='text/css'/>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>

</head>

<body>";

//======================================================================================================Body
			//---------------------------------------------------------------------Controls on the left
		$html .= "
		<div id='container'>
			<div id='logo'>
				<table width='450'>
					<tr>
						<td rowspan='2' style='width:270px;'><img src='images/SiteLogo.png' alt='No Resin Why' style='max-width:50%;height:auto;'></td>
						<td rowspan='2'><img src='images/user.png'></td>
						<td class='user' style='vertical-align:bottom;'>$user</td>
					</tr>
					<tr>
						<td class='user' style='vertical-align:top;'>$title</td>
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
										<a href='mobile.php'><div class='exit'>Cancel</div></a><input class='subbutton' type='submit' id='$subid' name='$subid' value='$formparts[5]'>
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