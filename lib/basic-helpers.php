<?php

function oikos_get_attachment_link_filter( $content, $post_id, $size, $permalink ) {
 
    // do this for all attachments
    //if (! $permalink) {
        // This returns an array of (url, width, height)
        $image = wp_get_attachment_image_src( $post_id, 'large' );
        $new_content = preg_replace('/href=\'(.*?)\'/', 'href=\'' . $image[0] . '\' class="mfp-gallery-item" data-fancybox-group=\'articlegallery\' rel=\'lightbox[gallery]\'', $content );
        return $new_content;
    //} else {
		// change attachment page to 
    //    return $content;
    //}
}
 
add_filter('wp_get_attachment_link', 'oikos_get_attachment_link_filter', 10, 4);


function custom_image_media_send_to_editor($html, $attachment_id, $attachment) {
    $attachment_ = wp_get_attachment_image_src( $attachment_id, 'large' );
    $attachment['url'] = $attachment_[0];

    $post =& get_post($attachment_id);
    if ( substr($post->post_mime_type, 0, 5) == 'image' ) {
        $url = $attachment['url'];
        $align = !empty($attachment['align']) ? $attachment['align'] : 'none';
        $size = !empty($attachment['image-size']) ? $attachment['image-size'] : 'medium';
        $alt = !empty($attachment['image_alt']) ? $attachment['image_alt'] : '';
        $rel = ( $url == get_attachment_link($attachment_id) );

        return get_image_send_to_editor($attachment_id, $attachment['post_excerpt'], $attachment['post_title'], $align, $url, $rel, $size, $alt);
    }

    return $html;
}
add_filter('media_send_to_editor', 'custom_image_media_send_to_editor', 11, 3);

add_filter('widget_text', 'do_shortcode');

?>