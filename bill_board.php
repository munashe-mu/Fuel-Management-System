<?php

 include("scscon.php");

            $resultset = $mysqli->query("SELECT sum(t.litres_drawn) as lit,t.emp_code,f.email,f.fn,f.sn,vehicle,t.fuel_type,t.date,f.balance

            FROM mds_transactions t, mds_fuel f

            Where f.employee_code = t.emp_code

            AND t.date  = '2019-11-27'

            group by t.emp_code,f.email,f.fn,f.sn,vehicle,t.fuel_type,t.date");

            if($resultset->num_rows > 0){
            while($rows=$resultset->fetch_assoc())
            {


?>