<?php

//database connection details
$mysqli = new mysqli('', // host
                     '', // user
                     '', // password
                     ''); // database

if ($mysqli->connect_errno) {
  printf("Connect failed: %s\n", $mysqli->connect_error);
  exit;
}

date_default_timezone_set ("America/Chicago");

$query = "
  SELECT   
    `zaktek`.`company_code`,
    `zaktek`.`dealer_code`,
    `zaktek`.`dealer_name`,
    `zaktek`.`dealer_address_1`,
    `zaktek`.`dealer_address_2`,
    `zaktek`.`dealer_city`,
    `zaktek`.`dealer_state`,
    `zaktek`.`dealer_zip_code`,
    `zaktek`.`dealer_phone`,
    `zaktek`.`status_code`,
    `zaktek`.`agreement`,
    `zaktek`.`agreement_suffix`,
    `zaktek`.`owner_last_name`,
    `zaktek`.`owner_first_name`,
    `zaktek`.`owner_address_1`,
    `zaktek`.`owner_address_2`,
    `zaktek`.`owner_city`,
    `zaktek`.`owner_state`,
    `zaktek`.`owner_zip_code`,
    `zaktek`.`owner_phone`,
    `zaktek`.`plan`,
    `zaktek`.`coverage`,
    `zaktek`.`coverage_option`,
    `zaktek`.`coverage_months`,
    `zaktek`.`coverage_miles`,
    `zaktek`.`expiration_mileage`,
    `zaktek`.`deductible`,
    `zaktek`.`vehicle_year`,
    `zaktek`.`vin`,
    `zaktek`.`beginning_mileage`,
    `zaktek`.`vehicle_maker`,
    `zaktek`.`model_code`,
    `zaktek`.`series_name`,
    `zaktek`.`contract_purchase_date`,
    `zaktek`.`expiration_date`,
    `zaktek`.`posted_date`,
    `zaktek`.`email_option`,
    `zaktek`.`email_address`,
    `zaktek`.`customer_cost`,
    `zaktek`.`dealer_cost`,
 IF (`home_kit`.`agreement` IS NULL, FALSE, TRUE) as `home_kit2` 
 FROM `zaktek` 
 LEFT JOIN `home_kit` ON
  (`zaktek`.`agreement` = `home_kit`.`agreement`)
";

if($result = $mysqli->query($query, MYSQLI_USE_RESULT)) {

  while($row = $result->fetch_row()) {
      $contract_purchase_date = strtotime($row[33]);
      $expiration_date = strtotime($row[34]);
      $posted_date = strtotime($row[35]);

      $csv_line = 
           '"'.$row[0].'"|'.           // company_code'
           '"'.$row[1].'"|'.           // dealer_code'
           '"'.$row[2].'"|'.           // dealer_name'
           '"'.$row[3].'"|'.           // dealer_address_1'
           '"'.$row[4].'"|'.           // dealer_address_2'
           '"'.$row[5].'"|'.           // dealer_city'
           '"'.$row[6].'"|'.           // dealer_state'
           '"'.$row[7].'"|'.           // dealer_zip_code'
           '"'.$row[8].'"|'.           // dealer_phone'
               $row[9].'|'.            // status_code'
               $row[10].'|'.           // agreement'
           '"'.$row[11].'"|'.          // agreement_suffix'
           '"'.$row[12].'"|'.          // owner_last_name'
           '"'.$row[13].'"|'.          // owner_first_name'
           '"'.$row[14].'"|'.          // owner_address_1'
           '"'.$row[15].'"|'.          // owner_address_2'
           '"'.$row[16].'"|'.          // owner_city'
           '"'.$row[17].'"|'.          // owner_state'
           '"'.$row[18].'"|'.          // owner_zip_code'
           '"'.$row[19].'"|'.          // owner_phone'
           '"'.$row[20].'"|'.          // plan'
           '"'.$row[21].'"|'.          // coverage'
               $row[22].'|'.           // coverage_option'
               $row[23].'|'.           // coverage_months'
               $row[24].'|'.           // coverage_miles'
               $row[25].'|'.           // expiration_mileage'
               intval($row[26]*100).'|'.//deductible'
               $row[27].'|'.           // vehicle_year'
           '"'.$row[28].'"|'.          // vin'
               $row[29].'|'.           // beginning_mileage'
           '"'.$row[30].'"|'.          // vehicle_maker'
           '"'.$row[31].'"|'.          // model_code'
           '"'.$row[32].'"|'.          // series_name'
           '"'.date("Y-m-d", $contract_purchase_date).'"|'.// contract_purchase_date
           '"'.date("Y-m-d", $expiration_date).'"|'.// expiration_date'
           '"'.date("Y-m-d", $posted_date).'"|'.// posted_date'
           '"'.$row[36].'"|'.          // email_option'
           '"'.$row[37].'"|'.          // email_address'
               intval($row[38]*100).'|'. //customer_cost'
               intval($row[39]*100).'|'.   //dealer_cost'
               intval($row[40])."\n";

        echo $csv_line;
    }
}

$mysqli->close();
