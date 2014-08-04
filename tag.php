<?php
/**
 * The template for displaying category pages.
 *
 *
 */
  


/********** Code Index
 *
 * -01- GET HEADER
 * -02- GET HEADERIMAGE
 * -03- MAIN PART
 * -04- GET FOOTER
 * 
 */


/**
 * -01- GET HEADER
 */ 
get_header(); 

	if (isset($tlset['cro_showbanindex']) && $tlset['cro_showbanindex'] == 1 ){
		$ps =  cro_fetch_banner('inner'); 
	} else {
		$ps =  ''; 
	}


?>


<!--
 * 02- GET HEADERIMAGE
-->					
<?php echo cro_headerimg('', 'tag',$ps);?>

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