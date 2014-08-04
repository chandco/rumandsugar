<?php
/**
 * THEME SETTINGS AND EXECUTION FOR THE CALENDAR
 *
 */

/********** Code Index
 *
 * -01- UPCOMMING EVENTS
 */



/* 
 * -01- UPCOMMING EVENTS
 * 
 * */
function create_upcomming_events($eventarray, $num) {

	$op = '';

	foreach ($eventarray as $crov) {

		$op .= '<div class="cro_eventswidgetout">';

		$op .= '<div class="cro_eventinfoholder"><div class="cro_caldayholder"><span class="month">' . date_i18n( 'M' , $crov['date'] , false )  . '</span><span class="day">' .  date('d', $crov['date'])  . '</span></div>';

		$op .= '<a href="' .  get_permalink($crov['id'])  . '">' .  get_the_title($crov['id'])  . '</a><span class="cro_thetime">' .   __('Time:','localize')    . '</span> ' . date_i18n( get_option('time_format') , $crov['date'] , false )  . '<div class="clearfix"></div></div>';

		$op .= '</div>';
	}

	return $op;
}


function create_a_timer() {

	$op = '';

	foreach ($eventarray as $crov) {

		$op .= '<div class="cro_eventswidgetout">';

		$op .= '<div class="cro_eventinfoholder"><div class="cro_caldayholder"><span class="month">' . date_i18n( 'M' , $crov['date'] , false )  . '</span><span class="day">' .  date('d', $crov['date'])  . '</span></div>';

		$op .= '<a href="' .  get_permalink($crov['id'])  . '">' .  get_the_title($crov['id'])  . '</a><span class="cro_thetime">' .   __('Time:','localize')    . '</span> ' . date_i18n( get_option('time_format') , $crov['date'] , false )  . '<div class="clearfix"></div></div>';

		$op .= '</div>';
	}

	return $op;
}

