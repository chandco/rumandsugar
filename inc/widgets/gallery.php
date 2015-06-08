<?php
/**
 * The gallery widget
 *
 */
 
 
 
class cro_gallery extends WP_Widget {

	
	public function __construct() {
		parent::__construct(
	 		'cro_gallery', // Base ID
			'Gallery widget  &nbsp; &nbsp;&nbsp; [C]', // Name
			array( 'description' => __( 'Croma gallery widget', 'localize' ), ) // Args
		);
	}


	// WIDGET OUTPUT
	public function widget( $args, $instance ) {


		extract( $args );		

		$randomstring = cro_randstring(4);
		$title = $instance[ 'title' ];
		$number = $instance[ 'number' ];
		$desc = $instance[ 'description' ];
		$scrp = '';
		$pimg = '';

		$cntr = 1;


		echo $before_widget;

		echo '<div id="gal'  .   $randomstring  .  '" class="galholderski" rel="'  .   $randomstring  .  '">';

		$pimg =  get_the_post_thumbnail($number,'fc1');
		
		if ($pimg == '') {
			$images = get_children( array( 'post_parent' => $number , 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
				
			foreach ( $images as $attachment_id => $attachment ) {

				$mid = wp_get_attachment_image_src( $attachment_id, 'fc1');
				if ($cntr <= 1) {
					echo  '<img src="' . $mid[0]  . '">';
				}
				$cntr++;
			}
		} else{
			echo $pimg;
		}

		$galclass = ($desc == '') ? 'cro_nodesc' : '' ;

		echo '<span class="cro_galoverlay ' . $galclass  .   '">';

		if ($desc) {
			echo '<span class="cro_galdesc cro_accent">' .  $desc . '</span>';
		}


		echo '</span>';
		echo '</div>';

		$page_object = get_page($number);

		echo get_gallery_data($number,$page_object->post_content);

		echo $after_widget;
				
	}
	
	
	

	// WIDGET VALUES UPDATE
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['description'] = esc_attr( $new_instance['description'] );
		return $instance;
	}

	
	// WIDGET FORM
	public function form( $instance ) {

		if (isset($instance[ 'title' ]) || isset($instance[ 'number' ]) || isset($instance[ 'description' ])){
			$title = $instance[ 'title' ];
			$number = $instance[ 'number' ];
			$desc = $instance[ 'description' ];

		} else {
			
			$title = '';
			$number = '';
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
			'type'		=> 'selectbox',
			'labelfor' 	=> $this->get_field_id( 'number' ),
			'label'		=> __('Select Gallery','localize'),
			'id'		=> $this->get_field_id( 'number' ),
			'idname'	=> $this->get_field_name( 'number' ),
			'val'		=> esc_attr( $number ),
			'options'	=> array('galleries')
		);
		echo cro_make_widget_formpart($args);	

		$args = array(
			'type'		=> 'textarea',
			'labelfor' 	=> $this->get_field_id( 'description' ),
			'label'		=> __('Gallery description:','localize'),
			'id'		=> $this->get_field_id( 'description' ),
			'idname'	=> $this->get_field_name( 'description' ),
			'val'		=> esc_attr( $desc ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);
	}

} // class Foo_Widget


add_action( 'widgets_init', create_function( '', 'register_widget( "cro_gallery" );' ) );
 

 
?>