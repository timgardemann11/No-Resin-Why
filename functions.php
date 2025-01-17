<?php

function Connect()
{
	$servername = "nrwphpsite-server.mysql.database.azure.com"; 
  	$username = "tekhneddch"; 
  	$password = "8\$qt3vaajySvWV4U"; 
  	$databasename = "no-resin-why"; 
  	
  	$conn = new mysqli($servername, $username, $password, $databasename);

	return $conn;
}


#======================================================================================================================================================Vendors

function Vendors($search,$type,$toptab,$selected)

{
    if($type == 'table'){
    	$return = "<table class='datatable'><tr class='vendorhd'><th width='90'>Vendor ID</th><th width='140'>Vendor Name</th><th width='150'>Account Number</th><th width='120'>Location</th></tr></table>
    				<div class='datascroll'>
					<table class='datatable'>";  
    } else {
    	$return = "";
    }
    	
  	$count = 0;
  	$opstable = "";

    try
    {
	   $conn = connect();
	   	    	
		// GET CONNECTION ERRORS 
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        if($search == ""){
        	$sql = "SELECT * FROM `no-resin-why`.vendor";
        } else {
        	$sql = "SELECT * FROM `no-resin-why`.vendor
					WHERE (lower(VendorName) like lower('%$search%') )
					or (lower(AccountNum) like lower('%$search%'))
					or (lower(Location) like lower('%$search%'))";
        }

        $result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$VID = $row["VendorID"];
				$VName = $row["VendorName"];
				$VAcct = $row["AccountNum"];
				$VLoc = $row["Location"];
				
				if($type == 'table'){
				    $return .= "<tr style='font-size:small;'><td width='90'><a href='default.php?toptab=$toptab&operation=VDR$VID' class='submenu'>Vendor ID $VID</a></td>
				    <td width='140'>$VName</td><td width='150'>$VAcct</td><td width='120'>$VLoc</td></tr>";
				} else {
					if($selected == $VName){
						$return .= "<option value='{$VName}' selected>{$VName}</option>";
					} else {
						$return .= "<option value='{$VName}'>{$VName}</option>";
					}
				}
				
				$findID = (int)substr($selected,3,strlen($selected) -3);
				if($findID == $VID) { #-----------------------Get the selected expense data
								$opstable = "<div><table class='datatable'>
									<tr class='vendorhd'><td colspan='2' sytle='font-weight:bold;' width='300'>Vend ID $VID</td></tr>
									<tr><td>Vendor Name</td><td>$VName</td></tr>
									<tr><td>Account Number</td><td>$VAcct</td></tr>
									<tr><td>Vendor Location</td><td>$VLoc</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr>
										<td><a href='default.php?toptab=$toptab&action=EditVDRz$VID' class='button'>Edit</a></td>
										<td><a href='default.php?toptab=$toptab&action=DeleteVDRz$VID' class='button'>Delete</a></td>
									</tr>
								</table></div>";
				}
			    
			    $count++;
			}
		} else {
			$return .= "<tr><td>No results</td></tr>";
		}
		if($type == 'table'){
			$return .= "</table></div>";
		}
        // Close connections
		mysqli_close($conn); 
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
	
	if($type == 'table'){
    	return "$return^$count^$opstable";
    } else {
    	return "$return";
    }
}




function AddVendor($vendor,$Account,$Location)
{
	 try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "INSERT INTO vendor (VendorName, AccountNum, Location) VALUES ('$vendor', '$Account', '$Location')";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "New vendor created successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}






function UpdateVendor($vendor,$Account,$Location,$vid)
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "UPDATE vendor SET VendorName='$vendor', AccountNum='$Account', Location='$Location' WHERE VendorID = $vid";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Vendor record updated successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}







function DeleteVendor($vendor,$Account,$Location,$vid)
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "DELETE FROM vendor WHERE VendorID = $vid";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Vendor record deleted successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}



function GetVendor($ID) 
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "SELECT * FROM `no-resin-why`.vendor
        		WHERE VendorID = $ID";
		
		$result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$VendorName = $row["VendorName"];
				$Account = $row["AccountNum"];
				$Location = $row["Location"];
				
				$return = "$VendorName^$Account^$Location";
			}
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}




#======================================================================================================================================================Expenses


