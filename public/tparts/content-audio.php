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

		<div class="entry-meta">
		<?php if ( comments_open() ) : ?>
				<div class="comments-link">
					<?php comments_popup_link( '<span class="leave-reply">' . __( '0', 'localize' ) . '</span>', __( '1', 'localize' ), __( '%', 'localize' ) ); ?>
				</div><!-- .comments-link -->
			<?php endif; // comments_open() ?>				
		</div>
		
	</div>

	<?php
		$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'audio/mpeg', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
		if ( $images ) :
			$total_images = count( $images );
			$image = array_shift( $images );
			$aud_url= wp_get_attachment_url($image->ID );
	?>



		<audio controls="controls" preload="none" class="mejs-player " data-mejsoptions='{"features":["playpause","current","progress","duration","volume","tracks","fullscreen"],"audioWidth":540,"audioHeight":30}'><br />
			<source src="<?php echo $aud_url; ?>" type="audio/mp3" /><br />
			<object width="400" height="30" type="application/x-shockwave-flash" data="<?php echo get_template_directory_uri(); ?>/inc/scripts/flashmediaelement.swf">
			<param name="movie" value="<?php echo get_template_directory_uri(); ?>/inc/scripts/flashmediaelement.swf" />
			<param name="flashvars" value="controls=true&amp;file=<?php echo $aud_url; ?>" />			
		</object>
		
		</audio>
	<?php endif; ?>

	<?php if ( is_search() || is_category() || is_front_page() || is_tag() || is_front_page() || is_home() || is_archive()) : // Only display Excerpts for search pages ?>
		<div class="entry-summary">
			<?php 

				the_excerpt(); 
				$do_button = get_post_meta($post->ID,  'cro_readmore', true);
			?>
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
			<?php the_excerpt(); ?>
		<?php else : ?>			
			<?php the_content(); ?>
		<?php endif; ?>		
	</div><!-- .entry-content -->
	<?php endif; ?>
</div>
