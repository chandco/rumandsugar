<?php
/**
 * php controller file for custom post types
 *
 */
 

add_action('init', 'mla_create_types');


function mla_create_types() {
	foreach (  mla_cpt() as $field ) {	
		$labels = array(
    		'name' => $field['plural'],
    		'singular_name' => ucfirst($field['singular']),
    		'add_new' => __('Add ','localize') . ucfirst($field['singular']),
    		'add_new_item' => __('Add new ','localize') . ucfirst($field['singular']),
    		'edit_item' => __('Edit ','localize') . ucfirst($field['singular']),
    		'new_item' => __('New ','localize') . ucfirst($field['singular']),
    		'view_item' => __('View ','localize') . ucfirst($field['singular']),
    		'search_items' => __('Search ','localize') . ucfirst($field['singular']),
    		'not_found' =>  __('No ','localize') . ucfirst($field['singular']) , __(' found','localize'),
    		'not_found_in_trash' => __('No ','localize') . ucfirst($field['singular']) , __(' found in trash','localize'), 
    		'parent_item_colon' => ''
  		);
  		
  		$args = array(
    		'labels' => $labels, 
    		'description' => $field['description'],
    		'menu_icon' => get_template_directory_uri() . '/public/styles/images/' . $field['singular'] . '.png',
    		'public' => true,  
			'show_ui' => true, 		
			'publicly_queryable' => true,		
			'exclude_from_search' => $field['exclude-search'], 
			'show_in_nav_menus' => $field['show_nav'], 
			'can_export' => true, 
			'hierarchical' => true, 
			'show_in_menu' => $field['show_men'], 
  			'menu_position' => $field['menu_position'],
			'supports' => $field['supports'],	
    		'query_var' => true,
    		'rewrite' => true,
    		'capability_type' => 'post', 
    		'has_archive' => 'true'
  		); 	 		
  		register_post_type($field['plural'],$args);
	}
}


add_filter('post_updated_messages', 'lets_make_messages');
function lets_make_messages( $messages ) {
	global $post, $post_ID, $netlabs_post_types; 
	foreach ( mla_cpt() as $field ) {	
  		$messages[$field['plural']] = array(
    		0 => '', 
    		1 => ucfirst($field['singular']) . __(' updated.','localize'),
    		2 => __('Custom field updated.' ,'localize'),
    		3 => __('Custom field deleted.', 'localize'),
    		4 => ucfirst($field['singular']) . __(' updated.', 'localize'),
    		5 => __('Restored ot Revision.', 'localize'),
    		6 => ucfirst($field['singular']) . __(' published','localize'),
    		7 => ucfirst($field['singular']) . __(' saved.','localize'),
    		8 => ucfirst($field['singular']) . __(' submitted.','localize'),
    		9 => ucfirst($field['singular']) . __(' scheduled','localize'),
    		10 => ucfirst($field['singular']) . __(' draft updated.','localize')
  		); 		
  		return $messages;	
	}
}


// hook into the init action and call create_book_taxonomies() when it fires
add_action( 'init', 'lets_create_taxonomies', 0 );


function lets_create_taxonomies() {

	foreach (  mla_cpt() as $field ) {	
	
		if ($field['make_categories'] == true) {
	
			$labels = array(
				'name' => ucfirst($field['cat_names']),
				'singular_name' => ucfirst($field['cat_names'])  . __(' category','localize'),
				'search_items' =>  __( 'Search ','localize') . ucfirst($field['cat_names']),
				'all_items' => __( 'All ','localize') . ucfirst($field['cat_names']),
				'parent_item' => __( 'Parent ','localize') . ucfirst($field['cat_names']),
				'parent_item_colon' => __( 'Parent ','localize') . ucfirst($field['cat_names']),
				'edit_item' => __( 'Edit ','localize') . ucfirst($field['cat_names']),
				'update_item' => __( 'Update ','localize') . ucfirst($field['cat_names']),
				'add_new_item' => __( 'Add new ','localize') . ucfirst($field['cat_names']),
				'new_item_name' => __( 'New ','localize') . ucfirst($field['cat_names'])
			);
		
			register_taxonomy( $field['cat_names'], array( $field['plural'] ), array(
				'hierarchical' => true,
				'labels' => $labels, /* NOTICE: Here is where the $labels variable is used */
				'show_ui' => true,
				'query_var' => true,
				'show_in_nav_menus' => false
			));

		}
	}
}
 


?>