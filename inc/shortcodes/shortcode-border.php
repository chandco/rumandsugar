<?php
add_shortcode('border', 'border_shortcode');

function border_shortcode( $atts, $content = null ) 
{
    if( isset( $atts['style'] ) )
    {
       return "<hr class='{$atts['style']}'/>";
    }  
}

add_shortcode('banner-title', 'banner_title_shortcode');

	function banner_title_shortcode( $atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'title' => 'Nibblesff'
			), $atts);

		return '
		<div class="banner-title">
		<h3>'. $atts['title'] . '</h3>
		</div>';
	}

?>