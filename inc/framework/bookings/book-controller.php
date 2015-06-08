<?php
/*
 * Croma admin framework: bookings controller
 */


/*===========  PAGE INDEX ================
 *
 * -01- BLOCK OR UNBLOCK A DATE
 * -02- FETCH TIMESLOTS FOR BOOKINGS FORM WHEN A DATE IS SELECTED
 * -03- MAKE A BOOKING
 * -04- PROCESS BOOKING STATUS
 * -05- GET AN ARRAY OF DATES THAT'S BOOKED FOR MAIN BACK CALENDAR
 * -06- DRAW THE CALENDAR
 * -07- DRAW THE DAILY VIEW
 * -08- DRAW THE SCHEDULER
 * 
 * */



/* 
 * -01- BLOCK OR UNBLOCK A DATE
 * */
function cro_processblocks($datevalue,$type){
	$settings = get_option("bookset");
	$bookarr = $settings['blockeddates'];

	if ($type == 'block') {
		$bookarr[] = esc_attr($datevalue);
		sort($bookarr);
		array_unique($bookarr);

	} elseif ($type == 'unblock') {
		if (isset($bookarr) && in_array($datevalue, $bookarr)) {
			foreach (array_keys($bookarr, $datevalue, true) as $key) {
    		unset($bookarr[$key]);
			}
		}
	}

	$settings['blockeddates'] = $bookarr;
	update_option('bookset', $settings);

	return $bookarr;
}



/* 
 * -02- FETCH TIMESLOTS FOR BOOKINGS FORM WHEN A DATE IS SELECTED
 * */
function booking_fetch_timeslots($timevalue){
	$dayofweek =  date('w',($timevalue + 43200));
	$timeslots = get_option('cro_booksched');
	$settings = get_option("bookset");
	$op = '';
	$def = array();
	$write = array();
	$bdates = $repdays = array();


	// array with all the bookings for the day.
	$maxbookings = (isset($settings['maxbookings']) && is_numeric($settings['maxbookings']) && $settings['maxbookings'] >= 1) ? $settings['maxbookings'] : 1 ;
	$btargs=array(
		'post_type' => 'reservations',
		'post_status' => 'private',
		'showposts'=> -1,
	);
	$btimeposts = get_posts($btargs);
	foreach( $btimeposts as $btpost ) :	setup_postdata($btpost);
		$dt 			= get_post_meta($btpost->ID, 'cro_date', true);
		$dh 			= get_post_meta($btpost->ID, 'cro_time', true);
		if(date('j/n/Y',$timevalue) == date('j/n/Y',($dt + $dh))) {
			$bdates[] = $dh;
		}
	endforeach; 
	$repdays = array_count_values($bdates);


	// CREATE AN ARRAY OF ALL THE STARTING DATES, ENDING DATES AND TIMESLOTS FOR THE REQUESTED DAY
	if (isset($timeslots) && $timeslots) {
		foreach ($timeslots as $crov) {
			if ($crov['day'] == $dayofweek) {
				$start = ($crov['shour'] * 60 * 60) + ($crov['smin'] * 60);
				$end   = ($crov['ehour'] * 60 * 60) + ($crov['emin'] * 60);
				$eval  = $crov['ival'];
				$def[] = array(
					'efrom' => $start,
					'eto' => $end,
					'eval' => $eval
				);
			}
		}


		// MAKE AN ARRAY OF ALL THE TIMESLOTS FOR THE DAY CALCULATED FROM THE STARTING TIME,
		// ENDING TIME AND INTERVAL.
		if ($def != '') {
			foreach ($def as $crovv) {
				if ($crovv['eto'] >= $crovv['efrom']) {
					$i = $crovv['efrom'];
					$mins = $crovv['eval'] * 60;
					while ( $i <= $crovv['eto']) {
						$write[] = $i;
						$i = $i + $mins;
					}
				}
			}
		}


		//IF WRITE TIMESLOTS THAT'S AVAILABLE
		if ($write != '') {
			$pp1 = $pp2 = '';
			$dayfrom = 0;
			$nowval = 0;
			if ($settings['daysbefore'] == '1') {
				$thour = date('G',time());
				$tminute = date('i',time());
				$toffs = get_option('gmt_offset') * 3600;
				$nowval = ($thour*60 * 60) + ($tminute * 60) + $toffs;
			} 
			foreach ($write as $cro) {
				$daytime = $timevalue + $cro;
				$timename = date(get_option('time_format'),$daytime);
				if (isset($repdays) && $repdays != '') {
					$rpd = 0;
					foreach ($repdays as $k => $v) {
						if ((($timevalue + $k) >= ($dayfrom + 1)) && (($timevalue + $k) <= $daytime) && ($v >= $maxbookings)){							
							$rpd++;
						} 
					}
					if ($rpd <= 0 && $cro >= $nowval) {
						$op .= '<span class="timeselect" rel="' .  $cro . '">' .  $timename  . '</span>';
					}
				} else {
					if ($cro >= $nowval){
						$op .= '<span class="timeselect" rel="' .  $cro . '">' .  $timename  . '</span>';
					}
				}
				$dayfrom = $daytime;
			}
		}
	}
	return $op;
}


