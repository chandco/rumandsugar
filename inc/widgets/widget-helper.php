<?php
/**
 * The file handling all the helper functions for the widgets
 *
 */



 
/********** Code Index
 *
 * -01- COMPOSE THE TWITTER QUESRY STRING
 * -02- THE FUNCTION TO CONVERT TIME TO TWITTER TIME
 * -03- THE FUNCTION TO UPDATE TWEETS
 * -04- THE FUNCTION TO LINKIFY TWEETS
 * -05- THE FUNCTION CREATE WIDGET FORM PARTS
 * -06- THE FUNCTION TO CREATE DIFFERENT KINDS OF OPTION NODES
 */



/* 
 * -01- COMPOSE THE TWITTER QUERY STRING
 * */
function cro_bquery( $query_data, $numeric_prefix='', $arg_separator='&' ) {
	$arr = array();
	foreach ( $query_data as $key => $val ) $arr[] = urlencode($numeric_prefix.$key) . '=' . urlencode($val);
	return implode($arr, $arg_separator);
}



/* 
 * -02- THE FUNCTION TO CONVERT TIME TO TWITTER TIME
 * */
function cro_twittertime( $tweettime) {

	$twittime = array(
		array(
			'singular' => __('year', 'localize'),
			'plural' => __('years', 'localize'),
			'timespan' => 31536000
		),
		array(
			'singular' => __('month', 'localize'),
			'plural' => __('months', 'localize'),
			'timespan' => 2592000
		),
		array(
			'singular' => __('week', 'localize'),
			'plural' => __('weeks', 'localize'),
			'timespan' => 604800
		),
		array(
			'singular' => __('day', 'localize'),
			'plural' => __('days', 'localize'),
			'timespan' => 86400
		),
		array(
			'singular' => __('hour', 'localize'),
			'plural' => __('hours', 'localize'),
			'timespan' => 3600
		),
		array(
			'singular' => __('minute', 'localize'),
			'plural' => __('minutes', 'localize'),
			'timespan' => 60
		)
	);


	$today = time();
	$since = $today - $tweettime;
	$op = '';


	for ($i = 0; $i < 6; $i++) {      
        $seconds = $twittime[$i]['timespan'];
        $name = $twittime[$i]['singular'];
        $namep = $twittime[$i]['plural'];
        if (($count = floor($since / $seconds)) != 0) break;
	}

	$op .= ($count == 1) ? '1 '. $name : $count . ' ' . $namep;
	return $op;
}




/* 
 * -03- THE FUNCTION TO UPDATE TWEETS
 * */
function cro_updatetweets($username, $args) {	

	if (!class_exists('Codebird')) {
		require ('twitterlib/codebird.php');
	}

	$tweetcontent = get_option('cro_tweetsave');

	if ($args) {
		$consumer_key 			= $args['consumer_key'];
		$consumer_secret 		= $args['consumer_secret'];
		$access_token 			= $args['access_token'];
		$access_token_secret 	= $args['access_token_secret'];
	} else {
		$consumer_key 			= $tweetcontent[$username]['consumer_key'];
		$consumer_secret 		= $tweetcontent[$username]['consumer_secret'];
		$access_token 			= $tweetcontent[$username]['access_token'];
		$access_token_secret 	= $tweetcontent[$username]['access_token_secret'];
	}

	$params = array(
		'screen_name'			=> $username, 
		'trim_user'				=> true, 
		'count'					=> 10,
		'consumer_key' 			=> $consumer_key ,
		'consumer_secret' 		=> $consumer_secret,
		'access_token' 			=> $access_token,
		'access_token_secret' 	=> $access_token_secret
	);

	$tweetcontent = get_option('cro_tweetsave');

	Codebird::setConsumerKey($params['consumer_key'], $params['consumer_secret']); 
	$cb = Codebird::getInstance();
	$cb->setToken($params['access_token'], $params['access_token_secret']);		
	$cb->setReturnFormat(CODEBIRD_RETURNFORMAT_ARRAY);


	try {
		$twitter_data =  $cb->statuses_userTimeline(array(
			'screen_name'=>$params['screen_name'], 
			'count'=>10
		));
	} catch (Exception $e) { return __('Error retrieving tweets','localize'); }


	if (isset($twitter_data['errors'])) {
		$cb->debug($options, __('Twitter data error:','localize').' '.$twitter_data['errors'][0]['message'].'<br />');
	}


	$tweetcontent[$username] = array(
			'user' 					=> $username,
			'tweets' 				=> $twitter_data,
			'consumer_key' 			=> $consumer_key,
			'consumer_secret' 		=> $consumer_secret,
			'access_token'			=> $access_token,
			'access_token_secret'	=> $access_token_secret
	);

	if (!isset($twitter_data['errors'])) {
		update_option( 'cro_tweetsave', $tweetcontent);
	}
	

	return ; 
}




 /* 
 * -04- THE FUNCTION TO LINKIFY TWEETS
 * */

