<?php
include('php-includes/connect.php');
$query = mysqli_query($con,"select * from admin where userident='$userident'");
$result = mysqli_fetch_array($query);
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><b>IFF</b></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <img src="../uploads/<?php echo  $result['picture']; ?>" class="user-image" alt="User Image" style="border-radius: 50%;" width="40px" height="40px"></i>&nbsp;&nbsp;&nbsp;<?php echo $result['Names']?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-message">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <br/>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="users.php"><i class="fa fa-dashboard fa-fw"></i> User's Account</a>
                        </li>
                        <li>
                            <a href="accountant.php"><i class="fa fa-dashboard fa-fw"></i> Accountants Account</a>
                        </li>
                        <li>
                            <a href="view-pin-request.php"><i class="fa fa-adjust fa-fw"></i> View Pin Request</a>
                        </li>
                        <li>
                            <a href="income.php"><i class="fa fa-rupee fa-fw"></i> Income</a>
                        </li>
                        <li>
                            <a href="income-history.php"><i class="fa fa-rupee fa-fw"></i> Income History</a>
                        </li>
                        <li>
                            <a href="payment.php"><i class="fa fa-rupee fa-fw"></i> Make Encashment</a>
                        </li>
                        <li>
                            <a href="report.php"><i class="fa fa-rupee fa-fw"></i> Encashment Report</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>