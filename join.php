<?php
include 'php-includes/connect.php';
include 'php-includes/check-login.php';
include './php-includes/treeUtil.php';
include './php-includes/queryHelper.php';
$userident = $_SESSION['userident'];
$capping = 5000;
$capping2 = 6000;
?>
<?php
//User cliced on join
  // ====================Taliki za none ================
   $dat = new DateTime('now', new DateTimeZone('Africa/Cairo'));

    $date = $dat->format('Y-m-d');

    //======== Taliki zibanje 

$dati = new DateTime('now', new DateTimeZone('Africa/Cairo'));
$dati->modify("-1 day");
    $datu = $dati->format('Y-m-d');



if (isset($_GET['join_user'])) {
    $matching = 0;
    $side = '';
    $pin = mysqli_real_escape_string($con, $_GET['pin']);
    $names = mysqli_real_escape_string($con, $_GET['names']);
    $natio_id = mysqli_real_escape_string($con, $_GET['natio_id']);
    $mobile = mysqli_real_escape_string($con, $_GET['mobile']);
    $address = mysqli_real_escape_string($con, $_GET['address']);
    $under_userpin = mysqli_real_escape_string($con, $_GET['under_userpin']);
    $side = mysqli_real_escape_string($con, $_GET['side']);
    $sponsor = mysqli_real_escape_string($con, $_GET['sponsor']);
    $password = mysqli_real_escape_string($con, $_GET['pass1']);
    // $password = md5($password);
    
     $dat = new DateTime('now', new DateTimeZone('Africa/Cairo'));

    $date = $dat->format('Y-m-d');
    $user_status = 'Active';
    $picture = 'images.png';

    $flag = 0;

    //==========================Counting users who joined per day 

    $newuser = $dbi->query("SELECT COUNT(id) from user where under_userpin='$under_userpin' AND created_at='$date'  ");
    while($rows=mysqli_fetch_array($newuser)){
       $countn=$rows['COUNT(id)'];
    }
    if($countn<=5){
        // put something here;
    }else{
        //echo"Flash out take a place";
    }

    if ('' != $pin && '' != $mobile && '' != $address && '' != $under_userpin && '' != $side) {
        //User filled all the fields.
        if (pin_check($pin)) {
            // pin is ok
            // if(userExist_check($userident)){
            //user exist is ok
            if (!userExist_check($under_userpin)) {
                //under user is ok
                if (side_check($under_userpin, $side)) {
                    //side check is ok
                    $flag = 1;
                } else {
                    echo '<script>alert("The side you selected is not available");</script>';
                }
            } else {
                //check under user id
                echo '<script>alert("Invalid Under User Id");</script>';
            }
            // }
            // else{
            // 	//check that user exist
            // 	echo '<script>alert("this user is arleady available");</script>';
            // }
        } else {
            //check pin
            echo '<script>alert("Invalid Pin");</script>';
        }
    } else {
        //check all fields are fill
        echo '<script>alert("Please fill all the fields.");</script>';
    }

    //Now we are heree
    //It means all the information is correct
    //Now we will save all the information
    if (1 == $flag) {
        //Insert into User profile
        $query = mysqli_query($con, "insert into user(`userident`,`Names`,`NationalID`,`password`,`mobile`,`address`,`under_userpin`,`side`,`user_status`,`picture`) values('{$pin}','{$names}','{$natio_id}','{$password}','{$mobile}','{$address}','{$under_userpin}','{$side}','{$user_status}','{$picture}')");

        //Insert into Tree
        //So that later on we can view tree.
        $query = mysqli_query($con, "insert into tree(`userident`,`Names`) values('{$pin}','{$names}')");

        //Insert to side
        $query = mysqli_query($con, "update tree set `{$side}`='{$pin}',`updated_at`=NOW() where userident='{$under_userpin}'");

        //Update pin status to close
        $query = mysqli_query($con, "update pin_list set status='close',`updated_at`=NOW() where pin='{$pin}'");

        //Inset into Icome
        $query = mysqli_query($con, "insert into income (`userident`) values('{$pin}')");
        echo mysqli_error($con);
        //This is the main part to join a user\
        //If you will do any mistake here. Then the site will not work.

        //Update count and Income.
        $temp_sponsor = $sponsor;
        $temp_under_userpin = $under_userpin;
        $temp_side = $side;
        $temp_side_count = $side.'count'; //leftcount or rightcount

        $total_count = 1;
        // $i=1;

        //Loop

        while ($total_count > 0) {
            // $i;
            $q = mysqli_query($con, "select * from tree where userident='{$temp_under_userpin}'");
            $r = mysqli_fetch_array($q);
            $current_temp_side_count = $r[$temp_side_count] + 1;
            // $temp_under_userpin;
            // $temp_side_count;
            mysqli_query($con, "update tree set `{$temp_side_count}`={$current_temp_side_count},`updated_at`=NOW() where userident='{$temp_under_userpin}'");
///=============helpers==================================
        //========= Flash out process Zitangirira hano(TT) !=====

             $query = mysqli_query($con, "select * from income where userident='{$temp_under_userpin}'");
                    $result = mysqli_fetch_array($query);

                    $qHelper = new QueryHelper();
                    $userTree = $qHelper->getUserCounts($result['userident']);
                    $leftSideCount = $userTree['leftcount'];
                    $rightSideCount = $userTree['rightcount'];
                    $calculator = new AmountCalculator($leftSideCount, $rightSideCount);

//==============Update points 

                    // $update=$dbi->query("UPDATE tree set leftpoints='$leftSideCount', rightpoints='$rightSideCount' where userident='{$temp_under_userpin}' ");

 //============Insertind tree to todays table to easly notify entry date (TT)
            $tree_data = tree($temp_under_userpin);

                $temp_left_count = $tree_data['leftcount'];
                $temp_right_count = $tree_data['rightcount'];
                $matched=$calculator->matchUsers();
//select matchedview to this 
 $usertri=$dbi->query("SELECT * FROM tree where userident='{$temp_under_userpin}' order by id desc limit 1");
 while($rows=mysqli_fetch_array($usertri)){
   
    $matchi=$rows['matchedview'];
 }               

$fmatch=$matched+$matchi;

$newentry = $dbi->query("INSERT INTO todays(userpin,matched,created_at,leftcount,rightcount,flashoutmatch) VALUES('$temp_under_userpin','$matched','$date','$temp_left_count','$temp_right_count','$fmatch')");

//===============Update tree - points--- (TT)=======================
 // $updta=$dbi->query("UPDATE tree SET leftpoints='$temp_left_count', rightpoints='$temp_right_count' where   userident='{$temp_under_userpin}' ");

//=============== left na light ziherukatc (TT)
 $iziheruka =  $dbi->query("SELECT * FROM todays where userpin='{$temp_under_userpin}' AND created_at='$datu' order by id desc limit 1 ");
 while($rows=mysqli_fetch_array($iziheruka)){
    $previousmatch = $rows['matched'];
   
 }
 //=============== left na light zuyumunsi (TT)
 $nowpo = $dbi->query("SELECT * FROM todays where userpin='{$temp_under_userpin}' AND created_at='$date' order by id desc limit 1 ");
 while($rows=mysqli_fetch_array($nowpo)){
    $todaymatch = $rows['matched'];

    

 }
//===============Selecting points 
 $usertrees=$dbi->query("SELECT * FROM tree where userident='{$temp_under_userpin}' order by id desc limit 1");
 while($rows=mysqli_fetch_array($usertrees)){
    $todayright=$rows['rightcount'];
    $todayleft=$rows['leftcount'];
    $rview=$rows['rightview'];
    $lview=$rows['leftview'];
    $matchu=$rows['matches'];
    $fmatchu=$rows['matchedview'];
 }
$righthand = $todayright-$todaymatch;
$lefthand = $todayleft-$todaymatch;


 $diff=$todaymatch+$fmatchu-$previousmatch;
 if($diff>6){
    //===Now Let update our points - as flash out took place
$matches=$todaymatch+$fmatchu+6;
$totright =$todayright+ $rview;
$totleft =$todayleft+ $lview;
$updatee=$dbi->query("UPDATE tree SET matches='$matches',matchedview='$matches',leftview='$totleft',rightview='$totright', rightcount=0,leftcount=0  where userident='{$temp_under_userpin}' ");


 }else{
     
$matches=$todaymatch;
$updatee=$dbi->query("UPDATE tree SET matches='$matches' where userident='{$temp_under_userpin}' ");

 }

//==================END OF FLASH OUT (TT)=======================

            //income
            if ('' != $temp_sponsor) {
                $income_data1 = income($temp_sponsor);
                $income_data2 = income($temp_under_userpin);

                $tree_data = tree($temp_under_userpin);

                $temp_left_count = $tree_data['leftcount'];
                $temp_right_count = $tree_data['rightcount'];

                //change under_userpin
                $next_under_userpin = getUnderId($temp_under_userpin);
                $temp_side = getUnderIdPlace($temp_under_userpin);
                $temp_side_count = $temp_side.'count';
                $temp_under_userpin = $next_under_userpin;
                // $i++;
            }

            //Chaeck for the last user
            if ('' == $temp_under_userpin) {
                $total_count = 0;
            }
        }//Loop

        if ('' != $temp_sponsor) {
            $income_data = income($temp_sponsor);

            $new_day_bal = $income_data['total_earnings'] + 5000;
            $new_current_bal = $income_data['available_balance'] + 5000;
            $new_total_bal = $income_data['total_bal'] + 5000;

            //update income
            mysqli_query($con, "update income set total_earnings='{$new_day_bal}', available_balance='{$new_current_bal}', total_bal='{$new_total_bal}',`updated_at`=NOW() where userident='{$temp_sponsor}' limit 1");
            // $usp_income_data = income($under_userpin);

            // $usp_new_day_bal = $usp_income_data['day_bal'] - 5000;
            // $usp_new_current_bal = $usp_income_data['current_bal'] - 5000;
            // $usp_new_total_bal = $usp_income_data['total_bal'] - 5000;
            // mysqli_query($con, "update income set day_bal='{$usp_new_day_bal}', current_bal='{$usp_new_current_bal}', total_bal='{$usp_new_total_bal}',`updated_at`=NOW() where userident='{$under_userpin}' limit 1");
        }

        echo mysqli_error($con);
        if ($temp_left_count === $temp_right_count && '' != $temp_left_count && '' != $temp_right_count && 0 == ($temp_left_count + $temp_right_count) % 2) {
            // $matching=$matching+2;
            // if($matching===2){

            // }
        }

        echo '<script>alert("User Registered successfully.");</script>';
        echo $matching;
    }
}
?>
<?php
//functions
function pin_check($pin)
{
    global $con,$userident;

    $query = mysqli_query($con, "select * from pin_list where pin='{$pin}' and userident='{$userident}' and status='open'");
    if (mysqli_num_rows($query) > 0) {
        return true;
    }

    return false;
}
function userExist_check($userident)
{
    global $con;

    $query = mysqli_query($con, "select * from user where userident='{$userident}'");
    if (mysqli_num_rows($query) > 0) {
        return false;
    }

    return true;
}
function side_check($userident, $side)
{
    global $con;

    $query = mysqli_query($con, "select * from tree where userident='{$userident}'");
    $result = mysqli_fetch_array($query);
    $side_value = $result[$side];
    if ('' == $side_value) {
        return true;
    }

    return false;
}
function income($userident)
{
    global $con;
    $data = [];
    $query = mysqli_query($con, "select * from income where userident='{$userident}'");
    $result = mysqli_fetch_array($query);
    $data['total_earnings'] = $result['total_earnings'];
    $data['available_balance'] = $result['available_balance'];
    $data['total_bal'] = $result['total_bal'];

    return $data;
}
function tree($userident)
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
function getUnderId($userident)
{
    global $con;
    $query = mysqli_query($con, "select * from user where userident='{$userident}'");
    $result = mysqli_fetch_array($query);

    return $result['under_userpin'];
}
function getUnderIdPlace($userident)
{
    global $con;
    $query = mysqli_query($con, "select * from user where userident='{$userident}'");
    $result = mysqli_fetch_array($query);

    return $result['side'];
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
                        <form method="get">
                            <div class="form-group">
                                <label>Pin</label>
                                <input type="text" name="pin" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Names</label>
                                <input type="text" name="names" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>National Id</label>
                                <input type="number" name="natio_id" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" name="pass1" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="phone" name="mobile" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>UpLine Pin</label>
                                <input type="pin" name="under_userpin" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Sponsor Pin</label>
                                <input type="text" name="sponsor" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Side</label><br>
                                <input type="radio" name="side" value="left"> Left
                                <input type="radio" name="side" value="right"> Right
                            </div>

                            <div class="form-group">
                                <input type="submit" name="join_user" class="btn btn-primary" value="Join">
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