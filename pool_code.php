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
     $item = strtoupper(mysqli_real_escape_string($mysqli,$_POST['item']));
    $resultset = $mysqli->query("SELECT * FROM mds_gen WHERE item_name = '$item'");
    while($rows=$resultset->fetch_assoc())
        {
            $_SESSION["item_name"]  = $rows['item_name']; 
        $_SESSION["item_type"]  = $rows['item_type']; 
        $_SESSION["division"]  = $rows['division']; 
        $_SESSION["balance"]  = $rows['balance']; 
           
        }
     

if(strlen($item)> 0){
 
    //check if balances have been reset
     $resultset = $mysqli->query("SELECT * FROM mds_staff_reset WHERE MONTH(period) = MONTH(CURRENT_DATE()) AND YEAR(period) = YEAR(CURRENT_DATE())");

    $row1 = $resultset->fetch_assoc();

    $user_reset = $row1['user'];
   

        if(empty($user_reset)){
              header("location:reset_pending");
        }else{
                header("location:pool_capture"); 
        }
    
    
    
 
}else{
    header("location:pool_code?val=invalid");
}
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
        
        <div class="user"><h3>Capture Fuel Transaction</h3></div> 
        
        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                    <form action="" method="post" class="form-horizontal"  role="form">
                    <table class="table">
                <tr><td><?php if(!isset($_GET['val'])){
                        }else{
                            echo "<p><b>Invalid Registration Number</b></p>";
                        }
                        ?></td><td></td></tr>
                    <tr><td>Select Item</td>
                        <td>
                         <select class="form-control" id="item" name="item">
                            <?php
                            require 'scscon.php';
                            
                           $resultset = $mysqli->query("SELECT * FROM mds_gen");
                            while($rows=$resultset->fetch_assoc())
                            {
                            $item  = $rows['item_name']; 
                            echo  "<option value='$item'>$item</option>";
                            }
                
                            ?>
                            
                            
                            </select>
                        </td>
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