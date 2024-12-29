<?php

function OpenConnection()
{
    try
    {
        $serverName = "TIM-7\SQLEXPRESS";
        $connectionOptions = array("Database"=>"Store",
            "Uid"=>"sa", "PWD"=>"PatTim");
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if($conn == false)
            die("Failed to connect");
    }
    catch(Exception $e)
    {
        echo("Error!");
    }
}


function ReadData($id)
{
    $return = "";
    try
    {
        $serverName = "TIM-7\SQLEXPRESS";
        $connectionOptions = array("Database"=>"Store",
            "Uid"=>"sa", "PWD"=>"PatTim");
        $conn = sqlsrv_connect($serverName, $connectionOptions);


        $tsql = "SELECT        Items.ItemID, Items.ItemName, Items.ItemDesc, Items.PicturePath, Items.MarkupDollars, CalcTable.Cost, Stores.StoreID
			                        , Stores.StoreMarkup, CalcTable.Cost +(CalcTable.Cost * (Stores.StoreMarkup / 100)) + Items.MarkupDollars as SuggestedRetail
                    FROM            Items INNER JOIN
                             (SELECT        SUM(ExpenseAmount) AS Cost, ItemID
                               FROM            Expenses
                               GROUP BY ItemID) AS CalcTable ON Items.ItemID = CalcTable.ItemID INNER JOIN
                         Stores ON Items.StoreID = Stores.StoreID
                    WHERE Stores.StoreID = {$id}";
        $getProducts = sqlsrv_query($conn, $tsql);
        if ($getProducts == FALSE)
            die("Failed to connect");
        $productCount = 0;
        while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))
        {
            $return .= $row['ItemName'];
            $return .= ",";
            $return .= $row['ItemDesc'];
            $return .= ",";
            $return .= $row['PicturePath'];
            $return .= ",";
            $return .= $row['SuggestedRetail'];
            $return .= ":";
            //echo("<br/>");
            $productCount++;
        }
        sqlsrv_free_stmt($getProducts);
        sqlsrv_close($conn);
    }
    catch(Exception $e)
    {
        echo("Error!");
    }
    $return =substr($return,0,-1);
    return $return;
}


function InsertData()
{
    try
    {
        $conn = OpenConnection();
        $tsql = "INSERT SalesLT.Product (Name, ProductNumber, StandardCost, ListPrice, SellStartDate) OUTPUT            INSERTED.ProductID VALUES ('SQL Server 1', 'SQL Server 2', 0, 0, getdate())";
        //Insert query
        $insertReview = sqlsrv_query($conn, $tsql);
        if($insertReview == FALSE)
            die("Failed to connect");
        echo "Product Key inserted is :";
        while($row = sqlsrv_fetch_array($insertReview, SQLSRV_FETCH_ASSOC))
        {
            echo($row['ProductID']);
        }
        sqlsrv_free_stmt($insertReview);
        sqlsrv_close($conn);
    }
    catch(Exception $e)
    {
        echo("Error!");
    }
}


function logindata($username,$password)
{
    $return = "";
    try
    {
        $serverName = "TIM-7\SQLEXPRESS";
        $connectionOptions = array("Database"=>"Store",
            "Uid"=>"sa", "PWD"=>"PatTim");
        $conn = sqlsrv_connect($serverName, $connectionOptions);


        $tsql = "SELECT [StoreID]
                        ,[Name]
                        ,[Username]
                        ,[Password]
                        ,[Rights]
      
                 FROM [Store].[dbo].[Owners]
                 Where [Username] = '{$username}' and [Password] = '{$password}'";
        $getStoreIDs = sqlsrv_query($conn, $tsql);
        if ($getStoreIDs == FALSE) 
            $return = "Failed to query database ".sqlsrv_error();
         
        $idCount = 0;
        while($row = sqlsrv_fetch_array($getStoreIDs, SQLSRV_FETCH_ASSOC))
        {
            $return .= $row['StoreID'];
            $return .= ",";
            //$return .= $row['Rights'];
            //$return .= ":";
            //echo("<br/>");
            $idCount++;
            $ownername = $row['Name'];
        }
        
        sqlsrv_free_stmt($getStoreIDs);
        sqlsrv_close($conn);
        $_SESSION["ownername"]=$ownername;
    }
    catch(Exception $e)
    {
        echo("Error!");
    }

    if ($idCount == 0) {
        $return = "Username or Password Incorrect, Login Failed!";
    } else {
        $return =substr($return,0,-1);
        
        return $return;
    }
}

function getcity ($selectedstate,$selectedcity)
{


$return = "";
     try
    {
        $serverName = "TIM-7\SQLEXPRESS";
        $connectionOptions = array("Database"=>"Store",
            "Uid"=>"sa", "PWD"=>"PatTim");
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        $tsql = "SELECT [CityID]
                        ,[City]
                    FROM [Store].[dbo].[Cities]
                    WHERE [StateID] = {$selectedstate}";
        $getCities = sqlsrv_query($conn, $tsql);
        if ($getCities == FALSE) 
            echo "Failed to query database ".sqlsrv_error();
         
        while($row = sqlsrv_fetch_array($getCities, SQLSRV_FETCH_ASSOC))
        {   
            $tempID = $row['CityID'];
            $tempcity = $row['City'];

            if($tempID == $selectedcity){
                $return .= "<option value='{$tempID}' selected='selected'>{$tempcity}</option>";
            }else if ($tempID != $selectedcity) {
                $return .= "<option value='{$tempID}'>{$tempcity}</option>";
            }    
        }
        
        sqlsrv_free_stmt($getCities);
        sqlsrv_close($conn);
    }
    catch(Exception $e)
    {
        echo("Error!");
    }
        return $return;
}



