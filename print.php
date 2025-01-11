<?php

for($i = 1; $i <= 27; $i++) {
	$price[$i] = "price $i";
	$item[$i] = "item $i";
	$mold[$i] = "mold $i";
	$desc[$i] = "description $i";

}
	$i = 1;
try
{
	
	$servername = "nrwphpsite-server.mysql.database.azure.com"; 
  	$username = "tekhneddch"; 
  	$password = "8\$qt3vaajySvWV4U"; 
  	$databasename = "no-resin-why"; 
  	
  	$conn = new mysqli($servername, $username, $password, $databasename);
	
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
			$price[$i] = "$" . $row["RetailPrice"];
			$item[$i] = "<span style='color:#3F5D8F'>Item ID </span>" . $row["ItemID"];
			$mold[$i] = $row["MoldShape"];
			$desc[$i] = $row["Description"];
			
			$i++;			
		}

	}
	
}   
catch(Exception $e)
{
    echo("Error!");
}


$html = "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
<meta content='text/html; charset=utf-8' http-equiv='Content-Type' />
<meta http-equiv='X-UA-Compatible' content='IE=edge' />
<link rel='stylesheet' type='text/css' href='print.css'>


 

<title>No Resin Why Retail Tags</title>

</head>

<body>

<div style='display:inline-block;'>
	<div style='display:inline-block;width:1.25in;height:2.7in;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[1]</div><br>
		<div class='itemid'>$item[1]</div><br>
		<div class='mold'>$mold[1]</div><br>
		<div class='desc'>$desc[1]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.7in;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images/Logo.png' width='105'></div><br>
		<div class='price'>$price[2]</div><br>
		<div class='itemid'>$item[2]</div><br>
		<div class='mold'>$mold[2]</div><br>
		<div class='desc'>$desc[2]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.7in;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[3]</div><br>
		<div class='itemid'>$item[3]</div><br>
		<div class='mold'>$mold[3]</div><br>
		<div class='desc'>$desc[3]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.7in;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[4]</div><br>
		<div class='itemid'>$item[4]</div><br>
		<div class='mold'>$mold[4]</div><br>
		<div class='desc'>$desc[4]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.7in;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[5]</div><br>
		<div class='itemid'>$item[5]</div><br>
		<div class='mold'>$mold[5]</div><br>
		<div class='desc'>$desc[5]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.7in;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[6]</div><br>
		<div class='itemid'>$item[6]</div><br>
		<div class='mold'>$mold[6]</div><br>
		<div class='desc'>$desc[6]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.7in;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[7]</div><br>
		<div class='itemid'>$item[7]</div><br>
		<div class='mold'>$mold[7]</div><br>
		<div class='desc'>$desc[7]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.7in;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[8]</div><br>
		<div class='itemid'>$item[8]</div><br>
		<div class='mold'>$mold[8]</div><br>
		<div class='desc'>$desc[8]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.7in;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[9]</div><br>
		<div class='itemid'>$item[9]</div><br>
		<div class='mold'>$mold[9]</div><br>
		<div class='desc'>$desc[9]</div>
	</div>



</div>
<div style='display:inline-block'>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[10]</div><br>
		<div class='itemid'>$item[10]</div><br>
		<div class='mold'>$mold[10]</div><br>
		<div class='desc'>$desc[10]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[11]</div><br>
		<div class='itemid'>$item[11]</div><br>
		<div class='mold'>$mold[11]</div><br>
		<div class='desc'>$desc[11]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[12]</div><br>
		<div class='itemid'>$item[12]</div><br>
		<div class='mold'>$mold[12]</div><br>
		<div class='desc'>$desc[12]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[13]</div><br>
		<div class='itemid'>$item[13]</div><br>
		<div class='mold'>$mold[13]</div><br>
		<div class='desc'>$desc[13]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[14]</div><br>
		<div class='itemid'>$item[14]</div><br>
		<div class='mold'>$mold[14]</div><br>
		<div class='desc'>$desc[14]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[15]</div><br>
		<div class='itemid'>$item[15]</div><br>
		<div class='mold'>$mold[15]</div><br>
		<div class='desc'>$desc[15]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[16]</div><br>
		<div class='itemid'>$item[16]</div><br>
		<div class='mold'>$mold[16]</div><br>
		<div class='desc'>$desc[16]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[17]</div><br>
		<div class='itemid'>$item[17]</div><br>
		<div class='mold'>$mold[17]</div><br>
		<div class='desc'>$desc[17]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[18]</div><br>
		<div class='itemid'>$item[18]</div><br>
		<div class='mold'>$mold[18]</div><br>
		<div class='desc'>$desc[18]</div>
	</div>


</div>

<div style='display:inline-block'>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[19]</div><br>
		<div class='itemid'>$item[19]</div><br>
		<div class='mold'>$mold[19]</div><br>
		<div class='desc'>$desc[19]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[20]</div><br>
		<div class='itemid'>$item[20]</div><br>
		<div class='mold'>$mold[20]</div><br>
		<div class='desc'>$desc[20]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[21]</div><br>
		<div class='itemid'>$item[21]</div><br>
		<div class='mold'>$mold[21]</div><br>
		<div class='desc'>$desc[21]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[22]</div><br>
		<div class='itemid'>$item[22]</div><br>
		<div class='mold'>$mold[22]</div><br>
		<div class='desc'>$desc[22]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[23]</div><br>
		<div class='itemid'>$item[23]</div><br>
		<div class='mold'>$mold[23]</div><br>
		<div class='desc'>$desc[23]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[24]</div><br>
		<div class='itemid'>$item[24]</div><br>
		<div class='mold'>$mold[24]</div><br>
		<div class='desc'>$desc[24]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[25]</div><br>
		<div class='itemid'>$item[25]</div><br>
		<div class='mold'>$mold[25]</div><br>
		<div class='desc'>$desc[25]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[26]</div><br>
		<div class='itemid'>$item[26]</div><br>
		<div class='mold'>$mold[26]</div><br>
		<div class='desc'>$desc[26]</div>
	</div>
	<div style='display:inline-block;width:1.25in;height:2.4;text-align:center;display:table-cell;'>
		<br><div><img alt='NRW' src='images\Logo.png' width='105'></div><br>
		<div class='price'>$price[27]</div><br>
		<div class='itemid'>$item[27]</div><br>
		<div class='mold'>$mold[27]</div><br>
		<div class='desc'>$desc[27]</div>
	</div>
	



</div>



	
</body>

</html>";

echo $html;

		

?>

