<?php
include('php-includes/connect.php');
include('php-includes/check-login.php');
$userident = $_SESSION['userident'];
$capping = 500;
?>
<?php
//User cliced on join
if(isset($_GET['btn_save'])){
    $Names = mysqli_real_escape_string($con,$_GET['Names']);
    $userid = mysqli_real_escape_string($con,$_GET['userid']);
    $mobile = mysqli_real_escape_string($con,$_GET['mobile']);
    $address = mysqli_real_escape_string($con,$_GET['address']);
    $National_ID = mysqli_real_escape_string($con,$_GET['National_ID']);
    $password = mysqli_real_escape_string($con,$_GET['password']);
    $user_status= "Active";
	
	$flag = 0;
	
	if($userid!='' && $Names!='' && $mobile!='' && $address!='' && $National_ID!='')
	{
		//User filled all the fields.
		// if(nid_check($nid)){
			//Pin is ok
			if(userid_check($userid)){
				//userid is ok
					if(mobile_check($mobile)){
						//Side check
						$flag=1;
					}
					else{
						echo '<script>alert("The phone number  you inserted is used.");</script>';
					}
			}
			else{
				//check userid
				echo '<script>alert("This user id already availble.");</script>';
			}
	}
	else{
		//check all fields are fill
		echo '<script>alert("Please fill all the fields.");</script>';
	}
	
	//Now we are heree
	//It means all the information is correct
	//Now we will save all the information
	if($flag==1){
		
		//Insert into User profile
		$query = mysqli_query($con,"insert into accountant(`password`,`userident`,`Names`,`mobile`,`address`,`NationalID`,`user_status`) values('$password','$userid','$Names','$mobile','$address','$National_ID','$user_status')");
		
		echo mysqli_error($con);
        echo mysqli_error($con);
        ?>
              <script>
				alert('Accountant added...');
				window.location.href='accountant.php';
				</script>
              <?php
       
	}
	
}
?><!--/join user-->
<?php 
//functions
function nid_check($nid){
	global $con,$userid;
	
	$query =mysqli_query($con,"select * from accountant where National_ID='$National_ID'");
	if(mysqli_num_rows($query)>0){
		return true;
	}
	else{
		return false;
	}
}
function userid_check($userid){
	global $con;
	
	$query =mysqli_query($con,"select * from accountant where userident='$userid'");
	if(mysqli_num_rows($query)>0){
		return false;
	}
	else{
		return true;
	}
}
function mobile_check($mobile){
	global $con;
	
	$query =mysqli_query($con,"select * from accountant where mobile='$mobile'");
	if(mysqli_num_rows($query)>0){
		return false;
	}
	else{
		return true;
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>IFF</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include('php-includes/menu.php'); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Admin Page</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <b>Add Accountant</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form">
                                        <div class="form-group">
                                            <label>Names</label>
                                            <input class="form-control" name="Names" placeholder="Enter your names">
                                        </div>
                                        <div class="form-group">
                                            <label>User Login ID</label>
                                            <input class="form-control" name="userid" placeholder="Enter user name! no space">
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile</label>
                                            <input class="form-control" name="mobile" placeholder="Enter user phone number">
                                        </div>
                                        <div class="form-group">
                                            <label>National ID</label>
                                            <input class="form-control" name="National_ID" placeholder="Enter user national ID">
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input class="form-control" name="address" placeholder="Province, City">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" name="password" placeholder="Enter user password">
                                        </div>
                                        <button type="submit" name="btn_save" class="btn btn-success"><span class="glyphicon glyphicon-floppy-save"></span>&nbsp; Save</button>
                                    </form>
                                </div>
                            
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>


            
          
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>
