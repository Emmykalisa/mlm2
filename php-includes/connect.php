<?php
	$db_host = "localhost";
	$db_user = "root";
	$db_pass = "";
	$db_name = "iff_mlm";
	 // error_reporting(0);
	$con =  mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	if(mysqli_connect_error()){
		echo 'connect to database failed';
	}
	$dbi = new mysqli($db_host,$db_user,$db_pass,$db_name);
?>