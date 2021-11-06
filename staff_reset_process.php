<?php

include("scscon.php");
session_start();

$resultset = $mysqli->query("SELECT * FROM mds_staff_reset WHERE MONTH(period) = MONTH(CURRENT_DATE())
AND YEAR(period) = YEAR(CURRENT_DATE())");

$row = $resultset->fetch_assoc();

$_SESSION["user_reset"] = $row['user'];
$_SESSION["user_reset_date"] = $row['date'];

if(strlen($_SESSION["user_reset"]) > 0){
    header("location:reset_fail");
    
}else{
    $stmt1 = $mysqli->query("UPDATE mds_fuel set balance = 120 WHERE rank = 'STANDARD'") or die (mysqli_error($mysqli));

$stmt2 = $mysqli->query("UPDATE mds_fuel set balance = 230 WHERE rank = 'EXEC4'") or die (mysqli_error($mysqli));

$stmt3 = $mysqli->query("UPDATE mds_fuel set balance = 250 WHERE rank = 'EXEC3'") or die (mysqli_error($mysqli));

$stmt4 = $mysqli->query("UPDATE mds_fuel set balance = 280 WHERE rank = 'EXEC2'") or die (mysqli_error($mysqli));


$stmt5 = $mysqli->query("UPDATE mds_fuel set balance = 300 WHERE rank = 'EXEC1'") or die (mysqli_error($mysqli));


$stmt11 = $mysqli->query("UPDATE mds_fuel set balance = 80 WHERE rank = 'DF'") or die (mysqli_error($mysqli));
    
$stmt12 = $mysqli->query("UPDATE mds_fuel set balance = 100 WHERE rank = 'HHC_DOC'") or die (mysqli_error($mysqli));

$stmt13 = $mysqli->query("UPDATE mds_fuel set balance = 200 WHERE rank = 'STD'") or die (mysqli_error($mysqli));

$stmt8 = $mysqli->query("UPDATE mds_assigned_pool set balance = 200 WHERE marker = 'MK'") or die (mysqli_error($mysqli));
    
$stmt9 = $mysqli->query("UPDATE mds_assigned_pool set balance = 250 WHERE marker = 'GEN'") or die (mysqli_error($mysqli));

$stmt14 = $mysqli->query("UPDATE mds_assigned_pool set balance = 1000 WHERE marker = 'AMB'") or die (mysqli_error($mysqli));
    
$stmt15 = $mysqli->query("UPDATE mds_assigned_pool set balance = 1000 WHERE marker = 'MEDP'") or die (mysqli_error($mysqli));
    
$stmt16 = $mysqli->query("UPDATE mds_gen set balance = 1000 WHERE division in ('SSD','MSD','HCS','HHC')") or die (mysqli_error($mysqli));    

$stmt7 = $mysqli->query("UPDATE mds_fuel set balance = 0 WHERE pool = 'Y'") or die (mysqli_error($mysqli));    
    

 $user =  $_SESSION["fn"]." ".$_SESSION["sn"];
$date = date("d-m-Y");

$stmt7 = $mysqli->query("UPDATE mds_staff_reset set user = '$user', date = '$date' WHERE MONTH(period) = MONTH(CURRENT_DATE())
AND YEAR(period) = YEAR(CURRENT_DATE())") or die (mysqli_error($mysqli));


header("location:reset_success");
    
}


   


?>