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

$query_start = '
  INSERT INTO `zaktek_mpp`
    ('.
    '`dealer_code`,'.           // 0
    '`dealer_name`,'.           // 1
    '`dealer_address_1`,'.      // 2
    '`dealer_city`,'.           // 3
    '`dealer_state`,'.          // 4
    '`dealer_zip_code`,'.       // 5
    '`status_code`,'.           // 6
    '`agreement`,'.             // 7
    '`agreement_suffix`,'.      // 8
    '`owner_last_name`,'.       // 9
    '`owner_first_name`,'.      // 10
    '`owner_address_1`,'.       // 11
    '`owner_address_2`,'.       // 12
    '`owner_city`,'.            // 13
    '`owner_state`,'.           // 14
    '`owner_zip_code`,'.        // 15
    '`owner_phone`,'.           // 16
    '`plan`,'.                  // 17
    '`coverage`,'.              // 18
    '`coverage_option`,'.       // 19
    '`coverage_months`,'.       // 20
    '`coverage_miles`,'.        // 21
    '`expiration_mileage`,'.    // 22
    '`deductible`,'.            // 23
    '`vehicle_year`,'.          // 24
    '`vin`,'.                   // 25
    '`beginning_mileage`,'.     // 26
    '`vehicle_maker`,'.         // 27
    '`model_code`,'.            // 28
    '`series_name`,'.           // 29
    '`contract_purchase_date`,'.// 30
    '`cancel_post_date`,'.      // 31
    '`expiration_date`,'.       // 32
    '`posted_date`'.            // 33
    ')                        
    VALUES (';               

echo "queryStart = $query_start";
$query_end = ');';
echo "queryEnd = $query_end";
$query = '';

// get the csv file
$cnt = 0;
if (($handle = fopen("ZAKCNTRCTS.txt", "r" )) != FALSE) {
    while (($row = fgetcsv($handle, 1000, "|")) !== FALSE) {
        $query = $query_start.
           '"'.trim($row[0]).'",'.                                                         
           '"'.$row[1].'",'.                                                         
           '"'.$row[2].'",'.                                                         
           '"'.$row[3].'",'.                                                         
           '"'.$row[4].'",'.                                                         
           '"'.$row[5].'",'.                                                         
           '"'.$row[6].'",'.                                                         
           '"'.$row[7].'",'.                                                         
           '"'.$row[8].'",'.                                                         
           '"'.$row[9].'",'.                                                         
           '"'.$row[10].'",'.                                                        
           '"'.$row[11].'",'.                                                        
           '"'.$row[12].'",'.                                                        
           '"'.$row[13].'",'.                                                        
           '"'.$row[14].'",'.                                                        
           '"'.$row[15].'",'.                                                        
           '"'.$row[16].'",'.                                                        
           '"'.$row[17].'",'.                                                        
           '"'.$row[18].'",'.                                                        
           '"'.$row[19].'",'.                                                        
           '"'.$row[20].'",'.                                                        
           '"'.$row[21].'",'.                                                        
           '"'.$row[22].'",'.                                                        
           '"'.$row[23].'",'.                                                        
           '"'.$row[24].'",'.                                                        
           '"'.$row[25].'",'.                                                          
           '"'.$row[26].'",'.                                                            
           '"'.$row[27].'",'.                                                          
           '"'.$row[28].'",'.                                                          
           '"'.$row[29].'",'.                                                          
           '"'.date("Y-m-d H:i:s", strtotime($row[30])).'",'.             
           '"'.date("Y-m-d H:i:s", strtotime($row[31])).'",'.             
           '"'.date("Y-m-d H:i:s", strtotime($row[32])).'",'.             
           '"'.date("Y-m-d H:i:s", strtotime($row[33])).'"'.             
           $query_end;

        if (!$result = $mysqli->query($query)) {
            die ('There was an error running the query on ['.$mysqli->error.']');
        }
        $cnt++;
        echo "cnt = $cnt\n";
    }
}

$mysqli->close();