function Expenses($search,$type,$toptab,$operation)
{
    if ($type == 'table'){
    	$return = "<table class='datatable'><tr class='expensehd'><th width='90'>Expense ID</th><th width='100'>Date</th><th width='150'>Vendor</th><th width='300'>Description</th><th width='90'>Amount</th></tr></table>
    				<div class='datascroll'>
					<table class='datatable'>";
    } else {
    	$return = "";
    }

   	$Total = 0;
  	$opstable = "";
  	
    try
    {
	  	$conn = connect();
	    	
		// GET CONNECTION ERRORS 
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        if($search == ""){
        	$sql = "SELECT * FROM `no-resin-why`.expenses";
        } else {
        	$sql = "SELECT * FROM `no-resin-why`.expenses
					WHERE (lower(Vendor) like lower('%$search%') )
					or (lower(Description) like lower('%$search%'))
					or (Date like '%$search%')
					or (Amount like '%$search%')";
        }
        
        $result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$EID = $row["ExpenseID"];
				$EDate = $row["Date"];
				$EVendor = $row["Vendor"];
				$EDescription = $row["Description"];
				$EAmount = $row["Amount"];
					
				if($type == 'table'){ #-----------------------Build the expense table
				    $return .= "<tr style='font-size:small;'><td width='90'><a href='default.php?toptab=$toptab&operation=EXP$EID' class='submenu'>EXP ID $EID</a></td>
				    				<td width='100'>$EDate</td><td width='150'>$EVendor</td><td width='300'>$EDescription</td><td width='90'>$EAmount</td></tr>";
				    $Total = $Total + $EAmount;
				} else { #-----------------------Build Expenses Drop Down
					$return .= "<option value='{$EVendor}'>{$EVendor}</option>";
				}
				
				$findID = (int)substr($operation,3,strlen($operation) -3);
				if($findID == $EID) { #-----------------------Get the selected expense data
					if (strlen($EDescription) > 26){
						$EDescShort = substr($EDescription,0,26) . "..";
					} else {
						$EDescShort = $EDescription;
					}
					$opstable = "<div><table class='datatable'>
									<tr class='expensehd'><td colspan='2' sytle='font-weight:bold;' width='300'>Expense ID $EID</td></tr>
									<tr><td>Date</td><td>$EDate</td></tr>
									<tr><td>Vendor</td><td>$EVendor</td></tr>
									<tr><td>Description</td><td>$EDescShort</td></tr>
									<tr><td>Amount</td><td>$EAmount</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr class='expensehd'><td colspan='2'>Expense Accounts</td></tr>
									<tr><td>Molds</td><td>value</td></tr>
									<tr><td>Color</td><td>value</td></tr>
									<tr><td>Overhead</td><td>value</td></tr>
									<tr><td>Resin</td><td>value</td></tr>
									<tr><td>Embedded</td><td>value</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr>
										<td><a href='default.php?toptab=$toptab&action=EditEXPz$EID' class='button'>Edit</a></td>
										<td><a href='default.php?toptab=$toptab&action=DeleteEXPz$EID' class='button'>Delete</a></td>
									</tr>
								</table></div>";
				} 
			}			
		} else {
			$return .= "<tr><td>No results</td></tr>";
		}
		$return .= "</table></div>";
        // Close connections
		mysqli_close($conn); 
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }

    return "$return^$Total^$opstable";
}





function AddExpense($edate,$evendor,$edescription,$eamount)
{
	 try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "INSERT INTO Expenses (Date, Vendor, Description, Amount) VALUES ('$edate', '$evendor', '$edescription', '$eamount')";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "New expense record created successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		
		$result = mysqli_insert_id($conn);;
		
		
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return^$result";
}






function UpdateExpense($edate,$evendor,$edescription,$eamount,$EID)
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "UPDATE Expenses SET Date='$edate', Vendor='$evendor', Description='$edescription', Amount='$eamount' WHERE ExpenseID = $EID";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Expense record updated successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}







function DeleteExpense($edate,$evendor,$edescription,$eamount,$EID)
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "DELETE FROM Expenses WHERE ExpenseID = $EID";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Expense record deleted successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		$sql ="DELETE FROM `no-resin-why`.`expensedetail` WHERE ExpenseID = $EID";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Expense record deleted successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}






function GetExpense($ID) 
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "SELECT * FROM `no-resin-why`.expenses";
		
		$result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$EID = $row["ExpenseID"];
				$EDate = $row["Date"];
				$EVendor = $row["Vendor"];
				$EDescription = $row["Description"];
				$EAmount = $row["Amount"];
				
				$return = "$EDate^$EVendor^$EDescription^$EAmount";
			}
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}




#======================================================================================================================================================Molds
   
function Molds($search,$type,$toptab,$operation,$selected)

