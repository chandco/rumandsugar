<?php
/**
 * Structure for the theme header
 */ 
   
/********** Code Index
 *
 * -01- DOCTYPE STUFF
 * -02- STYLESHEET STUFF
 * -03- HEADER STUFF
 * -04- TITLE STUFF
 * -05- GOOGLE FONT STUFF
 * 
 */
 
 
 
/**
 * -01- DOCTYPE STUFF
 */ 
 
add_action( 'croma_doctype', 'croma_fetch_doctype' );

function croma_fetch_doctype() {     ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes( 'xhtml' ); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<meta name="viewport" content="width=device-width" />

<?php  
}
 
 

 
/**
 * -02- STYLESHEET STUFF
 */ 
 
add_action( 'wp_enqueue_scripts', 'croma_fetch_headerstuff' );

function croma_fetch_headerstuff() {     
	$tlset = get_option( "tlset" );
	$font = str_replace(' ','+',$tlset['cro_font']);
	if (defined('CROCSH') && CROCSH == '1') {
		if (isset($_COOKIE['cro_css']) && isset($_COOKIE['cro_cssb'])){
			$pcol =  $_COOKIE['cro_cssb'] . $_COOKIE['cro_css'];
		}
	}
	wp_enqueue_script( 'rum-sugar-fonts', 'http://fast.fonts.net/jsapi/4c1962f5-fb8b-4f37-a7f3-79c0739273d7.js', false, '1', false );
	wp_enqueue_style('croma_style', get_template_directory_uri() . '/style.css', array(), null, 'all');
	// Add our own custom styyles
	wp_enqueue_style('croma_site', get_template_directory_uri() . '/public/styles/site.css', array(), null, 'all');

	wp_enqueue_style('rum-sugar-style', get_template_directory_uri() . '/css/main.css', array(), null, 'all');
	//if ($font && $font != '') {
	//	wp_enqueue_style('croma_font', 'http://fonts.googleapis.com/css?family=' . $font, array(), null, 'all');  
	//} 

	$cro_col = $tlset['cro_themecolor'];

	?>


	<?php 
	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script( 'jquery' );
}
 
 



/* 
 * -01- REGISTER AND ENQUEUE JQUERY
 * */

add_action( 'wp_enqueue_scripts', 'tli_jqlinks' );

function tli_jqlinks() {
	$vals = array(
		'ajaxurl' => urldecode(admin_url( 'admin-ajax.php')),
		'cro_nonces' => wp_create_nonce( 'cro_ajax_functions')
	);

	$presets = array_merge(create_slides_javascript(), $vals);

	wp_register_script( 'cro_nav', get_template_directory_uri() . '/inc/scripts/cro_nav.js', array('jquery'), '1.0', false );
	wp_register_script( 'mediaelement', get_template_directory_uri() . '/inc/scripts/mediaelement-and-player.min.js', array('jquery'), '1.0', true );
	wp_register_script( 'strap-foundation', get_template_directory_uri() . '/inc/scripts/foundation.min.js', array('jquery'), '3.0', true );
	wp_register_script( 'image-paper-corner', get_template_directory_uri() . '/inc/scripts/image-paper-corner.js', array('jquery'), '3.0', true );
	wp_register_script( 'action-app', get_template_directory_uri() . '/inc/scripts/app.js', array('jquery'), '1.0', true );
	wp_localize_script( 'action-app', 'cro_query', $presets);        
	wp_enqueue_script( 'cro_nav' );
	wp_enqueue_script( 'mediaelement' );
	wp_enqueue_script( 'strap-foundation' );
	wp_enqueue_script( 'image-paper-corner' );
	wp_enqueue_script( 'action-app' );
	
}

 
 
/**
 * -04- TITLE STUFF
 */ 
add_filter('wp_title', 'croma_title' , 10, 2);

function croma_title( $the_title, $sep = '', $sep_location = '', $postid = '' ){
global $post, $wp_query;

// SINGLE OR POST
if ( is_singular() ) {
	$the_title =  $post->post_title.' - '.get_bloginfo('name');
	
	
// CATEGORY OR TAXONOMY
} else if ( is_category() || is_tag() || is_tax()) {
	$term = $wp_query->get_queried_object();
	$the_title = ucfirst($term->name) . ' - ' . get_bloginfo('name') .' - '.get_bloginfo('description');
  
 
// FRONT OR INDEXPAGE
} elseif  ( is_home() || is_front_page() ) {
	$the_title = get_bloginfo('name').' - '.get_bloginfo('description');

  
// SEARCH PAGE
} elseif ( is_search() ) { 
	$the_title = __('Search results for', 'localize') . ' ' .  get_search_query() . ' - ' . $blog_name;

	
// 404 PAGE
} elseif ( is_404() ) {
	$the_title = __('Not Found', 'localize') . ' '.get_bloginfo('name'); 
   


// NON OF THE ABOVE
} else {
   $the_title =  get_bloginfo('name') .' - '.get_bloginfo('description');
}


return esc_html( stripslashes( trim( $the_title ) ) );
}
 

 /**
 * -05- GOOGLE FONT STUFF
 */ 

function get_mapstack() { 
	global $wp_query;    
	$tlset = get_option( "tlset" );
	$font = '"' . $tlset['cro_font'] . '"';
	$mapstack = false;
	$op = '';


	if (is_page() || is_single()) { 
		if (isset($tlset['cro_maparray'])){
			$prim =  $wp_query->post->ID;
			if (in_array($prim, $tlset['cro_maparray'])){
				$mapstack = true;
			}
		}
	}

	if ($mapstack) { 
		$op .= '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>';	
	}

	return $op;
}
 

 
?>