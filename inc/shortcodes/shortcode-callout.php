<?php
/**
 * The callout shortcodes
 *
 */
 




 /**
 * -01- ADD A TEAM 
 */ 


function cro_callout_func( $atts ) {
	global $post;
	$op = '';

    extract( shortcode_atts( array(
        'text'  => 'text',
        'layout'  => 'layout',
        'color' => 'color'
    ), $atts ) );


      switch ($color) {
        case "1":
           $stylesettings = '';
           $stylesclass = 'cro_themecallout';
        break;

        case '#FBFBFB':

          $stylesettings = 'color: #3A3A3A  ;   background: ' . $color  . ' ;';
          $stylesclass = '';

        break;

        case '#3A3A3A':
           $stylesettings = 'color: #fff  ;   background: ' . $color  . ' ;';
           $stylesclass = '';

        break;


        case '#52BFD3':
           $stylesettings = 'color: #fff  ;   background: ' . $color  . ' ;';
           $stylesclass = '';

        break;

        case '#E9510E':
           $stylesettings = 'color: #fff  ;   background: ' . $color  . ' ;';
            $stylesclass = '';           

        break;

        case '#886D64':
           $stylesettings = 'color: #fff  ;   background: ' . $color  . ' ;';
           $stylesclass = '';

        break;

        case '#FFDA07':
           $stylesettings = 'color: #fff  ;   background: ' . $color  . ' ;';
           $stylesclass = '';

        break;

        case '#DC042B':
           $stylesettings = 'color: #fff  ;   background: ' . $color  . ' ;';
           $stylesclass = '';

        break;

        case '#EB5777':
           $stylesettings = 'color: #fff  ;   background: ' . $color  . ' ;';
           $stylesclass = '';

        break;

        case '#CCCE01':
           $stylesettings = 'color: #fff  ;   background: ' . $color  . ' ;';
           $stylesclass = '';

        break;

        case '#BA265B':
           $stylesettings = 'color: #fff  ;   background: ' . $color  . ' ;';
           $stylesclass = '';

        break;

        case '#891C09':
           $stylesettings = 'color: #fff  ;   background: ' . $color  . ' ;';
           $stylesclass = '';

        break;
        

      }


       $op .= '<div class="cro_callout cro_callout_layout-' . $layout . ' ' . $stylesclass   . ' cro_accent" style="' .  $stylesettings  . '">';

       $op .= $text;

       $op .= '</div>';

   

    return $op;
}
add_shortcode( 'cro_callout', 'cro_callout_func' );
?>