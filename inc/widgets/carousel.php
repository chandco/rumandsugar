<?php
/**
 * The carousel widget
 *
 */
 
 
 
class tli_carousel extends WP_Widget {

	
	public function __construct() {
		parent::__construct(
	 		'tli-carousel', // Base ID
			'Image link &nbsp;&nbsp;&nbsp;&nbsp;[C]', // Name
			array( 'description' => __( 'Link to a page with an image', 'localize' ), ) // Args
		);
	}


	// WIDGET OUTPUT
	public function widget( $args, $instance ) {
		$tlset = get_option( 'tlset' );
		extract( $args );
		
		$title 			= apply_filters('widget_title', $instance['title']);		
		$carouselselect = $instance['carouselselect'];	
		$chlabl 		= $instance['label'];
		$chnewlink 		= $instance['newlink'];

		$page_data = get_page($carouselselect);


		echo $before_widget;


		if($page_data && $page_data->post_status == 'publish'){ 

			$cimg 	= get_the_post_thumbnail( $carouselselect, 'banner', '');


			if (!$cimg) {
				$cimg  =  '<img src="' . get_template_directory_uri() . '/public/styles/images/imgcommingsoon2.jpg">';
			}

			if (isset($chnewlink) && $chnewlink){
				$chref = cro_fix_url(esc_url($chnewlink));
			} else {
				$chref	= get_permalink($carouselselect);	
			}
		
			$mphot = strtolower($title);
		
			echo '<div class="crslinside">' . $cimg;
			echo '<div class="clartitle cro_accent">' . $title . '</div>';
			if (isset($chlabl) && $chlabl){
				echo '<div class="clarlabel"><a href="' . $chref  .   '" class="cro_accent">' .  $chlabl  . '</a></div>';
			}
			echo '</div>';
				
		}

		echo $after_widget;
	}
	
	
	

	// WIDGET VALUES UPDATE
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['carouselselect'] = strip_tags( $new_instance['carouselselect'] );
		$instance['label'] = strip_tags( $new_instance['label'] );
		$instance['newlink'] = strip_tags( $new_instance['newlink'] );

		return $instance;
	}

	
	// WIDGET FORM
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ]) && isset( $instance[ 'carouselselect' ]) && isset( $instance[ 'label' ])  && isset( $instance[ 'newlink' ]) ) {
			$title 			= $instance[ 'title' ];
			$carouselselect = $instance[ 'carouselselect' ];
			$label 			= $instance[ 'label' ];
			$newlink 		= $instance[ 'newlink' ];
		}
		else {
			$title 			= __( 'New title', 'localize' );
			$carouselselect = '';
			$label 			= '';
			$newlink 		= '';
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
				'type'		=> 'carouselselect',
				'labelfor' 	=> $this->get_field_id( 'carouselselect' ),
				'label'		=> __('Carousel Item','localize'),
				'id'		=> $this->get_field_id( 'carouselselect' ),
				'idname'	=> $this->get_field_name( 'carouselselect' ),
				'val'		=> esc_attr( $carouselselect ),
				'desc'		=> '',
				'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
				'type'		=> 'input',
				'labelfor' 	=> $this->get_field_id( 'label' ),
				'label'		=> __('Label','localize'),
				'id'		=> $this->get_field_id( 'label' ),
				'idname'	=> $this->get_field_name( 'label' ),
				'val'		=> esc_attr( $label ),
				'desc'		=> __('Add a label (keep it short) or leave open not to have a label','localize'),
				'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
				'type'		=> 'input',
				'labelfor' 	=> $this->get_field_id( 'newlink' ),
				'label'		=> __('Link hi-jack','localize'),
				'id'		=> $this->get_field_id( 'newlink' ),
				'idname'	=> $this->get_field_name( 'newlink' ),
				'val'		=> esc_attr( $newlink ),
				'desc'		=> __('Add an alternative address to redirect when the visitor click (leave open to direct to the post)','localize'),
				'options'	=> ''
		);
		echo cro_make_widget_formpart($args);
	}

} // class Foo_Widget


add_action( 'widgets_init', create_function( '', 'register_widget( "tli_carousel" );' ) );
 

 
?>