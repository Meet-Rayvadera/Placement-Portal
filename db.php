<?php
	$server='localhost';
	$port=3306;
	$uname='meet';
	$pass='meet';
	$dbname='plcmtportal';

	try
	{
		$conn = new PDO("mysql:host=$server; port=$port, dbname=$dbname", $uname, $pass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)
	{
		echo "Connection failed: ".$e->getMessage;
	}

?>