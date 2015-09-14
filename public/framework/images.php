<?php
/**
 * THEME SETTINGS AND EXECUTION FOR THE IMAGES
 *
 */

/********** Code Index
 *
 * -01- CREATE THE SETTINGS ARRAY FOR THE SLIDESHOW 
 * -02- SLIDESHOW CODE
 * -03- PAGE HEADER CODE
 */



/* 
 * -01- CREATE THE SETTINGS ARRAY FOR THE SLIDESHOW 
 * 
 * */


function create_slides_javascript() {

	$op = array(
		'cro_slspeed' => '7000',
		'cro_slideanim' => '800'
		);

	$tlset = get_option( "tlset" );

	if (isset($tlset['cro_slidespeed'])) {
		$op['cro_slspeed'] = $tlset['cro_slidespeed'] * 1000;
	}

	return $op;
}






/* 
 * -02- SLIDESHOW CODE
 * 
 * */




 
function cro_fetch_slider() {	
	$cro_ctr = 1;
	$vidframe =  '';
	$str 		= cro_get_postarray('slideshows');
	$tlset 		= get_option( 'tlset' );
	$op 		= '';	
	
	
	foreach ($str as $val) {
		$slidestring	= '';
		$tturi 			= $returninfo = array();
		$sideski 		= 'slidecontentcontents';		
		$timg			= get_the_post_thumbnail( $val, 'full', '');
		$image_url 		= wp_get_attachment_image_src(get_post_thumbnail_id($val),'sshow', true);
		$ttype 			= 1;
		$tttl 			= get_post_meta($val, 'cro_imgtitle', true);
		$tttcnt 		= get_post_meta($val, 'cro_imgcontent', true);
		$returninfo 	= get_post_meta($val, 'vid_info', true);
		$sllink 		= get_post_meta($val, 'ss-pagelink', true);
		$altlink 		= get_post_meta($val, 'cro_altlink', true);
		$linklabel 		= get_post_meta($val, 'cro_linklabel', true);
		$slidelabel 	= ($linklabel) ? $linklabel : __('More Info','localize');
		$altstring		= '<div class="slidelinkspan"><a href="' . $altlink  . '">' .  $slidelabel  .  '</a></div>';
		$slidestring 	= ($sllink && $sllink && $sllink !== 0) ? '<div class="slidelinkspan"><a href="' . get_permalink($sllink)  . '">' .  $slidelabel  .  '</a></div>' : '' ;
		$slidestring	= ($altlink) ? $altstring : $slidestring;
		$initstring 	= ($cro_ctr == 1) ? '<div class="cro_sldr" style="background: url(' .  $image_url[0]  . ') no-repeat center top;"><div class="flexslider"><div id="slides">' : '';

		$op .= $initstring . '<div>';


		if ($timg) {
           $op .= '<div class="imgdiv" style="background: url(' . $image_url[0] . ') no-repeat center top">&nbsp;</div>';
         }
		
		switch ($ttype) {
			
			
			// SMALL BANNER
			case 1:					
				if ($tttl || $tttcnt)	{
					$op .= '<div class="content"><div class="row slidecontents">';
					$op .= '<div class="slidecontentcontents slidecontentcontentsr cro_animatethis"><div class="cro_slidesinners">';
					if ($tttl){
						$op .= '<h1 class="cro_accent" >' . $tttl  .  '</h1>';
					}
					if ($tttcnt){
						$op .= '<p class="cro_accent">' . $tttcnt  .  '</p>';
						$op .= $slidestring;
					}
					$op .= '</div></div></div></div>';
				}		
			break;
			

		}
		
		$op .= '</div>';

		$cro_ctr++;
	}

	if ($op) {
		 $op .=   '</div></div><div class="bannercover"><div class="row">';
		if (isset($tlset['cro_showbanindex']) && $tlset['cro_showbanindex'] == 1) {
 			$op .=  cro_fetch_banner('front');		
		} else {
			$op .= '<div class="six column bannerprocess">&nbsp;</div>';
		}
		if ( has_nav_menu('secondnav' ) ) {
				$op .= wp_nav_menu( array( 'container_class' => 'secondnav', 'theme_location' => 'secondnav', 'echo' => false ) );
		}
		 return $op . '</div></div></div>'   .  $vidframe;
	} else {
		return '<div class="cro_sldr cro_slideinit" style="background: url(' .  get_template_directory_uri()  . '/public/styles/images/slideholder.jpg) no-repeat center top;"><div id="featured" class="ftsl"></div></div>';		
	}
}



/* 
* -03- PAGE HEADER CODE
 * 
 * */


