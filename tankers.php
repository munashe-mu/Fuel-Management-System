<?php
session_start();

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cimas Optical Authorizations</title>
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
        <h3>Fuel Tanks Statuses</h3>
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
        
   <table id="auths" class="table table-striped table-bordered" style="width:100%">
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
        <tfoot>
            <tr>
                <th>Fuel Type</th>
                <th>Capacity</th>
                <th>Balance</th>
            </tr>
        </tfoot>
    </table>
                  
               
                
         
        
        </div>
    </body>


</html>

