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
    
    
    $month = strtoupper(mysqli_real_escape_string($mysqli,$_POST['month_select']));
    $_SESSION['month'] =$month;
    
        $resultset = $mysqli->query("SELECT t.emp_code,f.fn,f.sn,t.fuel_type,f.email,substr(p.month,1,7) as Period,sum(t.litres_drawn) as Litres,round((sum(t.litres_drawn) * p.price),2) as Total_Cost
            FROM mds_transactions t , mds_fuel_price p, mds_fuel f
            WHERE substr(t.emp_code,1,2) = 'ZZ'
            AND t.emp_code = f.employee_code
            AND MONTH(t.date) = MONTH(p.month)
            AND YEAR(t.date) = YEAR(p.month)
            AND MONTH(t.date) = MONTH('$month')
            AND YEAR(t.date) = YEAR('$month')
            AND t.fuel_type = p.fuel_type
            AND t.indicator = 'P'
            GROUP BY substr(p.month,1,7),t.emp_code,f.fn,f.sn,f.email,t.fuel_type");
     
            if($resultset->num_rows > 0){
            while($rows=$resultset->fetch_assoc())
            {
                $emp_code = $rows['emp_code'];$fn = $rows['fn'];$sn = $rows['sn'];$email = $rows['email'];$month = $rows['Period'];$Total = $rows['Litres'];$cost = $rows['Total_Cost'];$ftype = $rows['fuel_type'];
                $email =$rows['email'];
                
            $bill_ref = "FLT".date('Y-m-d').rand(1111,9999);
            $stmnt = $mysqli->query("INSERT INTO mds_bills VALUES (null,'$emp_code','$fn','$sn','$month','$bill_ref','$cost','$cost','$ftype','$email')") or die (mysqli_error($mysqli));
            }
            }
    
    
    

    /*$sql = "SELECT * FROM mds_fuel_price WHERE fuel_type = '$ftype' AND  MONTH(month) = MONTH('$month') AND YEAR(month) = YEAR('$month')";
    $result1 = mysqli_query($mysqli,$sql);
    $count = mysqli_num_rows($result1);
    if ($count > 0){
         header("location:fuel_charge?val=err");
    }else{
    $price = strtoupper(mysqli_real_escape_string($mysqli,$_POST['price']));

    $captured_by =  $_SESSION["fn"]." ".$_SESSION["sn"];
    $captured_on = date("d-m-Y H:i:s");



    $stmt = $mysqli->query("INSERT INTO mds_fuel_price VALUES (null,'$month','$ftype','$price','$captured_by','$captured_on')") or die (mysqli_error($mysqli));*/
     //  header("location:bill_board");

    header("location:bill_success");
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

        <div class="user"><h3>Month End Task Bill Board Members</h3></div>

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
                  
                   <tr><td>Month</td><td><select id="month_select" name="month_select" class="form-control">
                      
                      <option value="2020-01-31">January 2020</option>
                      <option value="2020-02-29">February 2020</option>
                      <option value="2020-03-31">March 2020</option>
                      <option value="2020-04-30">April 2020</option>
                      <option value="2020-05-31">May 2020</option>
                      <option value="2020-06-30">June 2020</option>
                   </select></td></tr>
                    

                    <tr>
                        <td><button class="btn-success">Process</button></td><td></td>
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
