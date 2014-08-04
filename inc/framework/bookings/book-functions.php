<?php
/*
 * Croma Bookings Framework main functions file
 */

 


/*===========  PAGE INDEX ================
 *
 * -01- STRAP THE FILES NEEDED
 * -02- CREATE THE PAGE
 * -03- ADD STYLESHEET & JS
 * -04- INFO ARRAY SETUP
 * -05- DEFAULT BOOKING SETTINGS
 * 
 * */




/* 
 * -02- CREATE THE PAGE
 * */
add_action( 'admin_menu', 'cro_b_init' );
add_action( 'init', 'cro_book_init' );

function cro_b_init() {
	$cro_books_page = add_menu_page(
		__('Croma.Res', 'localize'), 
		__('Croma.Res', 'localize'), 
		'manage_options','cromares', 
		'cro_b_page', 
		get_template_directory_uri() .'/inc/admin/images/ticon.png',
		4
	);	
	add_action( "load-{$cro_books_page}", 'cro_bpage' );
	add_action( 'admin_print_styles-' . $cro_books_page, 'cro_book_scripts' );	
}



/* 
 * -03- ADD STYLESHEET & JS
 * */
function crob_enqueue_style( $hook_suffix ) {
	wp_enqueue_style( 'cro-options', get_template_directory_uri() . '/inc/framework/bookings/book-style.css', false, '2012-08-01' );
}
add_action( 'admin_print_styles-toplevel_page_cromares', 'crob_enqueue_style' );
function cro_book_scripts() {

	$vals = array(
		'activateBlocks' 	=> htmlentities(__('Date blocking is enabled. Any date in Yellow can now be blocked or unblocked. Click to disable when you are done','localize')),
		'deactivateBlocks' 	=> htmlentities(__('Date blocking is disabled','localize')),
		'blockDate' 		=> htmlentities(__('Blocking this day will make it unavailable to book. Ready to continue?','localize')),
		'unblockDate' 		=> htmlentities(__('Unblocking this day will make it available to book. Ready to continue?','localize')),
		'cancelled' 		=> htmlentities(__('Cancelled','localize')),
		'confirmed' 		=> htmlentities(__('Confirmed','localize')),
		'sday' 				=> htmlentities(__('Sunday','localize')),
		'mday' 				=> htmlentities(__('Monday','localize')),
		'tday' 				=> htmlentities(__('Tuesday','localize')),
		'wday' 				=> htmlentities(__('Wednesday','localize')),
		'thday' 			=> htmlentities(__('Thursday','localize')),
		'fday' 				=> htmlentities(__('Friday','localize')),
		'saday' 			=> htmlentities(__('Saturday','localize')),
		'every' 			=> htmlentities(__('every','localize')),
		'minutes' 			=> htmlentities(__('minutes','localize')),
		'moveCal' 			=> htmlentities(__('Fetching Calendar','localize'))
	);
    wp_enqueue_script( 'cro_c_scripts', get_template_directory_uri() . '/inc/scripts/bookingapp.js', array('jquery') );
    wp_localize_script( 'cro_c_scripts', 'cro_bquery', $vals);   
}



/* 
 * -03- BOOKINGS AJAX
 * */
add_action('wp_ajax_crob_post_action', 'crob_ajax_callback');
function crob_ajax_callback() {
	global $wpdb; 
	$op = '';
	$save_type = (isset($_POST['type'])) ? $_POST['type'] : '' ;
	$post_id = (isset($_POST['post'])) ? $_POST['post'] : '' ;
	$option1 = (isset($_POST['option1'])) ? $_POST['option1'] : '' ;
	check_ajax_referer( 'cro_book_functions', 'crnonce' );
	switch ($save_type) {
		case 'crob_movecal': 		$op = booking_calendar(date('m', $option1), date('Y', $option1),'back'); break;
		case 'crob_addblock':		$op = cro_processblocks($option1,'block');break;
		case 'crob_removeblock':	$op = cro_processblocks($option1,'unblock');break;
		case 'crob_confirmbooking':	cro_processbooking($option1, 'confirm_customer');break;
		case 'crob_declinebooking':	cro_processbooking($option1, 'decline_customer');break;
		case 'crob_cancelbooking':	cro_processbooking($option1, 'cancel_customer');
		break;
	}	
	echo $op;
	exit;
}


/* 
 * -04- INFO ARRAY SETUP
 * */
function book_setup_admin_data(){	
	global $crob_setupval;
    unset($crob_setupval);
	$bt = array();	
	$dashno	= isset($_GET['dash'])? $_GET['dash'] : 0;	
	$tabno	= isset($_GET['tab'])? $_GET['tab'] : 0;
	$itemno	= isset($_GET['item'])? $_GET['item'] : 0;	
	$action	= isset($_GET['action'])? $_GET['action'] : 0;
	$p_val = 'none';
	$s_mess = $s_val = $p_save = '';	
	
	foreach ( lets_define_booking_layouts() as $val ) {		
		$bt[] =  $val['dashname'];			
		if ($dashno == $val['dash'] && $tabno == $val['tab']){				
			$s_mess = $val['updatemess'];
			$s_val = $val['values'];
			if ($val['posttype']){
				$p_val = $val['posttype'];
			}
			$p_save = $val['savetype'];
		}		
		if ($dashno == $val['dash']){				
			$bg[] =  $val['tabname'];	
		}
	}
	
	$br = array_unique($bt);
	$bs = array_values($br);	
	$bh = array_unique($bg);
	$bi = array_values($bh);	
	$crob_setupval = array(
		'dash' => $dashno,
		'tab' => $tabno,
		'item' => $itemno,
		'action' => $action,
		'base_url' => 'admin.php?page=cromares',
		'mainmen' => $br,
		'dashname' => strtoupper($bs[$dashno]) . ' ' .  __('DASHBOARD', 'localize'),
		'update_mess' => $s_mess,
		'secmen' => $bi,
		'values' => $s_val,
		'ptype' => $p_val,
		'savetype' => $p_save
	);	
	return $crob_setupval;	
}



/* 
 * -01- DEFAULT BOOKING SETTINGS
 * */
function cro_book_init() {
	$settings = get_option( "bookset" );
	$settings = array();
	if ( empty( $settings ) ) {		
		foreach ( lets_define_booking_layouts() as $val ){			
			foreach ($val['values'] as $vs) {
				if (isset($vs['def'])  && $vs['def']) {
					$settings[$vs['fn']] = $vs['def'];
				}
			}						
		}
		add_option( "bookset", $settings, '');
	}
}



?>