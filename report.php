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

        <div class="user"><h3>Reports</h3></div>

        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                    <form action="" method="post" class="form-horizontal"  role="form">
                    <table class="table">
                <tr><td><a href="month_end_report">Month End Report</a></td><td><a href="">HR Report</a></td><td><a href="all_staff">All Staff List</a></td></tr>
                       <tr><td><a href="tankers">Tankers Status</a></td><td><a href="tanker_log">Tankers Refueling Log</a></td><td><a href="adjustments">Adjustments Report</a></td></tr>
                    <tr><td><a href="daily_report_summary_proc">Daily Report Summary</a></td>
                        <td><a href="daily_report_proc">Daily Report Detailed</a></td>
                        <td><a href="daily_report_pool_proc">Daily Report Pool</a></td>
                        </tr>

                        <tr><td><a href="month_end_consumption_staff">Staff Month End Consumption</a></td>
                        <td><a href="month_end_consumption_staff_cost">Staff Month End Costs</a></td>
                        <td><a href="month_end_consumption_pool">Pool Car Month End</a></td>

                         <tr><td><a href="month_end_consumption_total">Total Fuel Consumption Month End</a></td>
                        <td><a href="month_end_consumption_total_bdown">Month Consumption Breakdown Per Day</a></td>
                        <td><a href="month_end_consumption_gen">Generators Month End</a></td>


                        </tr>

                    </table>
                    </form>
                </div>
                </div>


        </div>
    </body>


</html>
