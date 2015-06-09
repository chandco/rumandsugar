<?php
add_shortcode('border', 'border_shortcode');

function border_shortcode( $atts, $content = null ) 
{
    if( isset( $atts['style'] ) )
    {
       return "<hr class='{$atts['style']}'/>";
    }  
}

?>