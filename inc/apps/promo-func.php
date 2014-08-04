<?php
/**
 * The file handling all the functions for the custom parts of the theme.
 *
 */
 
 
 
/********** Code Index
 *
 * -01- DRAW THE PROMO PAGE
 * -02- PREPARE THE CALENDAR ARRAY
 * -03- SORTING FUNCTION
 * -04- GET CALENDAR ENTRIES
 */

/* 
 * -01- DRAW THE PROMO PAGE
 * */
function fetch_front_promos($reqtype){

	$op = '';
	$pp = get_upcomming_promos(10);
	$cntr = 1;

	if ($pp && $pp != '') {
		foreach ($pp as $crovv) {$ps[] = $crovv['id'];}
		array_unique($ps);
    
    	foreach( $pp  as $apost ) : 
    		if (in_array($apost['id'], $ps)) {   	
    			$ps = array_diff($ps, array($apost['id']));
        		$img 				= get_the_post_thumbnail($apost['id'],'fc1');
        		if (!$img) {
					$img  =  '<img src="' . get_template_directory_uri() . '/public/styles/images/imgcommingsoon3.jpg">';
				}
    			$maininfo 			= '';
				$byline 			= get_post_meta($apost['id'], 'cro_bannerline', true);
				$valueline 			= get_post_meta($apost['id'], 'cro_value', true);
				$timeline 			= get_post_meta($apost['id'], 'cro_timedesc', true);
				$key_end_a 			= get_post_meta($apost['id'], 'cro_selrec_c', true);
				$key_end_b 			= get_post_meta($apost['id'], 'cro_selrec_d', true);
				$key_end_c 			= get_post_meta($apost['id'], 'cro_selrec_e', true);
				$key_recint_value	= get_post_meta($apost['id'], 'cro_selrec_a', true);
				$key_recday_value 	= get_post_meta($apost['id'], 'cro_selrec_b', true);
				$key_rectype_value 	= get_post_meta($apost['id'], 'cro_selrec', true);
				$key_date_value		= get_post_meta($apost['id'], 'cro_thiscalbox', true);
				$key_time_value 	= '23:59';
				$timeparts 			= explode(':', $key_time_value);
				$startepoch 		= $key_date_value + ($timeparts[0] * 60 * 60) + ($timeparts[1] * 60);
				$playtime 			= date(get_option('time_format'), $startepoch);
				$titlename = $linkname = $timename = $bannername = $valuename = '';
				$enddate = mktime(0,0,0, intval($key_end_b), $key_end_a, $key_end_c);
				$endname = (($key_end_a + $key_end_b + $key_end_c) !== 0) ? __(' to ','localize') . date_i18n(get_option('date_format'), $enddate, false ) : '';

				switch ($key_rectype_value) {
					case 1:
						$timename = date_i18n(get_option('date_format'), $startepoch, false);
					break;
					case 2:
						$timename = __('Every day from ','localize') . ' ' . date_i18n(get_option('date_format'), $startepoch, false ) . $endname;
					break;
					case 3:
						$timename = __('Every','localize') . ' ' . date_i18n('l', $startepoch, false ) . ' ' . __(' from ','localize') . date_i18n(get_option('date_format'), $startepoch, false ) . $endname;
					break;
					case 4:
						$timename = __('Every','localize') . ' ' . date_i18n('jS', $startepoch, false ) . ' ' . __(' from ','localize') . date_i18n(get_option('date_format'), $startepoch, false ) . $endname;
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
						$timename =  __('Every','localize') . ' ' . $intval . ' ' . $intday . ' ' . __('from','localize') . date_i18n(get_option('date_format'), $startepoch, false ) . $endname;
					break;
				}

				if ($reqtype == 'shortcode') {
					$cnt1 = '<div class="promoimg">';
					$cnt1 .= ($img) ? $img : '' ;
					$cnt1 .= '</div>';

					$cnt2 = '<h6 class="cro_promodate">' . $timename . ' ' . $timeline . '</h6>';
					$cnt2 .= '<h4 class="valueline cro_accent"><a href="' .  get_permalink( $apost['id']) . '">' . $valueline  . '</a></h4>';
					


					$op .= '<li class="promoshow">';
					$op .= '<h5 class="weekpromo cro_accent"><a href="' .  get_permalink( $apost['id']) . '">' . get_the_title( $apost['id'] ) . '</a></h5>';
					$op .= '<div class="twisterimage imgpromo timgleft">';
					$op .= $cnt1;
					$op .= '</div><div class="twistercontent">';
					$op .= $cnt2;
					$op .= '</div><div class="clearfix"></div>';
					$op .= '<h4 class="byline cro_accent">' . $byline . '</h4>';					
					$op .= '<div class="clarlabel"><a href="' .  get_permalink( $apost['id']) . '" class="cro_accent">' .  __('more info','localize') . '</a></div>';
					$op .= '</li>';

        		} elseif ($reqtype == 'banner' && $cntr <= 5) {
        			$img = get_the_post_thumbnail( $apost['id'],'thumbnail' );
					if (!$img) {
						$img  =  '<img src="' . get_template_directory_uri() . '/public/styles/images/imgcommingsoon2.jpg" />';
					}
        			$op .= '<div class="cro_bannerouter">' .  $img  . '
        						<div class="cro_baninner">
        							<div class="banleft">&nbsp;</div>
        							<div class="banright">
        								<h4 class="cro_accent"><a href="' .  get_permalink( $apost['id']) . '">' . get_the_title( $apost['id'] ) . '</a></h4>
        								<a href="' .  get_permalink( $apost['id']) . '" class="bannervalueline cro_accent">' .  $valueline   . '</a>
        								<div class="clearfix"></div>
        							</div>
        						</div>
        						<a href="' .   get_permalink( $apost['id'])   . '" class="cro_bannermoreinfo cro_accent">' . __('More info','localize') . '</a>
        					</div>';
        			}
    				$cntr++;
    		}
    	endforeach;
    		if ($reqtype == 'shortcode') {
    		$op = '<ul class="cro_twister ">' . $op . '</ul>';
    	}
    }
	return $op;	
}


