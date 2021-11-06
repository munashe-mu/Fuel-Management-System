<?php
session_start();
if($_SESSION['logged_in'] != true){
   header('Location:logout.php'); 
}
if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) { //have we expired?
    //redirect to logout.php
    header('Location:logout.php'); //change yoursite.com to the name of you site!!
} else{ //if we haven't expired:
    $_SESSION['last_activity'] = time(); //this was the moment of last activity.
}
require 'scscon.php';
if($_SERVER["REQUEST_METHOD"] == "POST") {
   // $auth = mysqli_real_escape_string($mysqli,$_POST['auth']);
   // $code = $_SESSION["cap_caode"];
    //$sql = "SELECT * FROM mds_fuel WHERE employee_code = '$code'";
    // $result = mysqli_query($mysqli,$sql);
    //    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    //    $mypasswordb = $row['password'];
    //    $hash = substr( $mypasswordb, 0, 60 );
    //   if (password_verify($auth, $hash)){
                $date = $_SESSION["date"];
                $employee =  $_SESSION["pool_car_owner"];
                $empcode = $_SESSION["pool_car_emp_code"];
                $vehicle = $_SESSION["pool_car_vehicle"];
                $ftype = $_SESSION["ftype"];
                $litre = $_SESSION["litres"];
                $captured_by = $_SESSION["fn"]." ".$_SESSION["sn"];
                $captured_on = date("d-m-Y H:i:s");
                $purpose = $_SESSION["purpose_pool"];
                
            $bal = $_SESSION["trans_emp_bal"];
                
               
            $indicator = "AP";
            $newbal =0;
            if($purpose=="TRAVEL"){
                $newbal = $bal;
            }else{
                $newbal = $bal - $litre;
            }
             $_SESSION["trans_emp_bal"] =$newbal;  
           $stmt = $mysqli->query("INSERT INTO mds_transactions VALUES (null,'$date','$employee','$empcode','$vehicle','$ftype','$litre','$captured_by','$captured_on','$indicator','$purpose')") or die (mysqli_error($mysqli));
           
            $stmt2 = $mysqli->query("UPDATE mds_assigned_pool set balance = '$newbal' WHERE emp_code = '$empcode'") or die (mysqli_error($mysqli));
           
           //Tankers Stats
           $sql1 = "SELECT * FROM mds_tankers WHERE fuel_type = '$ftype'";
     $result1 = mysqli_query($mysqli,$sql1);
        $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
        $tanker_bal = $row1['balance'];
        $new_tanker_bal = $tanker_bal - $litre;
        
        $stmt3 = $mysqli->query("UPDATE mds_tankers set balance = '$new_tanker_bal' WHERE fuel_type = '$ftype'") or die (mysqli_error($mysqli));
    
    //mileage
    
    $reg = $_SESSION["pool_car_reg_num"];
    $mileage =  $_SESSION["mileage"];
     $div = $_SESSION["pool_car_div"];
   $dept =  $_SESSION["pool_car_dept"];
    
    $stmt4 = $mysqli->query("INSERT INTO mds_pool_mileage VALUES (null,'$reg','$mileage','$captured_on','$div','$dept')") or die (mysqli_error($mysqli));
        
           
                header("location:pool_car_success"); 
      // }else{
    //      header("location:cap_approve?val=invalid"); 
    //   }
    
    
    
}

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cimas Fuel Management</title>
        <link href="css/optical.css" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
         <link href="css/bootstrap.min_2.css" rel="stylesheet" media="screen">
        <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
        <link rel="icon" type="image/png" href="images/cimasfav.png">
        <script language=JavaScript>
            <!--
            function reload(form)
            {
            var val=form.cat.options[form.cat.options.selectedIndex].value;
            self.location='transactions.php?cat=' + val ;
            }
            //-->
        </script>
    </head>
    <body>
    <div class="top_bar">
        <div class="left_top">
        <img src="images/logo.png">
        <h3>Fuel Management</h3>
        </div>
        
        <div class="right_top">
        <ul>
            <li><a href="home">Home</a></li>
          
            <li><a href="transaction">Transaction History</a></li>
             <li><a href="admin">Admin</a></li>
            <li><a href="transactions">Capture Transactions</a></li>
            <li><a href="report">Reports</a></li>
            <li><a href="logout">Log Out</a></li>
            </ul>
        </div>
        
        </div>
    <div class="container">
        
        <div class="user"><h3>Capture Fuel Transaction</h3></div> 

        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                    <form action="" method="post" class="form-horizontal"  role="form">
                  <p>Transaction Pending Approval</p>
                    <table class="table">
                    <tr>
                        <td>
                        <?php
                        if(!isset($_GET['val'])){
                        }else{
                            echo "<p><b>Invalid Authorization Code, Try Again</b></p>";
                        }
                        ?>
                        </td><td></td>
                        </tr>
                    <tr>
                        <td>Employee:</td><td><?php echo $_SESSION["pool_car_owner"];?></td></tr>
                        <tr><td>Date:</td><td><?php echo  $_SESSION["date"] ;?></td></tr>
                        <tr><td>Vehicle:</td><td><?php echo $_SESSION["pool_car_vehicle"];?></td></tr>
                        <tr><td>Reg Number:</td> <td><?php echo $_SESSION["pool_car_reg_num"];?></td></tr>
                        <tr><td>Litres Drawn:</td> <td><?php echo $_SESSION["litres"];?></td></tr>
                        <tr><td>Fuel Type:</td><td><?php echo  $_SESSION["ftype"] ;?></td></tr>
                        <tr><td>Mileage:</td><td><?php echo  $_SESSION["mileage"] ;?></td></tr>
                        <tr><td>Purpose:</td><td><?php echo  $_SESSION["purpose_pool"] ;?></td></tr>
                    <!--<tr><td>Enter Authorization Code</td><td><input type="password" class="form-control" id="auth" name="auth" required></td></tr>-->
                        <tr>
                        <td><button class="btn-success">Save Transaction</button></td>
                        <td></td>    
                        </tr>
                    </table>
                    </form>
                </div>
                </div>
        

        </div>
    </body>


</html>

<script type="text/javascript" src="js/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
    

</script>