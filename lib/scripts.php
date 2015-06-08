<?php


function chandco_enqueue_scripts() {


	//wp_enqueue_script( 'magnific-popup', get_stylesheet_directory_uri() . "/js/min/magnific-popup.min.js",  array( 'jquery'), true );
	//wp_enqueue_script( 'chandco-main', get_stylesheet_directory_uri() . "/js/min/main.min.js", array( 'jquery', 'magnific-popup'), true );

	wp_enqueue_script( 'magnific-popup', get_stylesheet_directory_uri() . "/js/min/magnific-popup.min.js",  array( 'jquery'), '0.9.9', true );
	wp_enqueue_script( 'chandco-main', get_stylesheet_directory_uri() . "/js/min/main.min.js", array( 'jquery', 'magnific-popup'), '1', true );
}


add_action( "wp_enqueue_scripts", "chandco_enqueue_scripts");







?>