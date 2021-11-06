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
        <h3>Trans History</h3>
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
        
   <table id="auths" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
              <th>Transaction By</th>
                <th>Date</th>
                <th>Balance Before Transaction</th>
                <th>Litres Added</th>
                <th>New Balance</th>
                  <th>Reason / Supplier</th>
            </tr>
        </thead>
        <tbody>
                <?php
            include("scscon.php");	
            $code = $_SESSION["code"];
            $resultset = $mysqli->query("SELECT * FROM mds_tankers_log");
            
            if($resultset->num_rows > 0){
            while($rows=$resultset->fetch_assoc())
            {
                $by = $rows['trans_by'];$date = $rows['date'];$curr_bal = $rows['curr_bal'];
                $lit = $rows['litres_added'];$newbal = $rows['new_bal'];$reason = $rows['reason'];
                
                echo "<tr><td>$by</td><td>$date</a></td><td>$curr_bal</td><td>$lit</td><td>$newbal</td><td>$reason</td></tr>";
            }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
              <th>Transaction By</th>
                <th>Date</th>
                <th>Balance Before Transaction</th>
                <th>Litres Added</th>
                <th>New Balance</th>
                  <th>Reason / Supplier</th>
            </tr>
        </tfoot>
    </table>
                  
               
                
         
        
        </div>
    </body>


</html>

