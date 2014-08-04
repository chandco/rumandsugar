<?php
/**
 * The file handling all the functions for the custom parts of the theme.
 *
 */
 
 
 
/********** Code Index
 *
 * -01- DRAW THE CALENDAR
 * -02- PREPARE THE CALENDAR ARRAY
 * -03- SORTING FUNCTION
 * -04- GET CALENDAR ENTRIES
 */




/* 
 * -01- DRAW THE CALENDAR
 * */
function fetch_calendar($type, $day , $month, $year, $default) {
	
$op = $thisday = '';
$tday = 0;
$date =time () ;

// IF THERE'S NO DAY OR MONTH SET, USE TODAY AS SETTINGS
if (!$month || !$year) {
	$day = date('d', $date) ;
	$month = date('m', $date) ;
	$year = date('Y', $date) ;
}

$first_day = mktime(0,0,0,$month, 1, $year);
$fifteenth = mktime(0,0,0,$month, 15, $year);
$title = date_i18n( 'F' , $first_day , false );


// GET A DEFAULT SETTING FOR THE TIMEPICKER
if ($default) {

	$mday = date('d', $default);
	$mmonth = date('m', $default);
	$myear = date('Y', $default);

	if ($mmonth == $month && $myear == $year) {
		$tday = $mday;
	}

} elseif (date('m', $date) == $month && date('Y', $date) == $year) {
	$tday = $day;
}


 // get a day number for the first day of the month
$startday = get_option('start_of_week');
$day_of_week = date('D', $first_day) ; 
 switch($day_of_week){ 
 	case "Sun": $blank = 0 - $startday; break; 
 	case "Mon": $blank = 1 - $startday; break; 
 	case "Tue": $blank = 2 - $startday; break; 
 	case "Wed": $blank = 3 - $startday; break; 
 	case "Thu": $blank = 4 - $startday; break; 
 	case "Fri": $blank = 5 - $startday; break; 
 	case "Sat": $blank = 6 - $startday; break; 
 }

 if ($blank < 0) {
 	$blank = 7 + $blank;
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


 // how many days in month
 $days_in_month = $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);

 
 //build the bloody thing

 $op .=  '<table style="width: 100%;">';
 
 $op .= '<tr><td>&nbsp;</td></tr>';

 $op .=  '<tr class="calhead"><th><span class="prevm caldir" rel="' . ($fifteenth - 2592000)  . '">&laquo;</span></th><th colspan=5><span>' .  $title . ' ' .  $year  . '</span></th><th><span class="nextm caldir" rel="' . ($fifteenth + 2592000)  . '">&raquo;</span></th></tr>';

 $op .=  '<tr>
 			<td class="dayname"><span>' . date_i18n( 'D' , $mon , false )  . '</span></td>
 			<td class="dayname"><span>' . date_i18n( 'D' , ($mon + 86400) , false )  . '</span></td>
 			<td class="dayname"><span>' . date_i18n( 'D' , ($mon + 172800) , false )  . '</span></td>
 			<td class="dayname"><span>' . date_i18n( 'D' , ($mon + 259200) , false )  . '</span></td>
 			<td class="dayname"><span>' . date_i18n( 'D' , ($mon + 345600) , false )  . '</span></td>
 			<td class="dayname"><span>' . date_i18n( 'D' , ($mon + 432000) , false )  . '</span></td>
 			<td class="dayname"><span>' . date_i18n( 'D' , ($mon + 518400) , false )  . '</span></td>
 		</tr>';



 // counts the day of the week to 7
 $day_count = 1;
 $op .=  '<tr>';



 // draw blank days

 while ( $blank > 0 ) 

 { 

 $op .=  '<td></td>'; 

 $blank = $blank-1; 

 $day_count++;

 } 
 
 // set first day of the month
 $day_num = 1;


 //count up the days

 while ( $day_num <= $days_in_month ) 

 { 

if ($day) {
	$thisday = ($tday == $day_num) ? 'thisday' : '' ;
}




 $relnumber = mktime(0,0,0,$month, $day_num, $year);

 $op .=  '</td><td class="daynum"><span class="' .  $thisday  . ' daybox">';

 $op .=   '<span class="daynumber" rel="' . $relnumber  . '">' . $day_num . '</span>';

 $op .=   '</span></td>'; 

 $day_num++; 

 $day_count++;



 //start each week on a new row
 if ($day_count > 7)

 {

 $op .=  '</tr><tr>';

 $day_count = 1;

 }

 } 
 
 // finnish with the blanks
 while ( $day_count >1 && $day_count <=7 ) 

 { 

 $op .=  '<td> </td>'; 

 $day_count++; 

 } 

 
 $op .=  '</tr></table>'; 

	return $op;
	
}





