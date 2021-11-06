<?php
  include("scscon.php");
	session_start();

   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = mysqli_real_escape_string($mysqli,$_POST['password']);
       $vpassword = mysqli_real_escape_string($mysqli,$_POST['vpassword']);
       if ($password != $vpassword){
           header("location:finalize?val=nomatch"); 
        }else{
           $code = $_SESSION["code"];
            $secure = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $mysqli->query("UPDATE mds_fuel SET password = '$secure' WHERE employee_code = '$code'") or die (mysqli_error($mysqli));
            header("Location:create_success");

    
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
                            echo "<p><b>Passwords Do Not Match</b></p>";
                        }
                        ?></td></tr>
                    <tr>
                        <td>Name:</td><td><?php echo $_SESSION["fn"]." ".$_SESSION["sn"]; ?></td>
                        </tr>
                    <tr>
                        <td>Department</td><td><?php echo $_SESSION["dept"]; ?></td>
                        </tr>
                    <tr>
                        <td>Enter Your Password:</td><td><input type ="password" id="password" name="password" class= "form-control-cimas-login"required/></td>
                        </tr>
                     <tr>
                        <td>Verify Password:</td><td><input type ="password" id="vpassword" name="vpassword" class= "form-control-cimas-login"required/></td>
                        </tr>
                    <tr>
                        <td><button class="btn-success">Save</button></td><td></td>
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