<?php
session_start();
require_once 'php-includes/connect.php';
include '../php-includes/treeUtil.php';
include '../php-includes/queryHelper.php';
$userident = $_SESSION['userident'];

if (!isset($_SESSION['id'])) {
    header('Location:../index.php');
}
$id = $_GET['payment_id'];

$result = mysqli_query($con, "SELECT * FROM user, income where income.userident='".$_GET['payment_id']."'");
$row = mysqli_fetch_array($result);

$qHelper = new QueryHelper();
$userTree = $qHelper->getUserCounts($id);
$leftSideCount = $userTree['leftcount'];
$rightSideCount = $userTree['rightcount'];
$calculator = new AmountCalculator($leftSideCount, $rightSideCount);
$totalAmount = $row['total_bal'] + $calculator->getTotalPoints();
if (isset($_POST['btn_save_updates'])) {
    //getting the text data from the fields

    $total_bal = $_POST['total_bal'];
    $total_payment = $_POST['total_payment'];
    $paid_amount = $_POST['paid_amount'];
    if ($paid_amount <= $totalAmount) {
        $new_total_bal = $row['total_bal'] - $paid_amount;
        $new_paid_bal = $total_payment + $paid_amount;
        $tax = (($paid_amount * 18) / 100);
        $amout_to_take = ($paid_amount - $tax) - 1000;

        $update = "update income set total_bal='{$new_total_bal}', total_payment='{$new_paid_bal}',`updated_at`=NOW() where userident='{$id}'";
        // $query = mysqli_query($con, "insert into payment_record (`userident`,`Names`,`NationalID`,`mobile`,`amount`,`after_charges`) values('{$id}','{$row['Names']}','{$row['NationalID']}','{$row['mobile']}','{$paid_amount}','{$amout_to_take}')");
        $run = mysqli_query($con, $update);
        if ($run) {
            ?>
            <script>
                alert('Collect : <?php echo $amout_to_take; ?>  of <?php echo $paid_amount; ?> after charges');
                window.location.href = 'payment.php';
            </script>
            <?php
        } else {
            echo "<script>alert('There is something wrong!')</script>";
        }
    } else {
            ?>
                <script>
                alert('You do not have those amount !...');
                window.location.href = 'payment_form.php?payment_id={$id}';
                </script>
            <?php
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
                            <b>Pay </b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" method="post" action="">
                                        <?php
                                            if (isset($errMSG)) {
                                                ?>
                                        <div class="alert alert-danger">
                                            <span class="glyphicon glyphicon-info-sign"></span> &nbsp;
                                            <?php echo $errMSG; ?>
                                        </div>
                                        <?php
                                            }
                                            ?>
                                        <div class="form-group">
                                            <label>User Names</label>
                                            <input class="form-control" name="Names"
                                                value="<?php echo $row['Names']; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Total amount he/she can withdrow</label>
                                            <input class="form-control" name="total_bal"
                                                value="<?php echo $totalAmount; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" name="total_payment"
                                                value="<?php echo $row['total_payment']; ?>" style="display: none">
                                        </div>
                                        <div class="form-group">
                                            <label>Paid Amount</label>
                                            <input class="form-control" name="paid_amount">
                                        </div>
                                        <button type="submit" name="btn_save_updates" class="btn btn-success"><span
                                                class="glyphicon glyphicon-floppy-save"></span>&nbsp; Make
                                            Payment</button>
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