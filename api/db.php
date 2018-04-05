<?php

foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }
    
    $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
	
	
}

try {
    $conn = new PDO("mysql:host=$connectstr_dbhost;dbname=$connectstr_dbname", $connectstr_dbusername, $connectstr_dbpassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully to host : " . $connectstr_dbhost; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
	print_r($conn);
$sql= "SELECT * FROM pd_products_general LIMIT 50";
$stmt = $conn->prepare($sql);
$stmt->execute();
$total = $stmt->rowCount();

while ($row = $stmt->fetchObject()) {
    //echo "<li>{$row->Name}</li>";
}