{
    if($type == 'table'){
    	$return = "<table class='datatable'><tr class='moldhd'><th width='100'>Mold ID</th><th width='150'>Shape</th><th width='300'>Description</th><th width='90'>Size</th></tr></table>
    				<div class='datascroll'>
					<table class='datatable'>";
    } else {
    	$return = "";
    }

  	$count = 0;
  	$opstable = "";
  	
    try
    {
	    $conn = connect();
	    	    	
		// GET CONNECTION ERRORS 
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "SELECT * FROM `no-resin-why`.molds";
        if($search == ""){
        	$sql = "SELECT * FROM `no-resin-why`.molds";
        } else {
        	$sql = "SELECT * FROM `no-resin-why`.molds
					WHERE (lower(Shape) like lower('%$search%') )
					or (lower(Description) like lower('%$search%'))
					or (lower(Size) like lower('%$search%'))";
        }

        $result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$MID = $row["MoldID"];
				$Shape = $row["Shape"];
				$Description = $row["Description"];
				$Size = $row["Size"];			    
			    
			    if($type == 'table'){ #-----------------------Build the Items table
				    $return .= "<tr style='font-size:small;'><td width='100'><a href='default.php?toptab=$toptab&operation=MLD$MID' class='submenu'>Mold ID $MID</a></td>
				    				<td width='150'>$Shape</td><td width='300'>$Description</td><td width='90'>$Size</td></tr>";
				    $count++;
				} else { #-----------------------Build Items Drop Down
					$addons = GetSizeSize($Size);#$return = "$SID^$Size^$Mod^$Cost^$Markup^$Price";
					$addon = explode('^',$addons);
					if($selected == $MID){
						$return .= "<option value='{$MID} {$Shape} {$Size} {$addon[3]} {$addon[5]}' selected>{$MID} {$Shape} {$Size}</option>";
					} else {
						$return .= "<option value='{$MID} {$Shape} {$Size} {$addon[3]} {$addon[5]}'>{$MID} {$Shape} {$Size}</option>";
					}
				}
				
				$findID = (int)substr($operation,3,strlen($operation) -3);
				if($findID == $MID) { #-----------------------Get the selected expense data
					if (strlen($Description) > 26){
						$EDescShort = substr($Description,0,26) . "..";
					} else {
						$EDescShort = $Description;
					}
					$opstable = "<div><table class='datatable'>
									<tr class='moldhd'><td colspan='2' sytle='font-weight:bold;' width='300'>Mold ID $MID</td></tr>
									<tr><td>Shape</td><td>$Shape</td></tr>
									<tr><td>Description</td><td>$Description</td></tr>
									<tr><td>Size</td><td>$Size</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr>
										<td><a href='default.php?toptab=$toptab&action=EditMLDz$MID' class='button'>Edit</a></td>
										<td><a href='default.php?toptab=$toptab&action=DeleteMLDz$MID' class='button'>Delete</a></td>
									</tr>
								</table></div>";
				} 			    
			    
			}
		} else {
			$return .= "<tr><td>No results</td></tr>";
		}
		if($type <> 'drop'){
			$return .= "</table></div>";
		}
        // Close connections
		mysqli_close($conn); 
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }

    return "$return^$count^$opstable";
}



function AddMold($shape,$description,$size)
{
	 try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "INSERT INTO molds (Shape, Description, Size) VALUES ('$shape', '$description', '$size')";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "New mold created successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}






function UpdateMold($shape,$description,$size,$mid)
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "UPDATE molds SET Shape='$shape', Description='$description', Size='$size' WHERE MoldID = $mid";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Mold record updated successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}





function DeleteMold($shape,$description,$size,$mid)
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "DELETE FROM molds WHERE MoldID = $mid";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Mold record deleted successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}




function GetMold($ID) 
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "SELECT * FROM `no-resin-why`.molds
        		WHERE MoldID = $ID";
		
		$result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$MID = $row["MoldID"];
				$Shape = $row["Shape"];
				$Description = $row["Description"];
				$Size = $row["Size"];
								
				$return = "$Shape^$Description^$Size^$MID";
			}
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}




#======================================================================================================================================================Inventory