function promo_header($id){
	$op = '';

	$img 				= get_the_post_thumbnail($id,'medium');
    $maininfo 			= '';
	$byline 			= get_post_meta($id, 'cro_bannerline', true);
	$valueline 			= get_post_meta($id, 'cro_value', true);
	$timeline 			= get_post_meta($id, 'cro_timedesc', true);
	$key_end_a 			= get_post_meta($id, 'cro_selrec_c', true);
	$key_end_b 			= get_post_meta($id, 'cro_selrec_d', true);
	$key_end_c 			= get_post_meta($id, 'cro_selrec_e', true);
	$key_recint_value	= get_post_meta($id, 'cro_selrec_a', true);
	$key_recday_value 	= get_post_meta($id, 'cro_selrec_b', true);
	$key_rectype_value 	= get_post_meta($id, 'cro_selrec', true);
	$key_date_value		= get_post_meta($id, 'cro_thiscalbox', true);
	$key_time_value 	= '23:59';
	$timeparts 			= explode(':', $key_time_value);
	$startepoch 		= $key_date_value + ($timeparts[0] * 60 * 60) + ($timeparts[1] * 60);
	$playtime 			= date(get_option('time_format'), $startepoch);
	$titlename = $linkname = $timename = $bannername = $valuename = '';
	$enddate = mktime(0,0,0, intval($key_end_b), $key_end_a, $key_end_c);
	$endname = (($key_end_a + $key_end_b + $key_end_c) !== 0) ? __(' to ','localize') . date_i18n(get_option('date_format'), $enddate, false ) : '';



	switch ($key_rectype_value) {
		case 1:
			$timename = date_i18n(get_option('date_format'), $startepoch, false);
		break;
		case 2:
			$timename = __('Every day from ','localize') . ' ' . date_i18n(get_option('date_format'), $startepoch, false ) . $endname;
		break;
		case 3:
			$timename = __('Every','localize') . ' ' . date_i18n('l', $startepoch, false ) . ' ' . __(' from ','localize') . date_i18n(get_option('date_format'), $startepoch, false ) . $endname;
		break;
		case 4:
			$timename = __('Every','localize') . ' ' . date_i18n('jS', $startepoch, false ) . ' ' . __(' from ','localize') . date_i18n(get_option('date_format'), $startepoch, false ) . $endname;
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
			$timename =  __('Every','localize') . ' ' . $intval . ' ' . $intday . ' ' . __('from','localize') . date_i18n(get_option('date_format'), $startepoch, false ) . $endname;
		break;
	}



	$cnt1 = '<div class="cro_calsingleimg">';
	$cnt1 .= ($img) ? $img : '' ;
	$cnt1 .= '</div>';

	
	$cnt2 = '<h3 class="cro_maindate cro_datebylines">' . $timename . ' ' . $timeline . '</h6>';
	$cnt2 .= '<h5 class="cro_bynone  cro_accent">' . $byline . '</h5>';
	$cnt2 .= '<div class="clearfix"></div><h4 class="valueline cro_accent"><a href="' .  get_permalink( $id) . '">' . $valueline  . '</a></h4>';

	$op .= $cnt1;
	$op .= $cnt2;


	$op = '<div class="cro_caldescsingleouter">' . $op . '</div>';

	return $op;

}







