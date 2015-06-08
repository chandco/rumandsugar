<?php
/**
 * Structure for processing the video inserts
 */ 
   
/********** Code Index
 *
 * -01- ADD MENU DESCRIPTIONS
 * 
 */




/* 
 * -04- ADD MENU DESCRIPTIONS
 * */


class cro_Walker extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		if (strlen($item->description)>2) {
			$item_output .= '<a'. $attributes .'><span class="main">';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
      		$item_output .= '</span><span class="sub">' . $item->description . '</span></a>';
		} else {
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
     		$item_output .= '</a>';
		}
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}


function cro_custom_walker( $args ) {
    return array_merge( $args, array(
        'walker' => new cro_Walker(),
    ) );
}
add_filter( 'wp_nav_menu_args', 'cro_custom_walker' );

 
?>