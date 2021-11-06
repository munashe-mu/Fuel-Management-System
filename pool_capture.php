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
    $ftype = strtoupper(mysqli_real_escape_string($mysqli,$_POST['f_type']));
    $date = strtoupper(mysqli_real_escape_string($mysqli,$_POST['date']));
    $litre = strtoupper(mysqli_real_escape_string($mysqli,$_POST['litre']));
   
    $_SESSION["ftype"] = $ftype;
    $_SESSION["date"] = $date;
    $_SESSION["litre"] = $litre;
    
    
      $item_name =  $_SESSION["item_name"];
      $sql = "SELECT * FROM mds_gen WHERE item_name = '$item_name'";
    $result = mysqli_query($mysqli,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $bal = $row['balance'];
                     
    $_SESSION["balance_pool"] = $bal;
   if($litre > $bal){
     header("location:pool_capture?val=err");   
   }elseif ($date==""){
        header("location:pool_capture?val=errdate");
   }else{
       header("location:pool_approve");
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
                    <table class="table"><tr>
                        <td>
                        <?php
                        if(!isset($_GET['val'])){
                        }else{
                            $val=$_GET['val'];
                            
                            if($val=="errdate"){
                                 echo "<p><b>Please Enter Date</b></p>";
                            }else{
                                 echo "<p><b>Above Float Transaction Not Allowed</b></p>";  
                            }
                         
                        }
                        ?>
                        </td><td></td>
                        </tr>
      
           
                        
                        
                  <tr><td>Item Name:</td><td><?php echo $_SESSION["item_name"];?></td></tr>
                    <tr><td>Item Type:</td><td><?php echo $_SESSION["item_type"];?></td></tr>
                     <tr><td>Divison:</td><td><?php echo $_SESSION["division"];?></td></tr>
                    
                    <tr><td>Current Balance</td><td><?php
                        $item_name =  $_SESSION["item_name"];
                        $sql = "SELECT * FROM mds_gen WHERE item_name = '$item_name'";
                        $result = mysqli_query($mysqli,$sql);
                        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                        $bal = $row['balance'];
                        echo $bal;
                        
                        
                        ?></td></tr>
                   
                    <tr><td>Fuel Type</td>
                        <td><select class="form-control" id="f_type" name="f_type">
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            </select></td>
                        </tr>
                  
                        <tr>
                        <td>
                        Date
                        </td>
                        <td>
                        <div class="input-group date form_datetime col-md-5" data-date="2019-08-16T05:25:07Z" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" value="" name="date" id="date" readonly required>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                        </td>
                        </tr>
                        <td>
                        Litres Drawn
                        </td>
                        <td><input type="number" id="litre" name="litre" class="form-control" required></td>
                        <tr>
                        <td><button class="btn-success">Save</button></td><td></td>
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