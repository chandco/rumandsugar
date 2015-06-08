<?php
/**
 * The Croma big but ugly all singing all dancing calendar drawer
 *
 */
 
 
/**
*
* - type 			list or table 		should the output be a list style calendar or table type calendar
* - month 			month of calendar 	what month must the current month be?
* - year 			year of calendar 	what year must the calendar be?
* - $dayarray 		day contents 		array wit hthe content for the days
* - $show today 	show today 	 		must today be shown if this is the current month
*/
 
function draw_a_calendar($type,$month,$year,$dayarray, $showtoday){

	$op 			= $thisday = '';
	$tday 			= 0;
	$date 			= time () ;
	$day_count 		= 1;
	$day_num 		= 1;


	if (isset($type) && $type == 'table') {
		$linestart 	= '<td class="dayname"><span>';
		$lineend   	= '</span></td>';
		$nameend   	= '</tr>';

	} elseif (isset($type) && $type == 'list'){
		$linestart 	= '<li class="dayname">';
		$lineend   	= '</li>';
		$nameend   	= '</ul>';
	}

	// IF THERE'S NO DAY OR MONTH SET, USE TODAY AS SETTINGS
	if (!$month || !$year) {
		$day 		= date('d', $date) ;
		$month 		= date('m', $date) ;
		$year 		= date('Y', $date) ;
	}

	$first_day 		= mktime(0,0,0,$month, 1, $year);
	$fifteenth 		= mktime(0,0,0,$month, 15, $year);
	$title 			= date_i18n( 'F' , $first_day , false );
	$days_in_month 	= $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
	$startday 		= get_option('start_of_week');
	$day_of_week 	= date('D', $first_day) ; 


	 // get a day number for the first day of the month
 	switch($day_of_week){ 
 		case "Sun": $blank = abs(0 - $startday); break; 
 		case "Mon": $blank = abs(1 - $startday); break; 
 		case "Tue": $blank = abs(2 - $startday); break; 
 		case "Wed": $blank = abs(3 - $startday); break; 
 		case "Thu": $blank = abs(4 - $startday); break; 
 		case "Fri": $blank = abs(5 - $startday); break; 
 		case "Sat": $blank = abs(6 - $startday); break; 
 	}

 	switch($startday){ 
 		case 0: $daytripper = 'sunday'		; break; 
 		case 1: $daytripper = 'monday'		; break; 
 		case 2: $daytripper = 'tuesday'		; break; 
 		case 3: $daytripper = 'wednesday'	; break; 
 		case 4: $daytripper = 'thursday'	; break; 
 		case 5: $daytripper = 'friday'		; break; 
 		case 6: $daytripper = 'saturday'	; break; 
 	}
	$mon = strtotime('December 2010 first ' . $daytripper);


 	// build the header
 	if (isset($type) && $type == 'table') {
 		$op .=  '<table style="width: 100%;">';
 		$op .= '<tr><td>&nbsp;</td></tr>';
 		$op .=  '<tr class="calhead"><th><span class="prevm caldir" rel="' . ($fifteenth - 2592000)  . '">&laquo;</span></th><th colspan=5><span>' .  $title . ' ' .  $year  . '</span></th><th><span class="nextm caldir" rel="' . ($fifteenth + 2592000)  . '">&raquo;</span></th></tr>';
 		$op .=  '<tr>';

 	} elseif (isset($type) && $type == 'list') {
		$op .= '<ul class="calhead">';
		$op .= '<li class="prevm caldir" rel="' . ($fifteenth - 2592000)  . '">&laquo;</li>';
		$op .= '<li class="caltitle" >' .  $title . ' ' .  $year  . '</li>';
		$op .= '<li class="prevm caldir" rel="' . ($fifteenth + 2592000)  . '">&raquo;</li>';
		$op .= '</ul>';
		$op .= '<ul class="calday">';
 	}

 	// build the day names
 	for ($d=0; $d < 7 ; $d++) { 
 		$op .= $linestart .  date_i18n( 'D' , $mon + ($d * 86400) , false )  . $lineend;
 	}
 	$op .= $nameend;


 	//build the main cal
 	if (isset($type) && $type == 'table') {

 		//do the first blanks
 		$op .=  '<tr>';
 		while ( $blank > 0 ) { 
 			$op .=  '<td></td>'; 
 			$blank--; 
 			$day_count++;
 		} 


 		// main cells
 		while ( $day_num <= $days_in_month ) { 
 			$relnumber = mktime(0,0,0,$month, $day_num, $year);

 			$op .= '<td class="daynum">';
 			if (isset($dayarray[$day_num]) && $dayarray[$day_num] != ''){
 				$op .=   '<span class="' . $dayarray[$day_num]['class']  .  '" rel="' . $relnumber  . '">' . $dayarray[$day_num]['daycontent'] . '</span>';
 			} else {
 				$op .=   '<span class="daynumber" rel="' . $relnumber  . '">' . $day_num . '</span>';
			}
 
 			$op .= '</td>';
 			$day_num++; 
 			$day_count++;
 			if ($day_count > 7){
 				$op .=  '</tr><tr>';
 				$day_count = 1;
			}
		}

		// finnish with the blanks
 		while ( $day_count >1 && $day_count <=7 ) { 
 			$op .=  '<td> </td>'; 
 			$day_count++; 
 		} 
 		$op .=  '</tr></table>'; 


 	} elseif (isset($type) && $type == 'list') {

 		//do the first blanks
 		$op .= '<ul class="maincal">';
 		$day_count = 1;
 		while ( $blank > 0 )  {
 			$op .=  '<li class="empty">&nbsp;</li>'; 
 			$blank--; 
 			$day_count++;
 		}


 		// main cells
 		while ( $day_num <= $days_in_month ) {
 			$relnumber = mktime(0,0,0,$month, $day_num, $year);
 			$op .=  '<li class="daynum">';

 			if (in_array($daynum, $dayarray)){
 				$op .=   '<span class="daynumber" rel="' . $relnumber  . '">' . $day_num . '</span>';
 			} else {
 				$op .=   '<span class="daynumber" rel="' . $relnumber  . '">' . $day_num . '</span>';
			}

 			$op .=   '</li>'; 
 			$day_num++; 
 			$day_count++;
 			if ($day_count > 7) {$day_count = 1;}
 		}

 		while ( $day_count >1 && $day_count <=7 ) {
 			$op .=  '<li class="empty">&nbsp;</li>'; 
 			$day_count++;
 		}

 		$op .= '</ul>';	
 	}
 	return $op;
}
 
?>