<?php
/**
 * Structure for the ajax functions
 */ 
   
/********** Code Index
 *
 * -01- ADD THE MAIN AJAX FUNCTION
 * 
 */




/* 
 * -01- ADD THE MAIN AJAX FUNCTION
 * */


add_action('wp_ajax_cro_get_ajaxdatas', 'cro_ajaxx_callback');
add_action('wp_ajax_nopriv_cro_get_ajaxdatas', 'cro_ajaxx_callback');

function cro_ajaxx_callback() {

	$cro_p = '';

	if(isset($_POST['type'])){$action_identifier = $_POST['type'];}
	if(isset($_POST['option1'])){$option1 = $_POST['option1'];}
	if(isset($_POST['option2'])){$option2 = $_POST['option2'];}
	if(isset($_POST['option3'])){$option3 = $_POST['option3'];}
	if(isset($_POST['option4'])){$option4 = $_POST['option4'];}
	if(isset($_POST['option5'])){$option5 = $_POST['option5'];}
	if(isset($_POST['option6'])){$option6 = $_POST['option6'];}
	if(isset($_POST['option7'])){$option7 = $_POST['option7'];}




	if ($action_identifier == 'updte_tweet') {
		$tweetcontent = get_option('cro_tweetsave');
		foreach ($tweetcontent as $crov) {
			$cro_p = cro_updatetweets($crov['user'],'');
		}

	} elseif ($action_identifier == 'cro_movecal') {
		$cro_p = fetch_front_calendar('', '', date('n', intval($option1)), date('Y', intval($option1)),'');




	}elseif ($action_identifier == 'cro_moveagenda') {
		$cro_p = fetch_upc_agenda('', '', date('n', intval($option1)), date('Y', intval($option1)),'');




	} elseif ($action_identifier == 'submit_newsl') {
		$newsarr = array(
			__('Name','localize') 		=> $option2,
			__('Email','localize') 		=> $option1
		);
		cro_newsletter_preprocessor($newsarr, 'newsletter');




	} elseif ($action_identifier == 'bookingcal_fetch_nextmonth') {
		$cro_p = booking_calendar(date('n', intval($option1)),date('Y', intval($option1)), 'front');




	} elseif ($action_identifier == 'bookingcal_fetch_timeslots') {
		check_ajax_referer( 'cro_ajax_functions', 'crnonce' );
		$cro_p = booking_fetch_timeslots($option1);



	} elseif ($action_identifier == 'bookingcal_make_booking') {
		check_ajax_referer( 'cro_ajax_functions', 'crnonce' );
		$cro_p = booking_make_booking($option1,$option2, $option3, $option4, $option5, $option6, $option7);



	} elseif ($action_identifier == 'bookingcal_form_submit') {
		$myformdata = array(
			__('Name','localize') 	=> $option1,
			__('Email','localize') 	=> $option2,
			__('Telephone','localize') 	=> $option4,
			__('Comment','localize') 	=> $option3,
			'locdata'                => $option5
		);
		cro_newsletter_preprocessor($myformdata, 'ctcform');
	}



	echo $cro_p;
	exit;

}
 
?>