function Inventory($search,$type,$toptab,$operation)
{
    $return = "<table class='datatable'><tr class='inventoryhd'><th width='100'>Item ID</th><th width='150'>Mold Shape</th><th width='250'>Description</th><th width='80'>Cost</th><th width='100'>Retail Price</th></tr></table>
    <div class='datascroll'>
	<table class='datatable'>";
  	$Total = 0;
  	$Count = 0;
  	$opstable = "";
  	
    try
    {
	  	$conn = connect();
	    	
		// GET CONNECTION ERRORS 
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        if($search == ""){
        	$sql = "SELECT * FROM `no-resin-why`.items
        			WHERE SalePrice IS NULL";
        } else {
        	$sql = "SELECT * FROM `no-resin-why`.items
					WHERE SalePrice IS NULL 
					and (lower(MoldShape) like lower('%$search%') )
					or (lower(Description) like lower('%$search%'))
					or (Cost like '%$search%')
					or (ItemID like '%$search%')
					or (RetailPrice like '%$search%')";
					
        }
        
        $result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$IID = $row["ItemID"];
				$Shape = $row["MoldShape"];
				$Description = $row["Description"];
				$Cost = $row["Cost"];
				$RAmount = $row["RetailPrice"];
				$ProdDate = $row["ProductionDate"];
				$MoldID = $row["MoldID"];
				$MoldSize = $row["MoldSize"];
				$PriceAdd = $row["PriceAddition"];
				$TAG = $row["TAGPrinted"];
				
					
				if($type == 'table'){ #-----------------------Build the Items table
				    $return .= "<tr style='font-size:small;'><td width='100'><a href='default.php?toptab=$toptab&operation=ITM$IID' class='submenu'>ITEM ID $IID</a></td>
				    				<td width='150'>$Shape</td><td width='250'>$Description</td><td width='80'>$Cost</td><td width='80'>$RAmount</td></tr>";
				    $Total = $Total + $RAmount;
				    $Count++;
				} else { #-----------------------Build Items Drop Down
					if($selected == $IID){
						$return .= "<option value='{$IID}' selected>$IID $Shape $Description</option>";
					} else {
						$return .= "<option value='{$IID}'>$IID $Shape $Description</option>";
					}
				}
								
				$findID = (int)substr($operation,3,strlen($operation) -3);
				if($findID == $IID) { #-----------------------Get the selected expense data
					if (strlen($Description) > 26){
						$EDescShort = substr($Description,0,26) . "..";
					} else {
						$EDescShort = $Description;
					}
					$opstable = "<div><table class='datatable'>
									<tr class='inventoryhd'><td colspan='2' sytle='font-weight:bold;' width='300'>Item ID $IID</td></tr>
									<tr><td>Production Date</td><td>$ProdDate</td></tr>
									<tr><td>Mold ID</td><td>$MoldID</td></tr>
									<tr><td>Mold Shape</td><td>$Shape</td></tr>
									<tr><td>Description</td><td>$EDescShort</td></tr>
									<tr><td>Cost</td><td>$Cost</td></tr>
									<tr><td>Retail Price</td><td>$RAmount</td></tr>
									<tr><td>Price Add</td><td>$PriceAdd</td></tr>
									<tr><td>Tags Printed</td><td>$TAG</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr>
										<td><a href='default.php?toptab=$toptab&action=EditITMz$IID' class='button'>Edit</a></td>
										<td><a href='default.php?toptab=$toptab&action=DeleteITMz$IID' class='button'>Delete</a></td>
									</tr>
								</table></div>";
				} 
			}			
		} else {
			$return .= "<tr><td>No results</td></tr>";
		}
		$return .= "</table></div>";
        // Close connections
		mysqli_close($conn); 
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }

    return "$return^$Total^$opstable^$Count";
}




function AddItem($edate,$mshape,$description,$priceadd,$price,$moldid,$moldsize,$moldshape,$cost,$tag)
{
	$return = "";
	if($priceadd == ""){$priceadd = '0';}
	 try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "INSERT INTO `no-resin-why`.`items`(`ProductionDate`,`MoldID`,`MoldSize`,`MoldShape`,`Description`,`Cost`,`RetailPrice`,`PriceAddition`,`TAGPrinted`)
        		VALUES ('$edate', '$moldid', '$moldsize', '$moldshape', '$description', '$cost', '$price', '$priceadd', '$tag');";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "New Item created successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}






function UpdateItem($edate,$mshape,$description,$priceadd,$price,$moldid,$moldsize,$moldshape,$cost,$tag,$iid)
{
	$return = "";
	if($priceadd == ""){$priceadd = '0';}
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "UPDATE `no-resin-why`.`items` 
        SET `ProductionDate`='$edate', `MoldID`='$moldid', `MoldSize`='$moldsize', `MoldShape`='$moldshape', `Description`='$description', `Cost`='$cost', `RetailPrice`='$price', `PriceAddition`='$priceadd', `TAGPrinted`='$tag' 
        WHERE `ItemID` = $iid";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Item record updated successfully";
		} else {
		     $return = "Error: " . $sql ;
		}
	}   
    catch(Exception $e)
    {
        echo("Error! $sql");
    }
    return "$return";
}





function DeleteItem($edate,$mshape,$description,$priceadd,$price,$moldid,$moldsize,$moldshape,$cost,$tag,$iid)
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "DELETE FROM `no-resin-why`.`items` WHERE `ItemID` = $iid";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Item deleted successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error! $sql");
    }
    return "$return";
}






function GetItem($ID) 
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "SELECT * FROM `no-resin-why`.items
        		WHERE ItemID = $ID";
		
		$result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$IID = $row["ItemID"];
				$Shape = $row["MoldShape"];
				$Description = $row["Description"];
				$Cost = $row["Cost"];
				$RAmount = $row["RetailPrice"];
				$ProdDate = $row["ProductionDate"];
				$MoldID = $row["MoldID"];
				$MoldSize = $row["MoldSize"];
				$PriceAdd = $row["PriceAddition"];
				$TAG = $row["TAGPrinted"];
				
				$return = "$ProdDate^$Shape^$Description^$RAmount^$Cost^$MoldID^$MoldSize^$PriceAdd^$TAG";
			}
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}



