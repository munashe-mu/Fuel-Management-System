<?php
  include("scscon.php");
	session_start();

   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
        $code = strtoupper(mysqli_real_escape_string($mysqli,$_POST['code']));
       $sql = "SELECT * FROM mds_fuel WHERE employee_code = '$code'";
       $result1 = mysqli_query($mysqli,$sql);
       $count = mysqli_num_rows($result1);
        if ($count > 0){
          $row = mysqli_fetch_array($result1,MYSQLI_ASSOC);
            $_SESSION["fn"] = $row['fn'];
            $_SESSION["sn"] = $row['sn'];
            $_SESSION["dept"] = $row['dept'];
            $_SESSION["code"] = $code;
            header("location:finalize");
        }else{
            header("location:create?val=invalid");
        }
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
        
      
        
        </div>
    <div class="container">
        
        
        <div class="card"  style="width:40rem;">
				<img class="card-img-top" src="images/top_card.jpg" alt="Card image cap">
				<div class="body">
                  <div class="card-header">
                        Staff Create Account
                    </div>
                    <form action="" method="post">
                    
                    <table class="table">
                    <tr><td></td><td><?php
                        if(!isset($_GET['val'])){
                        }else{
                            echo "<p><b>Invalid Employee Code</b></p>";
                        }
                        ?></td></tr>
                    <tr>
                        <td>Enter Your Employee Code:</td><td><input type ="text" id="code" name="code" class= "form-control-cimas-login" placeholder ="Employee Code" required/></td>
                        </tr>
                    
                    <tr>
                        <td><button class="btn-success">Verify</button></td><td></td>
                        </tr>
                    
                    </table>
                    </form>
                <div class="card-footer">
                    &copy; 2019 Cimas IT 
            </div>
                </div>
                </div>
        
        
        </div>
    </body>


</html>