/* 
 * -02- PREPARE THE PROMO ARRAY
 * */

function get_the_promos($month,$year) {
	$op = $endepoch = '';
	$promoentries = array();
	$promargs=array(
		'post_type'=>'promotions',
		'showposts'=> -1,
	);

	$promoposts = get_posts( $promargs );
	foreach( $promoposts as $ppost ) :	setup_postdata($ppost);

	$occurance = 0;

	$key_date_value		= get_post_meta($ppost->ID, 'cro_thiscalbox', true);
	$key_time_value 	= '23:59';
	$key_end_a 			= get_post_meta($ppost->ID, 'cro_selrec_c', true);
	$key_end_b 			= get_post_meta($ppost->ID, 'cro_selrec_d', true);
	$key_end_c 			= get_post_meta($ppost->ID, 'cro_selrec_e', true);
	$key_recint_value	= get_post_meta($ppost->ID, 'cro_selrec_a', true);
	$key_recday_value 	= get_post_meta($ppost->ID, 'cro_selrec_b', true);
	$key_rectype_value 	= get_post_meta($ppost->ID, 'cro_selrec', true);

	$timeparts = explode(':', $key_time_value);

	$startepoch = $key_date_value + ($timeparts[0] * 60 * 60) + ($timeparts[1] * 60);


	if ($key_end_a && $key_end_b && $key_end_c && $key_end_a != '0' && $key_end_b != '0' && $key_end_c != '0'){
		$endepoch = mktime($timeparts[0],$timeparts[1],0,$key_end_b, $key_end_a, $key_end_c);
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
		$promoentries[] = array (					
			'strdate' => $firstone,
			'cids' => $ppost->ID
		);
	}
	
	if ($occurance == 2) {
		foreach ($datelist as $dateentry) {
			$promoentries[] = array (					
				'strdate' => $dateentry,
				'cids' => $ppost->ID
			);
		}
	}
	endforeach; 

	return $promoentries;
}



/* 
 * -04- GET CALENDAR ENTRIES
 * */
function get_the_promentries($cmonth,$cyear) {
	$promoentries = get_the_promos($cmonth,$cyear);
	if($promoentries) {		
		$promoentries = cro_val_sort($promoentries,'strdate'); 
	}
	return $promoentries;
}


/* 
 * -05- GET UPCOMMING EVENTS ARRAY
 * */

function get_upcomming_promos($count) {
	$promowidget = array();
	$now = time() + ( get_option( 'gmt_offset' ) * 3600 );
	$wmonth = date("n", $now);
	$wyear = date("Y", $now);
	$ctime = mktime(0,0,0,$wmonth,15,$wyear);
	$emptycounter = 0;


	while (count($promowidget) <= ($count - 1) && $emptycounter <= 50) { 
		$promoentries =  get_the_promos(date("n", $ctime),date("Y", $ctime));

		if($promoentries) {
			$promoentries = cro_val_sort($promoentries,'strdate'); 
			foreach ($promoentries as $crov) {
				if (isset($crov['strdate']) &&  $crov['strdate']  >= $now && count($promowidget) <= ($count - 1)) {
					$promowidget[] = array(					
						'date' => $crov['strdate'],
						'id' => $crov['cids'],
					);	
				}	
			}	
		}

		$ctime  = $ctime + 2678400;
		$emptycounter++;
	}
	return $promowidget;
}
 
?>