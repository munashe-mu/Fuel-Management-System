<?php

    $id = $_GET['id'];
     include("scscon.php");
    $stmt = $mysqli->query("delete FROM mds_vehicles WHERE id = '$id'") or die (mysqli_error($mysqli));
    header("location:vehicle_add");


?>