/* 
 * -01- DRAW THE CALENDAR
 * */
function fetch_front_calendar($type, $day , $month, $year, $default) {
	
	$op = $thisday = '';
	$tday = 0;
	$date =time () ;

	// IF THERE'S NO DAY OR MONTH SET, USE TODAY AS SETTINGS
	if (!$month || !$year) {
		$day = date('d', $date) ;
		$month = date('m', $date) ;
		$year = date('Y', $date) ;
	}

	$first_day = mktime(0,0,0,$month, 1, $year);
	$fifteenth = mktime(0,0,0,$month, 15, $year);
	$title = date_i18n( 'F' , $first_day , false );


	// GET A DEFAULT SETTING FOR THE TIMEPICKER
	if ($default) {

		$mday = date('d', $default);
		$mmonth = date('m', $default);
		$myear = date('Y', $default);

		if ($mmonth == $month && $myear == $year) {
			$tday = $mday;
		}

	} elseif (date('m', $date) == $month && date('Y', $date) == $year) {
		$tday = $day;
	}


 	// get a day number for the first day of the month
	$startday = get_option('start_of_week');
	$day_of_week = date('D', $first_day); 
 	switch($day_of_week){ 
 		case "Sun": $blank = 0 - $startday; break; 
 		case "Mon": $blank = 1 - $startday; break; 
 		case "Tue": $blank = 2 - $startday; break; 
 		case "Wed": $blank = 3 - $startday; break; 
 		case "Thu": $blank = 4 - $startday; break; 
 		case "Fri": $blank = 5 - $startday; break; 
 		case "Sat": $blank = 6 - $startday; break; 
 	}

 	if ($blank < 0) {
 		$blank = 7 + $blank;
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


 	// how many days in month
	$days_in_month = $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
 

	$prt = get_the_calendar($month,$year);

 
 	//build the bloody thing
	$op .= '<ul class="calhead">';
	$op .= '<li class="prevm caldir" rel="' . ($fifteenth - 2592000)  . '">&laquo;</li>';
	$op .= '<li class="caltitle" >' .  $title . ' ' .  $year  . '</li>';
	$op .= '<li class="prevm caldir" rel="' . ($fifteenth + 2592000)  . '">&raquo;</li>';
	$op .= '</ul>';


	$op .= '<ul class="calday">
				<li class="dayname">' . date_i18n( 'D' , $mon , false )  . '</li>
 				<li class="dayname">' . date_i18n( 'D' , ($mon + 86400) , false )  . '</li>
 				<li class="dayname">' . date_i18n( 'D' , ($mon + 172800) , false )  . '</li>
 				<li class="dayname">' . date_i18n( 'D' , ($mon + 259200) , false )  . '</li>
 				<li class="dayname">' . date_i18n( 'D' , ($mon + 345600) , false )  . '</li>
 				<li class="dayname">' . date_i18n( 'D' , ($mon + 432000) , false )  . '</li>
 				<li class="dayname">' . date_i18n( 'D' , ($mon + 518400) , false )  . '</li>
			</ul>';


 	$op .= '<ul class="maincal">';

 	$day_count = 1;
 	while ( $blank > 0 )  {
 		$op .=  '<li class="empty">&nbsp;</li>'; 
 		$blank = $blank-1; 
 		$day_count++;
 	}


 	// set first day of the month
 	$day_num = 1;


 	while ( $day_num <= $days_in_month ) {

 		if ($day) {
			$thisday = ($tday == $day_num) ? 'thisday' : '' ;
		}

		$stringer = '';

		foreach ($prt as $cro_v) {
			$adate = date('j',$cro_v['strdate']);
 			if ($adate == $day_num) {
 				$stringer .= '<span class="numbday">' . $day_num . '</span>';
 				$stringer .= '<span class="numbtime">' . date(get_option('time_format'),$cro_v['strdate']) . '</span><div class="clearfix"></div>';
 				$stringer .= '<span class="numbdesc"><a href="' . get_permalink($cro_v['cids'])  . '">' . get_the_title($cro_v['cids']) . '</a></span>';
 			}
 		}

 		$relnumber = mktime(0,0,0,$month, $day_num, $year);

 		$op .=  '<li class="daynum"><span class="' .  $thisday  . ' daybox">';

 		if ($stringer == '') {
 			$op .=   '<span class="daynumber" rel="' . $relnumber  . '">' . $day_num . '</span>';
 		} else {
 			$op .=   '<span class="stringer">';
 			$op .= $stringer;
 			$op .=  '</span>';
 		}

 		$op .=   '</span></li>'; 

 		$day_num++; 
 		$day_count++;
 		if ($day_count > 7) {$day_count = 1;}
 	}	

 	while ( $day_count >1 && $day_count <=7 ) {
 		$op .=  '<li class="empty">&nbsp;</li>'; 
 		$day_count++;
 	}

 	$op .= '</ul>';
 
	return $op;
	
}





/* 
 * -01- DRAW THE CALENDAR
 * */
function fetch_front_agenda($type, $day , $month, $year, $default) {

	$op = $thisday = '';
	$tday = 0;
	$date =time () ;

	// IF THERE'S NO DAY OR MONTH SET, USE TODAY AS SETTINGS
	if (!$month || !$year) {
		$day = date('d', $date) ;
		$month = date('m', $date) ;
		$year = date('Y', $date) ;
	}


	$first_day = mktime(0,0,0,$month, 1, $year);
	$fifteenth = mktime(0,0,0,$month, 15, $year);
	$title = date_i18n( 'F' , $first_day , false );


	$prt = get_upcomming_arr(15);


	$cntr = 1;
	$op .= '<ul class="cro_twister cro_agendatwister">';

	foreach ($prt as $cro_v) {
		$img = get_the_post_thumbnail( $cro_v['id'], 'banner');
		if (!$img) {
				$img  =  '<img src="' . get_template_directory_uri() . '/public/styles/images/imgcommingsoon3.jpg">';
		}
		$page_object = get_page($cro_v['id']);
		$text = $page_object->post_content;
		if (strlen($text) > 90) {
				$text = substr($text,0,strpos($text,' ',90)); 
		}



        $op .= '<li class="twistercontent">';
        $op .= '<div class="promoimg">';
        $op .= ($img) ? $img : '' ;
         $op .= '<div class="agendadate">' .  date_i18n( 'j' , $cro_v['date'], false )   . '<br/>' .  date_i18n( 'M' , $cro_v['date'], false )   . '</div>';
        $op .= '</div>';
        $op .= '<h5 class="cro_accent;">' . get_the_title($cro_v['id']) . '</h5>';
        $op .= '<div class="fpdiv"><span class="cro_foodprice">' .  date_i18n( get_option('time_format') , $cro_v['date'], false ) . '</span></div>';
        $op .= '<p>' . $text . '</p>';
         $op .= '<div class="clarlabel"><a href="' . get_permalink($cro_v['id']) . '" class="cro_accent">' .  __('More Info','localize')  .'</a></div>';
               
        $op .= '</li>';





 		$cntr++;
 	}

 	$op .= '</ul>';

 	return $op;
}






/* 
 * -01- DRAW THE CALENDAR
 * */
function fetch_upc_agenda($type, $day , $month, $year, $default) {

	$op = $thisday = '';
	$tday = 0;
	$date =time () ;

	// IF THERE'S NO DAY OR MONTH SET, USE TODAY AS SETTINGS
	if (!$month || !$year) {
		$day = date('d', $date) ;
		$month = date('m', $date) ;
		$year = date('Y', $date) ;
	}


	$prt = get_the_calendar($month,$year);

	$first_day = mktime(0,0,0,$month, 1, $year);
	$fifteenth = mktime(0,0,0,$month, 15, $year);
	$title = date_i18n( 'F' , $first_day , false );


	$op .= '<ul class="calhead calagenda">';
	$op .= '<li class="prevm agendir" rel="' . ($fifteenth - 2592000)  . '">&laquo;</li>';
	$op .= '<li class="caltitle" >' .  $title . ' ' .  $year  . '</li>';
	$op .= '<li class="prevm agendir" rel="' . ($fifteenth + 2592000)  . '">&raquo;</li>';
	$op .= '</ul>';


	$cntr = 1;
	$op .= '<ul class="cro_twister cro_agendatwister">';

	foreach ($prt as $cro_v) {

		$img = get_the_post_thumbnail( $cro_v['cids'], 'banner');
		if (!$img) {
				$img  =  '<img src="' . get_template_directory_uri() . '/public/styles/images/imgcommingsoon3.jpg">';
		}
		$page_object = get_page($cro_v['cids']);
		$text = $page_object->post_content;
		if (strlen($text) > 90) {
				$text = substr($text,0,strpos($text,' ',90)); 
		} 


        $op .= '<li class="twistercontent">';
        $op .= '<div class="promoimg">';
        $op .= ($img) ? $img : '' ;
        $op .= '<div class="agendadate">' .  date_i18n( 'j' , $cro_v['strdate'], false )   . '<br/>' .  date_i18n( 'D' , $cro_v['strdate'], false )   . '</div>';
        $op .= '</div>';
        $op .= '<h5 class="cro_accent">' . get_the_title($cro_v['cids']) . '</h5>';
        $op .= '<div class="fpdiv"><span class="cro_foodprice">' .  date_i18n( get_option('time_format') , $cro_v['strdate'], false ) . '</span></div>';
        $op .= '<p>' . $text . '...</p>';
        $op .= '<div class="clarlabel"><a href="' . get_permalink($cro_v['cids']) . '" class="cro_accent">' .  __('More Info','localize')  .'</a></div>';
               
        $op .= '</li>';

       

 		$cntr++;
 	}

 	$op .= '</ul>';

 	return $op;
}









/* 
 * -02- PREPARE THE CALENDAR ARRAY
 * */

function calendar_add($cstrdate,$ccids) {
	global $calentries;
	$calentries[] = array (					
		'strdate' => $cstrdate,
		'cids' => $ccids,
	);	
}



function recinthappening ($intervalvalue, $dayvalue, $month, $year, $time, $daysinmonth){	

	$first_day_tocalculate = get_first_day($dayvalue,$month, $year);
	$specrec = $first_day_tocalculate + ($time[0] * 60 * 60) + ($time[1] * 60);
			
	if ($intervalvalue == 'second') {$specrec = $specrec + 604800;}
	if ($intervalvalue == 'third') {$specrec = $specrec + 1209600;}		
	if ($intervalvalue == 'fourth') {$specrec = $specrec + 1814400;}	
	if ($intervalvalue == 'last') {	
		$lastmonthday = mktime(23,59,59,$month, $daysinmonth, $year); 
		$specrec = ($specrec + 2419200 <= $lastmonthday) ? $specrec + 2419200 : $specrec + 1814400;	
	}
	return $specrec;	
}




function get_first_day($day_number, $month=false, $year=false)
  {
    $month  = ($month === false) ? strftime("%m"): $month;
    $year   = ($year === false) ? strftime("%Y"): $year;
	if ($day_number == 'Sunday') {$day_number = 0; 
  	} elseif($day_number == 'Monday') {$day_number = 1;
  	} elseif($day_number == 'Tuesday') {$day_number = 2;
  	} elseif ($day_number == 'Wednesday') {$day_number = 3;
  	} elseif ($day_number == 'Thursday') {$day_number = 4;
	} elseif ($day_number == 'Friday') {$day_number = 5;
	} elseif ($day_number == 'Saturday') {$day_number = 6; } 
    $first_day = 1 + ((7+$day_number - strftime("%w", mktime(0,0,0,$month, 1, $year)))%7);
    return mktime(0,0,0,$month, $first_day, $year);
}



function get_the_events($month,$year) {
	$op = $endepoch = '';
	$calentries = array();
	$calargs=array(
		'post_type'=>'events',
		'showposts'=> -1,
	);

	$calposts = get_posts($calargs);
	foreach( $calposts as $cpost ) :	setup_postdata($cpost);

	$occurance = 0;

	$key_date_value		= get_post_meta($cpost->ID, 'cro_thiscalbox', true);
	$key_time_value 	= get_post_meta($cpost->ID, 'cro_thisslider', true);
	$key_end_a 			= get_post_meta($cpost->ID, 'cro_selrec_c', true);
	$key_end_b 			= get_post_meta($cpost->ID, 'cro_selrec_d', true);
	$key_end_c 			= get_post_meta($cpost->ID, 'cro_selrec_e', true);
	$key_recint_value	= get_post_meta($cpost->ID, 'cro_selrec_a', true);
	$key_recday_value 	= get_post_meta($cpost->ID, 'cro_selrec_b', true);
	$key_rectype_value 	= get_post_meta($cpost->ID, 'cro_selrec', true);

	$timeparts = explode(':', $key_time_value);


	$startepoch = $key_date_value + ($timeparts[0] * 60 * 60) + ($timeparts[1] * 60);


	if ($key_end_a && $key_end_b && $key_end_c && $key_end_a != '0' && $key_end_b != '0' && $key_end_c != '0'){
		$endepoch = mktime($timeparts[0],$timeparts[1],0,$key_end_b, $key_end_a, $key_end_c);
	} else {
		$endepoch = '';
	}

	$beginningepoch = mktime(0,0,0,$month,1,$year);
	$daysinmonth = $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
	$closingepoch = mktime(23,59,59,$month,$daysinmonth,$year);


	if ($key_rectype_value == 5) {	
		$firstone = recinthappening($key_recint_value, $key_recday_value, $month, $year, $timeparts, $daysinmonth);
		if ($startepoch <= $firstone ){
			if (!$endepoch) {
				$occurance = 1;
			} elseif ($endepoch >= $firstone) {
				$occurance = 1;
			}
		}


	} elseif ($key_rectype_value == 4) {
		$firstone = mktime($timeparts[0],$timeparts[1],0,$month, date('j', $startepoch), $year);
		if ($startepoch <= $firstone ){
			if (!$endepoch) {
				$occurance = 1;
			} elseif ($endepoch >= $firstone) {
				$occurance = 1;
			}
		}

	} elseif ($key_rectype_value == 3) {
		$occurance = 2;
		$interval = 604800;
		unset($datelist);
		$datelist = array();
		$the_dayname = date('l', $startepoch);
		$monthname = date('F', mktime(0,0,0,$month, 1 , $year));
		$first_occurence_in_month = get_first_day($the_dayname, $month, $year);
		$firstone = $first_occurence_in_month + ($timeparts[0] * 60 * 60) + ($timeparts[1] * 60);

		for($i = $firstone; $i < $closingepoch; $i = $i + $interval) {	
			if ( $i <= $startepoch - 1 ) {

			} else {
				if (!$endepoch) {
					$datelist[] = $i;
				} else {
					if ($endepoch >= $i) {
						$datelist[] = $i;
					}
				}
			}
		}
	} elseif ($key_rectype_value == 2) {
		$occurance = 2;
		$timetocount = $beginningepoch  + ($timeparts[0] * 60 * 60) + ($timeparts[1] * 60);
		unset($datelist);
		$datelist = array();
		for($i = ($timetocount); $i < $closingepoch; $i = $i + 86400) {
			if ($i >= $startepoch && $endepoch == '') { 
				$datelist[] = $i;
			} elseif ($i >= $startepoch && $endepoch && $i <= $endepoch){
				$datelist[] = $i;
			}
		}
	} elseif ($key_rectype_value == 1) {
		if ( $month == date('n',$startepoch) && $year == date('Y',$startepoch)  ){
			$occurance = 1;
			$firstone = $startepoch;
		}
	}

	if ($occurance === 1) {
		$calentries[] = array (					
			'strdate' => $firstone,
			'cids' => $cpost->ID
		);
	}
	
	if ($occurance == 2) {
		foreach ($datelist as $dateentry) {
			$calentries[] = array (					
				'strdate' => $dateentry,
				'cids' => $cpost->ID
			);
		}
	}
	endforeach; 
	return $calentries;
}




/* 
 * -03- SORTING FUNCTION
 * */
function cro_val_sort($a,$subkey) {
	foreach($a as $k=>$v) {$b[$k] = strtolower($v[$subkey]);}
	asort($b);
	foreach($b as $key=>$val) {$c[] = $a[$key];}
	return $c;
}



/* 
 * -04- GET CALENDAR ENTRIES
 * */
function get_the_calendar($cmonth,$cyear) {
	$calentries = get_the_events($cmonth,$cyear);
	if($calentries) {		
		$calentries = cro_val_sort($calentries,'strdate'); 
	}
	return $calentries;
}


/* 
 * -05- GET UPCOMMING EVENTS ARRAY
 * */

function get_upcomming_arr($count) {
	$now = time() + ( get_option( 'gmt_offset' ) * 3600 );
	$wmonth = date("n", $now);
	$wyear = date("Y", $now);
	$ctime = mktime(0,0,0,$wmonth,15,$wyear);
	$emptycounter = 0;
	$calwidget = array();

	while ((count($calwidget) <= ($count - 1)) && $emptycounter <= 50) { 
		$calentries = get_the_events(date("n", $ctime),date("Y", $ctime));

		if($calentries) {
			$calentries = cro_val_sort($calentries,'strdate'); 
			foreach ($calentries as $crov) {
				if (isset($crov['strdate']) &&  $crov['strdate']  >= $now && count($calwidget) <= ($count - 1)) {
					$calwidget[] = array(					
						'date' => $crov['strdate'],
						'id' => $crov['cids'],
					);	
				}	
			}	
		}

		$ctime  = $ctime + 2678400;
		$emptycounter++;
	}
	return $calwidget;

}
 
?>