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
require 'scscon.php';
if($_SERVER["REQUEST_METHOD"] == "POST") {
   

                $date = $_SESSION["date"];
                $item_name = $_SESSION["item_name"];
                $item_type = $_SESSION["item_type"];
                 $ftype = $_SESSION["ftype"];
    $litre = $_SESSION["litre"];
        
            
               
                
                $captured_by = $_SESSION["fn"]." ".$_SESSION["sn"];
                $captured_on = date("d-m-Y H:i:s");
                $bal =$_SESSION["balance_pool"];
                $newbal = $bal - $litre;
                $_SESSION["balance_pool"] = $newbal;
                $indicator = "GEN";
             
                
               $stmt = $mysqli->query("INSERT INTO mds_transactions VALUES (null,'$date','$item_name','$item_name','$item_type','$ftype','$litre','$captured_by','$captured_on','$indicator','CIMAS')") or die (mysqli_error($mysqli));
           
                $stmt2 = $mysqli->query("UPDATE mds_gen set balance = '$newbal' WHERE item_name = '$item_name'") or die (mysqli_error($mysqli));
           
           
                header("location:pool_success"); 
           
    
       
    
    
    
}

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cimas Fuel Management System</title>
        <link href="css/optical.css" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
         <link href="css/bootstrap.min_2.css" rel="stylesheet" media="screen">
        <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
        <link rel="icon" type="image/png" href="images/cimasfav.png">
        <script language=JavaScript>
            <!--
            function reload(form)
            {
            var val=form.cat.options[form.cat.options.selectedIndex].value;
            self.location='transactions.php?cat=' + val ;
            }
            //-->
        </script>
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
                  <p>Transaction Pending Approval</p>
                    <table class="table">
                    <tr>
                        <td>
                        <?php
                        if(!isset($_GET['val'])){
                        }else{
                            echo "<p><b>Invalid Authorization Code, Try Again</b></p>";
                        }
                        ?>
                        </td><td></td>
                        </tr>
                        <tr><td>Item Name:</td><td><?php echo $_SESSION["item_name"];?></td></tr>
                        <tr><td>Item Type:</td><td><?php echo $_SESSION["item_type"];?></td></tr>
                     <tr><td>Divison:</td><td><?php echo $_SESSION["division"];?></td></tr>
                   
                    <tr><td>Date:</td><td><?php echo  $_SESSION["date"] ;?></td></tr>
                    
                        <tr><td>Litres Drawn:</td> <td><?php echo $_SESSION["litre"];?></td></tr>
                        <tr><td>Fuel Type:</td><td><?php echo  $_SESSION["ftype"] ;?></td></tr>
                        
                 
                        <tr>
                        <td><button class="btn-success">Save</button></td>
                        <td></td>    
                        </tr>
                    </table>
                    </form>
                </div>
                </div>
        
       
        </div>
    </body>


</html>

<script type="text/javascript" src="js/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
    

</script>