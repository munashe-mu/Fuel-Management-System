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

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cimas Fuel Management</title>
        <link href="css/optical.css" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/png" href="images/cimasfav.png">
    </head>
    <body>
    <div class="top_bar">
        <div class="left_top">
        <img src="images/logo.png">
        <h3>Cimas Fuel Management</h3>
        </div>
        
        <div class="right_top">
        <ul>
            <li><a href="home">Home</a></li>
           <li><a href="vehicle">My Vehicles</a></li>
            <li><a href="transaction">Transaction History</a></li>
         
            <li><a href="admin">Admin</a></li>
            <li><a href="transactions">Capture Transactions</a></li>
            <li><a href="report">Reports</a></li>
            <li><a href="logout">Log Out</a></li>
            </ul>
        </div>
        
        </div>
    <div class="container">
        
        <div class="user"><p>Welcome, <?php echo $_SESSION["fn"]." ".$_SESSION["sn"]; ?></p></div> 
        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                   <h5 class="card-title">This Month Summary for <?php echo $_SESSION["fn"]." ".$_SESSION["sn"]; ?></h5> 
                    <table class="table">
                    <thead>
                        <tr>
                        <th>Vehicle Type</th>
                        <th>Total Fuel Drawn</th>
                        <th>Balance</th>
                         
                        </tr></thead>
                    <!--<small><marquee>Watch this space feature to be launched on 1 October 2019</marquee></small>-->
                        <?php
                        include("scscon.php");	
                        
                        $bal = $_SESSION["balance"];
                        $emp_code = $_SESSION["code"];
                        $sql3 = "SELECT sum(litres_drawn) FROM mds_transactions where emp_code='$emp_code' AND indicator = 'P' AND MONTH(date) = MONTH(CURRENT_DATE())
                        AND YEAR(date) = YEAR(CURRENT_DATE())";
                       $result2 = mysqli_query($mysqli,$sql3);
                        $row = mysqli_fetch_array($result2,MYSQLI_ASSOC);
                        $var1 = $row['sum(litres_drawn)'];
                        
                        //Balance for Assigned Pool Car
                         $sql4 = "SELECT balance,reg_number FROM mds_assigned_pool where emp_code='$emp_code'";
                       $result3 = mysqli_query($mysqli,$sql4);
                        $row1 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
                        $pool_bal = $row1['balance'];
                        $pool_vehicle = $row1['reg_number'];
                        
                        //Pool Drawn Litres
                        $ind = 'AP';
                         $sql5 = "SELECT sum(litres_drawn) FROM mds_transactions where emp_code='$emp_code' AND MONTH(date) = MONTH(CURRENT_DATE()) AND indicator  = '$ind' 
                        AND YEAR(date) = YEAR(CURRENT_DATE())";
                       $result4 = mysqli_query($mysqli,$sql5);
                        $row5 = mysqli_fetch_array($result4,MYSQLI_ASSOC);
                        $var5 = $row5['sum(litres_drawn)'];
                        
                        
                        echo "<tr><td>Personal Vehicle</td><td>$var1</td><td>$bal</td></tr>";
                        
                        echo "<tr><td>Assigned Pool Car ($pool_vehicle) </td><td>$var5</td><td>$pool_bal</td></tr>";
                        
                        ?>
                       
                    </table>
                </div>
                </div>
         <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                   <h5 class="card-title">Financials For <?php echo $_SESSION["fn"]." ".$_SESSION["sn"]; ?></h5> 
                    <table class="table">
                    <tr>Financial data has been moved to the financials page which can be accessed from the link below. Financial data for a particular month with be displayed after the administration department has captured fuel price for the month on the last day of the month.</tr>
                        <tr><td><a href="finances">View Financial History</a></td></tr>
                    </table>
                </div>
          
                </div>
           <p><small><i>Powered By Cimas IT &copy; 2019</i></small></p>
        </div>
    </body>


</html>