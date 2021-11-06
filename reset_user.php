<?php
  include("scscon.php");
	session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = strtoupper(mysqli_real_escape_string($mysqli,$_POST['code']));
    $email = mysqli_real_escape_string($mysqli,$_POST['email']);
    $sql = "SELECT * FROM mds_fuel WHERE employee_code = '$code' AND email = '$email'";
    $result = mysqli_query($mysqli,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $mypasswordb = $row['password'];
        $ftype = $row['fuel_type'];
        $fn = $row['fn'];
       $sn = $row['sn'];
       if ($ftype !=""){
        $otp = "FMS". rand(11111,99999);
        $date = date("d-m-Y H:i:s");
        $stmt = $mysqli->query("INSERT INTO mds_pass_req VALUES (null,'$code','$email','$otp','$date','ACTIVE')") or die (mysqli_error($mysqli));
        $_SESSION["user_code"] = $code;
        $_SESSION["otp"] = $otp;
        $_SESSION["email"] = $email;
        $_SESSION["date"] =$date;
           $_SESSION["fn"] = $fn;
            $_SESSION["sn"] = $sn;
           header("location:/fuel/mail/send_reset");
         //header("location:home");
       }else{
         header("location:reset_user?val=invalid");
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
                        Reset User Password
                    </div>
                    <form action="" method="post">
                    
                    <table class="table">
                    <tr><td></td><td><?php
                        if(!isset($_GET['val'])){
                        }else{
                            echo "<p><b>Invalid Details Supplied</b></p>";
                        }
                        ?></td></tr>
                    <tr>
                        <td>Employee Code:</td><td><input type ="text" id="code" name="code" class= "form-control-cimas-login" placeholder ="Employee Code" required/></td>
                        </tr>
                    <tr>
                        <td>Enter Email Address:</td><td><input type ="text" id="email" name="email" class= "form-control" placeholder ="Cimas Email" required/></td>
                        </tr>
                    <tr>
                        <td><button class="btn btn-success" onclick="return change(this);">Submit</button></td><td></td>
                        </tr>
                        <tr><td><small><i>On submit wait for 10 seconds as request is processed</i></small></td></tr>
                   
                    </table>
                    </form>
                <div class="card-footer">
                 <p><small><i>Powered By Cimas IT &copy; 2019</i></small></p>
            </div>
                </div>
                </div>
        
        
        </div>
    </body>


</html>
<script type="text/javascript">
function change( el )
{
    if ( el.value === "Open Curtain" )
        el.value = "Close Curtain";
    else
        el.value = "Open Curtain";
}
</script>