function cro_headerimg($id, $type, $ban){

	$cclass = '';
	$cban = '';
	$cbanafter = '';


	if (!empty($ban)){
		$cclass .= ' cro_withbanner ';
		$cbanclass = ' leftmenrow ';
		$cbanleft = '';
	} else {
		$cbanleft = '<div class="six column">&nbsp;</div>';
		$cbanclass = ' rightmenrow ';
	}

	if ( has_nav_menu('secondnav' ) ) {
		$cclass .= ' cro_withnav ';
	}

	if (!empty($ban) || has_nav_menu('secondnav' )){
		$cban = '<div class="bannercover"><div class="row">';
		$cbanafter = '</div></div>';
	}


	/* old croma code:
	$headimg = get_header_image();
	$defimg  = get_template_directory_uri() . '/public/styles/images/defimg.jpg';
	*/

	// new code:
	get_the_post_thumbnail( $post_id, $size, $attr );
	$headimg = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'sshow');
	if (is_array($headimg)) $headimg = current($headimg); else $headimg = false;
	$defimg  = get_template_directory_uri() . '/public/styles/images/defimg.jpg';

	$minetitle = '';

	if ($headimg) {
		$defimg = $headimg;
	}



	if ($type =='page' ) {



		$args = array(
				'post_parent' 		=> $id,
				'post_type' 		=> 'attachment',
				'post_mime_type' 	=> 'image',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'numberposts' => 999
			);


		$images = get_children( $args );

					
		if ( $images ) {
			foreach($images as $v){
				$vals = get_post_meta($v->ID. '_cromadefimg'); 
				if (isset($vals['_cromadefimg'][0])) {
					$vvals = $vals['_cromadefimg'][0];
				} else {
					$vvals = 0;
				}
				if ($vvals == 1) {
					$image_img_tag = wp_get_attachment_image_src( $v->ID, 'full' );
					$defimg = $image_img_tag[0];
				}				
			}


		}



		$minetitle = '<h1 class="cro_accent">' . get_the_title($id) . '</h1>';

	} elseif ($type == 'category') {
		$minetitle = '<h1 class="cro_accent">' . single_cat_title('', false) . '</h1>';
	} elseif ($type == 'clear') {
		$minetitle = '';
	} elseif ($type == 'archive') {
		$minetitle = '<h1 class="cro_accent">' . __('Archives: ','localize')  . get_the_date( _x( 'M \'y', 'monthly archives date format', 'localize' ) ) .  '</h1>';
	} elseif ($type == 'tag') {
		$minetitle = '<h1 class="cro_accent">' . __('Tag Archives: ','localize') . single_cat_title('', false) . '</h1>';
	} elseif ($type == 'search') {
		$minetitle =  '<h1 class="cro_accent">' . __( 'Search Results for "', 'localize' ) .  '<span style="font-style: italic;">' . get_search_query() . '"</span></h1>';
	} elseif ($type == '404') {
		$minetitle =  '<h1 class="cro_accent">' . __( 'Page not found', 'localize' ) . '</h1>';
	} elseif ($type == 'post') {
		$args = array(
				'post_parent' 		=> $id,
				'post_type' 		=> 'attachment',
				'post_mime_type' 	=> 'image',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'numberposts' => 999
			);


		$images = get_children( $args );

					
		if ( $images ) {
			foreach($images as $v){
				$vals = get_post_meta($v->ID. '_cromadefimg'); 
				if (isset($vals['_cromadefimg'][0])) {
					$vvals = $vals['_cromadefimg'][0];
				} else {
					$vvals = 0;
				}
				if ($vvals == 1) {
					$image_img_tag = wp_get_attachment_image_src( $v->ID, 'full' );
					$defimg = $image_img_tag[0];
				}				
			}
		}

		$minetitle = '<h2 class="cro_accent">' . get_the_title($id) . '</h2>';
	} elseif ($type == 'event') {
			$args = array(
				'post_parent' 		=> $id,
				'post_type' 		=> 'attachment',
				'post_mime_type' 	=> 'image',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'numberposts' => 999
			);


		$images = get_children( $args );

					
		if ( $images ) {
			foreach($images as $v){
				$vals = get_post_meta($v->ID. '_cromadefimg'); 
				if (isset($vals['_cromadefimg'][0])) {
					$vvals = $vals['_cromadefimg'][0];
				} else {
					$vvals = 0;
				}
				if ($vvals == 1) {
					$image_img_tag = wp_get_attachment_image_src( $v->ID, 'full' );
					$defimg = $image_img_tag[0];
				}				
			}
		}

		$minetitle = '<h2 class="cro_accent">' . get_the_title($id) . '</h2>';
	} elseif ( $type == 'blog' ) {
		
		
		$blog_page_id = get_option('page_for_posts');
		
		$minetitle =  '<h1 class="cro_accent">' .get_page($blog_page_id)->post_title . '</h1>';
	}


	if (!empty($minetitle)){
		$minetitle = '<div class="cro_title">' . $minetitle . '</div>';
	}

	return '<div class="cro_headerspace ' .  $cclass . '">
				<div class="imgdiv" style="background: url(' . get_stylesheet_directory_uri() . '/lib/images/50tran.png) 0 0 repeat, url( ' . $defimg . ') 50% 0 no-repeat;">
					<div class="row">
						' . $minetitle . '
					</div>
				</div>
				'.  $cban .  $cp  .   $ban  .   $cbanafter  . '
			</div>';


}


