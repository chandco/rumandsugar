<?php
/**
 * The template for displaying category pages.
 *
 *
 */
  

get_header(); 

$tlset = get_option( 'tlset' );

?>


<!--
 * 02- GET HEADERIMAGE
-->					
<?php echo cro_fetch_slider(); ?>

<div class="carouselspaceholder">&nbsp;</div>

<!--
 * 03- MAIN PART
-->	
	<div class="main singleitem">				
		<div class="row singlepage" style="padding-top: 50px;">
			<div class="eight column">

				<?php 
					while ( have_posts() ) : the_post();
					get_template_part( 'public/tparts/content', get_post_format() ); 
					endwhile; 
				?>

				<?php cro_paging(); ?>
			</div>

			<div class="four column">
				<?php get_sidebar(); ?>
			</div>			
		</div>
	</div>


<!--
 * 03- FOOTER
-->	
<?php get_footer(); ?>