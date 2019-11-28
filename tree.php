<?php
include 'php-includes/connect.php';
include 'php-includes/check-login.php';
include 'php-includes/treeUtil.php';
include 'php-includes/queryHelper.php';
$userident = $_SESSION['userident'];
$search = $userident;
$qHelper = new QueryHelper();
$userTree = $qHelper->getUserCounts($userident);
$leftSideCount = $userTree['leftcount'];
$rightSideCount = $userTree['rightcount'];
$calculator = new AmountCalculator($leftSideCount, $rightSideCount);
function tree_data($userident)
{
    global $con;
    $data = [];
    $query = mysqli_query($con, "select * from tree where userident='{$userident}'");
    $result = mysqli_fetch_array($query);
    $data['left'] = $result['left'];
    $data['right'] = $result['right'];
    $data['leftcount'] = $result['leftcount'];
    $data['rightcount'] = $result['rightcount'];

    return $data;
}
if (isset($_GET['search-id'])) {
    $search_id = mysqli_real_escape_string($con, $_GET['search-id']);
    if ('' != $search_id) {
        $query_check = mysqli_query($con, "select * from user where userident='{$search_id}'");
        if (mysqli_num_rows($query_check) > 0) {
            $search = $search_id;
        } else {
            echo '<script>alert("Access Denied");window.location.assign("tree.php");</script>';
        }
    } else {
        echo '<script>alert("Access Denied");window.location.assign("tree.php");</script>';
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
                        <h1 class="page-header">Tree</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <!-- <div class="col-md-12">
                        <h2 class="text-center">
                            The tree points structure
                        </h2>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Matching point</h4>
                            </div>
                            <div class="panel-body">
                                <?php echo $calculator->matchUsers(); ?>
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
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h4 class="panel-title">Gift check</h4>
                            </div>
                            <div class="panel-body">
                                <?php echo $calculator->getGiftCheck(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h4 class="panel-title">Aggregated point</h4>
                            </div>
                            <div class="panel-body">
                              <?php echo $calculator->getTotalPoints(); ?>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table" align="center" border="0" style="text-align:center">
                                <tr height="150">
                                    <?php
$data = tree_data($search);
?>
                                    <td><?php echo $data['leftcount']; ?></td>
                                    <td colspan="2"><i class="fa fa-user fa-4x" style="color:#1430B1"></i>
                                        <p><?php echo $search; ?></p>
                                    </td>
                                    <td><?php echo $data['rightcount']; ?></td>
                                </tr>
                                <tr height="150">
                                    <?php
$first_left_user = $data['left'];
$first_right_user = $data['right'];
?>
                                    <?php
if ('' != $first_left_user) {
    ?>
                                    <td colspan="2"><a href="tree.php?search-id=<?php echo $first_left_user; ?>"><i
                                                class="fa fa-user fa-4x" style="color:#D520BE"></i>
                                            <p><?php echo $first_left_user; ?></p>
                                        </a></td>
                                    <?php
} else {
        ?>
                                    <td colspan="2"><i class="fa fa-user fa-4x" style="color:#D520BE"></i>
                                        <p><?php echo $first_left_user; ?></p>
                                    </td>
                                    <?php
    }
?>
                                    <?php
if ('' != $first_right_user) {
    ?>
                                    <td colspan="2"><a href="tree.php?search-id=<?php echo $first_right_user; ?>"><i
                                                class="fa fa-user fa-4x" style="color:#D520BE"></i>
                                            <p><?php echo $first_right_user; ?></p>
                                        </a></td>
                                    <?php
} else {
        ?>
                                    <td colspan="2"><i class="fa fa-user fa-4x" style="color:#D520BE"></i>
                                        <p><?php echo $first_right_user; ?></p>
                                    </td>
                                    <?php
    }
?>
                                </tr>
                                <tr height="150">
                                    <?php
$data_first_left_user = tree_data($first_left_user);
$second_left_user = $data_first_left_user['left'];
$second_right_user = $data_first_left_user['right'];

$data_first_right_user = tree_data($first_right_user);
$third_left_user = $data_first_right_user['left'];
$thidr_right_user = $data_first_right_user['right'];
?>
                                    <?php
if ('' != $second_left_user) {
    ?>
                                    <td><a href="tree.php?search-id=<?php echo $second_left_user; ?>"><i
                                                class="fa fa-user fa-4x" style="color:#361515"></i>
                                            <p><?php echo $second_left_user; ?></p>
                                        </a></td>
                                    <?php
} else {
        ?>
                                    <td><i class="fa fa-user fa-4x" style="color:#361515"></i></td>
                                    <?php
    }
?>
                                    <?php
if ('' != $second_right_user) {
    ?>
                                    <td><a href="tree.php?search-id=<?php echo $second_right_user; ?>"><i
                                                class="fa fa-user fa-4x" style="color:#361515"></i>
                                            <p><?php echo $second_right_user; ?></p>
                                        </a></td>
                                    <?php
} else {
        ?>
                                    <td><i class="fa fa-user fa-4x" style="color:#361515"></i></td>
                                    <?php
    }
?>
                                    <?php
if ('' != $third_left_user) {
    ?>
                                    <td><a href="tree.php?search-id=<?php echo $third_left_user; ?>"><i
                                                class="fa fa-user fa-4x" style="color:#361515"></i>
                                            <p><?php echo $third_left_user; ?></p>
                                        </a></td>
                                    <?php
} else {
        ?>
                                    <td><i class="fa fa-user fa-4x" style="color:#361515"></i></td>
                                    <?php
    }
?>
                                    <?php
if ('' != $thidr_right_user) {
    ?>
                                    <td><a href="tree.php?search-id=<?php echo $thidr_right_user; ?>"><i
                                                class="fa fa-user fa-4x" style="color:#361515"></i>
                                            <p><?php echo $thidr_right_user; ?></p>
                                        </a></td>
                                    <?php
} else {
        ?>
                                    <td><i class="fa fa-user fa-4x" style="color:#361515"></i></td>
                                    <?php
    }
?>
                                </tr>
                            </table>
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