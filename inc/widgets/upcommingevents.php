<?php
/**
 * The carousel widget
 *
 */
 
 
 
class tli_upevents extends WP_Widget {

	
	public function __construct() {
		parent::__construct(
	 		'tli-upevents', // Base ID
			'Upcomming Events &nbsp;&nbsp;&nbsp;&nbsp;[C]', // Name
			array( 'description' => __( 'A widget for displaying upcoming events', 'localize' ), ) // Args
		);
	}


	// WIDGET OUTPUT
	public function widget( $args, $instance ) {
		$tlset = get_option( 'tlset' );
		extract( $args );
		
		$title 			= apply_filters('widget_title', $instance['title']);
		$events 		= esc_attr($instance['events']);


		$$events = ($events <= 1) ? 3 : $events ;
		$evarr = get_upcomming_arr($events);

		echo $before_widget;
		if ( ! empty( $title ) )
		echo $before_title . $title . $after_title;

		echo create_upcomming_events($evarr, $events);		
		
		echo $after_widget;
	}
	
	
	

	// WIDGET VALUES UPDATE
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['events'] = esc_attr($new_instance['events']);

		return $instance;
	}

	
	// WIDGET FORM
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ]) || isset( $instance[ 'events' ])) {
			$title 			= $instance[ 'title' ];
			$events 		= $instance[ 'events' ];
		}
		else {
			$title 			= __( 'New title', 'localize' );
			$events			= __( 0, 'localize' );
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
				'label'		=> __('Number of events','localize'),
				'id'		=> $this->get_field_id( 'events' ),
				'idname'	=> $this->get_field_name( 'events' ),
				'val'		=> esc_attr( $events ),
				'desc'		=> '',
				'options'	=> ''
		);
		echo cro_make_widget_formpart($args);


	}

} // class Foo_Widget


add_action( 'widgets_init', create_function( '', 'register_widget( "tli_upevents" );' ) );
 

 
?>