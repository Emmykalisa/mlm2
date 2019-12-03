<?php
include('php-includes/check-login.php');
require('php-includes/connect.php');
$userident = $_SESSION['userident'];
$paymentid=$_GET['id'];
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
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">



</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include 'php-includes/menu.php'; ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Join The User</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">

                    <h1>Confirm Withdraw</h1>
   <?php

$ss=$dbi->query("SELECT * FROM withdraw where id='$paymentid' ");
while($rows=mysqli_fetch_array($ss)){
    $amount=$rows['amount'];
    $phone=$rows['telephone'];
    $trans=$rows['transactionid'];
    $userid=$rows['transactionid'];
}

echo"<p>User Identification: $userid </p>";
echo"<p>Amount: $amount </p>";
echo"<p>Telephone: $phone </p>";
   ?>
                    
                    <div class="col-lg-4">
                        <?php
//User cliced on join
  // ====================Taliki za none ================
   $dat = new DateTime('now', new DateTimeZone('Africa/Cairo'));

    $date = $dat->format('Y-m-d');


//==============end 
if (isset($_POST['join_user'])) {
    
   // $trid=rand(1000,10000000000);





$ss=$dbi->query("SELECT * FROM withdraw where id='$paymentid' ");
while($rows=mysqli_fetch_array($ss)){
    $amount=$rows['amount'];
    $phone=$rows['telephone'];
    $trans=$rows['transactionid'];
}

   $insert = $dbi->query("UPDATE withdraw SET status='yes' where id='$paymentid' ");

     

    if($insert){
    echo "<center><p class='alert alert-success'>You have withdrawn $amount RWF <b>$message</b>, $status  </p> </center>";
    echo"<script>window.setTimeout(function() {
    window.location.replace('withdraw.php');
}, 3000);</script>";
    }
   


else{

    echo"<p class='alert alert-danger'>Sorry , withdraw can not be processed-error: $message</p>";
}
}

?>

<div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: #f4f4f4;z-index: 99;">
                        <div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
                        <center><img src="https://filedb.experts-exchange.com/incoming/2014/12_w50/886830/load.gif" alt="Loading"></center>
                        Checking Please Wait! <Br> We are sending money..... <b style="color: red;">BE ONLINE</b>
                        </div>
                        </div>
                        <form method="POST">
                           
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category">
                                    
                                    <option value="yes">Withdraw</option>
                                   >
                                </select>
                            </div>
                            
                          
                         

                            <div class="form-group">
                                <input type="submit" name="join_user" onclick="check()" class="btn btn-success" value="Confirm withdraw">
                            </div>
                        </form>

                      
                    </div>
                </div>
                <!--/.row-->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<script type="text/javascript">

    function check()
    
    {
    
    $("#checking").show();
    
    }
    
    </script>
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>