/* 
 * -03- MAKE A BOOKING
 * */
function booking_make_booking($name,$email, $date, $time, $guests, $comments, $tel){

	$settings = get_option("bookset");
	$post_id = wp_insert_post( array(
		'post_type' => 'reservations',
		'post_status' => 'private',
		'comment_status' => 'closed',
		'post_content' => '',
		'post_title' => $name,
		'post_author' => '1'
	) );
	$bstatus = (isset($settings['bookstatus']) && $settings['bookstatus'] == '1') ? '2' : '1' ;

	add_post_meta($post_id, 'cro_tel', esc_attr($tel), '');
	add_post_meta($post_id, 'cro_mail', esc_attr($email), '');
	add_post_meta($post_id, 'cro_comments', esc_attr($comments), ''); 
	add_post_meta($post_id, 'cro_guests', esc_attr($guests), ''); 
	add_post_meta($post_id, 'cro_date', esc_attr($date), '');
	add_post_meta($post_id, 'cro_time', esc_attr($time), '');
	add_post_meta($post_id, 'cro_status', esc_attr($bstatus), '');
	add_post_meta($post_id, 'cro_reminded', 0, '');
	$glabel = $settings['guestlabel'];

	$args = array(
		__('Name','localize') 		=> $name,
		__('Email','localize') 		=> $email,
		$glabel						=> $guests,
		__('Comments','localize') 	=> $comments,
		__('Telephone','localize')	=> $tel,
		'_datetime'					=> array(
			'name' => __('Date','localize'),
			'time' => $time,
			'date' => $date
		)
	);

	cro_processbooking($post_id, 'book_admin');
	cro_processbooking($post_id, 'book_customer');
}


/* 
 * -04- PROCESS BOOKING STATUS
 * */
function cro_processbooking($post,$type) {

	$settings = get_option("bookset");
	$name = get_the_title( $post );
	$tel = get_post_meta($post, 'cro_tel', true);
	$email = get_post_meta($post, 'cro_mail', true);
	$comments = get_post_meta($post, 'cro_comments', true); 
	$guests = get_post_meta($post, 'cro_guests', true);
	$date = get_post_meta($post, 'cro_date', true);
	$time = get_post_meta($post, 'cro_time', true);
	$glabel = $settings['guestlabel'];

	switch ($type) {
		case 'confirm_customer': update_post_meta( $post, 'cro_status', 2); break;
		case 'decline_customer': update_post_meta( $post, 'cro_status', 3); break;
		case 'cancel_customer': update_post_meta( $post, 'cro_status', 3); break;
		case 'remind_customer': update_post_meta( $post, 'cro_reminded', 2); break;
	}

	$args = array(
		__('Name','localize') 		=> $name,
		__('Email','localize') 		=> $email,
		$glabel  					=> $guests,
		__('Comments','localize') 	=> $comments,
		__('Telephone','localize')	=> $tel,
		'_datetime'					=> array(
			'name' => __('Date','localize'),
			'time' => $time,
			'date' => $date
		)
	);
	
	cro_newsletter_preprocessor($args, $type);
}