function cro_linkify_tweet($tweet) {
    $tweet = preg_replace('/(^|\s)@(\w+)/',
        '\1<a href="http://www.twitter.com/\2">@\2</a>',
        $tweet);
    return preg_replace('/(^|\s)#(\w+)/',
        '\1<a href="http://search.twitter.com/search?q=%23\2">#\2</a>',
        $tweet);
}


 /* 
 * -05- THE FUNCTION TO CREATE WIDGET FORM PARTS
 * */


 function cro_make_widget_formpart($args){

 	$cro_p = '<p>';

 	if ($args['type'] != 'hidden'){
 		$cro_p .= '<label for="' . $args['labelfor']  . '">'   .  $args['label']  .    '</label> ';
 	}

 	switch ($args['type']) {
 		case 'input':
 			$cro_p .= '<input class="widefat" id="' .  $args['id']  . '" name="' .  $args['idname']  . '" type="text" value="' .  $args['val']  . '" />';	
 		break;

 		case 'textarea':
 			$cro_p .= '<textarea name="' .  $args['idname']  . '" id="' .  $args['id']  . '" cols="20" rows="16" class="widefat">' .  $args['val']  . '</textarea>';	
 		break;

 		case 'hidden':
 			$cro_p .= '<input class="widefat" id="' .  $args['id']  . '" name="' .  $args['idname']  . '" type="hidden" value="' .  $args['val']  . '" />';	
 		break;

 		case 'carouselselect':
 			$cro_p .= '<select class="widefat" id="' .  $args['id']  . '" name="' .  $args['idname']  . '">';	

 			if (isset($args['val'])){
 				$vals = $args['val'];
 			} else {
 				$vals = '';
 			}

 			$args = array(
 					'default' => $vals,
 					'type'		=> 'page',
 			);

 			$cro_p .= cro_get_optionnodes($args, 'ifimages');

 			$cro_p .= '</select>';
 		break;

 		case 'get_location':
 			$cro_p .= '<select class="widefat" id="' .  $args['id']  . '" name="' .  $args['idname']  . '">';	

 			if (isset($args['val'])){
 				$vals = $args['val'];
 			} else {
 				$vals = '';
 			}

 			$args = array(
 					'type'		=> 'locations'
 			);

 			$cro_p .= cro_get_optionnodes($args, '');

 			$cro_p .= '</select>';
 		break;


 		case 'get_cats':
 			$cro_p .= '<select class="widefat" id="' .  $args['id']  . '" name="' .  $args['idname']  . '">';	


 			if (isset($args['val'])){
 				$vals = $args['val'];
 			} else {
 				$vals = '';
 			}

 			if ($vals == 0) {
 				$cro_p .= '<option value="0"  selected="selected">' .  __('All catgories','localize')   . '</option>';
 			} else {
 				$cro_p .= '<option value="0">' .  __('All catgories','localize')   . '</option>';
 			}

 			$categories=  get_categories();
  			foreach ($categories as $category) {
  				if ($vals == $category->term_id){
  					$vsel = ' selected="selected"';
  				} else {
  					$vsel = '';
  				}
  				$cro_p .= '<option value="' .   $category->term_id    .     '" ' . $vsel  . '> '   .$category->category_nicename.'</option>';
  			}

 			$cro_p .= '</select>';
 		break;

 		case 'selectbox':
 			$cro_p .= '<select class="widefat" id="' .  $args['id']  . '" name="' .  $args['idname']  . '">';	

 			if (isset($args['options'])) {

 				foreach ($args['options'] as $cro_v) {


 					$cro_p .= '<optgroup label="' . $cro_v . '">';

 					$vals = '';
 					if (isset($args['val'])){
 						$vals = $args['val'];
 					} 

 					$args = array(
 					'default' => $vals,
 					'type'		=> $cro_v,
 					'options'	=> array()
 					);

 					$cro_p .= cro_get_optionnodes($args, '');

 					$cro_p .= '</optgroup>';

 				}
 			}

 			$cro_p .= '</select>';
 		break;


 	}

 	if (isset($args['desc'])) {
 		$cro_p .= '<br/>' . $args['desc'];
 	}

	$cro_p .= '</p>';
	return $cro_p;
 }



  /* 
 * -06- THE FUNCTION TO CREATE DIFFERENT KINDS OF OPTION NODES
 * */


function cro_get_optionnodes($args, $imagelinks){

	$cro_p = '';

	$myargs = array('post_type'=>$args['type'],'showposts'=> 10000);	
	
	
	$my_newquery = new WP_Query($myargs);
	
	
	if ($my_newquery->have_posts()) : while ($my_newquery->have_posts()) : $my_newquery->the_post();
	
	$ctotid = get_the_ID();
	$ctotit = get_the_title($ctotid);
	$img 	= get_the_post_thumbnail( $ctotid, 'thumbnail');
	$continue = ($img && $imagelinks) ? 1 : 0 ;

	if (!$imagelinks ||$continue === 1){

		if (isset($args['default']) && $args['default'] == $ctotid) {
			$sel = ' selected="selected"';
		} else {
			$sel = '';
		}

		if (isset($args['options']) && $args['options'] ){

			$testit = 'false';

			$ptemplate = get_post_meta($ctotid, '_wp_page_template', true);

			foreach ($args['options'] as $crov) {
				if ($crov == $ptemplate){
					$testit = 'true';
				}
			}

			if ($testit == 'true') {
				$cro_p .= '<option ' .  $sel . ' value="' . $ctotid  . '">';
				$cro_p .= $ctotit;
				$cro_p .= '</option>';
			}

		} else {

			$cro_p .= '<option ' .  $sel . ' value="' . $ctotid  . '">';
			$cro_p .= $ctotit;
			$cro_p .= '</option>';

		}

	}

	
	endwhile;
	else : endif;
	wp_reset_query();


	return $cro_p;

}


 
?>