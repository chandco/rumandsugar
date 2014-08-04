<?php
/**
 * The calendar shortcodes
 *
 */
 

 /********** Code Index
 *
 * -01- ADD A CALENDAR
 * 
 */


 /**
 * -01- ADD A CALENDAR  
 */ 


function cro_promos_func( $atts ) {

    $op = '';

    extract( shortcode_atts( array(
        'no' => 'catnumber'
    ), $atts ) );

    switch ($no) {
 
        case 0:
        $op .=  fetch_front_promos('shortcode');  
        break;  
    }


    return $op;
}
add_shortcode( 'cro_promo', 'cro_promos_func' );
?>