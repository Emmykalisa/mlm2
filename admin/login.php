<?php
session_start();
require('php-includes/connect.php');
$userident = mysqli_real_escape_string($con,$_POST['userident']);
$password = mysqli_real_escape_string($con,$_POST['password']);

$query = mysqli_query($con,"select * from admin where userident='$userident' and password='$password'");
if(mysqli_num_rows($query)>0){
	$_SESSION['userident'] = $userident;
	$_SESSION['id'] = session_id();
	$_SESSION['login_type'] = "admin";
	echo mysqli_error($con);
	
	echo '<script>alert("Login Success.");window.location.assign("home.php");</script>';
	
}
else{
	echo '<script>alert("Email id or password is worng.");window.location.assign("index.php");</script>';
}

?>