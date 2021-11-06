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
    $fuel = strtoupper(mysqli_real_escape_string($mysqli,$_POST['fuel']));  
  
    $code = $_SESSION["code"];
  
    $stmt = $mysqli->query("UPDATE mds_fuel SET fuel_type= '$fuel' WHERE employee_code = '$code'") or die (mysqli_error($mysqli));
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
                   <h5 class="card-title">Registered Fuel Type</h5> 
                    <table class="table">
                    <thead>
                        <tr>
                        <th>Registered Fuel Type</th>
                      
                        </tr></thead>
                    <tr>
                          <?php
                        include("scscon.php");	
                        $code = $_SESSION["code"];
                     $sql = "SELECT * FROM mds_fuel WHERE employee_code = '$code'";
                    $result = mysqli_query($mysqli,$sql);
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                    $fuel = $row['fuel_type'];
                       
                        
                        echo "<tr><td>$fuel</td>";
                        
                        ?>
                        </tr>
                    </table>
                </div>
                </div>
         <div class="card">
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                   <h5 class="card-title">Capture New Fuel Type</h5> 
                    <table class="table">
                    <thead>
                        <tr>
                        <th>Fuel Type</th>
                 
                        </tr></thead>
                    <form action="" method="post">
                    <tr>
                    <td><select class="form-control" id="fuel" name="fuel" required>
                        <option value="petrol">Petrol</option>
                        <option value="diesel">Diesel</option>
                        </select></td> 
                    
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