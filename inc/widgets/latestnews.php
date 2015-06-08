<?php
/**
 * The carousel widget
 *
 */
 
 
 
class tli_latestnews extends WP_Widget {

	
	public function __construct() {
		parent::__construct(
	 		'tli-latestnews', // Base ID
			'Latest News &nbsp;&nbsp;&nbsp;&nbsp;[C]', // Name
			array( 'description' => __( 'A widget for displaying latest news', 'localize' ), ) // Args
		);
	}


	// WIDGET OUTPUT
	public function widget( $args, $instance ) {
		$tlset = get_option( 'tlset' );
		extract( $args );
		
		$title 			= apply_filters('widget_title', $instance['title']);
		$events 		= esc_attr($instance['events']);
		$cats 			= esc_attr($instance['cats']);


		$events = (!$events || !is_numeric($events)) ? 3 : $events;


		echo $before_widget;
		if ( ! empty( $title ) )
		echo $before_title . $title . $after_title;

		if ($cats == 0) {
			$args = array( 'numberposts' => $events);
		} else {
			$args = array( 'numberposts' => $events, 'category'    => $cats);
		}
		$latestnewsposts = get_posts( $args );
		foreach( $latestnewsposts as $post ) :	setup_postdata($post); 


		$theimg = get_the_post_thumbnail($post->ID,'thumbnail');

		echo '<div class="singlep">';


		if ($theimg) {
			echo '<a href="' .  get_permalink($post->ID) .  '">';
			echo $theimg;
			echo '</a>';
		}


		echo '<h6 class="cro_accent"><a href="' .  get_permalink($post->ID) .  '">' .   $post->post_title   .  '</a></h6>';
		echo '<p>' . cro_excerpt(8) . '</p>';



		echo '<div class="clearfix"></div></div>';

		endforeach; 
		
		echo $after_widget;
	}
	
	
	

	// WIDGET VALUES UPDATE
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['events'] = esc_attr($new_instance['events']);
		$instance['cats'] = esc_attr($new_instance['cats']);

		return $instance;
	}

	
	// WIDGET FORM
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ]) || isset( $instance[ 'events' ])  || isset( $instance[ 'cats' ])   ) {
			$title 			= $instance[ 'title' ];
			$events 		= $instance[ 'events' ];
			$cats 			= $instance[ 'cats' ];
		}
		else {
			$title 			= __( 'New title', 'localize' );
			$events			= 3;
			$cats 			= 0;
		}


		$args = array(
				'type'		=> 'input',
				'labelfor' 	=> $this->get_field_id( 'title' ),
				'label'		=> __('Title','localize'),
				'id'		=> $this->get_field_id( 'title' ),
				'idname'	=> $this->get_field_name( 'title' ),
				'val'		=> esc_attr( $title ),
				'desc'		=> '',
				'options'	=> ''
		);

		echo cro_make_widget_formpart($args);

		$args = array(
				'type'		=> 'input',
				'labelfor' 	=> $this->get_field_id( 'events' ),
				'label'		=> __('Number of posts','localize'),
				'id'		=> $this->get_field_id( 'events' ),
				'idname'	=> $this->get_field_name( 'events' ),
				'val'		=> esc_attr( $events ),
				'desc'		=> '',
				'options'	=> ''
		);
		echo cro_make_widget_formpart($args);


		$args = array(
				'type'		=> 'get_cats',
				'labelfor' 	=> $this->get_field_id( 'cats' ),
				'label'		=> __('Category to show','localize'),
				'id'		=> $this->get_field_id( 'cats' ),
				'idname'	=> $this->get_field_name( 'cats' ),
				'val'		=> esc_attr( $cats ),
				'desc'		=> '',
				'options'	=> ''
		);
		echo cro_make_widget_formpart($args);


	}

} // class Foo_Widget


add_action( 'widgets_init', create_function( '', 'register_widget( "tli_latestnews" );' ) );
 

 
?>