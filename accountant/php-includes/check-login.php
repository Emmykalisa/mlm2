<?php
session_start();
if(isset($_SESSION['id']) && $_SESSION['login_type']=='accountant'){
}
else{
	echo '<script>alert("Access denied");window.location.assign("index.php");</script>';
}
?>