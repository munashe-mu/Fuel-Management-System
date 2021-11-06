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
        <h3>Financials for <?php echo $_SESSION["fn"]." ".$_SESSION["sn"]; ?></h3>
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
        
   <?php
        include("scscon.php");	
            $code = $_SESSION["code"];
         if(substr($code,0,3)=="MNG"){
                echo "<h2>Management Have No Fuel Cost &#128522;</h2>";
            }else{
             
             
    echo "<table id='auths' class='table table-striped table-bordered' style='width:100%'>
        <thead>
            <tr>
              <th>Month</th>
                <th>Fuel Type</th>
                <th>Litres Drawn</th>
                <th>Cost Per Litre</th>
                <th>Total Cost</th>
            </tr>
              
        </thead>
        <tbody>";
             
                
          
       
           
                      
            
            $resultset = $mysqli->query("SELECT substr(p.month,1,7) as Period,t.fuel_type,sum(t.litres_drawn) as Litres,p.price,round((sum(t.litres_drawn) * p.price),2) as Total_Cost
            FROM mds_transactions t , mds_fuel_price p
            WHERE t.emp_code = '$code'
            
            AND MONTH(t.date) = MONTH(p.month)
            AND YEAR(t.date) = YEAR(p.month)
            AND t.fuel_type = p.fuel_type
            AND t.indicator = 'P'
            GROUP BY substr(p.month,1,7),t.fuel_type");
            
            if($resultset->num_rows > 0){
            while($rows=$resultset->fetch_assoc())
            {
                $month = $rows['Period'];$ftype = $rows['fuel_type'];
                $Litres = $rows['Litres'];$price = $rows['price'];$Total_Cost = $rows['Total_Cost'];
                
                echo "<tr><td>$month</td><td>$ftype</a></td><td>$Litres</td><td>$price</td><td>$Total_Cost</td></tr>";
            }
            }
             
        echo "</tbody>
        <tfoot>
            <tr>
              <th>Month</th>
                <th>Fuel Type</th>
                <th>Litres Drawn</th>
                <th>Cost Per Litre</th>
                <th>Total Cost</th>
            </tr>
        </tfoot>
    </table>";
             
         }
        
        ?>
        
   
              
          
                
            
      
            
      
                  
               
                
         
        
        </div>
    </body>


</html>

