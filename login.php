<?php
session_start();
require('php-includes/connect.php');
$pin = mysqli_real_escape_string($con,$_POST['pin']);
$password = mysqli_real_escape_string($con,$_POST['password']);

$query = mysqli_query($con,"select * from user where userident='$pin' and password='$password' and user_status='Active'");
if(mysqli_num_rows($query)>0){
	$_SESSION['userident'] = $pin;
	$_SESSION['id'] = session_id();
	$_SESSION['login_type'] = "user";
	
	echo '<script>window.location.assign("home.php");</script>';
	
}
else{
	echo '<script>alert("pin id or password is worng, if you are sure they are ok, you are blocked with admin");window.location.assign("index.php");</script>';
}

?>