#======================================================================================================================================================Sales

function Sales($search,$type,$toptab,$operation)
{
    $return = "<table class='datatable'><tr class='saleshd'><th width='80'>Item ID</th><th width='80'>Sale Date</th><th width='150'>Mold Shape</th><th width='200'>Description</th><th width='80'>Sale Price</th><th width='140'>Sale Loc</th></tr></table>
    <div class='datascroll'>
	<table class='datatable'>";
  	$Total = 0;
  	$Count = 0;
  	$opstable = "";
  	
    try
    {
	  	$conn = connect();
	    	
		// GET CONNECTION ERRORS 
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        if($search == ""){
        	$sql = "SELECT * FROM `no-resin-why`.items
        			WHERE SalePrice IS NOT NULL";
        } else {
        	$sql = "SELECT * FROM `no-resin-why`.items
					WHERE SalePrice IS NOT NULL 
					and (lower(MoldShape) like lower('%$search%') )
					or (lower(Description) like lower('%$search%'))
					or (Cost like '%$search%')
					or (ItemID like '%$search%')
					or (RetailPrice like '%$search%')
					or (SaleLocation like '%$search%')";
					
        }
        
        $result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$IID = $row["ItemID"];
				$Shape = $row["MoldShape"];
				$Description = $row["Description"];
				$Cost = $row["Cost"];
				$RAmount = $row["RetailPrice"];
				$ProdDate = $row["ProductionDate"];
				$MoldID = $row["MoldID"];
				$MoldSize = $row["MoldSize"];
				$PriceAdd = $row["PriceAddition"];
				$TAG = $row["TAGPrinted"];
				
				$SPrice = $row["SalePrice"];
				$SDate = $row["SaleDate"];
				$SLoc = $row["SaleLocation"];
				
				
					
				if($type == 'table'){ #-----------------------Build the Items table
				    $return .= "<tr style='font-size:small;'><td width='80'><a href='default.php?toptab=$toptab&operation=SAL$IID' class='submenu'>ITEM ID $IID</a></td>
				    				<td width='80'>$SDate</td><td width='150'>$Shape</td><td width='200'>$Description</td><td width='80'>$SPrice</td><td width='140'>$SLoc</td></tr>";
				    $Total = $Total + $RAmount;
				    $Count++;
				} else { #-----------------------Build Items Drop Down
					if($selected == $IID){
						$return .= "<option value='{$IID}' selected>$IID $Shape $Description</option>";
					} else {
						$return .= "<option value='{$IID}'>$IID $Shape $Description</option>";
					}
				}
				
				
				$findID = (int)substr($operation,3,strlen($operation) -3);
				if($findID == $IID) { #-----------------------Get the selected Items data
					if (strlen($Description) > 26){
						$EDescShort = substr($Description,0,26) . "..";
					} else {
						$EDescShort = $Description;
					}
					$opstable = "<div><table class='datatable'>
									<tr class='saleshd'><td colspan='2' sytle='font-weight:bold;' width='300'>Item ID $IID</td></tr>
									<tr><td>Production Date</td><td>$ProdDate</td></tr>
									<tr><td>Mold ID</td><td>$MoldID</td></tr>
									<tr><td>Mold Shape</td><td>$Shape</td></tr>
									<tr><td>Description</td><td>$EDescShort</td></tr>
									<tr><td>Cost</td><td>$Cost</td></tr>
									<tr><td>Retail Price</td><td>$RAmount</td></tr>
									<tr><td>Price Add</td><td>$PriceAdd</td></tr>
									<tr><td>Tags Printed</td><td>$TAG</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td>Sale Date</td><td>$SDate</td></tr>
									<tr><td>Sale Price</td><td>$SPrice</td></tr>
									<tr><td>Sale Location</td><td>$SLoc</td></tr>

									<tr>
										<td><a href='default.php?toptab=$toptab&action=EditSALz$IID' class='button'>Edit</a></td>
										<td><a href='default.php?toptab=$toptab&action=DeleteSALz$IID' class='button'>Delete</a></td>
									</tr>
								</table></div>";
				} 
			}			
		} else {
			$return .= "<tr><td>No results</td></tr>";
		}
		$return .= "</table></div>";
        // Close connections
		mysqli_close($conn); 
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }

    return "$return^$Total^$opstable^$Count";
}



#======================================================================================================================================================Sizes

function Sizes($search,$type,$toptab,$selected)

