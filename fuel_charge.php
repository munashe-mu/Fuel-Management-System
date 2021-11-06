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
    $ftype = strtoupper(mysqli_real_escape_string($mysqli,$_POST['f_type']));
    $month = strtoupper(mysqli_real_escape_string($mysqli,$_POST['month_select']));

    $sql = "SELECT * FROM mds_fuel_price WHERE fuel_type = '$ftype' AND  MONTH(month) = MONTH('$month') AND YEAR(month) = YEAR('$month')";
    $result1 = mysqli_query($mysqli,$sql);
    $count = mysqli_num_rows($result1);
    if ($count > 0){
         header("location:fuel_charge?val=err");
    }else{
    $price = strtoupper(mysqli_real_escape_string($mysqli,$_POST['price']));

    $captured_by =  $_SESSION["fn"]." ".$_SESSION["sn"];
    $captured_on = date("d-m-Y H:i:s");



    $stmt = $mysqli->query("INSERT INTO mds_fuel_price VALUES (null,'$month','$ftype','$price','$captured_by','$captured_on')") or die (mysqli_error($mysqli));
       header("location:fuel_charge?val=success");
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

        <div class="user"><h3>Capture Fuel Price For Current Month</h3></div>

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
                  <tr><td>Fuel Type</td><td><select class="form-control" id="f_type" name="f_type" required>
                      <option value="Petrol">Petrol</option>
                       <option value="Diesel">Diesel</option>

                      </select ></td></tr>
                   <tr><td>Month</td><td><select id="month_select" name="month_select" class="form-control">
                      <option value="2019-11-30">November 2019</option>
                      <option value="2019-12-31">December 2019</option>
                      <option value="2020-01-31">January 2020</option>
                      <option value="2020-02-29">February 2020</option>
                      <option value="2020-03-31">March 2020</option>
                      <option value="2020-04-30">April 2020</option>
                      <option value="2020-05-31">May 2020</option>
                      <option value="2020-06-30">June 2020</option>
                   </select></td></tr>
                    <tr><td>Capture Price</td>
                        <td><input type="text" class="form-control" required id="price" name="price"></td>
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
