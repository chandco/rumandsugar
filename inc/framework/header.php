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

	<style type="text/css">

	.cro_formquote, .cromacol11 .mejs-container, .widget_tli-newsletter .newssubmit, 
	.comments-area li.comment .comment-meta,.comments-area input#submit, h5.cro_bynone, .cro_timewithimage, 
	h6.cro_promodate, .cro_drivedirections a,.cro_bookingsform table tbody td.daynum span.daynumber:hover, 
	.cro_bookingsform .cro_isselected, ul.sociallinks li:hover,.cro_themecallout, 
	.comments-area li.comment .reply a:hover, .footer .widget_cro_twitter{
		background: <?php echo $cro_col; ?>;
	}

	.widget_tli-newsletter .newssubmit, .caldiv .daynum span.thisday, .agendadate, .cro_stickwrap, .pagination span,
	ul.cro_directionscal li input#driveclick:hover,.cro_bookingsform .cro_bookingformsub:hover, 
	.secondnav ul li a, .cro_fpc:hover .fptitles h3, .mejs-container,.cro_caldayholder, .clarlabel:hover a, 
	form#ctcform input#cro_form_sub:hover, .secondnav ul li a:hover, .widget_cro_twitter, .footer .widget_search input#searchsubmit{
		background: <?php echo $cro_col; ?>;
	}

	 .cromacol11 .caldiv .daynum span.daybox:hover{
 		border: 4px solid <?php echo $cro_col; ?>;
 	}

 	ul.accordion > li.active {
    	border-top: 3px solid <?php echo $cro_col; ?> !important;
	}

	a, .footer ul.footwidget li h3.widget-title,  #access .current_page_item > a,#access .current_page_ancestor > a,
	#access ul  li:hover > a, .entry-title h2 a:hover, .comments-area h2.comments-title span,
	.caldiv .daynum span span.daynumber,.prevm:hover, .nextm:hover, .cromacol11 ul.ctclabels li.ctcclearside h4, 
	form#ctcform h4, .bannerprevious:hover, .bannernext:hover{
		color: <?php echo $cro_col; ?>;
	}

	ul.maincal li.daynum span.numbdesc a:hover, .quickiemenu span.quickieprice{
		color: <?php echo $cro_col; ?> !important;
	}

	#access ul li ul li:hover > a{
		border-right: 5px solid <?php echo $cro_col; ?> !important;
	}

	<?php /* Stop the below from happening
	<?php if (0){ //($tlset['cro_font'] && $tlset['cro_font'] != '') { ?>
		.cro_accent, h3.widget-title, #access a, .cro_headerspace .cro_title h1, .secondnav ul li a, 
		.cro_formquote p,h3#reply-title, ul.calday li, ul.calhead li, .cro_timewithimage, span.cro_foodprice, 
		h5.mainstayhead, h5.mastheadh,form#ctcform input#cro_form_sub, .cro_drivedirections a, tr.calhead, 
		.cro_bookingsform table tbody tr td.dayname,.cro_caldayholder span.month, .cro_caldayholder span.day, 
		.hentry h1, .hentry h2, .hentry h3, .hentry h4, .hentry h5, .hentry h6, .cro_fpc .slidelinkspan a,
		.cro_eventinfoholder a{
			font-family: <?php echo $tlset['cro_font']; ?>, cursive; font-weight: normal !important;
		}	
	<?php } */ ?>

	</style>
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
	wp_register_script( 'action-app', get_template_directory_uri() . '/inc/scripts/app.js', array('jquery'), '1.0', true );
	wp_localize_script( 'action-app', 'cro_query', $presets);        
	wp_enqueue_script( 'cro_nav' );
	wp_enqueue_script( 'mediaelement' );
	wp_enqueue_script( 'strap-foundation' );
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