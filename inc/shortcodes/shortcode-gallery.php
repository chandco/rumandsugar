<?php
/**
 * The gallery shortcodes
 *
 */
 

 /********** Code Index
 *
 * -01- ADD A TEAM
 * 
 */


 /**
 * -01- ADD A TEAM  [team no="category number"]
 */ 


function cro_gallist_func( $atts ) {
	global $post;
	$op = '';
	$pid = get_post_meta($post->ID, 'cro_sidebar', true);

	$pcat = ($pid == 1) ? 'cro_col_3' : 'cro_col_4' ;

	$op .= '<ul class="' .    $pcat . ' cro_gallerylist">';

    extract( shortcode_atts( array(
        'no' => 'catnumber'
    ), $atts ) );

     $term = get_term( $no, 'photobook');

    if ($no >=1) {
    	$catargs = array( 
    		'post_type' => 'galleries', 
    		'numberposts' => -1, 
    		'photobook' => $term->slug
    	); 
    } else {
    	$catargs = array( 
    		'post_type' => 'galleries', 
    		'numberposts' => -1, 
    	);   	
    }

    $myposts = get_posts( $catargs );

	foreach( $myposts as $apost ) :	setup_postdata($apost);

	$op .= '<li class="widget-container"><div class="imgouter galholderski">'  .   get_the_post_thumbnail($apost->ID,'banner');

	$op .= '<h5 class="cro_accent cro_galtitle">' . $apost->post_title . '</h5>';


    $op .= get_gallery_data($apost->ID, $apost->post_content);


	$op .= '<span class="cro_galoverlay ">&nbsp;</span></div></li>';
	
	endforeach; 

	$op .= '</ul>';

    return $op;
}
add_shortcode( 'cro_gallery', 'cro_gallist_func' );
?>