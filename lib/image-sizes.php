<?php

add_theme_support( 'post-thumbnails' );
//featured image
add_image_size('featured-image', 630, 400, true); 






// function insert_fill_width_image($html, $id, $caption, $title, $align, $url, $size) {
    
//     // this should probably be a bit more dynamic but then it's linked to the editor add sizes below so, it's okay for now.
    

// 			if ($size == 'full' || $size == 'large')
// 			{
// 				// this should not be medium - it should be 'featured image' or wahtever would be full width on a blog
// 				$html = wp_get_attachment_image( $id, 'medium' );
// 			}

// 		return $html;
    
 
// }
// add_filter('image_send_to_editor', 'insert_fill_width_image', 10, 9);



// add_filter( 'image_size_names_choose', 'cf_custom_image_sizes' );

// function cf_custom_image_sizes( $sizes ) {

// 	//global $imagesizes;


// 	$tomerge = array();
// 	$tomerge['gallery-thumb'] = __("Gallery Thumbnail");

//     return array_merge( $sizes, $tomerge );
// }
