<?php

function Vendors($search)
{
    $return = "<table class='datatable'><tr class='vendorhd'><th>Vendor ID</th><th>Vendor Name</th><th>Account Number</th><th>Location</th></tr>";
    $servername = "nrwphpsite-server.mysql.database.azure.com"; 
  	$username = "tekhneddch"; 
  	$password = "8\$qt3vaajySvWV4U"; 
  	$databasename = "no-resin-why"; 
  	
  	$count = 0;

    try
    {
	    // CREATE CONNECTION
	    //$conn = mysqli_init(); 
	    //mysqli_real_connect($conn,$servername,$username,$password,$databasename,3306,MYSQLI_CLIENT_SSL);
	  	$conn = new mysqli($servername, $username, $password, $databasename);
	    	
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
			    $return .= "<tr><td>$VID</td><td>$VName</td><td>$VAcct</td><td>$VLoc</td></tr>";
			    
			    $count++;
			}
		} else {
			$return .= "<tr><td>No results</td></tr>";
		}
		$return .= "</table>";
        // Close connections
		mysqli_close($conn); 
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }

    return "$return^$count";
}


function Expenses($search)
{
    $return = "<table class='datatable'><tr class='expensehd'><th>Expense ID</th><th>Date</th><th>Vendor</th><th>Description</th><th>Amount</th></tr>";
    $servername = "nrwphpsite-server.mysql.database.azure.com"; 
  	$username = "tekhneddch"; 
  	$password = "8\$qt3vaajySvWV4U"; 
  	$databasename = "no-resin-why"; 
  	
  	$Total = 0;
    try
    {
	    // CREATE CONNECTION
	    //$conn = mysqli_init(); 
	    //mysqli_real_connect($conn,$servername,$username,$password,$databasename,3306,MYSQLI_CLIENT_SSL);
	  	$conn = new mysqli($servername, $username, $password, $databasename);
	    	
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

			    $return .= "<tr><td>$EID</td><td>$EDate</td><td>$EVendor</td><td>$EDescription</td><td>$EAmount</td></tr>";
			    
			    $Total = $Total + $EAmount;
			}
		} else {
			$return .= "<tr><td>No results</td></tr>";
		}
		$return .= "</table>";
        // Close connections
		mysqli_close($conn); 
	}   
    catch(Exception $e)
    {
        echo("Error!");
    }

    return "$return^$Total";
}



function Molds($search)
{
    $return = "<table class='datatable'><tr class='moldhd'><th>Mold ID</th><th>Shape</th><th>Description</th><th>Size</th></tr>";
    $servername = "nrwphpsite-server.mysql.database.azure.com"; 
  	$username = "tekhneddch"; 
  	$password = "8\$qt3vaajySvWV4U"; 
  	$databasename = "no-resin-why"; 
  	
  	$count = 0;
  	
    try
    {
	    // CREATE CONNECTION
	    //$conn = mysqli_init(); 
	    //mysqli_real_connect($conn,$servername,$username,$password,$databasename,3306,MYSQLI_CLIENT_SSL);
	  	$conn = new mysqli($servername, $username, $password, $databasename);
	    	
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
				
				$count++;
			    $return .= "<tr><td>$MID</td><td>$Shape</td><td>$Description</td><td>$Size</td></tr>";
			    
			}
		} else {
			$return .= "<tr><td>No results</td></tr>";
		}
		$return .= "</table>";
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

?>