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
if($_SERVER["REQUEST_METHOD"] == "POST") {
    include("scscon.php");
    $type = strtoupper(mysqli_real_escape_string($mysqli,$_POST['type']));  
    $make = strtoupper(mysqli_real_escape_string($mysqli,$_POST['make'])); 
    $reg = strtoupper(mysqli_real_escape_string($mysqli,$_POST['reg'])); 
    $code = $_SESSION["code"];
    $name = $_SESSION["fn"]." ".$_SESSION["sn"];
    $stmt = $mysqli->query("INSERT INTO mds_vehicles VALUES (null,'$name','$code','$type','$make','$reg')") or die (mysqli_error($mysqli));
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
        
        <div class="user"><p>Hi, <?php echo $_SESSION["fn"]." ".$_SESSION["sn"]; ?></p></div> 
        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                   <h5 class="card-title">Registered Vehicles</h5> 
                    <table class="table">
                    <thead>
                        <tr>
                        <th>Vehicle Make</th>
                        <th>Vehicle Model</th>
                        
                         <th>Vehicle Reg #</th>
                        <th>Ownership</th>
                       
                        </tr></thead>
                    <tr>
                          <?php
                        include("scscon.php");	
                       $code = $_SESSION["code"];
                         $resultset = $mysqli->query("SELECT * FROM mds_vehicles where emp_code ='$code'");
                        if($resultset->num_rows > 0){
                        while($rows=$resultset->fetch_assoc())
                        {
                            $type = $rows['type'];$maake = $rows['make'];$reg = $rows['reg_number'];
                            $id = $rows['id'];

                            echo "<tr><td>$type</td><td>$maake</a></td><td>$reg</td><td>Personal</td></tr>";
                        }
                        }
                        
                          $resultset1 = $mysqli->query("SELECT * FROM mds_assigned_pool where emp_code ='$code'");
                        if($resultset1->num_rows > 0){
                        while($rows1=$resultset1->fetch_assoc())
                        {
                            $type1 = $rows1['vehicle_make'];$maake1 = $rows1['vehicle_make'];$reg1 = $rows1['reg_number'];
                            $id = $rows['id'];$own = $rows['Ownership'];

                            echo "<tr><td>$type1</td><td>$maake1</a></td><td>$reg1</td><td>Assigned Pool Car</td></tr>";
                        }
                        }
                        
                        ?>
                        </tr>
                    </table>
                </div>
                </div>
        
        <p>Vehicle Register is maintained by Administration Department. For changes contact them directly.</p>
        </div>
    </body>


</html>