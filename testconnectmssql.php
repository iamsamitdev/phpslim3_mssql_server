<?php
$host = "localhost"; // ip address or server name ex. DESKTOP-5KFFN0F
$user   = "sa";
$pass   = "377040";
$dbname = "stockappdb";

try{

	$connect = new PDO("sqlsrv:Server=" . $host . ";Database=" . $dbname, $user, $pass);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "connect database success";

}catch (Exception $e){
    die(print_r($e->getMessage()));
}