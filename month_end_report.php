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


   }
    
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
        
        <div class="user"><h3>Month End Report</h3></div> 
        <p>Report shows total fuel drawn per employee in the current month</p>
        <p>Currently Shows Information For the Month Of <?php echo date("F Y"); ?></p>
        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                    <form action="" method="post" class="form-horizontal"  role="form">
                    <table class="table">
                    <tr>
                        <th>Employee Code</th> 
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Division</th>
                        <th>Total Fuel Drawn</th>
                        </tr>
                        <?php
                        include("scscon.php");
                        $resultset = $mysqli->query("SELECT f.employee_code,f.fn,f.sn,f.dept,f.division,sum(t.litres_drawn) as lit FROM mds_transactions t, mds_fuel f 
                        WHERE f.employee_code = t.emp_code
                        AND MONTH(t.date) = MONTH(CURRENT_DATE())
                        AND YEAR(t.date) = YEAR(CURRENT_DATE())
                        GROUP BY f.employee_code,f.fn,f.sn,f.dept,f.division");
                         if($resultset->num_rows > 0){
                        while($rows=$resultset->fetch_assoc())
                        {
                            $empcode = $rows['employee_code'];$emp = $rows['fn']." ".$rows['sn'];
                            $dept = $rows['dept'];$div = $rows['division'];
                            $lit = $rows['lit'];
                            
                            echo "<tr><td>$empcode</td><td>$emp</td><td>$dept</td><td>$div</td><td>$lit</td></tr>";
                
                            }
                         }
                        ?>
                    </table>
                    </form>
                </div>
                </div>
        
       
        </div>
    </body>


</html>