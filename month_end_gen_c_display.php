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


   }

}


?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cimas Fuel Management</title>
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

          <div class="user"><h3>Generators Month End Report Summary</h3></div>

        <p>Currently Showing Information For <?php echo substr($_SESSION["filter_date"],0,7); ?></p>

        <div class="card" >
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="card-body">
                    <form action="" method="post" class="form-horizontal"  role="form">
                    <table class="table">
                    <tr>
                        <th>Generator Name</th>
                        <th>Station</th>

                        <th>Fuel Type</th>

                        <th>Total Fuel Drawn</th>
                        </tr>
                        <?php
                        include("scscon.php");
                         $filter = $_SESSION["filter_date"];

                        $resultset = $mysqli->query("SELECT t.emp_code,t.employee,t.fuel_type,sum(t.litres_drawn) as Litres
                        FROM mds_transactions t

                        WHERE MONTH(t.date) = MONTH('$filter')
                        AND YEAR(t.date) = YEAR('$filter')

                        AND t.indicator = 'GEN'

                        GROUP BY t.emp_code,t.employee,t.fuel_type");
                         if($resultset->num_rows > 0){
                        while($rows=$resultset->fetch_assoc())
                        {
                            $empcode = $rows['emp_code'];$emp = $rows['employee'];

                            $lit = $rows['Litres'];$ftype = $rows['fuel_type'];
                            echo "<tr><td>$empcode</td><td>$emp</td><td>$ftype</td><td>$lit</td></tr>";



                            }
                         }
                        ?>
                    </table>
                    </form>
                </div>
                </div>


        </div>
    </body>


</html>
