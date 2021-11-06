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
    $code = $_SESSION["cap_caode"];
    $name = $_SESSION["fn_cap"]." ".$_SESSION["sn_cap"];
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
                   <h5 class="card-title">Registered Vehicles for <?php echo $_SESSION["fn_cap"]." ".$_SESSION["sn_cap"]; ?></h5> 
                    <table class="table">
                    <thead>
                        <tr>
                        <th>Vehicle Make</th>
                        <th>Vehicle Model</th>
                         <th>Vehicle Reg #</th>
                        <th></th>
                        </tr></thead>
                    <tr>
                          <?php
                        include("scscon.php");	
                       $code = $_SESSION["cap_caode"];
                        
                         $resultset1 = $mysqli->query("SELECT * FROM mds_vehicles where emp_code ='$code'") or die (mysqli_error($mysqli));
                 
                        if($resultset1->num_rows > 0){
                        while($rows=$resultset1->fetch_assoc())
                        {
                            $type = $rows['type'];$maake = $rows['make'];$reg = $rows['reg_number'];
                            $id = $rows['id'];

                            echo "<tr><td>$type</td><td>$maake</a></td><td>$reg</td><td><a href='vehidel?id=$id'>Delete</a></td></tr>";
                        }
                        }
                    
                        
                        ?>
                        </tr>
                    </table>
                </div>
                </div>
         <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                   <h5 class="card-title">Capture New Vehicle</h5> 
                    <table class="table">
                    <thead>
                        <tr>
                        <th>Type</th>
                        <th>Make</th>
                        <th>Reg #</th>   
                        </tr></thead>
                    <form action="" method="post">
                    <tr>
                    <td><input class="form-control" type ="text" id="type" name="type" required></td> 
                    <td><input class="form-control" type ="text" id="make" name="make" required></td>     
                    <td><input class="form-control" type ="text" id="reg" name="reg" required></td>     
                    </tr>
                    <tr>
                        <td><button class="btn-success">Save</button></td> 
                        <td></td> 
                        <td></td> 
                        </tr>
                    </form>
                    </table>
                </div>
                </div>
        
        </div>
    </body>


</html>