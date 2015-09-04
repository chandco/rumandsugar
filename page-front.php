<?php
/**
 * The main template file.
 *
 * Template Name: Front page
 */
 
  $tlset = get_option( 'tlset' );

  get_header();  
  
   
/********** Code Index
 *
 * -01- FETCH SLIDESHOW
 * -02- MAIN PART		
 */

?>


<!--
 * -01- FETCH SLIDESHOW
-->
<?php

// get attachments from database
	$imageArgs = array(
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'numberposts' => null,
			'post_status' => null,
			'orderby' => 'menu_order',
			'posts_per_page'=>-1
		);

		global $post; 
		$imageArgs['post_parent'] = ($atts["page"]) ? $atts["page"] : get_the_ID();

		$images = get_posts($imageArgs);

  
  if ($images) { 




?>
    <div class="slider cro_sldr">
        <div class="flexslider fullscreenslider content">  
            
                <?php    
                foreach($images as $image) {

                	$big_output = wp_get_attachment_image_src( $image->ID, 'sshow' );
									$big_output = current($big_output);

                    ?>
                    <div>
                    	<div class="imgdiv"  style="background-image: url(<?= $big_output ?>);  no-repeat center top">&nbsp;</div>
                    	<div class="content">
                    		<div class="row slidecontents">
                    			<div class="slidecontentcontents slidecontentcontentsr cro_animatethis">
                    				<div class="cro_slidesinners">
                    					<h1 class="cro_accent"><?= $image->post_title ?></h1>
                    					<p class="cro_accent"><?= $image->post_excerpt ?></p>
                    				</div>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                    <?php
                }
                ?>
            
        </div>
    </div><!-- end slider -->


<?php } ?>




<!--
 * -02- MAIN PART
-->
<div class="main clipboard-outer" >
	<div class="row clipboard-inner">				
		
	<?php the_content(); ?>


	</div>
</div>







			
<?php get_footer(); ?>
