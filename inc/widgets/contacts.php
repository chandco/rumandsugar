<?php
/**
 * The contacts
 *
 */
 
 
 
class cro_contacts extends WP_Widget {

	
	public function __construct() {
		parent::__construct(
	 		'cro_contacts', // Base ID
			'Contacts &nbsp;&nbsp;&nbsp;&nbsp;[C]', // Name
			array( 'description' => __( 'A widget for displaying contacts', 'localize' ), ) // Args
		);
	}


	// WIDGET OUTPUT
	public function widget( $args, $instance ) {
		$tlset = get_option( 'tlset' );
		extract( $args );
		$op = '';
		
		$title 			= apply_filters('widget_title', $instance['title']);
		$cats 			= esc_attr($instance['cats']);

		echo $before_widget;
		if ( ! empty( $title ) )
		echo $before_title . $title . $after_title;


		$op .= '<ul class="ctclabels">';



            $p = get_post_meta( $cats , 'cro_operatinghrs' , true );
            if ($p){
                $op .= '<li class="ctclabelside cro_accent">' .  __('Operating hours:','localize') . '</li>';
                $op .= '<li class="ctcinfoside">' .  $p  . '</li>';
                $op .= '<li class="ctcclearside"></li>';
            }

            $p = get_post_meta( $cats , 'cro_streetaddr' , true );
            if ($p){
                $op .= '<li class="ctclabelside  cro_accent">' .  __('Address:','localize') . '</li>';
                $op .= '<li class="ctcinfoside">' .  $p  . '</li>';
                $op .= '<li class="ctcclearside"></li>';
            }

            $p = get_post_meta( $cats , 'cro_telephone' , true );
            if ($p){
                $op .= '<li class="ctclabelside  cro_accent">' .  __('Telephone:','localize') . '</li>';
                $op .= '<li class="ctcinfoside">' .  $p  . '</li>';
                $op .= '<li class="ctcclearside"></li>';
            }

            $p = get_post_meta( $cats , 'cro_fax' , true );
            if ($p){
                $op .= '<li class="ctclabelside  cro_accent">' .  __('Fax:','localize') . '</li>';
                $op .= '<li class="ctcinfoside">' .  $p  . '</li>';
                $op .= '<li class="ctcclearside"></li>';
            }

            $p = get_post_meta( $cats , 'cro_contactmail' , true );
            if ($p){
                $op .= '<li class="ctclabelside  cro_accent">' .  __('Email:','localize') . '</li>';
                $op .= '<li class="ctcinfoside">' .  $p  . '</li>';
                $op .= '<li class="ctcclearside"></li>';
            }

        echo $op;
		
		echo $after_widget;
	}
	
	
	

	// WIDGET VALUES UPDATE
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['cats'] = esc_attr($new_instance['cats']);

		return $instance;
	}

	
	// WIDGET FORM
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ]) || isset( $instance[ 'cats' ])   ) {
			$title 			= $instance[ 'title' ];
			$cats 			= $instance[ 'cats' ];
		}
		else {
			$title 			= __( 'New title', 'localize' );
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
				'type'		=> 'get_location',
				'labelfor' 	=> $this->get_field_id( 'cats' ),
				'label'		=> __('Location to show','localize'),
				'id'		=> $this->get_field_id( 'cats' ),
				'idname'	=> $this->get_field_name( 'cats' ),
				'val'		=> esc_attr( $cats ),
				'desc'		=> '',
				'options'	=> ''
		);
		echo cro_make_widget_formpart($args);


	}

} // class Foo_Widget


add_action( 'widgets_init', create_function( '', 'register_widget( "cro_contacts" );' ) );
 

 
?>