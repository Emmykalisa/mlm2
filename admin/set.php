<?php
include('php-includes/check-login.php');
require('php-includes/connect.php');
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
                        <h1 class="page-header">Join The User</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">

                    <h1>WITHDRAW CATEGORY</h1>

                    <p>Currently withdraw automatically is set to <span class="btn  btn-danger">
                        <?php
                        $select=$dbi->query("SELECT * FROM automatic order by id desc limit 1");
                        while($rows=mysqli_fetch_array($select)){
                            echo $rows['categorized'];
                        }
                        ?>

                    </span></p>
                    <div class="col-lg-4">
                        <?php
//User cliced on join
  // ====================Taliki za none ================
   $dat = new DateTime('now', new DateTimeZone('Africa/Cairo'));

    $date = $dat->format('Y-m-d');


//==============end 
if (isset($_POST['join_user'])) {
    
    $category = mysqli_real_escape_string($con, $_POST['category']);
    
   $insert=$dbi->query("INSERT INTO automatic(categorized,created_at) VALUES('$category', '$date')");
   if($insert){
    echo "<p class='alert alert-success'>withdraw method updated</p> ";
    echo"<script>window.setTimeout(function() {
    window.location.replace('set.php');
}, 1000);</script>";

   }else{
     echo "<p class='alert alert-danger'>withdraw method can not be updated</p> ";
   }
   
}

?>
                        <form method="POST">
                           
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category">
                                    <option>Choose</option>
                                    <option value="yes">Automatic withdraw</option>
                                    <option value="no">Approve withdraw</option>
                                </select>
                            </div>
                            
                          
                         

                            <div class="form-group">
                                <input type="submit" name="join_user" class="btn btn-success" value="Set it now">
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