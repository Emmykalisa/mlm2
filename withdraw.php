<?php
include 'php-includes/connect.php';
include 'php-includes/check-login.php';
include './php-includes/treeUtil.php';
include './php-includes/queryHelper.php';
$userident = $_SESSION['userident'];
$capping = 5000;
$capping2 = 6000;

$selec=$dbi->query("SELECT * FROM user where userident='$userident' ");
                        while($rows=mysqli_fetch_array($selec)){
                            $fullname=$rows['Names'];
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
                    <div class="col-lg-4">
                        <?php
//User cliced on join
  // ====================Taliki za none ================
   $dat = new DateTime('now', new DateTimeZone('Africa/Cairo'));

    $date = $dat->format('Y-m-d');

    //======== Taliki zibanje 

$dati = new DateTime('now', new DateTimeZone('Africa/Cairo'));
$dati->modify("-1 day");
    $datu = $dati->format('Y-m-d');

//=============Selecting  balance with helper
 $query = mysqli_query($con, "select * from income where userident='{$userident}'");
                    $result = mysqli_fetch_array($query);

                    $qHelper = new QueryHelper();
                    $userTree = $qHelper->getUserCounts($result['userident']);
                    $leftSideCount = $userTree['leftcount'];
                    $rightSideCount = $userTree['rightcount'];
                    $calculator = new AmountCalculator($leftSideCount, $rightSideCount);



$s=$dbi->query("SELECT SUM(amount) FROM withdraw where userident='$userident' and status='yes' ");
                        while($rows=mysqli_fetch_array($s)){
                            $withd=$rows['SUM(amount)'];
                        }

$available_balance = $result['total_bal']+ $calculator->getTotalPoints()-$withd;                        
echo"<p class='alert alert-warning'>Amount to withdraw: $available_balance </p>";

//==============end 
if (isset($_POST['join_user'])) {
    
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);

    $phone="25$mobile";

    $tax=$amount*0.18;
    $amoun=$amount-$tax-1000;
  
if($amount<=$available_balance and $amount>=8000 ){

 $s=$dbi->query("SELECT SUM(amount) FROM withdraw where userident='$userident' and status='yes' and created_at='$date' ");
                        while($rows=mysqli_fetch_array($s)){
                            $amountw=$rows['SUM(amount)'];
                        } 
$toto=$amountw+$amount;

if($toto<=100000){                          
$select=$dbi->query("SELECT * FROM automatic order by id desc limit 1");
                        while($rows=mysqli_fetch_array($select)){
                            $category=$rows['categorized'];
                        }

$trid=rand(1000,1000000);



 $insert = $dbi->query("INSERT INTO withdraw(userident,amount,telephone,created_at,status,transactionid,fullname,receivedamount) VALUES('$userident','$amount','$phone','$date','no','$trid','$fullname','$amoun')");

     echo "<center><p class='alert alert-success'>Encashment of  $amount RWF  is placed.. transactionid:$trid </p> </center>";
    echo"<script>window.setTimeout(function() {
    window.location.replace('withdraw.php');
}, 6000);</script>";

}else{
     echo "<center><p class='alert alert-danger'>You can not withdraw amount greater than 100000RWF per day </p> </center>";
}

 }else{
    echo "<center><p class='alert alert-danger'>You can not withdraw amount greater than your balance </p> </center>";

 }

}

?> <div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: #f4f4f4;z-index: 99;">
                        <div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
                        <center><img src="https://filedb.experts-exchange.com/incoming/2014/12_w50/886830/load.gif" alt="Loading"></center>
                        Checking Please Wait! <Br> We are sending Request..... <b style="color: red;">BE ONLINE</b>
                        </div>
                        </div>
                        <form method="POST">
                           
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" name="amount" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="phone" name="mobile" class="form-control" minilength="10" maxlength="10" required>
                            </div>
                         

                            <div class="form-group">
                                <input type="submit" name="join_user" onclick="check()" class="btn btn-success" value="withdraw">
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