{
    if($type == 'table'){
    	$return = "<table class='datatable'><tr class='sizeshd'><th width='90'>Size ID</th><th width='100'>Size</th><th width='90'>Modifier</th><th width='90'>Cost</th><th width='90'>75% Markup</th><th width='90'>Price</th></tr></table>
    				<div class='datascroll'>
					<table class='datatable'>";  
    } else {
    	$return = "";
    }
    	
  	$count = 0;
  	$opstable = "";

    try
    {
	   $conn = connect();
	   	    	
		// GET CONNECTION ERRORS 
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        if($search == ""){
        	$sql = "SELECT * FROM `no-resin-why`.sizes";
        } else {
        	$sql = "SELECT * FROM `no-resin-why`.sizes
					WHERE (lower(Size) like lower('%$search%') )
					or (lower(SizeID) like lower('%$search%'))
					or (lower(Price) like lower('%$search%'))";
        }

        $result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$SID = $row["SizeID"];
				$Size = $row["Size"];
				$Mod = $row["Modifier"];
				$Cost = $row["Cost"];
				$Markup = $row["Markup"];
				$Price = $row["Price"];
				
				if($type == 'table'){
				    $return .= "<tr style='font-size:small;'><td width='90'><a href='default.php?toptab=$toptab&operation=SIZ$SID' class='submenu'>Size ID $SID</a></td>
				    <td width='100'>$Size</td><td width='90'>$Mod</td><td width='90'>$Cost</td><td width='90'>$Markup</td><td width='90'>$Price</td></tr>";
				} else {
					if($selected == $Size){
						$return .= "<option value='{$Size}' selected>{$Size}</option>";
					} else {
						$return .= "<option value='{$Size}'>{$Size}</option>";
					}
				}
				
				$findID = (int)substr($selected,3,strlen($selected) -3);
				if($findID == $SID) { #-----------------------Get the selected expense data
								$opstable = "<div><table class='datatable'>
									<tr class='sizeshd'><td colspan='2' sytle='font-weight:bold;' width='300'>Size ID $SID</td></tr>
									<tr><td>Size</td><td>$Size</td></tr>
									<tr><td>Modifier</td><td>$Mod</td></tr>
									<tr><td>Cost</td><td>$Cost</td></tr>
									<tr><td>75% Markup</td><td>$Markup</td></tr>
									<tr><td>Price</td><td>$Price</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr>
										<td><a href='default.php?toptab=$toptab&action=EditSIZz$SID' class='button'>Edit</a></td>
										<td><a href='default.php?toptab=$toptab&action=DeleteSIZz$SID' class='button'>Delete</a></td>
									</tr>
								</table></div>";
				}
			    
			    $count++;
			}
		} else {
			$return .= "<tr><td>No results</td></tr>";
		}
		if($type == 'table'){
			$return .= "</table></div>";
		}
        // Close connections
		mysqli_close($conn); 
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
	
	if($type == 'table'){
    	return "$return^$count^$opstable";
    } else {
    	return "$return";
    }
}



function AddSize($size,$modifier,$cost,$markup,$price)
{
	 try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "INSERT INTO sizes (Size, Modifier, Cost, Markup, Price) VALUES ('$size', '$modifier', '$cost', '$markup', '$price')";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "New size created successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}






function UpdateSize($size,$modifier,$cost,$markup,$price,$sid)
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "UPDATE sizes SET Size='$size', Modifier='$modifier', Cost='$cost', Markup='$markup', Price='$price' WHERE SizeID = $sid";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Size record updated successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}







function DeleteSize($size,$modifier,$cost,$markup,$price,$sid)
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "DELETE FROM sizes WHERE SizeID = $sid";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Size record deleted successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}



function GetSize($ID) 
{
$return = "";
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "SELECT * FROM `no-resin-why`.sizes
        WHERE SizeID = $ID";
		
		$result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$SID = $row["SizeID"];
				$Size = $row["Size"];
				$Mod= $row["Modifier"];
				$Cost = $row["Cost"];
				$Markup = $row["Markup"];
				$Price = $row["Price"];
				$return = "$SID^$Size^$Mod^$Cost^$Markup^$Price";
			}
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return $return;
}


function GetSizeSize($Selected) 
{
$return = "";
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "SELECT * FROM `no-resin-why`.sizes
        WHERE Size = '$Selected'";
		
		$result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$SID = $row["SizeID"];
				$Size = $row["Size"];
				$Mod= $row["Modifier"];
				$Cost = $row["Cost"];
				$Markup = $row["Markup"];
				$Price = $row["Price"];
				$return = "$SID^$Size^$Mod^$Cost^$Markup^$Price";
			}
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return $return;
}


