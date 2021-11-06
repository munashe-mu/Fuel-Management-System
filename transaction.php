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
    
        <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/png" href="images/cimasfav.png">
        <script src="js/jquery-3.3.1.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script>
        $(document).ready(function() {
            $('#auths').DataTable();
        } );
        </script>
    </head>
    <body>
    <div class="top_bar">
        <div class="left_top">
        <img src="images/logo.png">
        <h3>Trans History</h3>
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
        
   <table id="auths" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
              <th>Date</th>
                <th>Employee</th>
                <th>Vehicle</th>
                <th>Fuel Type</th>
                <th>Litres Drawn</th>
                <th>Purpose</th>
                <th>Captured By</th>
              
        </thead>
        <tbody>
                <?php
            include("scscon.php");	
            $code = $_SESSION["code"];
            $resultset = $mysqli->query("SELECT * FROM mds_transactions WHERE emp_code ='$code'");
            
            if($resultset->num_rows > 0){
            while($rows=$resultset->fetch_assoc())
            {
                $date = $rows['date'];$employee = $rows['employee'];$vehicle = $rows['vehicle'];
                $fuel_type = $rows['fuel_type'];$litre = $rows['litres_drawn'];$cap = $rows['captured_by'];$purpose = $rows['purpose'];
                
                echo "<tr><td>$date</td><td>$employee</a></td><td>$vehicle</td><td>$fuel_type</td><td>$litre</td><td>$purpose</td><td>$cap</td></tr>";
            }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
             <th>Date</th>
                <th>Employee</th>
                <th>Vehicle</th>
                <th>Fuel Type</th>
                <th>Litres Drawn</th>
                <th>Purpose</th>
                 <th>Captured By</th>
            </tr>
        </tfoot>
    </table>
                  
               
                
         
        
        </div>
    </body>


</html>

