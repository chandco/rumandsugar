<?php
/**
 * The carousel widget
 *
 */
 
 
 
class cro_video extends WP_Widget {

	
	public function __construct() {
		parent::__construct(
	 		'cro_video', // Base ID
			'Video &nbsp;&nbsp;&nbsp;&nbsp;[C]', // Name
			array( 'description' => __( 'Croma video widget', 'localize' ), ) // Args
		);
	}


	// WIDGET OUTPUT
	public function widget( $args, $instance ) {


		extract( $args );		

		$video = $instance[ 'video' ];
		if (isset($instance[ 'ids' ])) {
			$id = $instance[ 'ids' ];
		}
		$thumb = $instance[ 'thumb' ];
		$frame = $instance[ 'frame' ];
		$desc = $instance[ 'description' ];

		

		echo $before_widget;


		$randomstring = cro_randstring(4);


		$galclass = ($desc == '') ? 'cro_nodesc' : '' ;

		echo '<div style="position: relative;"><img src="' . $thumb . '"><div class="playerbutdiv videodiv ' . $galclass  . '" rel="' .  $randomstring .   '">&nbsp;</div>';

		if ($desc) {
			echo '<div class="cro_videodesc cro_accent">' .  $desc  .   '</div>';
		}

		$vidframe = '</div><div class="myModal reveal-modal large" rel="' . $randomstring  .  '"><div class="flex-video vimeo widescreen">';
		$vidframe .= $frame;
		$vidframe .= '</div><a class="close-reveal-modal">&#215;</a>';


		echo $after_widget;

		echo $vidframe;
				
	}
	
	
	

	// WIDGET VALUES UPDATE
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['video'] = esc_attr( $new_instance['video'] );
		$instance['ids'] = esc_attr( $new_instance['ids'] );
		$instance['thumb'] = esc_attr( $new_instance['thumb'] );
		$instance['frame'] = esc_attr( $new_instance['frame'] );
		$instance['description'] = esc_attr( $new_instance['description'] );
		$tturi = cro_identifyvideo($instance['video'], $instance['ids']);	
		if ($tturi != '' && isset($tturi)) {
			$instance['ids'] = $tturi['ids'];
			$instance['thumb'] = $tturi['thumb'];
			$instance['frame'] = $tturi['frame'];
		}
		return $instance;
	}

	
	// WIDGET FORM
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) || isset( $instance[ 'video' ]) || isset( $instance[ 'id' ] ) || isset( $instance[ 'thumb' ])  || isset( $instance[ 'frame' ] )  || isset( $instance[ 'description' ] )) {
			$title = $instance[ 'title' ];
			$video = $instance[ 'video' ];
			$desc = $instance[ 'description' ];
			$ids = $instance[ 'ids' ];
			$thumb = $instance[ 'thumb' ];
			$frame = $instance[ 'frame' ];
		}
		else {
			$title = __( 'New title', 'localize' );
			$video = '';
			$ids = '';
			$thumb = '';
			$frame = '';
			$desc = '';
		}

		$args = array(
			'type'		=> 'input',
			'labelfor' 	=> $this->get_field_id( 'title' ),
			'label'		=> __('Title','localize'),
			'id'		=> $this->get_field_id( 'title' ),
			'idname'	=> $this->get_field_name( 'title' ),
			'val'		=> esc_attr( $title ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
			'type'		=> 'input',
			'labelfor' 	=> $this->get_field_id( 'video' ),
			'label'		=> __('Video link:','localize'),
			'id'		=> $this->get_field_id( 'video' ),
			'idname'	=> $this->get_field_name( 'video' ),
			'val'		=> esc_attr( $video ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);


		$args = array(
			'type'		=> 'textarea',
			'labelfor' 	=> $this->get_field_id( 'description' ),
			'label'		=> __('Video description:','localize'),
			'id'		=> $this->get_field_id( 'description' ),
			'idname'	=> $this->get_field_name( 'description' ),
			'val'		=> esc_attr( $desc ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
			'type'		=> 'hidden',
			'labelfor' 	=> $this->get_field_id( 'ids' ),
			'label'		=> '',
			'id'		=> $this->get_field_id( 'ids' ),
			'idname'	=> $this->get_field_name( 'ids' ),
			'val'		=> esc_attr( $ids ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
			'type'		=> 'hidden',
			'labelfor' 	=> $this->get_field_id( 'thumb' ),
			'label'		=> '',
			'id'		=> $this->get_field_id( 'thumb' ),
			'idname'	=> $this->get_field_name( 'thumb' ),
			'val'		=> esc_attr( $thumb ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
			'type'		=> 'hidden',
			'labelfor' 	=> $this->get_field_id( 'frame' ),
			'label'		=> '',
			'id'		=> $this->get_field_id( 'frame' ),
			'idname'	=> $this->get_field_name( 'frame' ),
			'val'		=> esc_attr( $frame ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);
	}

} // class Foo_Widget


add_action( 'widgets_init', create_function( '', 'register_widget( "cro_video" );' ) );
 

 
?>