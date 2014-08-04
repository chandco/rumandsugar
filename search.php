<?php
/**
 * The template for displaying member pages.
 *
 *
 */
 
$tlset = get_option( 'tlset' );
  

get_header(); 

	if (isset($tlset['cro_showbanindex']) && $tlset['cro_showbanindex'] == 1 ){
		$ps =  cro_fetch_banner('inner'); 
	} else {
		$ps =  ''; 
	}
 ?>


				
	<?php 
		$sbar = 1;
		echo cro_headerimg('', 'search',$ps);				
	?>

	<div class="main singleitem">				
		<div class="row singlepage searchpage">
			<div class="eight column">
				<?php 
					while ( have_posts() ) : the_post();
					get_template_part( 'public/tparts/content', 'search' ); 
					endwhile; 
				?>
				<?php cro_paging(); ?>
			</div>

			<div class="four column">
				<?php get_sidebar(); ?>
			</div>			
		</div>
	</div>


<?php get_footer(); ?>