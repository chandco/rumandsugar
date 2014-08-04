<?php
/**
 * The team shortcodes
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


function cro_video_func( $atts ) {
	global $post;
	$op = '';

    extract( shortcode_atts( array(
        'no' => 'catnumber'
    ), $atts ) );


    if ($no != '') {

        $tturi = cro_identifyvideo($no, 0);


        if (isset($tturi['frame']) && $tturi['frame']) {
            $op .= '<div class="flex-video widescreen vimeo">';
            $op .= $tturi['frame'];
            $op .= '</div>';
        }
    	
    } 

   

    return $op;
}
add_shortcode( 'cro_video', 'cro_video_func' );
?>