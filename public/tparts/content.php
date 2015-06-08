<?php
/**
 * The template for displaying posts in the Gallery Post Format on index and archive pages
 *
 */
?>


<?php
	$tlset = get_option( 'tlset' );

?>

<div id="post-<?php the_ID(); ?>" <?php post_class('featured-image-post'); ?>>
	
	<?php if ( is_search() || is_category() || is_front_page() || is_tag() || is_front_page() || is_home() || is_archive()) : // Only display Excerpts for search pages ?>
	<div class="entry-title"> 
		<h2 class="entry-title cro_accent">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'localize' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>		
	</div>
	<?php endif; ?>
	

	<?php if ( is_search() || is_category() || is_front_page() || is_tag() || is_front_page() || is_home() || is_archive()) : // Only display Excerpts for search pages ?>


		<?php	//$op =  get_the_post_thumbnail( get_the_ID(), 'full' ); 
			  $op =  the_post_thumbnail('featured-image'); ?> 

			 <?php
			
			if ($op) {
				echo '<a href="' . get_permalink(get_the_ID())  . '" title="' .  $post->post_title   .    '">';
				echo $op;
				echo '</a>';
			} 			
		?>

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
				<?php the_post_thumbnail('featured-image'); ?> <!--singular featured image for a post-->
					<?php if ( post_password_required() ) : ?>
						<?php the_excerpt(); ?>

					<?php else : ?>
					<?php the_content(); ?>
				<?php endif; ?>	
	</div>
	<?php endif; ?>

</div>