#======================================================================================================================================================Expense Accounts
function Accounts($search,$type,$toptab,$selected)
{
    if($type == 'table'){
    	$return = "<table class='datatable'><tr class='sizeshd'><th width='90'>Account ID</th><th width='150'>Name</th><th width='250'>Description</th></tr></table>
    				<div class='datascroll'>
					<table class='datatable'>";  
    } else {
    	$return = "";
    }
    	
  	$count = 0;
  	$opstable = "";

    try
    {
	   $conn = connect();
	   	    	
		// GET CONNECTION ERRORS 
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        if($search == ""){
        	$sql = "SELECT * FROM `no-resin-why`.expaccounts";
        } else {
        	$sql = "SELECT * FROM `no-resin-why`.expaccounts
					WHERE (lower(ExpAccountID) like lower('%$search%') )
					or (lower(Name) like lower('%$search%'))
					or (lower(Description) like lower('%$search%'))";
        }

        $result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$AID = $row["ExpAccountID"];
				$Name = $row["Name"];
				$Description = $row["Description"];
				
				if($type == 'table'){
				    $return .= "<tr style='font-size:small;'><td width='90'><a href='default.php?toptab=$toptab&operation=EXA$AID' class='submenu'>EXP Acct ID $AID</a></td>
				    <td width='150'>$Name</td><td width='250'>$Description</td></tr>";
				} else {
					if($selected == $Name){
						$return .= "<option value='{$Name}' selected>{$Name}</option>";
					} else {
						$return .= "<option value='{$Name}'>{$Name}</option>";
					}
				}
				
				$findID = (int)substr($selected,3,strlen($selected) -3);
				if($findID == $AID) { #-----------------------Get the selected expense data
								$opstable = "<div><table class='datatable'>
									<tr class='sizeshd'><td colspan='2' sytle='font-weight:bold;' width='300'>Size ID $AID</td></tr>
									<tr><td>Name</td><td>$Name</td></tr>
									<tr><td>Description</td><td>$Description</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr>
										<td><a href='default.php?toptab=$toptab&action=EditEXAz$AID' class='button'>Edit</a></td>
										<td><a href='default.php?toptab=$toptab&action=DeleteEXAz$AID' class='button'>Delete</a></td>
									</tr>
								</table></div>";
				}
			    
			    $count++;
			}
		} else {
			$return .= "<tr><td>No results</td></tr>";
		}
		if($type == 'table'){
			$return .= "</table></div>";
		}
        // Close connections
		mysqli_close($conn); 
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
	
	if($type == 'table'){
    	return "$return^$count^$opstable";
    } else {
    	return "$return";
    }
}




function AddExpAcct($Name,$Description)
{
	 try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "INSERT INTO expaccounts (Name, Description) VALUES ('$Name', '$Description')";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "New Exp Account created successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}



function UpdateExpAcct($Name,$Description,$aid)
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "UPDATE expaccounts SET Name='$Name', Description='$Description' WHERE ExpAccountID = $aid";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Exp Account updated successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}




function DeleteExpAcct($Name,$Description,$aid)
{
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "DELETE FROM expaccounts WHERE ExpAccountID = $aid";		
		if (mysqli_query($conn, $sql)) {
		     $return = "Exp Account deleted successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
}







function GetExpAcct($Selected) 
{
$return = "";
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "SELECT * FROM `no-resin-why`.expaccounts
        WHERE ExpAccountID = '$Selected'";
		
		$result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$AID = $row["ExpAccountID"];
				$Name = $row["Name"];
				$Description= $row["Description"];
				$return = "$AID^$Name^$Description";
			}
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return $return;
}

function GetAllAccounts($EID)
{
$return = "";
$i = 1;
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "SELECT * FROM `no-resin-why`.expaccounts";
		
		$result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$AID[$i] = $row["ExpAccountID"];
				$Name[$i] = $row["Name"];
				$Description[$i] = $row["Description"];
				$i++;
				$count = $i -1;
			}
			
			for ($i=1; $i<= $count; $i++){
				if ($EID == "") {	
					
					$return .= "<tr>
						<td><input type='hidden' id='expaccountid$i' name='expaccountid$i' value='$AID[$i]'></td>
						<td style='disabled'><input type='text' id='expacctname$i' name='expacctname$i' value='$Name[$i]'></td>
						<td><input type='text' id='amount$i' name='amount$i' onchange='PopulateExpenseAccounts(this.value);'></td>
					</tr>";
				} else {
					$sql ="SELECT Amount FROM `no-resin-why`.expensedetail WHERE ExpAccountID = '$AID[$i]' and ExpenseID = '$EID';";
					$result = $conn->query($sql); 
        
			        if ($result->num_rows > 0)
					{		
						// Loop through each row in the result set
						while($row = $result->fetch_assoc())
						{
							$value = $row["Amount"];
						}
					}
					$return .= "<tr>
						<td><input type='hidden' id='expaccountid$i' name='expaccountid$i' value='$AID[$i]'></td>
						<td style='disabled'><input type='text' id='expacctname$i' name='expacctname$i' value='$Name[$i]'></td>
						<td><input type='text' id='amount$i' name='amount$i' onchange='PopulateExpenseAccounts(this.value);' value='$value'></td>
					</tr>";
					$value = "";
				}
			}
				
		}
		
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return $return;
}




