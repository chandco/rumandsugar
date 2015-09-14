<?php
/**
 * The template for displaying category pages.
 *
 *
 */
  

get_header(); 
$tlset = get_option( 'tlset' );

	if (isset($tlset['cro_showbanindex']) && $tlset['cro_showbanindex'] == 1 ){
		$ps =  '';//cro_fetch_banner('inner'); 
	} else {
		$ps =  ''; 
	}

?>


<!--
 * 02- GET HEADERIMAGE
-->					
<?php echo cro_headerimg('', 'blog', $ps);?>

<div class="carouselspaceholder">&nbsp;</div>

<!--
 * 03- MAIN PART
-->	
	<div class="main clipboard-outer">				
		<div class="row clipboard-inner">
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
	</div></div>

<!--
 * 03- FOOTER
-->	
<?php get_footer(); ?>