<?php
    session_start();

    $id = $_GET['edit_id'];
    require_once 'php-includes/connect.php';
    $userident = $_SESSION['userident'];

    if (!isset($_SESSION['id'])) {
        header('Location:../index.php');
    }

if (count($_POST) > 0) {
    mysqli_query($con, "UPDATE user set Names='".$_POST['Names']."', NationalID='".$_POST['nid']."', mobile='".$_POST['mobile']."',`updated_at`=NOW() WHERE id='".$_GET['edit_id']."'"); ?>
<script>
alert('Successfully Updated...');
window.location.href = 'users.php';
</script>
<?php
}
    $result = mysqli_query($con, "SELECT * FROM user WHERE id='".$_GET['edit_id']."'");
    $row = mysqli_fetch_array($result);

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
                    <h1 class="page-header">Admin Page</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Edit user Account</b>
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
                                                value="<?php echo $row['Names']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>National ID</label>
                                            <input class="form-control" name="nid"
                                                value="<?php echo $row['NationalID']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Telphone</label>
                                            <input class="form-control" name="mobile"
                                                value="<?php echo $row['mobile']; ?>">
                                        </div>
                                        <button type="submit" name="btn_save_updates" class="btn btn-success"><span
                                                class="glyphicon glyphicon-floppy-save"></span>&nbsp; Update</button>
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