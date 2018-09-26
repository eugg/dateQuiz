<?php
require 'vendor/autoload.php';
require 'modules/CountDate.php';
use Carbon\Carbon;

// Show the hint on command line interface
echo "\n Plese enter the output file name: ";

// Get the file name from user
$handle = fopen ("php://stdin","r");
$name = fgets($handle); 

// Pick up dates, 12 months
$result_list = CountDate::pickDate(12);

// Transfer the result list to csv
$fp = fopen('output/' . trim($name) . '.csv', 'w');
foreach ($result_list as $fields) {
    fputcsv($fp, $fields);
}
fclose($fp);

// Print out the result hint
echo "\n Your file is already completed to '/output/";
echo trim($name) . ".csv' \n\n";