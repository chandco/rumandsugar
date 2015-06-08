<?php
/**
 * The template for displaying posts in the Gallery Post Format on index and archive pages
 *
 */
?>


<?php
	$tlset = get_option( 'tlset' );

?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-title">
		<h2 class="entry-title cro_accent">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'localize' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>

		
	</div>

	<?php if ( is_search() || is_category() || is_front_page() || is_tag() || is_front_page() || is_home() || is_archive()) : // Only display Excerpts for search pages ?>
		<div class="entry-summary">
			<div class="cro_formquote">
			<?php 
				the_excerpt(); 
				$do_button = get_post_meta($post->ID,  'cro_readmore', true);
			?>
			</div>
			<?php the_tags('<div class="tagspan"><span>Tagged with:</span> ',' • ','</div>'); ?>
			<div class="summarymeta clearfix">
				<?php if ($do_button == 1) { ?>
					<p class="cro_readmorep cro_accent"><a href="<?php the_permalink() ?>" class="cro_readmorea"><?php _e('Read more','localize'); ?></a></p>
				<?php } ?>
				<div class="entry-meta">	
					<?php if ( comments_open() ) : ?>
					<div class="comments-link">
						<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'localize' ) . '</span>', __( '1 Reply', 'localize' ), __( '% Replies', 'localize' ) ); ?>
					</div><!-- .comments-link -->
				<?php endif; // comments_open() ?>		
				</div>
				<div class="summarydate">
					<?php echo get_the_date( get_option('date_format')); ?> 
				</div>
			</div>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php if ( post_password_required() ) : ?>
				<?php the_content(); ?>

			<?php else : ?>
			<?php the_content(); ?>
		<?php endif; ?>
		
	</div><!-- .entry-content -->
	<?php endif; ?>

</div>
