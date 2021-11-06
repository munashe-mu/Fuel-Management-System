<?php
session_start();
require 'scscon.php';
if($_SESSION['logged_in'] != true){
   header('Location:logout.php'); 
}
if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) { //have we expired?
    //redirect to logout.php
    header('Location:logout.php'); //change yoursite.com to the name of you site!!
} else{ //if we haven't expired:
    $_SESSION['last_activity'] = time(); //this was the moment of last activity.
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg = strtoupper(mysqli_real_escape_string($mysqli,$_POST['reg']));
    $sql = "SELECT * FROM mds_pool WHERE reg_number = '$reg'";
    $result1 = mysqli_query($mysqli,$sql);
    $count = mysqli_num_rows($result1);
    if ($count > 0){
         header("location:add_item?val=err");    
    }else{
      $type = strtoupper(mysqli_real_escape_string($mysqli,$_POST['type']));
    $division = strtoupper(mysqli_real_escape_string($mysqli,$_POST['division']));
    $dept = strtoupper(mysqli_real_escape_string($mysqli,$_POST['dept']));
    $reg = strtoupper(mysqli_real_escape_string($mysqli,$_POST['reg']));
    $passcode = mysqli_real_escape_string($mysqli,$_POST['passcode']);
    $reg = strtoupper(mysqli_real_escape_string($mysqli,$_POST['reg']));
    $allocation = strtoupper(mysqli_real_escape_string($mysqli,$_POST['allocation']));
    $captured_by =  $_SESSION["fn"]." ".$_SESSION["sn"];
     $captured_on = date("d-m-Y H:i:s");
    $secure = password_hash($passcode, PASSWORD_DEFAULT);
    $stmt = $mysqli->query("INSERT INTO mds_pool VALUES (null,'$type','$division','$dept','$reg','$secure','$allocation','$captured_by','$captured_on')") or die (mysqli_error($mysqli));
       header("location:add_item?val=success");   
    }

    
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
        
        <div class="user"><h3>Capture Pool Item</h3></div> 
        
        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                    <form action="" method="post" class="form-horizontal"  role="form">
                    <table class="table"><tr>
                        <td>
                        <?php
                        if(!isset($_GET['val'])){
                            
                        }else{
                            $val =$_GET['val'];
                            if($val=="err"){
                             echo "<p><b>Item Already Exist</b></p>";   
                            }else{
                              echo "<p><b>Item Saved Succesfully</b></p>";  
                            }
                            
                        }
                        ?>
                        </td><td></td>
                        </tr>
                  <tr><td>Item Type</td><td><select class="form-control" id="type" name="type" required>
                      <option value="Pool Car">Pool Car</option>
                       <option value="Pool Bike">Pool Bike</option>
                       <option value="Generator">Generator</option>
                      </select ></td></tr>
                   <tr><td>Division</td><td><select class="form-control" id="division" name="division" required>
                      <option value="Medical Aid">Medical Aid</option>
                       <option value="Health Care">Health Care</option>
                       <option value="Medical laboratories">Medical Laboratories</option>
                      </select></td></tr>
                    <tr><td>Department</td>
                        <td><input type="text" class="form-control" required id="dept" name="dept"></td>
                        </tr>
                    <tr><td>Reg Number / Serial Number</td>
                        <td><input type="text" class="form-control" required id="reg" name="reg"></td>
                        </tr>
                    <tr><td>Default Passcode</td>
                        <td><input type="password" class="form-control" id="passcode" name="passcode" required></td>
                        </tr>
                    <tr><td>Monthly Allocation</td>
                            <td><input type="text" class="form-control" required id="allocation" name="allocation"></td>
                        </tr>
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