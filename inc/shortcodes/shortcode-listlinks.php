<?php
/**
 * The team shortcodes
 *
 */
 

 /********** Code Index
 *
 * -01- ADD A TEAM
 * 
 */


 /**
 * -01- ADD A TEAM  [team no="category number"]
 */ 



 function cro_post_top_ancestor_id(){
    global $post;
    
    if($post->post_parent){
        $ancestors = array_reverse(get_post_ancestors($post->ID));
        return $ancestors[0];
    }
    
    return $post->ID;
}


function cro_parent_links( $atts ) {
	global $post;
	$op = '';

    $op .= '<ul class="parentlinks">';

    wp_list_pages( array('title_li'=>'','include'=>get_post_top_ancestor_id()) );

    wp_list_pages( array('title_li'=>'','depth'=>1,'child_of'=>get_post_top_ancestor_id()) );

    $op .= '</ul>';
      

    return $op;
}
add_shortcode( 'cro_parentlinks', 'cro_parent_links' );
?>