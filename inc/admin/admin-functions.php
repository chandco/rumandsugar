<?php
/*
 * Croma admin framework
 */


/********** Code Index
 *
 * -01- INITIALIZE ADMIN MENU
 * -02- REGISTER SCRIPTS
 * -03- ADMIN AJAX FUNCTION
 * -04- VALUES ARRAY
 * -05- SAVE THEME DEFAULT SETTINGS ON INITIALIZE
 * 
 */


/**
 * -01- INITIALIZE ADMIN MENU
 */ 
add_action( 'admin_menu', 'cro_init' );
add_action( 'init', 'cro_admin_init' );

function cro_init() {
	$cro_s_page = add_menu_page(
		__('Croma.Dash', 'localize'), 
		__('Croma.Dash', 'localize'), 
		'manage_options','cromadash', 
		'cro_page', 
		get_template_directory_uri() .'/inc/admin/images/ticon.png',
		3
	);
	
	add_action( "load-{$cro_s_page}", 'cro_spage' );	
	add_action( 'admin_print_styles-' . $cro_s_page, 'cro_scripts' );
}




/**
 * -02- REGISTER SCRIPTS
 */ 
function cro_scripts() {
    wp_enqueue_script( 'cro_c_scripts', get_template_directory_uri() . '/inc/scripts/adminapp.js', array('jquery','media-upload','thickbox','jquery-ui-sortable','wp-color-picker') );
}

function cro_enqueue_style( $hook_suffix ) {
	 wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style('thickbox');
	wp_enqueue_style( 'cro-options', get_template_directory_uri() . '/inc/admin/admin-style.css', false, '2012-08-01' );
}
add_action( 'admin_print_styles-toplevel_page_cromadash', 'cro_enqueue_style' );



/**
 * -03- ADMIN AJAX FUNCTION
 */ 
add_action('wp_ajax_cro_post_action', 'cro_ajax_callback');
function cro_ajax_callback() {
	global $wpdb; 
	$save_type = $_POST['type'];

	if ($save_type == 'update_order'){
		$id = $_POST['idees'];
		$arr_id = explode('/',$id);
		$arr_cnt = count($arr_id);
		for ($i = 1; $i <= $arr_cnt; $i++) {
			$b = $i - 1;
			update_post_meta($arr_id[$b], 'post_order',$i);
		}
		exit;
	}			
}


/**
 * -03- VALUES ARRAY
 */ 
function cro_setup_admin_data(){
	
	global $cro_setupval;
    unset($cro_setupval);
	$bt = array();	
	$dashno	= isset($_GET['dash'])? $_GET['dash'] : 0;	
	$tabno	= isset($_GET['tab'])? $_GET['tab'] : 0;
	$itemno	= isset($_GET['item'])? $_GET['item'] : 0;	
	$action	= isset($_GET['action'])? $_GET['action'] : 0;
	$p_val = 'none';
	$s_mess = $s_val = $p_save = '';	
	
	foreach ( lets_define_admin_layouts() as $val ) {		
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
	
	$cro_setupval = array(
		'dash' => $dashno,
		'tab' => $tabno,
		'item' => $itemno,
		'action' => $action,
		'base_url' => 'admin.php?page=cromadash',
		'mainmen' => $br,
		'dashname' => strtoupper($bs[$dashno]) . ' ' .  __('DASHBOARD', 'localize'),
		'update_mess' => $s_mess,
		'secmen' => $bi,
		'values' => $s_val,
		'ptype' => $p_val,
		'savetype' => $p_save
	);
	
	return $cro_setupval;	
}


/**
 * -05- SAVE THEME DEFAULT SETTINGS ON INITIALIZE
 */ 
function cro_admin_init() {
	$settings = get_option( "tlset" );
	$settings = array();
	if ( empty( $settings ) ) {
		
		foreach ( lets_define_admin_layouts() as $val ){			
			foreach ($val['values'] as $vs) {
				if (isset($vs['def'])  && $vs['def']) {
					$settings[$vs['fn']] = $vs['def'];
				}
			}						
		}
		add_option( "tlset", $settings, '');
	} elseif ($settings['guesttype'] == '') {
		$settings['guesttype'] = 1;
		update_option('tlset',$settings);
	}
}

?>