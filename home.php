<?php

include 'php-includes/check-login.php';
include 'php-includes/connect.php';

include './php-includes/treeUtil.php';
include './php-includes/queryHelper.php';
$userident = $_SESSION['userident'];
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
                        <h1 class="page-header">User Dashboard</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <?php
                    $query = mysqli_query($con, "select * from income where userident='{$userident}'");
                    $result = mysqli_fetch_array($query);

                    $qHelper = new QueryHelper();
                    $userTree = $qHelper->getUserCounts($result['userident']);
                    $leftSideCount = $userTree['leftcount'];
                    $rightSideCount = $userTree['rightcount'];
                    $calculator = new AmountCalculator($leftSideCount, $rightSideCount);

                   
                    $totalAmount = $result['total_bal'] + $calculator->getTotalPoints();
                    ?>
                     <div class="col-lg-3">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h4 class="panel-title">Available Pin</h4>
                            </div>
                            <div class="panel-body">
                                <?php
                                echo  mysqli_num_rows(mysqli_query($con, "select * from pin_list where userident='{$userident}' and status='open'"));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Matching point</h4>
                            </div>
                            <div class="panel-body">
                                  <?php 
$select = $dbi->query("SELECT * FROM tree where userident='{$userident}' order by id desc limit 1");
while($rows=mysqli_fetch_array($select)){
    $matches=$rows['matches']+$rows['matchedview'];
    echo $matches;
}

                                 ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Indirect point</h4>
                            </div>
                            <div class="panel-body">
                                <?php echo $calculator->getIndirectProfit(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Gift check</h4>
                            </div>
                            <div class="panel-body">
                                <?php echo $calculator->getGiftCheck(); ?>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Flash out</h4>
                            </div>
                            <div class="panel-body">
                                <?php echo $calculator->Flashout(); ?>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-3">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h4 class="panel-title">Total earnings</h4>
                            </div>
                            <div class="panel-body">
                                <?php
                                $total_earnings=$result['total_earnings']+ $calculator->getTotalPoints();
                                echo $total_earnings
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h4 class="panel-title">Available balance </h4>
                            </div>
                            <div class="panel-body">
                                <?php
                                $s=$dbi->query("SELECT SUM(amount) FROM withdraw where userident='$userident' and status='yes' ");
                        while($rows=mysqli_fetch_array($s)){
                            $withd=$rows['SUM(amount)'];
                        }
                                $available_balance = $result['total_bal']+ $calculator->getTotalPoints()-$withd;
                                echo $available_balance;
                                ?>
                            </div>
                        </div>
                    </div
                    >
 <div class="col-lg-3">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h4 class="panel-title"> Amount Withdrawn </h4>
                            </div>
                            <div class="panel-body">
                                <?php
                                $s=$dbi->query("SELECT SUM(amount) FROM withdraw where userident='$userident' and status='yes' ");
                        while($rows=mysqli_fetch_array($s)){
                            $withd=$rows['SUM(amount)'];
                        }
                               
                                echo $withd;
                                ?>
                            </div>
                        </div>
                    </div
                    >


                    <div class="col-md-3">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h4 class="panel-title">Matching + Indirect Balance</h4>
                            </div>
                            <div class="panel-body">
                              <?php echo $calculator->getTotalPoints(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h4 class="panel-title">sponsor</h4>
                            </div>
                            <div class="panel-body">
                                <?php
                                echo $result['total_bal'];
                                ?>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

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