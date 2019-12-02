<?php
session_start();
require_once 'php-includes/connect.php';
include '../php-includes/treeUtil.php';
include '../php-includes/queryHelper.php';
$userident = $_SESSION['userident'];

$id = $_GET['id'];

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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include 'php-includes/menu.php'; ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Payment of user</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Pay Encashment</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                      <?php

$ss=$dbi->query("SELECT * FROM withdraw where id='$id' ");
while($rows=mysqli_fetch_array($ss)){
    $amount=$rows['amount'];
    $phone=$rows['telephone'];
    $trans=$rows['transactionid'];
    $userid=$rows['transactionid'];
      $fullname=$rows['fullname'];
}
echo"<p>Fullname: $fullname </p>";
echo"<p>User Identification: $userid </p>";
echo"<p>Amount: $amount </p>";
echo"<p>Telephone: $phone </p>";
   ?>
                                           <?php
//User cliced on join
  // ====================Taliki za none ================
   $dat = new DateTime('now', new DateTimeZone('Africa/Cairo'));

    $date = $dat->format('Y-m-d');


//==============end 
if (isset($_POST['join_user'])) {
    
   // $trid=rand(1000,10000000000);




   $insert = $dbi->query("UPDATE withdraw SET status='yes' where id='{$id}' ");

   if($insert){ 

     echo "<center><p class='alert alert-success'>You have withdrawn $amount RWF <b>$message</b>, $status  </p> </center>";
    echo"<script>window.setTimeout(function() {
    window.location.replace('payment.php');
}, 3000);</script>";

    
   


}else{

    echo"<p class='alert alert-danger'>Sorry , withdraw can not be processed-error</p>";
}
}

?>


                        <form method="POST">
                           
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category">
                                    
                                    <option value="yes">Withdraw</option>
                                   >
                                </select>
                            </div>
                            
                          
                         

                            <div class="form-group">
                                <input type="submit" name="join_user" class="btn btn-success" value="Confirm withdraw">
                            </div>
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