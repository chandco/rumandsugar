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


function cro_calendar_func( $atts ) {

    $op = '';

    extract( shortcode_atts( array(
        'no' => 'catnumber'
    ), $atts ) );

    switch ($no) {
 
        case 0:
        $op .= '<div class="caldiv">';
        $op .=  fetch_front_calendar('', '', '', '', '');  
        $op .= '</div>'; 
        break;  

        case 2:
        $op .= '<div class="cro_agendadiv">';
        $op .=  fetch_front_agenda('', '', '', '', '');  
        $op .= '</div>'; 
        break; 

        case 1:
        $op .= '<div class="cro_agendadiv">';
        $op .=  fetch_upc_agenda('', '', '', '', '');  
        $op .= '</div>'; 
        break;      

    }


    return $op;


}
add_shortcode( 'cro_calendar', 'cro_calendar_func' );
?>