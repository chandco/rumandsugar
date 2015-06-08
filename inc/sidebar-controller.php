<?php
/**
 * The file handling sidebars and custom sidebars
 *
 */
 
 
function tli_sidebars() {

	$msidebars = get_option('cro_sbar');
 
	$sidebarsarray = array(
						array(
							'class' => 'cro_sidebarmain',
							'name' => __('Main Sidebar','localize')
						),
						array(
							'class' => 'trifronttop',
							'name' => __('Front Page left','localize')
						),
						array(
							'class' => 'tcifronttop',
							'name' => __('Front Page center','localize')
						),
						array(
							'class' => 'tlifronttop',
							'name' => __('Front Page right','localize')
						),
						array(
							'class' => 'cro_footleft',
							'name' => __('Footer left','localize')
						),
						array(
							'class' => 'cro_footcent',
							'name' => __('Footer center','localize')
						),
						array(
							'class' => 'cro_footright',
							'name' => __('Footer right','localize')
						)
						
					);
						
	
	foreach($sidebarsarray as $val) {		
		register_sidebar( array(
			'name' => $val['name'],
			'id' => $val['class'],
			'before_widget' => '<li id="%1$s" class="widget-container %2$s clear">',
			'after_widget' => '</li>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			) 
		);
	}

	if (isset($msidebars) && $msidebars){

		foreach($msidebars as $crov) {		
		register_sidebar( array(
			'name' => $crov['name'],
			'id' => 'cro_' . sanitize_title($crov['name']),
			'before_widget' => '<li id="%1$s" class="widget-container %2$s clear">',
			'after_widget' => '</li>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			) 
		);
	}

	}					
}

add_action( 'widgets_init', 'tli_sidebars' );
 
?>