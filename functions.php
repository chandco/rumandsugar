<?php

/**
 * functions and definitions
 */


/********** Code Index
 *
 * -01- SET UP FUNCTION
 * -02- NAV MENU ADD HOMEPAGE
 * -03- COMMENTS FUNCTION
 * 
 */



/**
 * -01- SET UP FUNCTION
 */ 
add_action( 'after_setup_theme', 'cro_setup' );

if ( ! function_exists( 'cro_setup' ) ):
function cro_setup() {
	load_theme_textdomain( 'localize', get_template_directory() . '/languages' );

	require( get_template_directory() . '/inc/custom-functions.php' );
	require( get_template_directory() . '/inc/font-list.php' );
	require( get_template_directory() . '/inc/sidebar-controller.php' );
	require( get_template_directory() . '/inc/widgets/widget-helper.php' );
	require( get_template_directory() . '/inc/widgets/carousel.php' );
	require( get_template_directory() . '/inc/widgets/twitter.php' );
	require( get_template_directory() . '/inc/widgets/video.php' );
	require( get_template_directory() . '/inc/widgets/gallery.php' );
	require( get_template_directory() . '/inc/widgets/contacts.php' );
	require( get_template_directory() . '/inc/widgets/upcommingevents.php' );
	require( get_template_directory() . '/inc/widgets/newsletter.php' );
	require( get_template_directory() . '/inc/widgets/latestnews.php' );
	require( get_template_directory() . '/inc/admin/admin-functions.php' );
	require( get_template_directory() . '/inc/meta-boxes/cpt-init.php' );
	require( get_template_directory() . '/inc/apps/cal-func.php' );
	require( get_template_directory() . '/inc/apps/promo-func.php' );
	require( get_template_directory() . '/inc/framework/bookings/book-functions.php' );
	require( get_template_directory() . '/inc/framework/header.php' );
	require( get_template_directory() . '/inc/framework/menus.php' );
	require( get_template_directory() . '/inc/framework/ajax.php' );
	require( get_template_directory() . '/inc/framework/footer.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-functions.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-team.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-gallery.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-calendar.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-video.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-menu.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-layout.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-contact.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-promos.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-callout.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-button.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-accordion.php' );
	require( get_template_directory() . '/inc/shortcodes/shortcode-icons.php' );
	require( get_template_directory() . '/inc/admin/page-controller.php');
	require( get_template_directory() . '/inc/admin/page-parts.php');
	require( get_template_directory() . '/inc/admin/admin-helpers.php');
	require( get_template_directory() . '/inc/admin/formbuilder.php');
	require( get_template_directory() . '/inc/admin/webfonts.php');
	require( get_template_directory() . '/inc/framework/bookings/book-controller.php' );
	require( get_template_directory() . '/inc/framework/bookings/book-parts.php' );
	require( get_template_directory() . '/inc/framework/bookings/bookbuilder.php' );
	require( get_template_directory() . '/inc/meta-boxes/cpt-functions.php' );
	require( get_template_directory() . '/inc/meta-boxes/cpt-builder.php' );
	require( get_template_directory() . '/inc/meta-boxes/cpt-tax.php' );
	require( get_template_directory() . '/public/style-functions.php' );
	require( get_template_directory() . '/public/admin/content.php' );
	require( get_template_directory() . '/public/meta-boxes/cpt-init.php' );
	require( get_template_directory() . '/public/meta-boxes/content.php' );
	require( get_template_directory() . '/public/meta-boxes/content-tax.php' );
	require( get_template_directory() . '/public/framework/images.php' );
	require( get_template_directory() . '/public/framework/calendar.php' );
	require( get_template_directory() . '/public/framework/newsletters.php' );
	require( get_template_directory() . '/public/framework/banner.php' );
	require( get_template_directory() . '/public/app/bookingform.php' );
	require( get_template_directory() . '/public/app/content.php' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support('custom-background');

	add_editor_style();

	$cust_args = array(
		'width'         => 2000,
		'height'        => 480
	);
	add_theme_support( 'custom-header', $cust_args);


	register_nav_menu( 'primary', __( 'Primary Menu', 'localize' ) );
	register_nav_menu( 'secondnav', __( 'Primary sub menu', 'localize' ) );


	add_theme_support( 'post-formats', array( 'quote', 'audio', 'video' ) );


	if ( ! isset( $content_width ) ) $content_width = 900;

	
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'small-feature', 500, 300 );
	add_image_size( 'carousel1', 300, 200, true);
	add_image_size( 'banner', 400, 270, true);
	add_image_size( 'fc1', 465, 340, true);
	add_image_size( 'fc2', 465, 170, true);
	add_image_size( 'sshow', 1680, 550, array( 'center', 'top' ) ); // Hard crop left top
}
endif; 




/**
 * -02- NAV MENU ADD HOMEPAGE
 */ 
function cro_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'cro_page_menu_args' );




function cro_show_admin_mess() {
	if (get_option('show_on_front') == 'posts'){

		echo '<div class="error"><p>' .  __('Your frontpage is currently set as a blog.<br/> To change it to look like the demo of the forked theme, you need to create a page, set the front page template as "front page"<br/> You also need to create a blog page.<br/>Lastly you need to set your "frontpage displays" to show the page and the blog page.<br/> You can view a short video on achieving these settings <a target="_blank" href="https://vimeo.com/70324939">here</a>','localize')  . '</p></div>';

	}
}


//Allow Wordpres to upload SVG file format
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/** 
  * Call showAdminMessages() when showing other admin 
  * messages. The message only gets shown in the admin
  * area, but not on the frontend of your WordPress site. 
  */
add_action('admin_notices', 'cro_show_admin_mess'); 



/**
 * -03- COMMENTS FUNCTION
 */ 
if ( ! function_exists( 'cro_comment' ) ) :

function cro_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :

	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'localize' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'localize' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :

		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),

						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'localize' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),

						sprintf( __( '%1$s at %2$s', 'localize' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'localize' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'localize' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'localize' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

 require("lib/functions.php");

?>