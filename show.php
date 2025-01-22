<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'functions.php';
include 'Calendar.php';
include 'Dialogs.php';

$calendar = new Calendar(Date('Y-m-d'));
$eventdata = GetShows();
$events = explode("^",$eventdata);
$count =count($events);
$result = "$eventdata";

for ($i=0;$i<=$count-2;$i++){
	$item = explode(",",$events[$i]);
	$calendar->add_event($item[0],$item[1]);
}


$calendar->add_event('<a href=\'default.php?toptab=VDR&operation=VDR1\'><div style=\'text-decoration:none;\'>Holiday 8 am to 9 pm</div></a>', '2025-1-17');


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




if(isset($_GET["select"])) {
	$select = $_GET["select"];
} else {
	$select = "";
}

if(isset($_POST["show"])) {
	$show = $_POST["show"];
	$_SESSION["show"]=$show;
} else {
	$show = "";
	$showname = "No Show Selected";
}

if (isset($_SESSION["show"])){
	$show = $_SESSION["show"];
	if($show <> ""){
		$showData = GetShow($show);#$return .= "$shid^$SDate^$Name^$Start^$Finish^$Location^$LocationAddress^$LocationCity^$LocationState^$ContactName^$ContactEmail^$ContactPhone";
		$showparts = explode("^",$showData);
		
		$ShowDate = $showparts[1];
		$showname = $showparts[2];
		$Start = $showparts[3];
		$Finish = $showparts[4];
		$Location = $showparts[5];
		$LocationAddress = $showparts[6];
		$LocationCity = $showparts[7];
		$LocationState = $showparts[8];
		$ContactName = $showparts[9];
		$ContactEmail = $showparts[10];
		$ContactPhone = $showparts[11];
	} else {
		$ShowDate = "";
		
		$Start = "";
		$Finish = "";
		$Location = "";
		$LocationAddress = "";
		$LocationCity = "";
		$LocationState = "";
		$ContactName = "";
		$ContactEmail = "";
		$ContactPhone = "";
	}
} else {
	$ShowDate = "";
	$Start = "";
	$Finish = "";
	$Location = "";
	$LocationAddress = "";
	$LocationCity = "";
	$LocationState = "";
	$ContactName = "";
	$ContactEmail = "";
	$ContactPhone = "";

}

#...........................Text Box Submitted - Save Contents
if (isset($_GET['file']))
{	
	$file =$_GET['file'];
    file_put_contents($file, $_POST['text']);
}


//#############################################################################################################################################Build html Page

//=====================================================================================================================Page Headers and script

$html = "
<html>
    <head>
        <title></title>
        <link href='NRWShow.css' rel='stylesheet' type='text/css'/>
        <link rel='stylesheet' href='//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
        <meta name='viewport' content='width=device-width, initial-scale=1.00'>
        
        <script src='https://code.jquery.com/jquery-1.12.4.js'></script>
		<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
		<script src='./nicEdit.js' type='text/javascript'></script>
		
		<script>
			function showSave() {
				document.getElementById('change').style.display = 'block';
			}
		</script>

		<script type='text/javascript'>
			bkLib.onDomLoaded(function() {
				new nicEditor().panelInstance('text');
				document.getElementById('text').parentElement.onkeypress = function () { showSave(); };	
			});	
		</script>
		
        <script>
			$( function() {
			$( '#datepicker' ).datepicker();
			$( '#datepicker2' ).datepicker();
			} );
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
						
		</script>

		
    </head>";

