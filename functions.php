<?php

function Vendors($search,$type,$selected)
{
    if($type == 'table'){
    	$return = "<table class='datatable'><tr class='vendorhd'><th>Vendor ID</th><th>Vendor Name</th><th>Account Number</th><th>Location</th></tr>";  
    } else {
    	$return = "";
    }
    	
  	$count = 0;

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
				    $return .= "<tr><td>$VID</td><td>$VName</td><td>$VAcct</td><td>$VLoc</td></tr>";
				} else {
					if($selected == $VName){
						$return .= "<option value='{$VName}' selected>{$VName}</option>";
					} else {
						$return .= "<option value='{$VName}'>{$VName}</option>";
					}
				}
			    
			    $count++;
			}
		} else {
			$return .= "<tr><td>No results</td></tr>";
		}
		if($type == 'table'){
			$return .= "</table>";
		}
        // Close connections
		mysqli_close($conn); 
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
	
	if($type == 'table'){
    	return "$return^$count";
    } else {
    	return "$return";
    }
}






function Connect()
{
	$servername = "nrwphpsite-server.mysql.database.azure.com"; 
  	$username = "tekhneddch"; 
  	$password = "8\$qt3vaajySvWV4U"; 
  	$databasename = "no-resin-why"; 
  	
  	$conn = new mysqli($servername, $username, $password, $databasename);

	return $conn;
}


function Expenses($search,$type,$toptab,$operation)
{
    if($type == 'table'){
    	$return = "<table class='datatable'><tr class='expensehd'><th width='90'>Expense ID</th><th width='100'>Date</th><th width='150'>Vendor</th><th width='300'>Description</th><th width='90'>Amount</th></tr></table>
    	<div class='datascroll'>
		<table class='datatable'>";
    } else {
    	$return = "";
    }

    $return = "
    <div class='datascroll'>
	<table class='datatable'>";
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
				    $return .= "<tr><td width='90'><a href='default.php?toptab=$toptab&operation=EXP$EID' class='submenu'>EXP ID $EID</a></td>
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
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return";
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






function Molds($search,$type,$toptab,$operation,$selected)

{
    if($type == 'table'){
    	$return = "<table class='datatable'><tr class='moldhd'><th>Mold ID</th><th>Shape</th><th>Description</th><th>Size</th></tr>";
    } else {
    	$return = "";
    }

  	$count = 0;
  	
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
				    $return .= "<tr><td width='100'><a href='default.php?toptab=$toptab&operation=MLD$MID' class='submenu'>Mold ID $MID</a></td>
				    				<td width='150'>$Shape</td><td width='300'>$Description</td><td width='90'>$Size</td></tr>";
				    $count++;
				} else { #-----------------------Build Items Drop Down
					if($selected == $MID){
						$return .= "<option value='{$MID}' selected>{$MID} {$Shape} {$Size}</option>";
					} else {
						$return .= "<option value='{$MID}'>{$MID} {$Shape} {$Size}</option>";
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
			$return .= "</table>";
		}
        // Close connections
		mysqli_close($conn); 
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }

    return "$return^$count";
}


function AddEvent(){


}





function Inventory($search,$type,$toptab,$operation)
{
    $return = "<table class='datatable'><tr class='inventoryhd'><th width='100'>Item ID</th><th width='150'>Mold Shape</th><th width='250'>Description</th><th width='80'>Cost</th><th width='80'>Retail Amount</th></tr></table>
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
				    $return .= "<tr><td width='100'><a href='default.php?toptab=$toptab&operation=ITM$IID' class='submenu'>ITEM ID $IID</a></td>
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
										<td><a href='default.php?toptab=$toptab&action=DeleteEITMz$IID' class='button'>Delete</a></td>
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


?>