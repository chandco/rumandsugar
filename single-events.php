<?php
/**
 * The template for displaying member pages.
 *
 *
 */
 
$tlset = get_option( 'tlset' );
  

get_header(); ?>

<?php 
	if (isset($tlset['cro_showbanindex']) && $tlset['cro_showbanindex'] == 1 ){
		$ps =  cro_fetch_banner('inner'); 
	} else {
		$ps =  ''; 
	}

?>


				
	<?php while ( have_posts() ) : the_post();

		$sbar = get_post_meta($post->ID, 'cro_sidebar', true);

		echo cro_headerimg($post->ID, 'event', $ps);				
	?>

	<div class="main singleitem">				
		<div class="row singlepage">


			<?php if ($sbar == 1) { ?>
				<div class="eight column">
					<?php echo  create_a_page_header($post->ID); ?>
					<?php get_template_part( 'public/tparts/content', 'page' ); ?>
				</div>

				<div class="four column">
					<?php get_sidebar(); ?>
				</div>



			<?php } else { ?>

				<div class="twelve column">
					<?php echo  create_a_page_header($post->ID); ?>
					<?php get_template_part( 'public/tparts/content', 'page' ); ?>
				</div>

			<?php } ?>
			
		</div>
	</div>

	<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>