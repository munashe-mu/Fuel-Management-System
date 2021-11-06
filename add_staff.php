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
require 'scscon.php';
$code = strtoupper(mysqli_real_escape_string($mysqli,$_POST['code']));
$sql = "SELECT * FROM mds_fuel WHERE employee_code = '$code'";
$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$_SESSION["fn_cap"] = $row['fn'];
$_SESSION["sn_cap"] = $row['sn'];
if(strlen($_SESSION["sn_cap"])> 0){
    $_SESSION["cap_caode"] = $row['employee_code'];
    header("location:vehicle_add"); 
}else{
    header("location:add_staff?val=invalid");
}
}   
}


?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fuel Management</title>
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
        <h3>Fuel Management System</h3>
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
        
        <div class="user"><h3>Capture Vehicle For Staff</h3></div> 
        
        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                    <form action="" method="post" class="form-horizontal"  role="form">
                    <table class="table">
                <tr><td><?php if(!isset($_GET['val'])){
                        }else{
                            echo "<p><b>Invalid Employee Code</b></p>";
                        }
                        ?></td><td></td></tr>
                    <tr><td>Enter Employee Code</td>
                        <td><input type ="text" placeholder ="Code" id="code" name="code" class="form-control" required></td>
                        </tr>
                        
                        <tr>
                        <td><button class="btn-success">Continue</button></td><td></td>
                        </tr>
                    </table>
                    </form>
                </div>
                </div>
        
       
        </div>
    </body>


</html>