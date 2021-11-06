<?php
  include("scscon.php");
	session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
        $code = strtoupper(mysqli_real_escape_string($mysqli,$_POST['code']));
       $sql = "SELECT * FROM mds_fuel WHERE employee_code = '$code'";
       $result = mysqli_query($mysqli,$sql);
       $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $mypasswordb = $row['password'];
        $_SESSION["fn"] = $row['fn'];
        $_SESSION["sn"] = $row['sn'];
       $_SESSION["code"] = $code;
        $_SESSION["balance"] = $row['balance'];
       $_SESSION["ftype"] = $row['fuel_type'];
       $_SESSION["access"] =$row['user_access'];
       $mypassword = mysqli_real_escape_string($mysqli,$_POST['password']); 
       $hash = substr( $mypasswordb, 0, 60 );
       if (password_verify($mypassword, $hash)){
        $_SESSION['logged_in'] = true;
        $_SESSION['last_activity'] = time();
        $_SESSION['expire_time'] = 60000;
         header("location:home");
       }else{
         header("location:index?val=invalid");
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
                        Staff Login
                    </div>
                    <form action="" method="post">
                    
                    <table class="table">
                    <tr><td></td><td><?php
                        if(!isset($_GET['val'])){
                        }else{
                            echo "<p><b>Invalid Login Credentials</b></p>";
                        }
                        ?></td></tr>
                    <tr>
                        <td>Employee Code:</td><td><input type ="text" id="code" name="code" class= "form-control-cimas-login" placeholder ="Employee Code" required/></td>
                        </tr>
                    <tr>
                        <td>Password:</td><td><input type ="password" id="password" name="password"class= "form-control-cimas-login" placeholder ="Password" required/></td>
                        </tr>
                    <tr>
                        <td><button class="btn btn-success">Login</button></td><td></td>
                        </tr>
                    <tr>
                        <td><a href="create">Create New Account</a></td><td><a href="reset_user">Reset Password</a></td>
                        </tr>
                    </table>
                    </form>
                <div class="card-footer">
                 <p><small><i>Powered By Cimas IT &copy; 2020</i></small></p>
            </div>
                </div>
                </div>
        
        
        </div>
    </body>


</html>