function GetExpAcctCount() {
$return = "";
$i = 1;
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "SELECT count(Name) as Count FROM `no-resin-why`.expaccounts;";
		
		$result = $conn->query($sql); 
		
		if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$count = $row["Count"];
			}
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return $count;
}


function AddExpenseAcctValue($expenseid,$expaccountid,$expacctname,$amount) {
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "INSERT INTO `no-resin-why`.`expensedetail` (`ExpenseID`,`ExpAccountID`,`ExpAcctName`,`Amount`)VALUES('$expenseid','$expaccountid','$expacctname','$amount');";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Exp Account updated successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return $return;


}


function UpdateExpenseAcctValue($expenseid,$expaccountid,$expacctname,$amount) {

	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "UPDATE `no-resin-why`.`expensedetail` SET `Amount` = '$amount' WHERE ExpenseID = $expenseid and ExpAccountID = $expaccountid;";
		
		if (mysqli_query($conn, $sql)) {
		     $return = "Exp Account updated successfully";
		} else {
		     $return = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return $return;

}
#=========================================================================================================================Retrun Financial Data
function Profit() 
{
$return = "";
	try
    {
	    $conn = connect();
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		}     
        
        $sql = "SELECT SUM(`items`.`SalePrice`) as Sales
				FROM `no-resin-why`.`items`
				WHERE `SalePrice` IS NOT NULL;";
		
		$result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$Sales = $row["Sales"];
				$Other = "0.00";
				$TSales = $Sales;			
			}
		}
		
		$sql = "SELECT SUM(`expenses`.`Amount`) as TExpense
				FROM `no-resin-why`.`expenses`;";
		
		$result = $conn->query($sql); 
        
        if ($result->num_rows > 0)
		{		
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
			{
				$TExpense = $row["TExpense"];
				$Color = "0.00";
				$Molds = "0.00";
				$Embedded= "0.00";
				$Resin = "0.00";
				$ShowFees = "0.00";
				$Overhead = "0.00";
				$Displays = "0.00";			
			}
			
		}

		$return .= "$Sales^$Other^$TSales^$TExpense^$Color^$Molds^$Embedded^$Resin^$ShowFees^$Overhead^$Displays";	
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    
    return $return;
}


function MarkPrinted() {

$return = "Item Tags Marked as Printed";

for($i = 1; $i <= 27; $i++) {
	$price[$i] = "price $i";
	$item[$i] = "item $i";
	$mold[$i] = "mold $i";
	$desc[$i] = "description $i";

}
	$i = 1;
try
{
	
	$conn = connect();
	
	if ($conn->connect_error) { 
	     die("Connection failed: " . $conn->connect_error); 
	}     
    
   
    $sql = "SELECT * FROM `no-resin-why`.items WHERE TAGPrinted <> 'Yes';";
   
    $result = $conn->query($sql); 
    
    
    if ($result->num_rows > 0)
	{		
		
		// Loop through each row in the result set
		while($row = $result->fetch_assoc())
		{
			$itemid = $row["ItemID"];
					
			if ($i <= 27){
				$conn2 = connect();
	
				if ($conn2->connect_error) { 
				     die("Connection failed: " . $conn->connect_error); 
				}     
			   
			    $sql2 = "UPDATE `no-resin-why`.`items` SET `TAGPrinted` = 'Yes' WHERE `ItemID` = '$itemid';";
			    
			    if (mysqli_query($conn2, $sql2)) {
				     $return = "Item tags marked as printed successfully";
				} else {
				     $return = "Error: " . $sql2 . "<br>" . mysqli_error($conn2);
				}

	
				
			}
			$i++;			
		}

	}
	
}   
catch(Exception $e)
{
    echo("Error!");

}
return $return;
}



function logindata($username,$password)
{
    $return = "";
    $idCount = 0;
    try
    {
        $conn = connect();
	
		if ($conn->connect_error) { 
		     die("Connection failed: " . $conn->connect_error); 
		} 

        $sql = "SELECT `FullName` FROM `no-resin-why`.users Where `Username` = '$username' and `Password` = '$password'";
        
        $result =  $conn->query($sql);
        
        if ($result->num_rows > 0)
			{		
			
			// Loop through each row in the result set
			while($row = $result->fetch_assoc())
	        {
	            $return .= $row['FullName'];
	            $idCount++;
	        }
	    }   
    }
    catch(Exception $e)
    {
        echo("Error!");
    }

    if ($idCount == 0) {
        $return = "Username or Password Incorrect, Login Failed!";
    } else {
        //$return =substr($return,0,-1);
        
        return $return;
    }
}


?>