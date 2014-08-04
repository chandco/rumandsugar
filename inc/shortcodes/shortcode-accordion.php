<?php
/**
 * The accordion shortcodes
 *
 */
 


function cro_accordion_start($atts) {
    extract( shortcode_atts( array(
        'color' => 'color'
    ), $atts ) );

    $op = '';  
    $op .= '<ul class="accordion cro_boxcol-' . $color  . '">';
   
    return $op;
}
add_shortcode( 'cro_accordionstart', 'cro_accordion_start' );

function cro_accordion_end() {
    $op = '';  
    $op .= '</ul>';
   
    return $op;
}
add_shortcode( 'cro_accordionend', 'cro_accordion_end' );


function cro_accordion_content($atts, $content = null) {

     extract( shortcode_atts( array(
        'title' => 'acc_title',
        'item' => 'item',
        'color' => 'color'
    ), $atts ) );

    $op = '<li class="' . $item   . ' cro_bitty">
    <div class="title">
      <h5 class="cro_accent">' . $title . '</h5>
    </div>
    <div class="content">
     ' . $content . ';
    </div>
    </li>';  
   
    return $op;
}
add_shortcode( 'cro_accordionitem', 'cro_accordion_content' );





?>