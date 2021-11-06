<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
session_start();

//$office = $_SESSION["office"];
//$fname =$_SESSION["fullname"];
//$memnumber=$_SESSION["mnumber"];
//$files = $_SESSION["file"];
require ('PHPMailer\src\PHPMailer.php');
require ('PHPMailer\src\Exception.php');
require ('PHPMailer\src\SMTP.php');
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
//require 'vendor/autoload.php';

//$mail = new PHPMailer(true);     
//echo $office;echo $fname;echo $memnumber;echo $files;                         // Passing `true` enables exceptions
$mail2 = new PHPMailer\PHPMailer\PHPMailer();
try {
    //Server settings
    $mail2->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail2->isSMTP();                                      // Set mailer to use SMTP
    $mail2->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
    $mail2->SMTPAuth = true;                               // Enable SMTP authentication
    $mail2->Username = 'fuel@cimas.co.zw';                 // SMTP username
    $mail2->Password = 'Masci19#';                           // SMTP password
    $mail2->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail2->Port = 587;                                    // TCP port to connect to
	
    
    
        include("scscon.php");	
            
            $resultset = $mysqli->query("SELECT f.employee_code,f.fn,f.sn,f.email,sum(t.litres_drawn) as lit FROM mds_transactions t, mds_fuel f 
                        WHERE f.employee_code = t.emp_code
                        AND MONTH(t.date) = MONTH(CURRENT_DATE())
                        AND YEAR(t.date) = YEAR(CURRENT_DATE())
                        GROUP BY f.employee_code,f.fn,f.sn,f.dept,f.division");
            
            if($resultset->num_rows > 0){
            while($rows=$resultset->fetch_assoc())
            {
                $emp = $rows['employee_code'];$email = $rows['email'];$lit = $rows['lit'];
                $fn = $rows['fn'];$sn = $rows['sn'];
             
                
                
                 //Recipients
    $mail2->setFrom('fuel@cimas.co.zw', 'Fuel Manager');
    $mail2->addAddress($email, 'Online Applications');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
 //$mail2->addCC('tmutande@cimas.co.zw');
//$mail2->addBCC('dmushoriwa@cimas.co.zw');
    //Attachments
   //$mail2->addAttachment('C:/valuepckg/$files');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail2->isHTML(true);                                  // Set email format to HTML
    $mail2->Subject = 'Month End Summary - Fuel Consumption ';
    $mail2->Body    = "Dear $fn  $sn<br> <br> 
				        Your total fuel consumption for the month of October 2019 is <b>$lit</b> litres<br><br>
                        Adminstration department has captured fuel cost for October 2019 please logon to your account to view your transaction history and total fuel cost.<br><br>
                        
                        Logon to your account on : http://172.17.16.43/fuel<br><br>
                        
                        For any fuel related queries please contact admin department<br><br>
                        
                        Login challenges contact helpdesk@cimas.co.zw &#128521 <br><br>
                        
						
						<small>Powered By Cimas IT</small>" ;
    $mail2->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail2->send();
    $date = date("d-m-Y H:i:s");
    $msg = "Dear $fn  $sn<br> <br> 
				        Your total fuel consumption for the month of October 2019 is $lit litres<br><br>
                        Adminstration department has captured fuel cost for October please logon to your account to view your total fuel cost.<br><br>
                        
                        Logon to your account on : http://172.17.16.43/fuel<br><br>
                        
                        For any fuel related queries please contact admin department<br><br>
                        
                        Login challenges contact helpdesk@cimas.co.zw &#128521 <br><br>
                        
						
						<small>Powered By Cimas IT</small>" ;
    $stmnt = $mysqli->query("INSERT INTO mds_alerts VALUES (null,'$date','$email','$msg')") or die (mysqli_error($mysqli));
    $mail2->clearAddresses();
    echo 'Message has been sent';
                
              
            }
            }
    
    
    
    
    
  
	
   
   

} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail2->ErrorInfo;
}