/* 
 * -05- GET AN ARRAY OF DATES THAT'S BOOKED FOR MAIN BACK CALENDAR
 * */
function get_booked_dates($month, $year){

	$dtarr = array();
	$args = array(
			'post_type' => 'reservations', 
    		'numberposts' => -1
	);

	$book_query = new WP_Query( $args );
	foreach($book_query->posts as $cro_v) {
		$test 		= $month . $year;
		$postdate 	= get_post_meta( $cro_v->ID , 'cro_date', true );
		$control 	= date('m',$postdate) . date('Y',$postdate);

		if ($test === $control) {
			$dtarr[] = date('d',$postdate);
		}
	}
	return $dtarr;
}



/* 
 * -06- DRAW THE CALENDAR
 * how the hell can we get this thing to be neat?......... beats me
 * */
function booking_calendar($month, $year, $location) {
	
	$op = $thisday = $day = '';
	$tday = 0;
	$date =time();
	$day_count = 1;
	$day_num = 1;
	$blockeddates = $blockresult = $cro_rewriteblocks = array();
	$booksched = get_option('cro_booksched');
	$settings = get_option("bookset");
	$daybefore = $settings['daysbefore'];

	// IF THERE'S NO DAY OR MONTH SET, USE TODAY AS SETTINGS
	if (!$month || !$year) {
		$day = date('d', $date) ;
		$month = date('m', $date) ;
		$year = date('Y', $date) ;
	}

	// GET A LIST OF DATES THAT'S BOOKED FOR THIS MONTH
	$bkdates = get_booked_dates($month, $year);

	// GET THE DAY VALUES FOR OUR CALCULATIONS AS WEL AS THE MONTH NAME
	$first_day = mktime(0,0,0,$month, 1, $year);
	$fifteenth = mktime(0,0,0,$month, 15, $year);
	$title = date_i18n( 'F' , $first_day , false );

	// DETERMINE IF TODAY FALLS IN THIS MONTH
	$tday = (date('m', $date) == $month && date('Y', $date) == $year) ? $day : '' ;

 	// GET THE FIRST DAY OF THE MONTH AND FIGURE THE NAME OF THE FIRST DAY
	$startday = get_option('start_of_week');
	$day_of_week = date('D', $first_day) ; 

	// FIGURE THE BLANK SETTINGS BASED ON WORDPRESS START OF WEEK SETTINGS
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


 	// GET ARRAY OF BLOCKED DATES BASED ON THE DEFINED SCHEDULES
 	if (isset($booksched) && $booksched) {
 		foreach ($booksched as $crov) {
 			$blockeddates[] = $crov['day'];
 		}
 	}
 	$blockresult = array_unique($blockeddates);
 	unset($blockeddates);
 	$blockeddates = array();
 	sort($blockresult);

 	foreach ($blockresult as $crovv) {
 		$bearing = $crovv - $startday;
 		if ($bearing <= -1) {$bearing = 7 + $bearing;}
 		$blockeddates[] =  $bearing + 1;
 	}
 	unset($blockresult);
 	$blockresult = array();


 	// GET ARRAY OF BLOCKED DATES BASED ON DAYS THAT WAS BLOCKED IN THE CALENDAR AND ERASE BLOCKED DAYS THAT HAVE PASSED.
 	if (isset($settings['blockeddates']) && $settings['blockeddates']) {
 		foreach ($settings['blockeddates'] as $crovv) {
 			if (intval($crovv) >= time()){
 				if ($crovv >= time() -  2592000)
 				$cro_rewriteblocks[] = $crovv;
 			}
 			$p = date('j',$crovv) . '/' . date('m',$crovv) .  '/'  . date('Y',$crovv);
 			$blockresult[] = $p;
 		}
 	}


 	if ($blockresult && isset($blockresult)) {
 		$blockresult = array_unique($blockresult);
 		sort($blockresult);
 		$settings['blockeddates'] = $cro_rewriteblocks;
 		update_option('bookset', $settings);
 	}

 	//FIGURE THE FORMULA FOR THE DAY THAT THE WEEK STARTS FOR LOCALIZATION OF THE DAY ABBREVIATIONS
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


 	// HOW MANY DAYS IN MONTH
 	$days_in_month = $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
 

 	if ($location == 'back'){
 		$op .= '<div class="activateblocks isblock1">' . __('Enable date blocking', 'localize') . '</div>';
 		$op .= '<div class="deactivateblocks activateblocks isblock0">' . __('Disable date blocking', 'localize') . '</div><br class="clear">';
 	}
 
 	//BLOCK TO ADD THE TABLE HEADER AND DAY NAMES
 	$op .=  '<table style="width: 100%;">';
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


 	$op .=  '<tr>';


 	// DRAW THE PREBLANKS
	while ( $blank > 0 ) { $op .=  '<td></td>'; $blank = $blank-1; $day_count++;} 

 	// PROCESS THE VALID DAYS
 	while ( $day_num <= $days_in_month ) { 

 		// DETERMINE IF THE THISDAY CLASS SHOULD BE ADDED FOR THE CURRENT DAY OF THE MONTH
		if ($day) {$thisday = ($tday == $day_num) ? 'thisday' : '' ;}


		// DETERMINE IF THE DAY IS UNAVAILABLE AND NOT YET SET IN THE SCHEDULES
		if ($blockeddates != '') { 
			if (!in_array($day_count, $blockeddates)){
				$blckd = 'cro_blockedday';
			} else {
				if ($location == 'back') {
					$blckd = 'cro_canbeblocked';
				} else {
					$blckd = '';
				}
			}
		} else {
			$blckd = 'cro_blockedday';
		}


		if (in_array($day_num, $bkdates)){
			$blckd .= ' cro_dayisbooked ';
		}

		$relnumber = mktime(0,0,0,$month, $day_num, $year);

		// BLOCKING OF DAYS THAT'S BLOCKED MANUALLY BY THE USER.
		if (isset($blockresult) && $blockresult) {
			$dn  = date('j',$relnumber) . '/' . date('m',$relnumber) .  '/'  . date('Y',$relnumber);

			if (in_array($dn, $blockresult, true)){
				$blckd .= ' cro_isblocked ';
			} 
		}

		if ($location == 'front' &&  $relnumber <= ($date - 86400) + (86400 * ($daybefore - 1))){
			$blckd .= ' cro_dayhaspassed ';
		}

 		$op .=  '</td><td class="daynum"><span class="' .  $thisday  . '"><span class="daynumber  ' .  $blckd  . '" rel="' . $relnumber  . '">' .  $day_num  . '</span></span></td>'; 
 		$day_num++; 
 		$day_count++;

 		if ($day_count > 7){$op .=  '</tr><tr>';$day_count = 1;}

 	} 
 
 	// FINALIZE THE BLANKS
 	while ( $day_count >1 && $day_count <=7 ) { $op .=  '<td> </td>'; $day_count++; } 
 	$op .=  '</tr></table>'; 
	return $op;	
}