function create_a_page_header($post_id) {

	$op = '';
	$byline = get_post_meta($post_id, 'cro_bannerline', true);
	$key_end_a 			= get_post_meta($post_id, 'cro_selrec_c', true);
	$key_end_b 			= get_post_meta($post_id, 'cro_selrec_d', true);
	$key_end_c 			= get_post_meta($post_id, 'cro_selrec_e', true);
	$key_recint_value	= get_post_meta($post_id, 'cro_selrec_a', true);
	$key_recday_value 	= get_post_meta($post_id, 'cro_selrec_b', true);
	$key_rectype_value 	= get_post_meta($post_id, 'cro_selrec', true);
	$key_date_value		= get_post_meta($post_id, 'cro_thiscalbox', true);
	$key_time_value 	= get_post_meta($post_id, 'cro_thisslider', true);
	$timeparts = explode(':', $key_time_value);
	$startepoch = $key_date_value + ($timeparts[0] * 60 * 60) + ($timeparts[1] * 60);
	$playtime = date(get_option('time_format'), $startepoch);
	$img = get_the_post_thumbnail( $post_id , 'thumbnail' );
	$maininfo = '';

	switch ($key_rectype_value) {
		case 1:
			$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $startepoch, false ) . '</h3>';
			if ($byline) {
				$maininfo .= '<h5 class="cro_bynone  cro_accent">' .  $byline   . '</h5>';
			}
		break;


		case 2:
			if (($key_end_a + $key_end_b + $key_end_c) === 0) {
				$maininfo .= '<h3 class="cro_maindate cro_datebylines">' . __('Every day from','localize') . '</h3>';
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $startepoch, false ) . '</h3>';			
				if ($byline) {
					$maininfo .= '<h5 class="cro_bynone cro_accent">' .  $byline   . '</h5>';
				}
			} else {
				$enddate = mktime(0,0,0, intval($key_end_b), $key_end_a, $key_end_c);
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $startepoch, false ) . '</h3>';
				$maininfo .= '<h3 class="cro_maindate cro_datebylines">' . __('To','localize') . '</h3>';
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $enddate, false ) . '</h3>';
			}
		break;


		case 3:

			if (($key_end_a + $key_end_b + $key_end_c) === 0) {
				$maininfo .= '<h3 class="cro_maindate cro_datebylines">' . __('Every','localize') . ' ' . date_i18n('l', $startepoch, false ) . ' ' . __('from','localize') . '</h3>';
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $startepoch, false ) . '</h3>';			
				if ($byline) {
					$maininfo .= '<h5 class="cro_bynone  cro_accent">' .  $byline   . '</h5>';
				}
			} else {
				$enddate = mktime(0,0,0, intval($key_end_b), $key_end_a, $key_end_c);
				$maininfo .= '<h3 class="cro_maindate cro_datebylines">' . __('Every','localize') . ' ' . date_i18n('l', $startepoch, false ) . ' ' . __('from','localize') . '</h3>';
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $startepoch, false ) . '</h3>';
				$maininfo .= '<h3 class="cro_maindate cro_datebylines">' . __('To','localize') . '</h3>';
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $enddate, false ) . '</h3>';
			}

		break;

		case 4:

			if (($key_end_a + $key_end_b + $key_end_c) === 0) {
				$maininfo .= '<h3 class="cro_maindate cro_datebylines">' . __('Every','localize') . ' ' . date_i18n('jS', $startepoch, false ) . ' ' . __('from','localize') . '</h3>';
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $startepoch, false ) . '</h3>';			
				if ($byline) {
					$maininfo .= '<h5 class="cro_bynone  cro_accent">' .  $byline   . '</h5>';
				}
			} else {
				$enddate = mktime(0,0,0, intval($key_end_b), $key_end_a, $key_end_c);
				$maininfo .= '<h3 class="cro_maindate cro_datebylines">' . __('Every','localize') . ' ' . date_i18n('jS', $startepoch, false ) . ' ' . __('from','localize') . '</h3>';
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $startepoch, false ) . '</h3>';
				$maininfo .= '<h3 class="cro_maindate cro_datebylines">' . __('To','localize') . '</h3>';
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $enddate, false ) . '</h3>';
			}

		break;

		case 5:

		switch ($key_recint_value) {
			case 'first': 		$intval = __('First','localize');  break;
			case 'second': 		$intval = __('Second','localize');  break;
			case 'third': 		$intval = __('Third','localize');  break;
			case 'fourth': 		$intval = __('Fourth','localize');  break;
			case 'last': 		$intval = __('Last','localize');  break;
		}

		switch ($key_recday_value) {
			case 'Monday': 		$intday = date_i18n('l', (40000 + (86400 * 4)), false );  break;
			case 'Tuesday': 	$intday = date_i18n('l', (40000 + (86400 * 5)), false );  break;
			case 'Wednesday': 	$intday = date_i18n('l', (40000 + (86400 * 6)), false );  break;
			case 'Thursday': 	$intday = date_i18n('l', 40000, false );  break;
			case 'Friday': 		$intday = date_i18n('l', (40000 + (86400 * 1)), false );  break;
			case 'Saturday': 	$intday = date_i18n('l', (40000 + (86400 * 2)), false );  break;
			case 'Sunday': 		$intday = date_i18n('l', (40000 + (86400 * 3)), false );  break;
		}



			if (($key_end_a + $key_end_b + $key_end_c) === 0) {
				$maininfo .= '<h3 class="cro_maindate cro_datebylines">' . __('Every','localize') . ' ' . $intval . ' ' . $intday . ' ' . __('from','localize') . '</h3>';
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $startepoch, false ) . '</h3>';			
				if ($byline) {
					$maininfo .= '<h5 class="cro_bynone  cro_accent">' .  $byline   . '</h5>';
				}
			} else {
				$enddate = mktime(0,0,0, intval($key_end_b), $key_end_a, $key_end_c);
				$maininfo .= '<h3 class="cro_maindate cro_datebylines">' . __('Every','localize') . ' ' . $intval . ' ' . $intday . ' ' . __('from','localize') . '</h3>';
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $startepoch, false ) . '</h3>';
				$maininfo .= '<h3 class="cro_maindate cro_datebylines">' . __('To','localize') . '</h3>';
				$maininfo .= '<h3 class="cro_maindate">' . date_i18n(get_option('date_format'), $enddate, false ) . '</h3>';
			}


		break;
		
	}

	$op .= '<div class="cro_caldescsingleouter">';



	if ($img) {
		$op .= '<div class="cro_calsingleimg">' . $img;
		$op .= '<div class="cro_twiouter"><div class="cro_timewithimage">'  .  $playtime   . '</div></div>';
		$op .=  '</div>';
	} else {
		$op .= '<div class="cro_calsingletime">'  .  $playtime   . '</div>';
	}

	$op .= $maininfo;



	$op .= '<div class="clearfix"></div>';

	$op .= '</div>';
	return $op;
}


?>