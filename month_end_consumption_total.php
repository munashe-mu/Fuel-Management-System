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
if($_SESSION["access"]!= "ADMIN"){
    header("location:violation");
}else{
if($_SERVER["REQUEST_METHOD"] == "POST") {
    include("scscon.php");
      $dated = strtoupper(mysqli_real_escape_string($mysqli,$_POST['dated']));
    $division = strtoupper(mysqli_real_escape_string($mysqli,$_POST['division']));



        $div="";
        if($division==1){
            $div = "MEDICAL AID";
        }elseif($division==2){
            $div="Healthcare Services";
        }elseif($division==3){
            $div="Medical Services";
        }elseif($division==4){
            $div="BOARD MEMBER";
        }elseif($division==5){
            $div="DATA AFRICA";
        }


        $_SESSION["filter_date"] = $dated;

    header("location:month_end_total_c_display");

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

        <div class="user"><h3>Staff Month End Consumption</h3></div>

        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                    <form action="" method="post" class="form-horizontal"  role="form">
                    <table class="table">
                    <tr>
                        <td>
                      Select Month and Division
                        </td>
                        <td>
                       <select class="form-control" id="dated" name="dated" required>
                            <option value="2019-10-01">2019-10</option>
                             <option value="2019-11-01">2019-11</option>
                           <option value="2019-12-01">2019-12</option>
                            <option value="2020-01-01">2020-01</option>
                            </select>
                        </td>
                        </tr>
                        <tr>

                      <td><button class="btn-success">Open Report</button></td>
                        </tr>
                    </table>
                    </form>
                </div>
                </div>


        </div>
    </body>


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
</html>
