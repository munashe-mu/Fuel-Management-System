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
        
        <div class="user"><h3>Daily Report Summary</h3></div> 
    
        <p>Currently Showing Information For <?php echo $_SESSION["filter_date"]; ?></p>
        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                    <form action="" method="post" class="form-horizontal"  role="form">
                    <table class="table">
                    <tr>
                        <th>Fuel Type</th> 
                        <th>Litres Drawn</th>
                       
                        </tr>
                        <?php
                        include("scscon.php");
                        $filter = $_SESSION["filter_date"];
                        $resultset = $mysqli->query("SELECT fuel_type,sum(litres_drawn) as lit FROM mds_transactions t
                       WHERE t.date  = '$filter'
                       GROUP BY fuel_type");
                         if($resultset->num_rows > 0){
                        while($rows=$resultset->fetch_assoc())
                        {
                            $fuel_type = $rows['fuel_type'];
                            $lit = $rows['lit'];
                            
                            echo "<tr><td>$fuel_type</td><td>$lit</td></tr>";
                
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