//=====================================================================================================================Page Top and tabs

	$html .= "
 
    <body>

	    <div id='main'>
	    	
	    		<div id='logo'>&nbsp;&nbsp;<img src='images/SiteLogo.png' alt='No Resin Why' style='width:120px;'></div>
	    		
	    		<div class='login'><table style='float:right;font-size:12px;'>
		    							<tr>
		    								<td rowspan='2'><img src='images/user.png' alt='No Resin Why' style='width:35px;'></td>
		    								<td>$user&nbsp;</td>
		    							</tr>
		    							<tr>
		    								<td>$title</td>
		    							</tr>
		    						</table>
		    	</div>
		    	<div class='siteswitcherlocation'>
		    			<table class='siteswitcherheader'>
							<tr>
								<td class='siteswitcherheader' colspan='3' style='vertical-align:bottom;text-align:center;height:10px;'>Site Switcher</td>
							<tr class='siteswitcherheader'>
								<td><a href='mobile.php'><div class='siteswitcher'>Mobile</div></a></td>
								<td><a href='default.php'><div class='siteswitcher'>Operations</div></a></td>
								<td><a href='show.php'><div class='siteswitcheractive'>Craft Show</div></a></td>
							</tr>
						</table>
	    		</div>
	    		
	    		<div id='site'>&nbsp;&nbsp;&nbsp;Craft Show&nbsp;&nbsp;&nbsp;$result</div>
	    
	    
			    <div class='showswitcher'>";
			    	
			    	switch ($select) {
			    		case "":
			    			If($show == ""){
				    			$html .= "
				    			<a href='show.php?select=set'><div class='button' style='width:120;'>Set Show</div></a>
				    			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='show'>$showname</span>";
				    		} else {
				    			$html .= "
				    			<a href='show.php?select=set'><div class='button' style='width:120';>Change Show</div></a>
				    			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='show'>$showname</span>";
							}
			    			break;
			    		
			    		case "set":
			    			$html .= "<div class='buttondisabled' style='width:120';>Set Show</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='showselector'>
			    			<form action='show.php' method='post' enctype='multipart/form-data'>
				    			<div class='custom-select'>
				    			<select id='show' name='show' onchange='this.form.submit()'>
				                    <option value='0'>Select a Show</option>";
				                    $html .= GetShowsDrop(); #$search,$type,$toptab,$selected
				                    $html .= "
								</select>
								</div>
							</form>
							</span>";
							break;						
			    	}
			    $html .= "
			    </div>
		</div>";

//=====================================================================================================================Page Left Menu Buttons

		$html .= "
		<div id='container'>
			<div id='controls'><br>
					
				<div class='sidemenu'>
		   			<ul>
		   					<li><a href='show.php?action=SEL'>Sell Items</a></li>
		   					<li><a href='show.php?action=NOT'>Add Notes</a></li>
							<li><a href='show.php?action=SHO'>Edit Show</a></li>
		    		</ul>
				</div>
			
	   		</div>
	    	<div class='showdata'>
	    		<div style='width:40%;float:left'>
					<table style='font-size:large;'>
						<tr><td>Show Date:</td><td style='font-weight:bold;'>$ShowDate</td></tr>			
						<tr><td>Start Time:</td><td>$Start</td></tr>	
						<tr><td>Finish Time:</td><td>$Finish</td></tr>	
						<tr><td>Location:</td><td>$Location</td></tr>	
						<tr><td>Location Address:</td><td>$LocationAddress</td></tr>	
						<tr><td>Location City:</td><td>$LocationCity</td></tr>	
						<tr><td>Location State:</td><td>$LocationState</td></tr>	
						<tr><td>Contact Name:</td><td>$ContactName</td></tr>	
						<tr><td>Contact Email:</td><td>$ContactEmail</td></tr>	
						<tr><td>Contact Phone:</td><td>$ContactPhone</td></tr>	
					</table><br>
					
					<div class='shownotes'>Show Notes:</div><br>
					
					<div class='notes'>";
						$file = 'Documents/' . $show . '.txt';
				    	$text = file_get_contents($file);
				    	
				    	$html .= "
				    		<div id='ovrleft'>				    		
					    		<div class='containform'>
						    				
					    			<form action='show.php' method='post'>
										<input class='canceltext2' type='submit' value='Cancel'>
									</form>
									
									<form action='show.php?file=$file' method='post'>
					    				<input class='savetext2' type='submit' value='Save Changes'>
					    				<span id='change'>Dont forget to save your changes.</span>
						    			<textarea style='background-color:white;' id='text' name='text' cols='79' rows='26' onblur='showSave()'>$text</textarea>
									</form>
									
									&nbsp;&nbsp;
								</div>
							</div>
						   	
					</div>
					
				</div>";
				
					$return = Sales($showname,'show',"","");
					$parts = explode("^",$return);
					$money = '$' . number_format($parts[1], 2);
				$html .= "
				<div style='float:left;display:inline-block;padding-left:40px;font-size:large;color:white'>
						<div>
							Number of Items Sold:  <span style='font-weight:bold;font-size:x-large;'>$parts[3]</span><br>
							Total Sales:  <span style='font-weight:bold;font-size:x-large;'>$money</span><br><br>
							<span style='font-size:small;'>$parts[2]</span>
						</div>
				</div>
				
				<div class='Sales'>";
					
					$html .= $parts[0];
					$html .= "
					
				</div>
			</div>";
	
	
		
		$html .= "
		
	</body>
</html>";

//#############################################################################################################################################echo html Page to screen

echo $html
?>
