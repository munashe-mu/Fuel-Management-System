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
    $litre = strtoupper(mysqli_real_escape_string($mysqli,$_POST['litre']));
	$reason = strtoupper(mysqli_real_escape_string($mysqli,$_POST['reason']));
    $_SESSION["litre"] = $litre;
    $emp_code = $_SESSION["cap_caode"];
    $employee =  $_SESSION["fn_cap"]." ". $_SESSION["sn_cap"];
    $cap_by = $_SESSION["fn"]." ". $_SESSION["sn"];
    $cap_on = date("Y-m-d H:i:s");
    
     $sql = "SELECT * FROM mds_fuel WHERE employee_code = '$emp_code'";
    $result = mysqli_query($mysqli,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $bal = $row['balance'];
   
    $newbal = $bal + $litre;
    
    $_SESSION["newbal"] = $newbal;
    
    $stmnt = $mysqli->query("INSERT INTO MDS_ADJUST_LOG VALUES (null,'$emp_code','$employee','$reason','$bal','$litre','$newbal','$cap_on','$cap_by')");
    
    $stmnt2 = $mysqli->query("UPDATE MDS_FUEL SET balance ='$newbal' WHERE employee_code='$emp_code'");
    
    header("location:adjust_success"); 
    
}

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cimas Optical Authorizations</title>
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
        
        <div class="user"><h3>Adjust Limit</h3></div> 
        
        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                    <form action="" method="post" class="form-horizontal"  role="form">
                    <table class="table"><tr>
                        <td>
                        <?php
                        if(!isset($_GET['val'])){
                        }else{
                            echo "<p><b>Adjustment Saved Successfully</b></p>";
                        }
                        ?>
                        </td><td></td>
                        </tr>
                  <tr><td>Employee Name</td><td><?php echo $_SESSION["fn_cap"]." ". $_SESSION["sn_cap"];?></td></tr>
                    <tr><td>Current Balance</td><td><?php
                        $emp_code = $_SESSION["cap_caode"];
                        $sql = "SELECT * FROM mds_fuel WHERE employee_code = '$emp_code'";
                        $result = mysqli_query($mysqli,$sql);
                        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                        $bal = $row['balance'];
                        echo $bal;
                        
                        
                        ?></td></tr><tr>
                 
                     
                        <td>
                        Litres To Add
                        </td>
                        <td><input type="number" id="litre" name="litre" class="form-control" required></td></tr>
						<tr><td>Reason</td><td><textarea id="reason" name="reason" class="form-control" required></textarea></td></tr>
                        <tr>
                        <td><button class="btn-success">Save</button></td><td></td>
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