<?php
/*
 * CROMA ADMIN FRAMEWORK HELPER FUNCTIONS
 */



/********** Code Index
 *
 * -01- CONFIGURE SAVETYPE BASED ON TYPE OF PAGE SHOWN
 * -02- MAIN PAGE UPDATE FUNCTION
 * -03- SIDEBAR CREATOR SAVE FUNCTION
 * -04- CONVERT OBJECT TO AN ARRAY
 * -05- SAVE FUNCTION FOR POST TYPES.
 * -06- UPDATE MESSAGE GENERATOR
 * -07- GET THE POSTARRAY
 * -08- ADD A NEW POST
 * 
 */



/**
 * -01- CONFIGURE SAVETYPE BASED ON TYPE OF PAGE SHOWN
 */ 
function cro_fetch_updateaction($tab, $dash, $item, $action, $url, $savetype, $posttype, $values){		
	switch ($savetype) {
		case 'optionsave':			
			cro_save_the_elements($values);	
			$op = $url . '&tab=' . $tab . '&dash=' . $dash . '&item=0&action=' . $action . '&updated=true';									
		break;
		case 'postsave':					
			ntl_save_the_post($item, $values, $posttype);	
			$op = $url . '&tab=' . $tab . '&dash=' . $dash . '&item=' . $item . '&action=' . $action . '&updated=true';									
		break;
		case 'keyvalsave':					
			cro_save_the_sidebars();	
			$op = $url . '&tab=' . $tab . '&dash=' . $dash . '&item=' . $item . '&action=' . $action . '&updated=true';									
		break;											
	}	
	return $op;	
}





/**
 * -02- MAIN PAGE UPDATE FUNCTION
 */ 
function cro_save_the_elements($values) {
	
	$settings = get_option( "tlset" );	
	foreach ( $values as $field ) {
		
		if ($field['fn'] && isset($_POST[$field['fn']])) {
			if ($field['type'] == 'textarea') {
				$settings[$field['fn']] = esc_textarea($_POST[$field['fn']]);
			} else {
				$settings[$field['fn']] = esc_attr($_POST[$field['fn']]);
			}
		}					
	}	
	$updated = update_option( "tlset", $settings );		
	return;	
}



/**
 * -03- SIDEBAR CREATOR SAVE FUNCTION
 */ 
function cro_save_the_sidebars() {
	
	$notaskey = array('crosubmit', 'crotab', 'crodash', 'croitem', 'croaction', 'Submit', '_wp_http_referer', '_wpnonce');
	
	$setsidearr = array();
			
	foreach ($_POST as $key => $value) {
		
		if (!in_array($key, $notaskey)){
			
			$setsidearr[] = array(
			'code' => $key,
			'name' => esc_attr($value)			
			);			
		}
  	}
	
	$updated = update_option( "cro_sbar", $setsidearr );			
	return;	
}



/**
 * -04- CONVERT OBJECT TO AN ARRAY
 */ 
function cro_admin_objtoA($d) {
	if (is_object($d)) {
		$d = get_object_vars($d);
	}
 
	if (is_array($d)) {
		return array_map(__FUNCTION__, $d);
	}
	else {
		return $d;
	}
}


/**
 * -05- SAVE FUNCTION FOR POST TYPES.
 */ 
function ntl_save_the_post($item, $values, $posttype) {
	
	$post_id = $item;	
	if ($item == 0) {
		$post_ids = cro_get_postarray($posttype);	
		$post_id = $post_ids[0];
	}
	
	foreach($values as $args){
		if ($args['fn'] && isset($_POST[$args['fn']]) && $args['type'] != 'getlogo') {
			if ($args['fn'] == 'textarea') {
				update_post_meta($post_id, $args['fn'], esc_textarea($_POST[$args['fn']]));
			} else {
				update_post_meta($post_id, $args['fn'], esc_attr($_POST[$args['fn']]));
			}
		}				
	}		
	return;	
}



/**
 * -06- UPDATE MESSAGE GENERATOR
 */ 
function tli_fetch_updatemess($dashno, $tabno, $itemno, $action){
	
	foreach ( lets_define_admin_layouts() as $field ) {
		
		// render the fields
		if ($field[tab] == $tabno && $field[dash] == $dashno && $field[action] == $action){			
			$op  = $field[updatemess];			
		}
	}	
	return $op;	
}




/**
 * -07- GET THE POSTARRAY
 */ 
function cro_get_postarray($posttype) {
	$op = array();
	
	$myargs = array('post_type'=>$posttype,'showposts'=> 10000, 'orderby' => 'meta_value_num', 'meta_key' => 'post_order', 'order' => 'ASC');	
	
	
	$my_newquery = new WP_Query($myargs);
	
	
	if ($my_newquery->have_posts()) : while ($my_newquery->have_posts()) : $my_newquery->the_post();
	
	$op[] =  get_the_ID();
	
	endwhile;
	else : endif;
	wp_reset_query();
	
	return $op;
}




/**
 * -08- ADD A NEW POST
 */ 

function cro_add_a_post($postname, $posttype){
		
	$post_id = wp_insert_post( array(
		'post_type' => $posttype,
		'post_status' => 'publish',
		'comment_status' => 'closed',
		'post_content' => '',
		'post_title' => $postname,
		'post_author' => '1'
	) );
	
	update_post_meta($post_id, 'post_order', 0);	
	$op = cro_get_postarray($posttype);
	
	foreach ($op as $list) {		
		$meta_values = get_post_meta($post_id, 'post_order', true);		
		update_post_meta($post_id, 'post_order', $meta_values++);
	}

	return $post_id;
}





?>