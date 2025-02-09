<?php



#------------------------------------------------get the correct variables for the form
function Dialog($action,$ID,$search,$toptab,$operation)
{
	$footer = "";
	
			switch ($action){
				case 'tag':
					$title = "Print Retail Tags";
					$headers = "<tr><td>Print Tags button will open tags page in a new tab.  If the page prints successfully, return here and click Mark Tags Printed button.</td></tr>";
					$inputs = "<tr><td><button class='button' onclick='window.open(&apos;print.php&apos;,&apos;_blank&apos;)'>Print Tags</button></td></tr>";
					$subid = 'subtag';
					$subtxt = "Mark Tags as Printed";
					$top = 'INV';

					break;
					
				case 'EXP':
					$title = "Add Expense";
					$TDate = Date('m/d/Y');
					$headers = "<tr><td>Expense Date</td><td>Vendor</td><td>Description</td><td>Amount</td></tr>";
					$inputs = "<td><input type='text' id='datepicker' name='edate' value='$TDate'></td>
						 		<td><select id='evendor' name='evendor' onchange='DropDownChanged(this);'>
			                            <option value='0'>Select a Vendor</option>";
			                            $inputs .= vendors($search,'drop',$toptab," "); #$search,$type,$toptab,$selected
			                            $inputs .= "
			                            <option value=''>Other..</option>
									</select>
									<input type='text' id='evtext' name='evtext' style='display: none;' /></td>
								<td><input type='text' id='edescription' name='edescription' size='30'/></td>
								<td><input type='number' id='eamount' name='eamount' step='.01' onchange='PopulateExpenseAccounts(this.value);'></td>";
										
					$footer .= "<hr /><br>
								<table style='font-size:small;padding: 1px;border-spacing: 2px;'>
								<tr><td>&nbsp;</td><td>Expense Account Name</td><td>Amount</td></tr>
								<tr>";
								$footer .= GetAllAccounts("");
								$footer .= "</table>";
							
					$subid = 'subexpadd';
					$subtxt = "Add This Expense";
					$top = 'EXP';
					break;
					
				case 'EXPMBL':
					$title = "Add Expense";
					
					$headers = "";
					$inputs = "<table>
								<tr><td>Expnse Date<br><input type='text' id='datepicker' name='edate' value='$TDate'></td></tr>
						 		<tr><td>Vendor<br><select id='evendor' name='evendor' onchange='DropDownChanged(this);'>
			                            <option value='0'>Select a Vendor</option>";
			                            $inputs .= vendors($search,'drop',$toptab," "); #$search,$type,$toptab,$selected
			                            $inputs .= "
			                            <option value=''>Other..</option>
									</select>
									<input type='text' id='evtext' name='evtext' style='display: none;' /></td></tr>
								<tr><td>Description<br><input type='text' id='edescription' name='edescription' size='30'/></td></tr>
								<tr><td>Amount<br><input type='number' id='eamount' name='eamount' step='.01' onchange='PopulateExpenseAccounts(this.value);'></td></tr>
								</table>";
										
					$footer .= "<hr /><br>
								<table style='font-size:small;padding: 1px;border-spacing: 2px;'>
								<tr><td>&nbsp;</td><td>Expense Account Name</td><td>Amount</td></tr>
								<tr>";
								$footer .= GetAllAccounts("");
								$footer .= "</table>";
							
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
					$footer .= "<hr /><br>
								<table style='font-size:small;padding: 1px;border-spacing: 2px;'>
								<tr><td>&nbsp;</td><td>Expense Account Name</td><td>Amount</td></tr>
								<tr>";
								$footer .= GetAllAccounts($ID);
								$footer .= "</table>";

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
			                            $inputs .= vendors($search,'drop',$toptab,$parts[1]);
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
					$selectedSMold ="$parts[5] $parts[1] $parts[6]";
					
					$headers = "<tr><td width='120'>Production Date</td><td width='300'>Mold</td><td width='300'>Description</td></tr>";
					$inputs = "<tr>
									<td><input type='text' id='datepicker' name='edate' value='$parts[0]'></td>
							 		<td width='120'><select id='mshape' name='mshape' onchange='PopulateItemFields(this.value);'>
				                            <option value='0'>Select a Mold</option>";
				                            $inputdata = Molds($search,'drop',$toptab,$operation,$parts[5]);
							                $inputparts = explode("^",$inputdata);
							                $inputs .= $inputparts[0];

				                            $inputs .= "
										</select>
									</td>
									<td><input type='text' id='description' name='description' size='30' value='$parts[2]'/></td>
								</tr>
								<tr><td colspan='4'>&nbsp;$selectedSMold</td></tr>
								<tr><td colspan='4'>&nbsp;</td></tr>
								<tr><td width='100'>Add to Price</td><td width='100'>Retail Price</td></tr>
								<tr>
									<td><input type='number' id='priceadd' name='priceadd' step='.01' value='$parts[7]' onchange='PriceAdd(this.value);'></td>
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
				                            $inputdata = Molds($search,'drop',$toptab,$operation,$parts[5]);
							                $inputparts = explode("^",$inputdata);
							                $inputs .= $inputparts[0];
				                            $inputs .= "
										</select>
									</td>
									<td><input type='text' id='description' name='description' size='30' value='$parts[2]'/></td>
								</tr>
								<tr><td colspan='4'>&nbsp;</td></tr>
								<tr><td colspan='4'>&nbsp;</td></tr>
								<tr><td width='100'>Add to Price</td><td width='100'>Retail Price</td></tr>
								<tr>
									<td><input type='number' id='priceadd' name='priceadd' step='.01' value='$parts[7]' onchange='PriceAdd(this.value);'></td>
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
					$inputs = "
									<td><input type='text' id='datepicker' name='edate' value='$TDate'></td>
							 		<td width='120'><select id='mshape' name='mshape' onchange='PopulateItemFields(this.value);'>
							                            <option value='0'>Select a Mold</option>";
							                            	$inputdata = Molds($search,'drop',$toptab,$operation,'');
							                            	$inputparts = explode("^",$inputdata);
							                            	$inputs .= $inputparts[0];
							                            	$inputs .= "
													</select>
									</td>
									<td><input type='text' id='description' name='description' size='30'/></td>
								</tr>";
								$inputs .= "
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
				                            $inputs .= Sizes($search,'drop',$toptab,"");
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

			
			case 'EXA':
					$title = "Add Expense Account";
					$headers = "<tr><td>Name</td><td>Description</td></tr>";
					$inputs = "<tr><td><input type='text' id='name' name='name'/></td>
						 		<td><input type='text' id='description' name='description'/></td>
								</tr>";
					$subid = 'subexaadd';
					$subtxt = "Add This Exp Account";
					$top = 'EXA';
					break;

			case 'EditEXA':
					$title = "Edit Expense Account";
					$data = GetExpAcct($ID); 
					$parts = explode("^",$data); #$return = "$AID^$Name^$Description";

					$headers = "<tr><td>Name</td><td>Description</td></tr>";
					$inputs = "<tr><td><input type='text' id='name' name='name' value='$parts[1]'/></td>
						 		<td><input type='text' id='description' name='description' value='$parts[2]'/></td>
								</tr>
								<input type='hidden' id='aid' name='aid' value='$ID'/>";
					$subid = 'subexaup';
					$subtxt = "Edit This Exp Account";
					$top = 'EXA';
					break;
			
			
			case 'DeleteEXA':
					$title = "Delete Expense Account";
					$data = GetExpAcct($ID); 
					$parts = explode("^",$data); #$return = "$AID^$Name^$Description";

					$headers = "<tr><td>Name</td><td>Description</td></tr>";
					$inputs = "<tr><td><input type='text' id='name' name='name' value='$parts[1]'/></td>
						 		<td><input type='text' id='description' name='description' value='$parts[2]'/></td>
								</tr>
								<input type='hidden' id='aid' name='aid' value='$ID'/>";
					$subid = 'subexadel';
					$subtxt = "Delete This Exp Account";
					$top = 'EXA';
					break;

			case 'SHO':
					$title = "Schedule Craft Show";
					
					$headers = "<tr><td>Name</td><td>Date</td><td>Start</td><td>Finish</td></tr>";
					$inputs = "<tr><td><input type='text' id='name' name='name'/></td>
									<td><input type='text' id='datepicker' name='sdate'></td>
						 			<td><input type='text' id='start' name='start'/></td>
						 			<td><input type='text' id='finish' name='finish'/></td>
								</tr>";
								
					$footer .= "<hr /><br>
								<table>
								<tr><td>Location</td>
									<td><input type='text' id='location' name='location'></td>
									<td>&nbsp;</td>
									<td>Contact Name</td>
									<td><input type='text' id='contactname' name='contactname'></td>
								</tr>
								
								<tr><td>Location Address</td>
									<td><input type='text' id='locationaddress' name='locationaddress'></td>
									<td>&nbsp;</td>
									<td>Contact Email</td>
									<td><input type='text' id='contactemail' name='contactemail'></td>
								</tr>
								
								<tr><td>Location City</td>
									<td><input type='text' id='locationcity' name='locationcity'></td>
									<td>&nbsp;</td>
									<td>Contact Phone</td>
									<td><input type='text' id='contactphone' name='contactphone'></td>
								</tr>
								
								<tr><td>Location State</td>
									<td><input type='text' id='locationstate' name='locationstate'></td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>";
					
					
					$subid = 'subsho';
					$subtxt = "Add This Show";
					$top = 'INV';
					break;
					
			case 'EditSHO':
					$title = "Edit Craft Show";
					$data = GetShow($ID); 
					$parts = explode("^",$data); # $return .= "$shid0^$SDate1^$Name2^$Start3^$Finsih4^$Location5^$LocationAddress6^$LocationCity7^$LocationState8^$ContactName9^$ContactEmail10^$ContactPhone11";

					$headers = "<tr><td>Name</td><td>Date</td><td>Start</td><td>Finish</td></tr>";
					$inputs = "<tr><td><input type='text' id='name' name='name' value='$parts[2]'/></td>
									<td><input type='text' id='datepicker' name='sdate' value='$parts[1]'></td>
						 			<td><input type='text' id='start' name='start' value='$parts[3]'/></td>
						 			<td><input type='text' id='finish' name='finish' value='$parts[4]'/></td>
								</tr>";
								
					$footer .= "<hr /><br>
								<table>
								<tr><td>Location</td>
									<td><input type='text' id='location' name='location' value='$parts[5]'></td>
									<td>&nbsp;</td>
									<td>Contact Name</td>
									<td><input type='text' id='contactname' name='contactname' value='$parts[9]'></td>
								</tr>
								
								<tr><td>Location Address</td>
									<td><input type='text' id='locationaddress' name='locationaddress' value='$parts[6]'></td>
									<td>&nbsp;</td>
									<td>Contact Email</td>
									<td><input type='text' id='contactemail' name='contactemail' value='$parts[10]'></td>
								</tr>
								
								<tr><td>Location City</td>
									<td><input type='text' id='locationcity' name='locationcity' value='$parts[7]'></td>
									<td>&nbsp;</td>
									<td>Contact Phone</td>
									<td><input type='text' id='contactphone' name='contactphone' value='$parts[11]'></td>
								</tr>
								
								<tr><td>Location State</td>
									<td><input type='text' id='locationstate' name='locationstate' value='$parts[8]'></td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr><input type='hidden' id='shid' name='shid' value='$ID'/>";
					
					
					$subid = 'subshoup';
					$subtxt = "Update This Show";
					$top = $toptab;
					break;

					
			case 'SHOMBL':
					$title = "Schedule Craft Show";
					
					$headers = "";
					$inputs = "<table>
								<tr><td>Name<br><input type='text' id='name' name='name'/></td></tr>
								<tr><td>Date<br><input type='text' id='datepicker' name='sdate'></td></tr>
						 		<tr><td>Start Time<br><input type='text' id='start' name='start'/></td></tr>
						 		<tr><td>End Time<br><input type='text' id='finish' name='finish'/></td></tr>
						 		<tr><td>Location<br><input type='text' id='location' name='location'></td></tr>
								<tr><td>Location Address<br><input type='text' id='locationaddress' name='locationaddress'></td></tr>
								<td>Contact Name<br><input type='text' id='contactname' name='contactname'></td></tr>
								<td>Contact Email<br><input type='text' id='contactemail' name='contactemail'></td></tr>
								<tr><td>Location City<br><input type='text' id='locationcity' name='locationcity'></td></tr>
								<tr><td>Contact Phone<br><input type='text' id='contactphone' name='contactphone'></td></tr>
								<tr><td>Location State<br><input type='text' id='locationstate' name='locationstate'></td></tr>
							  </table>";
								
					$footer .= "<hr /><br>
								
								";
					
					
					$subid = 'subsho';
					$subtxt = "Add This Show";
					$top = 'mnu';
					break;
			
			case 'SLD':
					$title = "Mark Item as Sold";
					$showparts[6] = "";
					$headers = "";
					
					$inputs = "<form action='Default.php?action=SLD&toptab=INV' method='post' enctype='multipart/form-data'>
									<div class='locator2'>Item Locator<br>
										<input class='selinput' type='text' id='lookuptxt' name='lookuptxt' value='$operation'>
										<input class='selsubmit' type='submit' id='sublookup' name='sublookup' value='Find Item'><br></div>&nbsp;<br><br>";
										if($operation <> ""){
											$showdata = Inventory("","table","","SEL$operation");
											$showparts = explode("^",$showdata); #return "$return0^$Total1^$opstable2^$Count3^$Shape4^$EDescShort5^$RAmount6^$Cost7^$IID";
											$inputs .= "$showparts[2]<br></form>";
										}
										$inputs .= "<div class='locator'><form action='Default.php?toptab=SAL' method='post' enctype='multipart/form-data'>";
										if($operation <> ""){
											$showparts[5] = substr($showparts[5],0,21) . "...";
											$inputs .= "	
											Sale Price: <input class='selinput' type='text' id='saleprice' name='saleprice' value=$showparts[6]>
											<br><br>
											<input class='selsubmit' type='submit' id='subsold' name='subsold' value='Mark this Item as Sold'>
											<input type='hidden' id='selid' name='selid' value='$showparts[8]'>
											<input type='hidden' id='selshape' name='selshape' value='$showparts[4]'>
											<input type='hidden' id='seldesc' name='seldesc' value='$showparts[5]'>
											<input type='hidden' id='selamount' name='selamount' value='$showparts[6]'>
											<input type='hidden' id='selcost' name='selcost' value='$showparts[7]'>";
										}
										$inputs .= "
									</div>
							</form>";
								
					$footer .= "";
					
					
					$subid = 'subsld';
					$subtxt = "Sell this Item";
					$top = $toptab;
					break;
					
			case 'SLDMBL':
					$title = "Mark Item as Sold";
					$showparts[6] = "";
					$headers = "";
					
					$inputs = "<form action='mobile.php?action=itm' method='post' enctype='multipart/form-data'>
									<div class='locator2'>Item Locator<br>
										<input class='selinput' type='text' id='lookuptxt' name='lookuptxt' value='$operation'>
										<input class='selsubmit' type='submit' id='sublookup' name='sublookup' value='Find Item'><br></div>&nbsp;<br><br>";
										if($operation <> ""){
											$showdata = Inventory("","table","","SEL$operation");
											$showparts = explode("^",$showdata); #return "$return0^$Total1^$opstable2^$Count3^$Shape4^$EDescShort5^$RAmount6^$Cost7^$IID";
											$inputs .= "$showparts[2]<br></form>";
										}
										$inputs .= "<div class='locator'><form action='mobile.php?toptab=SAL' method='post' enctype='multipart/form-data'>";
										if($operation <> ""){
											$showparts[5] = substr($showparts[5],0,21) . "...";
											$inputs .= "	
											Sale Price: <input class='selinput' type='text' id='saleprice' name='saleprice' value=$showparts[6]>
											<br><br>
											
											<input type='hidden' id='selid' name='selid' value='$showparts[8]'>
											<input type='hidden' id='selshape' name='selshape' value='$showparts[4]'>
											<input type='hidden' id='seldesc' name='seldesc' value='$showparts[5]'>
											<input type='hidden' id='selamount' name='selamount' value='$showparts[6]'>
											<input type='hidden' id='selcost' name='selcost' value='$showparts[7]'>";
										}
										$inputs .= "
									</div>";
								
					$footer .= "</form>";
					
					
					$subid = 'subsold';
					$subtxt = "Sell this Item";
					$top = $toptab;
					break;


			}	
			
	return "$title^$headers^$inputs^$footer^$subid^$subtxt^$top";
}
?>