/* 
 * -07- DRAW THE DAILY VIEW
 * */
function cro_make_bookday(){
	$op = '';

	//DEFAULTS
	$myday = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : time() ;
	$today = mktime(0,0,0,date('m',$myday), date('d',$myday) , date('Y',$myday)  );
	$dayofweek =  date('w',$today);
	$timeslots = get_option('cro_booksched');
	$settings = get_option("bookset");
	$def = '';
	$linkline = 'admin.php?page=cromares&dash=' .   $_GET['dash'] . '&tab=' .   $_GET['tab'] . '&action=';
	$linklinkn1 = admin_url($linkline . ($today - 86400));
	$linklinkn2 = admin_url($linkline . ($today + 86400));

	// DAILY HEADER
	$op .= '<div class="dailyviewheader">
				<div class="dailydaynumber">' . date('j',$today) . '</div>
				<div class="datenumberrest">
					<div class="dailydayname">' . date_i18n( 'l', $today, false ) . '</div>
					<div class="dailyyearname">' . date_i18n( 'F, Y', $today, false ) . '</div>
				</div>
				<div class="dayviewprvnxt">
					<a class="dprv" href="' .   $linklinkn1  . '">' .  __('Prev','localize')  .  '</a>
					<a class="dnxt" href="' . $linklinkn2 . '">' .  __('Next','localize')  .  '</a>
				</div>
				<br class="clear">
			</div>';

	$args = array(
		'post_type' => 'reservations', 
    	'numberposts' => -1
	);

	$book_query = new WP_Query( $args );

	foreach($book_query->posts as $cro_v) {
		$dval 		= date('j',$today) . '/' . date('F',$today) . '/' . date('Y',$today);
		$postdate 	= get_post_meta( $cro_v->ID , 'cro_date', true );
		$pval		= date('j',$postdate) . '/' . date('F',$postdate) . '/' . date('Y',$postdate);
		$posttime 	= get_post_meta( $cro_v->ID , 'cro_time', true );
		$daytime 	= $postdate + $posttime;
		$timename 	= date(get_option('time_format'),$daytime);
		$timename 	= date(get_option('time_format'),$daytime);
		$postmail 	= get_post_meta( $cro_v->ID , 'cro_mail', true );
		$posttel 	= get_post_meta( $cro_v->ID , 'cro_tel', true );
		$postcmmt 	= get_post_meta( $cro_v->ID , 'cro_comments', true );
		$postguest 	= get_post_meta( $cro_v->ID , 'cro_guests', true );
		$poststatus = get_post_meta( $cro_v->ID , 'cro_status', true );
		$alnk 		= admin_url( 'post.php?post=' . $cro_v->ID  . '&action=edit' );

		switch ($poststatus) {
			case 2:
				$realstatus = __('Confirmed','localize');
				$realcss	= 'confirmed';
			break;
			case 1:
				$realstatus = __('Unconfirmed','localize');
				$realcss	= 'unconfirmed';
			break;
			case 3:
				$realstatus = __('Cancelled','localize');
				$realcss	= 'cancelled';
			break;								
		}

		if ($dval == $pval) {
			$def .= '<div class="dailytimeslot" rel="' .  $cro_v->ID  . '"><div class="dailytimeselect">';
			$def .= '<div class="timename">' .  $timename . '</div>';
			$def .= '<div class="guestnumber"> '   .  $settings['guestlabel']  .    ': ' .  $postguest . '</div>';
			$def .= '<div class="bookingstatus ' .  $realcss . '">'  .  $realstatus . '</div>';
			$def .= '</div>';
				


			$def .= '<div class="dailytimecontent">';
			$def .= '<h5 class="dailybookingstitle">' . $cro_v->post_title . '</h5>';
			$def .= '<div class="dailybookingscontacts"><span class="lft">' . $posttel . '</span><span clas="rgt">' .  $postmail  . '</span></div>';
			$def .= '<div class="dailybookingscomments"><h6>' . __('Special Requests','localize') . '</h6>';
			$def .= '<p>' . $postcmmt . '</p>';
			$def .= '<div class="dailyupdaters">';
			$def .= '<a href="' .  $alnk . '">Edit</a>';

			switch ($poststatus) {
				case 1:
					$def .= '<a href="#" class="cro_bookingconfirm cro_processbooking" rel="confirm">Confirm</a>';
					$def .= '<a href="#" class="cro_bookingdecline cro_processbooking" rel="decline">Decline</a>';
					$def .= '<a href="#" class="cro_bookingcancel cro_processbooking" rel="cancel">Cancel</a>';	
				break;
				case 2:
					$def .= '<a href="#" class="cro_bookingcancel cro_processbooking" rel="cancel">Cancel</a>';
				break;
			}

			$def .= '</div></div>';
			$def .= '</div><br class="clear"></div>';
		}
	}

	if ($def) {
		$op .= '<div class="dailyshedouter">';
		$op .= $def;
		$op .= '<div class="cro_backloader"><div class="cro_bl">&nbsp;</div></div>';


	} else {
		$op .= '<div class="dailyshedouter nobookingstoday">';
		$op .= __('No Bookings for today','localize');
		$op .= '</div>';
	}


	return $op;
}



