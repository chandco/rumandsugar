<?php


add_action("wp_enqueue_scripts", "enqueueRSCSS");

function enqueueRSCSS() {
	wp_enqueue_style( 'rs-child', get_stylesheet_directory_uri() . "/style.css", 'croma_font');
}

?>