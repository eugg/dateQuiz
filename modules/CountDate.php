<?php
require '../vendor/autoload.php';
use Carbon\Carbon;

Class CountDate {

	/**
	  * @desc push the count date result to container array
	  * @param int $months_amount - the amount of count months
	  * @return array - the array combines salary and bonus payment date
	*/
	public static function pickDate( $months_amount ) {

		// Initial the data array with column name
		$list = array (
		    array('Month', 'Salary Payment Date', 'Bonus Payment Date'),
		);
		
		for( $i = 0; $i < $months_amount; $i++ ) {
			// Initial data 
			$start_date = Carbon::now()->addMonths(1); //Start at next month
			$data_array = []; // Initial the data array
			$salary_payment_day = ''; // Initial salary payment day
			$bouns_payment_day = ''; // Initial bonus payment day
			$date = $start_date->addMonths($i); // Handle month in each loop

			array_push($data_array, $date->format('F')); // get the month name
			$date = $date->endOfMonth();

			// Pick add salary payment date to data_array
			$salary_payment_day = self::pickSalaryDate($date);
			array_push($data_array, $salary_payment_day); 

			// Pick add bonus payment date to data_array
			$bouns_payment_day = self::pickBounsDate($date);
			array_push($data_array, $bouns_payment_day); 

			// Add to result list
			array_push($list, $data_array);
		}

		return $list;
	}

	/**
	  * @desc  If the salary payment date is weekend, then pick last Friday
	  * @param date(object) $date - the origin date object
	  * @return string - the formated date string of count result
	*/
	private static function pickSalaryDate($date) {
		
		if($date->isWeekend()) {
			$date = $date->startOfWeek()->addDays(4);
			$salary_payment_day = $date->format('d (l)');
		} else {
			$salary_payment_day = $date->format('d (l)');
		}

		return $salary_payment_day;
	}

	/**
	  * @desc  If the bonus payment date is weekend, then pick the next Wednesday
	  * @param date(object) $date - the origin date object
	  * @return string - the formated date string of count result
	*/
	private static function pickBounsDate($date) {
		// pick 15th as default bonus date
		$bounsDate = Carbon::parse($date->format('Y-m-15')); 

		if($bounsDate->isWeekend()) {
			$bounsDate = $bounsDate->addWeeks(1)->startOfWeek()->addDays(2);
			$bouns_payment_day = $bounsDate->format('d (l)');
		} else {
			$bouns_payment_day = $bounsDate->format('d (l)');
		}
			return $bouns_payment_day;
	}
}