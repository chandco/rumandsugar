<?php
/**
 * The template for displaying Comments.
 *
 *
 */


/********** Code Index
 *
 * -01- ABORT IF POST IS PASSWORD PROTECTED
 * -02- MAIN PART
 * -03- COMMENT LIST
 * -04- COMMENT FORM
 * 
 */


/**
 * -01- ABORT IF POST IS PASSWORD PROTECTED
 */ 
if ( post_password_required() )
	return;
?>


<!--
 * -02- MAIN PART
-->	
<div id="comments" class="comments-area">


	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title cro_accent">
			<?php
				printf( _n( 'Replies for %2$s', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'localize' ),
					number_format_i18n( get_comments_number() ), '<span>&ldquo;' . get_the_title() . '&rdquo;</span>' );
			?>
		</h2>


<!--
 * -03- COMMENT LIST
-->	
		<ul class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'cro_comment', 'style' => 'ul' ) ); ?>
		</ul>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'localize' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'localize' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'localize' ) ); ?></div>
		</nav>
		<?php endif;  ?>

		<?php
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'localize' ); ?></p>
		<?php endif; ?>

	<?php endif;  ?>



<!--
 * -04- COMMENT FORM
-->	
	<?php comment_form(); ?>

</div>