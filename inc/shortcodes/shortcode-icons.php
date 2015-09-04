<?php

add_shortcode('icon', 'icon_shortcode');

function icon_shortcode( $atts, $content = null ) 
{
    if( isset( $atts['style'] ) )
    {
       return "<div class='{$atts['style']}'></div>";
    }  
}