/* 
 * -08- DRAW THE SCHEDULER
 * */
function build_dateblock($num,$randomstring,$def,$class,$name){
	$op = '';
	$op .= '<div class="dateblocker"><select class="' . $class . '" name="' . $name . '-' . $randomstring . '">';					
	for ($i=0; $i <  $num ; $i++) { 
		$sel = ($i == $def) ? ' selected="selected" ' : '' ;
		$j = ($i <= 9) ? '0' . $i : $i ;							
		$op .= '<option value="' . $i . '" ' . $sel  . '>' . $j . '</option>';
	}					
	$op .= '</select></div>';
	return $op;
}

function cro_make_scheduler(){
	$op = '';
	// CREATE A FIELD TO REMIND THE FORM HANDLER TO CREATE A NEW FIELD				
	$op .= '<input type="hidden" name="addtype" value="schedule" />
				<div class="schedouter">';	
	$booksched = get_option('cro_booksched');


	if ($booksched) {
		$op .= '<p class="cro_thereisnone" style="display:none;">' .  __('No schedules set. Click to add one','localize')   . '</p>';

		foreach($booksched as $crov) {

			$rndmzer = cro_randstring(10);
			$op .= '<div class="schedblox">
						<input type="hidden" name="cro_schedcontrol-' . $rndmzer . '" value="' . $rndmzer . '">
						<span class="cro_listdeleteone">-</span>
						<div class="dateblocker datepadright">
						<select class="dayname" name="cro_dayname-' . $rndmzer . '">';

			
			for ($i=0; $i <  7 ; $i++) { 
				$sel = ($i == $crov['day']) ? ' selected="selected" ' : '' ;
				$op .= '<option value="' . $i . '" ' . $sel  . '>' . date_i18n('l', 299000 + ($i * 86400) , false) . '</option>';
			}					
			$op .= '</select></div>';

			$op .= build_dateblock(24,$rndmzer,$crov['shour'],'starthour','cro_schedfromhour');
			$op .= build_dateblock(60,$rndmzer,$crov['smin'],'startminute','cro_schedfrommin');
			$op .= '<div class="dateblocker"><span class="dateto">-</span></div>';
			$op .= build_dateblock(24,$rndmzer,$crov['ehour'],'endhour','cro_schedtohour');
			$op .= build_dateblock(60,$rndmzer,$crov['emin'],'endminute','cro_schedtomin');
			$op .= '<div class="dateblocker"><span class="dateto">' .  __('every','localize')   . '</span></div>';
			$op .= '<div class="dateblocker"><input type="text" class="intervalminutes" name="cro_intervalminutes-' . $rndmzer . '" value="' . $crov['ival']  . '"></div>';
			$op .= '<div class="dateblocker"><span class="dateto">' .  __('minutes','localize')   . '</span></div><br class="clear"></div>';

		}
	} else {
		$op .= '<p class="cro_thereisnone">' .  __('No schedules set. Click to add one','localize')   . '</p>';
	}

	$op .= '</div><div class="cro_itemplusitems"><span>+</span></div>';
	return $op;
}


