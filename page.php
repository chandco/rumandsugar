<?php
/**
 * The template for displaying pages.
 *
 *
 * 
 */
 
$tlset = get_option( 'tlset' );
  

get_header(); 

	
		$ps =  ''; 
	

?>

				
	<?php while ( have_posts() ) : the_post();
		$sbar = get_post_meta($post->ID, 'cro_sidebar', true);



		echo cro_headerimg($post->ID, 'page', $ps);			
	?>

	<div class="main clipboard-outer">				
		<div class="row clipboard-inner">


			<?php if ($sbar == 1) { ?>


				<div class="eight column">
					<?php get_template_part( 'public/tparts/content', 'page' ); ?>
				</div>

				<div class="four column">
					<?php get_sidebar(); ?>
				</div>



			<?php } else { ?>

				<div class="twelve column">
					<?php get_template_part( 'public/tparts/content', 'page' ); ?>
				</div>

			<?php } ?>
			
		</div>
	</div>

	<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>