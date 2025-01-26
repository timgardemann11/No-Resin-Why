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


if (isset($_GET['action'])) {
    $action = $_GET['action'];

} else {
    $action = "";
}

if(isset($_POST["lookuptxt"])) {
	$lookuptxt = $_POST["lookuptxt"];
} else {
	$lookuptxt = "";
}

if(isset($_POST['subcart'])){
	$ItemID = $_POST['selid'];
	$Shape = $_POST['selshape'];
	$Description = $_POST['seldesc'];
	$SalePrice = $_POST['saleprice'];
	$Cost = $_POST['selcost'];
	$lookuptxt = "";
	
	$result = AddCart($ItemID,$Shape,$Description,$SalePrice);

} else {
	$ItemID = "";
	$Shape = "";
	$Description = "";
	$SalePrice = "";
	$Cost = "";

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

if(isset($_GET['delcart'])) {
	$delcart = $_GET['delcart'];
	$result = DeleteCartItem($delcart);
}

if(isset($_GET['cart'])) {
	$answer = $_GET['cart'];
	if($answer == 'complete'){
		$result = FinalizeSale($showname);
	} else {
		$answer = "";
	}
}



//#############################################################################################################################################Build html Page

//=====================================================================================================================Page Headers and script

$html = "
<html>
    <head>
        <title></title>
        <link href='NRWShow.css' rel='stylesheet' type='text/css'/>
        <link rel='stylesheet' href='//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
        <meta name='viewport' content='width=device-width, initial-scale=0.60'>
        
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
			
			function lookupadd(val){
				 let current = document.getElementById('lookuptxt').value
				 let newvalue = +current + +newvalue
				 document.getElementById('lookuptxt').value = '44';
			}
			
			function calchange(val){
				Total = document.getElementById('totaldue').value
				Change = val - Total;
				Change = (Math.round(Change * 100) / 100).toFixed(2);
				document.getElementById('changedue').value = Change;
			}
						
		</script>
		
		<script>

		function setFocusToTextBox(){
		    document.getElementById('lookuptxt').addEventListener('focus', function(){
				document.getElementById('button1').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );
				document.getElementById('button2').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );
				document.getElementById('button3').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );
				document.getElementById('button4').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );
				document.getElementById('button5').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );
				document.getElementById('button6').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );
				document.getElementById('button7').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );
				document.getElementById('button8').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );
				document.getElementById('button9').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );	
				document.getElementById('buttonbs').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );
				document.getElementById('button0').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );
				document.getElementById('buttond').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );
				document.getElementById('buttonc').setAttribute( 'onClick', 'javascript: LookupClick(this.value);' );	
				document.getElementById('lookuptxt').focus();
			});
			document.getElementById('saleprice').addEventListener('focus', function(){
				document.getElementById('button1').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );
				document.getElementById('button2').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );
				document.getElementById('button3').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );
				document.getElementById('button4').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );
				document.getElementById('button5').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );
				document.getElementById('button6').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );
				document.getElementById('button7').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );
				document.getElementById('button8').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );
				document.getElementById('button9').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );
				document.getElementById('buttonbs').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );	
				document.getElementById('button0').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );	
				document.getElementById('buttond').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );
				document.getElementById('buttonc').setAttribute( 'onClick', 'javascript: SalePriceClick(this.value);' );	
				document.getElementById('saleprice').focus();
			});
			document.getElementById('amounttended').addEventListener('focus', function(){
				document.getElementById('button1').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );
				document.getElementById('button2').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );
				document.getElementById('button3').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );
				document.getElementById('button4').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );
				document.getElementById('button5').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );
				document.getElementById('button6').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );
				document.getElementById('button7').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );
				document.getElementById('button8').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );
				document.getElementById('button9').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );
				document.getElementById('buttonbs').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );	
				document.getElementById('button0').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );	
				document.getElementById('buttond').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );
				document.getElementById('buttonc').setAttribute( 'onClick', 'javascript: TendedClick(this.value);' );	
				document.getElementById('amounttended').focus();
			});		
		}
		
		function LookupClick(val)
		{
			let current = document.getElementById('lookuptxt').value;
			switch (val) {
				case 'BKSP':
					slen = current.length -1;
					newval = current.substring(0,slen);
					break;
				case '.':
					newval = current + val;
					break;
				case 'Clear':
					newval = '';
					break;

				default:
					newval = current + val;	
			}
			document.getElementById('lookuptxt').value= newval;
		}
		
		function SalePriceClick(val)
		{
			let current = document.getElementById('saleprice').value;
			switch (val) {
				case 'BKSP':
					slen = current.length -1;
					newval = current.substring(0,slen);
					break;
				case '.':
					newval = current + val;
					break;
				case 'Clear':
					newval = '';
					break;

				default:
					newval = current + val;	
			}
			document.getElementById('saleprice').value= newval;
		}
		
		function TendedClick(val)
		{ 
			let current = document.getElementById('amounttended').value;
			switch (val) {
				case 'BKSP':
					slen = current.length -1;
					newval = current.substring(0,slen);
					break;
				case '.':
					newval = current + val;
					break;
				case 'Clear':
					newval = '';
					break;

				default:
					newval = current + val;	
			}
			document.getElementById('amounttended').value= newval;
			calchange(newval);
		}

		    
		
		</script>
		<body onload='setFocusToTextBox()'>
		
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
				    			<a href='show.php?select=set'><div class='button' style='width:140;font-size:x-large;'>Set Show</div></a>
				    			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='show'>$showname</span>";
				    		} else {
				    			$html .= "
				    			<a href='show.php?select=set'><div class='button' style='width:140;font-size:x-large;';>Change Show</div></a>
				    			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='show'>$showname</span>";
							}
			    			break;
			    		
			    		case "set":
			    			$html .= "<div class='buttondisabled' style='width:140;font-size:x-large;';>Set Show</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='showselector'>
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
						$answer = file_exists('Documents/' . $show . '.txt');
						
						If($answer == false){
							$myfile = fopen('Documents/' . $show . '.txt', 'w');
							fclose($myfile);
						}
						
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
			</div>
		</div>";
			
			
			//=====================================================================================================================Hidden Dialogs
		
		#----------------------------------------------------Get the Dialog variables
		
			
			
			#-----------------------------------------------The Actual Dialog Layout
			
			switch($action) {
			case 'SEL':
				$html .= "<div class='action'></div>
				
				<div class='form1'>
					<a href='show.php'><div class='exit'>Cancel</div></a>
					<div class='formtitle'>Customer Sales $lookuptxt</div><br><br>
					<div class='salescontainer'>
						<div class='input'>
							<table>
								<tr>
									<td><input class='calcbutton' id='button1' type='button' value='1' onclick='LookupClick(this.value)'></td>
									<td><input class='calcbutton' id='button2' type='button' value='2' onclick='LookupClick(this.value)'></td>
									<td><input class='calcbutton' id='button3' type='button' value='3' onclick='LookupClick(this.value)'></td>
								</tr>
								<tr>
									<td><input class='calcbutton' id='button4' type='button' value='4' onclick='LookupClick(this.value)'></td>
									<td><input class='calcbutton' id='button5' type='button' value='5' onclick='LookupClick(this.value)'></td>
									<td><input class='calcbutton' id='button6' type='button' value='6' onclick='LookupClick(this.value)'></td>
								</tr>
								<tr>
									<td><input class='calcbutton' id='button7' type='button' value='7' onclick='LookupClick(this.value)'></td>
									<td><input class='calcbutton' id='button8' type='button' value='8' onclick='LookupClick(this.value)'></td>
									<td><input class='calcbutton' id='button9' type='button' value='9' onclick='LookupClick(this.value)'></td>
								</tr>
								<tr>
									<td><input class='calcbutton' id='buttonbs' type='button' value='BKSP' onclick='LookupClick(this.value)'></td>
									<td><input class='calcbutton' id='button0' type='button' value='0' onclick='LookupClick(this.value)'></td>
									<td><input class='calcbutton' id='buttond' type='button' value='.' onclick='LookupClick(this.value)'></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td><input class='calcbutton' id='buttonc' type='button' value='Clear' onclick='LookupClick(this.value)'></td>
								</tr>

								
							</table>
						</div>
						
						<div class='selection'>
							<form action='show.php?action=SEL' method='post' enctype='multipart/form-data'>
									<div class='locator'>Item Locator<br><br>
										<input class='selinput' type='text' id='lookuptxt' name='lookuptxt' value='$lookuptxt'><br><br>
										<input class='selsubmit' type='submit' id='sublookup' name='sublookup' value='Find Item'><br><br>";
										if($lookuptxt <>""){
											$showdata = Inventory("","table","","SEL$lookuptxt");
											$showparts = explode("^",$showdata); #return "$return0^$Total1^$opstable2^$Count3^$Shape4^$EDescShort5^$RAmount6^$Cost7^$IID";
											$html .= "$showparts[2]<br>";
										}
										$html .= "	
										Sale Price: <input class='selinput' type='text' id='saleprice' name='saleprice' value=$showparts[6]>
											<br><br>";
										if($lookuptxt <>""){
											$showparts[5] = substr($showparts[5],0,21) . "...";
											$html .= "	
											<input class='selsubmit' type='submit' id='subcart' name='subcart' value='Add Item to Cart'>
											<input type='hidden' id='selid' name='selid' value='$showparts[8]'>
											<input type='hidden' id='selshape' name='selshape' value='$showparts[4]'>
											<input type='hidden' id='seldesc' name='seldesc' value='$showparts[5]'>
											<input type='hidden' id='selamount' name='selamount' value='$showparts[6]'>
											<input type='hidden' id='selcost' name='selcost' value='$showparts[7]'>";
										}
										$html .= "
									</div>
							</form>
						</div>
						
						<div class='cart'>
							<form action='show.php?action=SEL' method='post' enctype='multipart/form-data'>
									<div class='cartcontrols'>Shopping Cart<br><br>";
										$CartData = GetCart();
										$CartParts = explode("^",$CartData);
										if(count($CartParts) > 1){
											$Total = number_format($CartParts[2],2);
											$Count = $CartParts[1];
											$html .= $CartParts[0];
										 
											$html .="
											<br>
											<div style='float:left;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$Count Items</div><div style='float:right;'>Total Due: <input class='selinput' type='text' id='totaldue' name='totaldue' value='$Total' disabled='disabled'></div><br><br>
											<div style='float:left;'>&nbsp;</div><div style='float:right;'>Amount Tended: <input class='selinput' type='text' id='amounttended' name='amounttended' value='' onkeyup='calchange(this.value);'></div><br><br>
											<a href='show.php?cart=complete'><div class='compbutton' style='float:left;'>Complete Sale</div></a><div style='float:right;'>Change Due: <input class='selinput' type='text' id='changedue' name='changedue' disabled='disabled'></div><br>";
										}
										
										$html .= "
									</div>
							</form>
						</div>
		
						
					</div>
				</div>";
	
			break;		
		}		
		
		$html .= "
		
	</body>
</html>";

//#############################################################################################################################################echo html Page to screen

echo $html
?>