/* 
 * -08- CREATE REMINDERS
 * */
function cro_create_reminders() {
	$settings = get_option("bookset");
	if ($settings['sendreminders'] === 1) {
		$target = (time() + (get_option('gmt_offset') * 3600)) - 172800;
		$args=array(
			'post_type'=>'reservations',
			'showposts'=> -1
		);
		$reminder_query = new WP_Query($args);
		if ($reminder_query->have_posts()) : while ($reminder_query->have_posts()) : $reminder_query->the_post();
	
			$remid = $reminder_query->ID;
			$remdated = get_post_meta($remid, 'cro_date', true);
			$remdateh = get_post_meta($remid, 'cro_time', true);
			$reminded = get_post_meta($remid, 'cro_reminded' , true);
			$remstatus = get_post_meta($remid, 'cro_status' , true);
			$remdate = $remdated + $remdateh;
			if ($remdate >= $target && $reminded === 0 && $remstatus <= 2) {
				cro_processbooking($remid,'remind_customer');
			}
	
		endwhile;
		else : endif;
		wp_reset_query();	
	}	
}
add_action('60min_reminder_check', 'cro_create_reminders');
function cro_do_check() {
	if ( !wp_next_scheduled( '60min_reminder_check' ) ) {
		wp_schedule_event(time(), 'hourly', '60min_reminder_check');
	}
}
add_action('wp', 'cro_do_check');



