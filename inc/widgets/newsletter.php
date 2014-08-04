<?php
/**
 * The carousel widget
 *
 */
 
 
 
class tli_newsletter extends WP_Widget {

	
	public function __construct() {
		parent::__construct(
	 		'tli-newsletter', // Base ID
			'Newsletter &nbsp;&nbsp;&nbsp;&nbsp;[C]', // Name
			array( 'description' => __( 'A widget for capturing Newsletter subscriptions', 'localize' ), ) // Args
		);
	}

	// WIDGET OUTPUT
	public function widget( $args, $instance ) {
		$tlset = get_option( 'tlset' );
		extract( $args );
		
		$title 		= apply_filters('widget_title', $instance['title']);
		$message 	= esc_attr(stripslashes($instance['message']));
		$label 		= esc_attr(stripslashes($instance['label']));


		echo $before_widget;
		if ( ! empty( $title ) )
		echo $before_title . $title . $after_title;

		echo 	'<p class="signupinvite">' .  $message  . '</p>
				<form id="newslettersignup" class="clear" post="" action="">
				<p class="newslform">
					<label class="netlabs_newsnamel" for="name">' . __('Name:', 'localize') . '</label>
					<input class="netlabs_newsname reset" id="netlabs_newsname" name="netlabs_newsname" type="text" value="" />
				</p>
				<p class="newslform">
					<label class="netlabs_newsmaill" for="name">'. __('Email:', 'localize') . '</label>
					<input class="netlabs_newsmail reset" id="netlabs_newsmail" name="netlabs_newsmail" type="text" value="" />
				</p>
			<label class="newsloc" for="name">' .  __('Location:', 'localize') . '</label>
			<input class="newsloc" id="netlabs_newsloc" name="netlabs_newsloc" type="text" value="" />
			<div id="valmess">
					<div class="valsuccess">' .  __('Thank you for submitting. Your first newsletter will follow shortly.' , 'localize')   . '</div>
					<div class="valerror">' .  __('there is an error in your submission. Please review your details and resend' , 'localize')   . '</div>
				</div>
			<input class="newssubmit smallfont" type="submit" value="' . $label  . '">
		</form>';

		
		echo $after_widget;
	}
	
	
	

	// WIDGET VALUES UPDATE
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['message'] = esc_attr( stripslashes($new_instance['message']) );
		$instance['label'] = esc_attr( $new_instance['label'] );

		return $instance;
	}

	
	// WIDGET FORM
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ])  || isset( $instance[ 'message' ])   || isset( $instance[ 'label' ]))   {
			$title 			= $instance[ 'title' ];
			$message 		= $instance[ 'message' ];
			$label 			= $instance[ 'label' ];
		}
		else {
			$title 			= __( 'New title', 'localize' );
			$message 		= __( 'Sign up for our newsletter and get the latest news.', 'localize' );
			$label 			= __( 'Submit', 'localize' );
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
				'labelfor' 	=> $this->get_field_id( 'label' ),
				'label'		=> __('Button Label','localize'),
				'id'		=> $this->get_field_id( 'label' ),
				'idname'	=> $this->get_field_name( 'label' ),
				'val'		=> esc_attr( $label),
				'desc'		=> __('label for submit button','localize'),
				'options'	=> ''
		);

		echo cro_make_widget_formpart($args);

		$args = array(
				'type'		=> 'textarea',
				'labelfor' 	=> $this->get_field_id( 'message' ),
				'label'		=> __('Message','localize'),
				'id'		=> $this->get_field_id( 'message' ),
				'idname'	=> $this->get_field_name( 'message' ),
				'val'		=> esc_attr( $message ),
				'desc'		=> __('short lintro message to go with widget', 'localize'),
				'options'	=> ''
		);

		echo cro_make_widget_formpart($args);

	}

} // class Foo_Widget


add_action( 'widgets_init', create_function( '', 'register_widget( "tli_newsletter" );' ) );
 
?>