<?php
require 'vendor/autoload.php';
use Carbon\Carbon;

$itemCallable = function (CliMenu $menu) {
    echo $menu->getSelectedItem()->getText();
};


echo "Plese enter the file name:";
$handle = fopen ("php://stdin","r");
$name = fgets($handle);

$list = array (
    array('Month', 'Salary Payment Date', 'Bonus Payment Date'),
);
for($i=0;$i<12;$i++){
	$date = Carbon::now()->addMonths(1);
	$dataArray = [];
	$salaryPaymentDay = '';
	$bounsPaymentDay = '';
	$date = $date->addMonths($i);

	//salary
	array_push($dataArray, $date->format('F'));
	$date = $date->endOfMonth();
	if($date->isWeekend()) {
		$date = $date->startOfWeek()->addDays(4);
		$salaryPaymentDay .= $date->format('d (l)');
	} else {
		$salaryPaymentDay .= $date->format('d (l)');
	}

	//bouns
	$bounsDate = Carbon::parse($date->format('Y-m-15'));
	if($bounsDate->isWeekend()) {
		$bounsDate = $bounsDate->addWeeks(1)->startOfWeek()->addDays(2);
		$bounsPaymentDay .= $bounsDate->format('d (l)');
	} else {
		$bounsPaymentDay .= $bounsDate->format('d (l)');
	}

	echo $bounsPaymentDay;
	echo "\n";
	array_push($dataArray, $salaryPaymentDay);	
	array_push($dataArray, $bounsPaymentDay);	
	array_push($list, $dataArray);
}


$fp = fopen(trim($name) . '.csv', 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);


echo "\n";
echo "Your file is already completed to ";
echo trim($name) . ".csv";
echo "\n";
?>