/* 
 * -09- MAKE THE GUEST MANAGER
 * */
function cro_make_guests(){

	$settings = get_option("bookset");
	$guesttype = $settings['guesttype'];
	$minguests = (isset($settings['minguests']) && $settings['minguests']) ? $settings['minguests'] : '';
	$maxguests = (isset($settings['maxguests']) && $settings['maxguests']) ? $settings['maxguests'] : '';
	$custworks = (isset($settings['custworks']) && $settings['custworks']) ? $settings['custworks'] : '';
	$op = '';

	switch ($guesttype) {
		case '1':
			$op .= '<input type="hidden" name="guestadd" value="add_a_guest">';
			$op .= '<input type="hidden" name="guesttype" value="1">';
			$op .= '<div class="oneside"><div class="sideinner">
						<h2>' . __('Minimum guests','localize') . '</h2>
						<p class="helper">' . __('Minimum guests per booking that can be selected','localize') . '</p>
						<div class="helphelp">?</div>
							<div style="margin-bottom: 20px;" class="opti">
								<select name="minguests" class="selectlist">';

			for ($i=0; $i < 50 ; $i++) { 
				$sell = (isset($minguests) && $minguests == $i) ? 'selected="selected"' : '' ;
				$op .= '<option ' .  $sell . '>' . $i . '</option>';
			}
			$op .= '</select></div></div></div><div class="oneside">';

			$op .= '<div class="sideinner">
						<h2>' . __('Maximum guests','localize') . '</h2>
						<p class="helper">' . __('Maximum guests per booking that can be selected','localize') . '</p>
						<div class="helphelp">?</div>
							<div style="margin-bottom: 20px;" class="opti">
								<select name="maxguests" class="selectlist">';

			for ($i=0; $i < 50 ; $i++) { 
				$sell = (isset($maxguests) && $maxguests == $i) ? 'selected="selected"' : '' ;
				$op .= '<option ' .  $sell . '>' . $i . '</option>';
			}

			$op .= '</select></div></div></div>';

		break;	

		case '2':
			$op .= '<p style="text-align: center; font-size: 18px;">' .  __('Guest currently not enabled. Enable guest options in the settings','localize')  . '</p>';		
		break;	

		case '3':
		$op .= '<input type="hidden" name="guestadd" value="add_a_guest">';
		$op .= '<input type="hidden" name="guesttype" value="2">';
		$op .= '<div class="cro_itemlistinside"><div class="cro_itemlistitems">';


			if (isset($custworks) && $custworks) {				
				foreach ($custworks as $v){				
					$op .= '<div class="cro_listcloneractive" style="display: block;"><input type="text" name="' . $v['code']  . '" value="'  .  $v['name']  . '"><span class="cro_listdeleteone">-</span></div>';
				}				
			} else {
				$op .= '<p class="cro_theresnolist">' .  __('You have no custom guestlist at present. Click to add a guest item', 'localize')  . '</p>';
			}

			$op .= '</div><div class="cro_listcloner"><input type="text"><span class="cro_listdeleteone">-</span></div><div class="cro_itemplusitems"><span>+</span></div></div>';			

		
		break;		
	}
	return $op;
}

?>