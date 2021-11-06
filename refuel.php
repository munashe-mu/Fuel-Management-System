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
    $type = strtoupper(mysqli_real_escape_string($mysqli,$_POST['ftype']));  
    $litres = strtoupper(mysqli_real_escape_string($mysqli,$_POST['litres'])); 
 $supplier = strtoupper(mysqli_real_escape_string($mysqli,$_POST['supplier']));
  $price = strtoupper(mysqli_real_escape_string($mysqli,$_POST['price']));  
    $sql = "SELECT * FROM mds_tankers WHERE fuel_type = '$type'";
    $result = mysqli_query($mysqli,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $bal = $row['balance'];
    
    $newbal = $bal + $litres;
    
    $name = $_SESSION["fn"]." ".$_SESSION["sn"];
    $date = date("Y-m-d");
    
    $stmnt = $mysqli->query("UPDATE mds_tankers set balance = '$newbal' WHERE fuel_type = '$type'");
    
    $stmnt1 = $mysqli->query("INSERT INTO mds_tankers_log VALUES(null,'$name','$date','$bal','$litres','$newbal','$supplier','$price')"); 

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
                   
                    <table class="table">
                     <thead>
            <tr>
              <th>Fuel Type</th>
                <th>Capacity</th>
                <th>Balance</th>
            </tr>
              
        </thead>
        <tbody>
                <?php
            include("scscon.php");	
            $code = $_SESSION["code"];
            $resultset = $mysqli->query("SELECT * FROM mds_tankers");
            
            if($resultset->num_rows > 0){
            while($rows=$resultset->fetch_assoc())
            {
                $type = $rows['fuel_type'];$capacity = $rows['capacity'];$balance = $rows['balance'];
                
                
                echo "<tr><td>$type</td><td>$capacity</a></td><td>$balance</td></tr>";
            }
            }
            ?>
        </tbody>
       
                    </table>
                </div>
                </div>
         <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                   <h5 class="card-title">Tankers Re Fueling</h5> 
                    <table class="table">
                    <thead>
                        <tr>
                        <th>Fuel Type</th>
                        <th>Litres Added</th>
                          <th>Reason / Supplier</th>
                            <th>Price</th>
                        </tr></thead>
                    <form action="" method="post">
                    <tr>
                    <td><select class="form-control" required id="ftype" name="ftype">
                        <option value="PETROL">Petrol</option>
                        <option value="DIESEL">Diesel</option>
                        </select></td> 
                    <td><input class="form-control" type ="number" id="litres" name="litres" required></td>     
                    <td><input class="form-control" type ="text" id="supplier" name="supplier" required></td>
                         <td><input class="form-control" type ="text" id="price" name="price" required></td>
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