/* 
* -03- FETCH GALLERY DATA
 * 
 * */

function get_gallery_data($id, $content){

	$regex_pattern = get_shortcode_regex();
	preg_match ('/'.$regex_pattern.'/s', $content, $regex_matches);
	$imgarr = '';


	if (isset($regex_matches[2]) && $regex_matches[2] == 'gallery' && isset($regex_matches[3]) && $regex_matches[3]) {
		$result = str_replace('ids="', '', $regex_matches[3]);
		$result = str_replace('"', '', $result);
		$imgarr = explode(',', $result);

		$scrp = '';
		foreach ( $imgarr as $cro_v ) {
			$tid = wp_get_attachment_image_src( $cro_v, 'thumbnail');
            $fid = wp_get_attachment_image_src( $cro_v, 'large');
            $scrp .=  '<li rel="' .  $tid[0]  . '" contents="' . $fid[0]  . '" title="' . get_the_title($cro_v)  . '"></li>'; 
		}

	} else {

		$scrp = '';
    	$images = get_children( array( 'post_parent' => $id , 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
        foreach ( $images as $attachment_id => $attachment ) {
            $tid = wp_get_attachment_image_src( $attachment_id, 'thumbnail');
            $fid = wp_get_attachment_image_src( $attachment_id, 'large');        
            $scrp .=  '<li rel="' .  $tid[0]  . '" contents="' . $fid[0]  . '" title="' . $attachment->post_title  . '"></li>';

        }
	}

	$op = '<ul class="cro_gallerycontentwidget">' .  $scrp  . '</ul>';
	return $op;
}





function get_frontcontent() {

	$str 	= cro_get_postarray('frontcontents');
	$first 	= '';
	$second = '';
	$third 	= '';
	$fourth = '';


	$substring = '';
	if (!empty($str)) {


		$perColumn = ceil(count($str) / 2);
		
		$firstColumn = true;

	
		// top left content
		$output = '<div class="six columns">';


		foreach ($str as $index => $unit):// seriously why didn't they do this in the first place?


		if ($index >= $perColumn and $firstColumn) {
			$output .= "</div><div class='six columns'>";
			$firstColumn = false;

		}

		$substring = '';
		$img = '<a href="' . get_permalink($sllink)  . '">' . get_the_post_thumbnail( $unit, 'fc1' ) . '</a>';
		$tttl 	= get_post_meta($unit, 'cro_imgtitle', true);
		$tttcnt = get_post_meta($unit, 'cro_imgcontent', true);

		
		$sllink 		= get_post_meta($unit, 'ss-pagelink', true);
		$altlink 		= get_post_meta($unit, 'cro_altlink', true);
		$slidelabel 	=  __('More Info','localize');
		$altstring		= '<div class="slidelinkspan"><a href="' . $altlink  . '">' .  $slidelabel  .  '</a></div>';
		
		

		$slidestring 	= ($sllink && $sllink && $sllink !== 0) ? '<div class="slidelinkspan"><a href="' . get_permalink($sllink)  . '">' .  $slidelabel  .  '</a></div>' : '' ;
		

		$slidestring	= ($altlink) ? $altstring : $slidestring;

	
		if (!empty($tttl)) {


			if ($sllink)
				$substring .= '<div class="fptitles"><h3 class="fptitle cro_accent"><a href="' . get_permalink($sllink)  . '">' . $tttl  . '</a></h3></div>';
			else 
				$substring .= '<div class="fptitles nolink"><h3 class="fptitle cro_accent">' . $tttl  . '</h3></div>';
		}

		if (!empty($tttcnt)) {
			$substring .= '<div class="fpcontents"><p class="cro_accent"><a href="' . get_permalink($sllink)  . '">' . $tttcnt  . '</a></p></div>';
		}


		
		if ($sllink) {
				$output .= '<div class="cro_fpc crolink cro_fpbig">
					<div class="cro_backgroundmask">&nbsp;</div>'
						. $img . $substring . $slidestring . '
				</div>';
		} else {

				$output .= '<div class="cro_fpc cro_nolink cro_fpbig">
					<div class="cro_backgroundmask">&nbsp;</div>'
						. $img . $substring . $slidestring . '
				</div>';

		}

		




		endforeach;


		$output .= '</div>';


		return $output;

	}

}