function getstate ($selectedstate)
{

if($stateID = ""){$stateID = 0;}
$return = "";
     try
    {
        $serverName = "TIM-7\SQLEXPRESS";
        $connectionOptions = array("Database"=>"Store",
            "Uid"=>"sa", "PWD"=>"PatTim");
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        $tsql = "SELECT [StateID]
                        ,[State]
                    FROM [Store].[dbo].[State]";
        $getStates = sqlsrv_query($conn, $tsql);
        if ($getStates == FALSE) 
            echo "Failed to query database ".sqlsrv_error();
        while($row = sqlsrv_fetch_array($getStates, SQLSRV_FETCH_ASSOC))
        {   
            $tempID = $row['StateID'];
            $tempState = $row['State'];
            if($tempID == $selectedstate){
                $return .= "<option value='{$tempID}' selected='selected'>{$tempState}</option>";
            }else if ($tempID != $selectedstate) {
                $return .= "<option value='{$tempID}'>{$tempState}</option>";
            }      
        }
        
        sqlsrv_free_stmt($getStates);
        sqlsrv_close($conn);
    }
    catch(Exception $e)
    {
        echo("Error!");
    }
        return $return;
}



function getstores ($selectedcity,$selectedstore)
{
$return = "";
    try
    {
        $serverName = "TIM-7\SQLEXPRESS";
        $connectionOptions = array("Database"=>"Store",
            "Uid"=>"sa", "PWD"=>"PatTim");
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        $tsql = "SELECT [StoreID]
                        ,[StoreName]
                    FROM [Store].[dbo].[Stores]
                    WHERE [CityID] = {$selectedcity}";
        $getStores = sqlsrv_query($conn, $tsql);
        if ($getStores == FALSE) 
            $return = "Failed to query database ";
        while($row = sqlsrv_fetch_array($getStores, SQLSRV_FETCH_ASSOC))
        {   
            $tempID = $row['StoreID'];
            $tempstore = $row['StoreName'];
            if($tempID == $selectedstore){
                $return .= "<option value='{$tempID}' selected='selected'>{$tempstore}</option>";               
                $contentURL = "storecontent.php?id=$tempID&sn=$tempstore";
            }else if ($tempID != $selectedstore) {
                $return .= "<option value='{$tempID}'>{$tempstore}</option>";   
            }
        }
        sqlsrv_free_stmt($getStores);
        sqlsrv_close($conn);
        $return .= "</select>";
    }
    catch(Exception $e)
    {
        echo("Error!");
    }
    return "$return:$contentURL";
}

function getownerstores($stores,$selectedstore)
{
$return = "";
try
    {
        $serverName = "TIM-7\SQLEXPRESS";
        $connectionOptions = array("Database"=>"Store",
            "Uid"=>"sa", "PWD"=>"PatTim");
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        $tsql = "SELECT [StoreID]
                        ,[StoreName]
                    FROM [Store].[dbo].[Stores]
                    WHERE [StoreID] IN ({$stores})";
        $getStores = sqlsrv_query($conn, $tsql);               
        while($row = sqlsrv_fetch_array($getStores, SQLSRV_FETCH_ASSOC))
        {   
            $tempID = $row['StoreID'];
            $tempstore = $row['StoreName'];


            if (substr($stores, "," !== false)) {
                
                if($tempID == $selectedstore){
                    $return .= "<option value='{$tempID}' selected='selected'>{$tempstore}</option>";             
                    $contentURL = "storeowner.php?id=$tempID&sn=$tempstore";
                }else if ($tempID != $selectedstore) {
                    $return .= "<option value='{$tempID}'>{$tempstore}</option>";   
                }
            }else {
                $return .= "<option value='{$tempID}' selected='selected'>{$tempstore}</option>";             
                $contentURL = "storeowner.php?id=$tempID&sn=$tempstore"; 
            }
            

        }
        sqlsrv_free_stmt($getStores);
        sqlsrv_close($conn);
        $return .= "</select>";
    }
    catch(Exception $e)
    {
        echo("Error!");
    } 
return "$return:$contentURL";
}


function getMenu ($menuid)
{
    
    

    $return = "";
     try
    {
        $serverName = "TIM-7\SQLEXPRESS";
        $connectionOptions = array("Database"=>"Store",
            "Uid"=>"sa", "PWD"=>"PatTim");
        $conn = sqlsrv_connect($serverName, $connectionOptions);


        $tsql = "SELECT [MenuText]
                        ,[MenuAction]
                        ,[MenuIcon]
                    FROM [Store].[dbo].[Menu]
                    WHERE [MenuID] = {$menuid}";
        $getMenus = sqlsrv_query($conn, $tsql);
        if ($getMenus == FALSE) 
            $return = "Failed to query database ";
         
        while($row = sqlsrv_fetch_array($getMenus, SQLSRV_FETCH_ASSOC))
        {   
            $menutext = $row['MenuText'];
            $menuaction = $row['MenuAction'];
            $menuicon = $row['MenuIcon'];

            $return .= "<li><a href='{$menuaction}' target='content'>{$menutext}</a></li>";
            
        }
        
        sqlsrv_free_stmt($getMenus);
        sqlsrv_close($conn);
    }
    catch(Exception $e)
    {
        echo("Error!");
    }
        $return .= "</ul>";
        return $return;



}
?>