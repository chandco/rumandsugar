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


function cro_half_start() {
    $op = '';  
    $op .= '<div class="six column">';
   
    return $op;
}
add_shortcode( 'cro_halves_layoutstart', 'cro_half_start' );


function cro_half_mid() {
    $op = '';  
    $op .= '</div><div class="six column">';
   
    return $op;
}
add_shortcode( 'cro_halves_layoutmid', 'cro_half_mid' );


function cro_half_end() {
    $op = '';  
    $op .= '</div><span class="clearfix"> </span>'; 
    return $op;
}
add_shortcode( 'cro_layoutend', 'cro_half_end' );


function cro_thirds_firstthird_f() {
    $op = '';  
    $op .= '<div class="four column">';
   
    return $op;
}
add_shortcode( 'cro_thirds_firstthird', 'cro_thirds_firstthird_f' );


function cro_thirds_secondthird_f() {
    $op = '';  
    $op .= '</div><div class="four column">';
   
    return $op;
}
add_shortcode( 'cro_thirds_secondthird', 'cro_thirds_secondthird_f' );


function cro_thirds_third_third_f() {
    $op = '';  
    $op .= '</div><div class="four column">';
   
    return $op;
}
add_shortcode( 'cro_thirds_third-third', 'cro_thirds_third_third_f' );


function cro_thirds_twothirds_f() {
    $op = '';  
    $op .= '<div class="eight column">';
   
    return $op;
}
add_shortcode( 'cro_thirds_twothirds', 'cro_thirds_twothirds_f' );


function cro_thirds_onethird_f() {
    $op = '';  
    $op .= '</div><div class="four column">';
   
    return $op;
}
add_shortcode( 'cro_thirds_onethird', 'cro_thirds_onethird_f' );


function cro_thirds_onethirds_f() {
    $op = '';  
    $op .= '<div class="four column">';
   
    return $op;
}
add_shortcode( 'cro_thirds_onethirds', 'cro_thirds_onethirds_f' );

function cro_thirds_twothird_f() {
    $op = '';  
    $op .= '</div><div class="eight column">';
   
    return $op;
}
add_shortcode( 'cro_thirds_twothird', 'cro_thirds_twothird_f' );


function cro_quarters_firstquarter_f() {
    $op = '';  
    $op .= '<div class="three column">';
   
    return $op;
}
add_shortcode( 'cro_quarters_firstquarter', 'cro_quarters_firstquarter_f' );


function cro_quarters_secondquarter_f() {
    $op = '';  
    $op .= '</div><div class="three column">';
   
    return $op;
}
add_shortcode( 'cro_quarters_secondquarter', 'cro_quarters_secondquarter_f' );

function cro_quarters_thirdquarter_f() {
    $op = '';  
    $op .= '</div><div class="three column">';
   
    return $op;
}
add_shortcode( 'cro_quarters_thirdquarter', 'cro_quarters_thirdquarter_f' );

function cro_quarters_fourthquarter_f() {
    $op = '';  
    $op .= '</div><div class="three column">';
   
    return $op;
}
add_shortcode( 'cro_quarters_fourthquarter', 'cro_quarters_fourthquarter_f' );


function cro_quarters_firsthalf_f() {
    $op = '';  
    $op .= '<div class="six column">';
   
    return $op;
}
add_shortcode( 'cro_quarters_firsthalf', 'cro_quarters_firsthalf_f' );


function cro_quarters_half_firstquarter_f() {
    $op = '';  
    $op .= '</div><div class="three column">';
   
    return $op;
}
add_shortcode( 'cro_quarters_half-firstquarter', 'cro_quarters_half_firstquarter_f' );


function cro_quarters_half_secondquarter_f() {
    $op = '';  
    $op .= '</div><div class="three column">';
   
    return $op;
}
add_shortcode( 'cro_quarters_half_secondquarter', 'cro_quarters_half_secondquarter_f' );


function cro_quarters_half_firstquarters_f() {
    $op = '';  
    $op .= '<div class="three column">';
   
    return $op;
}
add_shortcode( 'cro_quarters_half-firstquarters', 'cro_quarters_half_firstquarters_f' );


function cro_quarters_half_secondquarters_f() {
    $op = '';  
    $op .= '</div><div class="three column">';
   
    return $op;
}
add_shortcode( 'cro_quarters_half_secondquarters', 'cro_quarters_half_secondquarters_f' );


function cro_quarters_lasthalf_f() {
    $op = '';  
    $op .= '</div><div class="six column">';
   
    return $op;
}
add_shortcode( 'cro_quarters_lasthalf', 'cro_quarters_lasthalf_f' );


?>