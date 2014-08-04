<?php
/**
 * THEME SETTINGS AND EXECUTION FOR THE banners
 *
 */

/********** Code Index
 *
 * -01- FETCH THE BANNERS
 */



/* 
 * -01- UPCOMMING EVENTS
 * 
 * */

function cro_fetch_banner($position) {

	$tlset = get_option( 'tlset' );
	$op = $pp = ''; 
	$ap = get_upcomming_arr(1);


	if (isset($tlset['cro_showbanwhat']) && $tlset['cro_showbanwhat'] == 1 || $tlset['cro_showbanwhat'] == 3){
		if (isset($ap) && $ap != ''){
			$img = get_the_post_thumbnail($ap[0]['id'],'thumbnail' );
			if (!$img) {
				$img  =  '<img src="' . get_template_directory_uri() . '/public/styles/images/imgcommingsoon2.jpg" />';
			}
			$apdate = $ap[0]['date'] - (get_option('gmt_offset') * 3600) ;

			$pp .= '<div class="cro_bannerouter">';
			$pp .= get_the_post_thumbnail($ap[0]['id'],'thumbnail' );
			$pp .= '<div class="cro_baninner">';
			$pp .= '<div class="banright">';
			$pp .= '<h4 class="cro_accent"><a href="' .   get_permalink($ap[0]['id'])   . '">' .  get_the_title($ap[0]['id']) . '</a></h4>';
			$pp .= '<ul class="timervalue" rel="' .  $apdate . '">';
			$pp .= '<li class="cro_timerday cro_accent"><span class="daynumber dsec">00</span><span class="dayname">' . __('Days','localize') . '</span></li>';
			$pp .= '<li class="cro_timerday cro_accent"><span class="hournumber dsec">00</span><span class="dayname">' . __('Hour','localize') . '</span></li>';
			$pp .= '<li class="cro_timerday cro_accent"><span class="minutenumber dsec">00</span><span class="dayname">' . __('Min','localize') . '</span></li>';
			$pp .= '<li class="cro_timerday cro_accent"><span class="secondnumber dsec">00</span><span class="dayname">' . __('Sec','localize') . '</span></li>';
			$pp .= '</ul>';
			$pp .= '<div class="clearfix"></div>';
			$pp .= '</div>';
			$pp .= '</div>';
			$pp .= '<a href="' .   get_permalink($ap[0]['id'])   . '" class="cro_bannermoreinfo cro_accent">' . __('More info','localize') . '</a>';
			$pp .= '</div>';
		}
		if ($tlset['cro_showbanwhat'] == 3){
			$pp .= fetch_front_promos('banner');
		}
	} elseif (isset($tlset['cro_showbanwhat']) && $tlset['cro_showbanwhat'] == 2 ) {
		$pp .= fetch_front_promos('banner');
	}
	

	if ($pp && $position == 'front') {
		$op .= '<div class="six column bannerprocess">';
		$op .= $pp;
		$op .= '<div class="bannernext">&raquo</div>';
		$op .= '</div>';
	} elseif ($pp && $position == 'inner') {
	
		$op .= '<div class="six column bannerprocess">';
		$op .= $pp;
		$op .= '<div class="bannernext">&raquo</div>';
		$op .= '</div>';
	}

	return $op;
}


?>