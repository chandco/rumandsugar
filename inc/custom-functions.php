<?php
/**
 * The file handling all the functions for the custom parts of the theme.
 *
 */
 
 
 
/********** Code Index
 *
 * -01- REGISTER AND ENQUEUE JQUERY
 * -02- SOCIAL LINKS
 * -03- RANDOM STRING GENERATOR
 * -04- VIDEO PARSER
 * -05- VIDEO DATA GENERATOR
 * -06- WELCOME NOTE
 * -07- DEFAULT IMAGE CHOOSER
 * -08- ENSURE THAT A URL HAVE A HTTP BEFORE THEM
 * -09- EXCERPT SHORTENER
 * -09- EXCERPT REMOVE READMORE AND ADD ELLIPSES
 * -10- PAGING FUNCTION
 */
 

 /* 
  * -02- SOCIAL LINKS
  * */
  
 function ntfetch_social() {
 	$op = '';
 	$tlset = get_option( 'tlset' );
 	$servicesarray = array(
 		array('class' => 'facebook',	'name' => __('facebook','localize')),
 		array('class' => 'twitter',		'name' => __('twitter','localize')),
 		array('class' => 'rss',			'name' => __('rss','localize')),
 		array('class' => 'mail',		'name' => __('email','localize')),
 		array('class' => 'googleplus',	'name' => __('google+','localize')),
 		array('class' => 'pinterest',	'name' => __('pinterest','localize')),
 		array('class' => 'vimeo',		'name' => __('vimeo','localize')),
 		array('class' => 'youtube',		'name' => __('youtube','localize')),
 		array('class' => 'linkedin',	'name' => __('linkedin','localize')),
 		array('class' => 'flickr',		'name' => __('flickr','localize')),
 		array('class' => 'instagram',	'name' => __('instagram','localize')),
 		array('class' => 'foursquare',	'name' => __('foursquare','localize'))
 	);
 							
	$op .= '<ul class="sociallinks">';	
	foreach ($servicesarray as $tl){
		if (isset( $tlset[$tl['class']] )) {
			$op .= ($tlset[$tl['class']]) ? '<li id="' . $tl['class'] . '" ><em>' . $tl['name'] . '</em><a href="' . $tlset[$tl['class']] . '" target=_blank"><span>' . $tl['name']  . '</span></a></li>' : '' ;
		}
	}	
	$op .= '</ul>';	
	return $op;
 }
 




/* 
 * -03- RANDOM STRING GENERATOR
 * */
function cro_randstring($length, $charset='abcdefghijklmnopqrstuvwxyz')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}



/* 
 * -04- VIDEO PARSER
 * */
function cro_parsevideo($string, $type){

	$matches = array();
	$ipart1 = 'ifr';
	$ipart2 = $ipart1 . 'ame';

	$youtubestring = '~								# Match Youtube link and embed code
				(?: 								# Group to match embed codes
				(?:<' .  $ipart2  . ' [^>]*src=")?	# If iframe match up to first quote of src
				|(?:				 				# Group to match if older embed
				(?:<object .*>)?					# Match opening Object tag
				(?:<param .*</param>)*				# Match all param tags
				(?:<embed [^>]*src=")?				# Match embed tag to the first quote of src
				)?									# End older embed code group
				)?									# End embed code groups
				(?:									# Group youtube url
   				https?:\/\/		         			# Either http or https
   				(?:[\w]+\.)*		        		# Optional subdomains
   				(?:               	        		# Group host alternatives.
       			youtu\.be/      	        		# Either youtu.be,
       			| youtube\.com		 				# or youtube.com 
       			| youtube-nocookie\.com	 			# or youtube-nocookie.com
   				)				 					# End Host Group
   				(?:\S*[^\w\-\s])?       			# Extra stuff up to VIDEO_ID
   				([\w\-]{11})		        		# $1: VIDEO_ID is numeric
				[^\s]*								# Not a space
				)				 					# End group
				"?				 					# Match end quote if part of src
				(?:[^>]*>)?			 				# Match any extra stuff up to close brace
				(?:				 					# Group to match last embed code
   				</' .  $ipart2  . '>		        # Match the end of the iframe	
   				|</embed></object>	        		# or Match the end of the older embed
				)?				 					# End Group of last bit of embed code
				~ix';

	$vimeostring = '~  								# Match Vimeo link and embed code
				(?:<' .  $ipart2  . ' [^>]*src=")? 	# If iframe match up to first quote of src
				(?:									# Group vimeo url
				https?:\/\/							# Either http or https
				(?:[\w]+\.)*						# Optional subdomains
				vimeo\.com							# Match vimeo.com
				(?:[\/\w]*\/videos?)?				# Optional video sub directory this handles groups links also
				\/									# Slash before Id
				([0-9]+)							# $1: VIDEO_ID is numeric
				[^\s]*								# Not a space
				)									# End group
				"?									# Match end quote if part of src
				(?:[^>]*></' .  $ipart2  . '>)?		# Match the end of the iframe
				(?:<p>.*</p>)?		        		# Match any title information stuff
				~ix';




	if ($type  == 'youtube') {
		preg_match($youtubestring, $string, $matches);

	} else {
		preg_match($vimeostring, $string, $matches);
	}

	return $matches;

}



/* 
 * -05- VIDEO DATA GENERATOR
 * */

function cro_identifyvideo( $url, $id = 0)  {

	$returninfo = $vinf = array();
	$service = '';
	$vidno = $url;
	$ipart1 = 'ifr';
	$ipart2 = $ipart1 . 'ame';


	// QUICKLY DETERMINE WHICH TYPE OF SERVICE WE WILL NEED TO ACCESS.
	if (!is_numeric($url)){
		$service = 'youtube';
		if (strpos($url,'vimeo') !== false) {
    		$service = 'vimeo';
    		$vinf = cro_parsevideo($url, 'vimeo');
    	} else {
    		$vinf = cro_parsevideo($url, 'youtube');
    	}
	} else {
		$service = 'vimeo';
	}
    	
	if (isset($vinf[1]) && $vinf != '') {
		$vidno = $vinf[1];
	}



	if ($vidno !== $id) {

		switch ($service) {
    		case 'vimeo':
    			$response = wp_remote_get( esc_url_raw('http://vimeo.com/api/v2/video/' . $vidno . '.php'), array( 'User-Agent' => 'wordpress' ) );
 				$response_code = wp_remote_retrieve_response_code( $response );
				if ( 200 == $response_code ) {
   					$videoinfo = unserialize(wp_remote_retrieve_body($response));
   					$returninfo['thumb'] =  str_replace('_200.jpg', '_295.jpg', $videoinfo[0]['thumbnail_medium']);
   					$returninfo['id'] =  $vidno;
   					$returninfo['frame'] = '<' .  $ipart2  . ' src="http://player.vimeo.com/video/' .  $vidno . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="600" height="350" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></' .  $ipart2  . '>';
   				}
    		break;

    		case 'youtube':
    			$returninfo['thumb'] =  'http://img.youtube.com/vi/' . $vidno  . '/mqdefault.jpg';
   				$returninfo['id'] =  $vidno;
   				$returninfo['frame'] = '<' .  $ipart2  . ' width="600" height="250" src="http://www.youtube.com/embed/' . $vidno . '?rel=0&autohide=1" frameborder="0" allowfullscreen></' .  $ipart2  . '>';   			
    		break;
    	}

    	return $returninfo;

	} else {

		return '';

	}
}
 
 
/* 
 * -06- WELCOME NOTE
 * */
 
 
function tl_fetch_welcomenote($id){
	
	$tlset = get_option( 'tlset' );
	$bt = get_post($id); 
	$imgurl = wp_get_attachment_image_src(get_post_thumbnail_id($id),'full', true); 
	$op = '<div class="carouselspaceholder" style="height: 40px;">&nbsp;</div><div class="welcomemsg" style="background: url(' .  $imgurl[0]  .  ') fixed center top"><div class="row">';
		
	$op .= '<h3 class="cro_accent">' . $bt->post_title . '</h3>';
	
	$op .= '<p class="cro_accent">' . $bt->post_content . '</p>';
	
	$op .= '</div></div>';
	
	
	return $op;
}



/* 
 * -07- DEFAULT IMAGE CHOOSER
 * */

 
function croma_attachment_edit( $form_fields, $post ) {
	$isban = (bool) get_post_meta($post->ID, '_cromadefimg', true);
	$checked = ($isban) ? 'checked' : '';

	$form_fields['cromadefimg'] = array(
		'label' => 'Banner Image ?',
		'input' => 'html',
		'html' => '<input type="checkbox" ' .  $checked  .   ' name="attachments[' . $post->ID . '][cromadefimg]" id="attachments[' . $post->ID . '][cromadefimg]" />',
		'value' => $isban,
		'helps' => 'Is this image a banner ?'
	);
	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'croma_attachment_edit', null, 2 );
 
 
function croma_attachment_save($post, $attachment) {
	if (isset($attachment['cromadefimg'])){
		$a = $attachment['cromadefimg'];
	} else {
		$a = '';
	}
	$islogo = ($a == 'on') ? '1' : '0';
	update_post_meta($post['ID'], '_cromadefimg', $islogo);
	return $post;
}

add_filter('attachment_fields_to_save', 'croma_attachment_save', 10, 2);




/* 
 * -08- ENSURE THAT A URL HAVE A HTTP BEFORE THEM
 * */
function cro_fix_url($url) {
    if (substr($url, 0, 7) == 'http://') { return $url; }
    if (substr($url, 0, 8) == 'https://') { return $url; }
    return 'http://'. $url;
}



/* 
 * -09- EXCERPT SHORTENER
 * */



class CroExcerpt {

  public static $length = 55;

  /**
   *
   * @param string $new_length 
   * @return void
   * @author Baylor Rae'
   */
  public static function length($new_length = 55) {
    CroExcerpt::$length = $new_length;

    add_filter('excerpt_length', 'CroExcerpt::new_length');

    CroExcerpt::output();
  }


  public static function new_length() {
      return CroExcerpt::$length;
  }


  public static function output() {
    the_excerpt();
  }

}

// An alias to the class
function cro_excerpt($length = 55) {
  CroExcerpt::length($length);
}



/* 
 * -09- EXCERPT REMOVE READMORE AND ADD ELLIPSES
 * */
function croma_auto_excerpt_more( $more ) {
	 '&hellip;';
}
add_filter( 'excerpt_more', 'croma_auto_excerpt_more' );






/* 
 * -10- PAGING FUNCTION
 * */



if ( ! function_exists( 'cro_paging' ) ) {

	function cro_paging( $args = array(), $query = '' ) {
		global $wp_rewrite, $wp_query;
				
		if ( $query ) {$wp_query = $query;} 
	
		if ( 1 >= $wp_query->max_num_pages ) return;
	
		$current = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );
	
		$max_num_pages = intval( $wp_query->max_num_pages );
	
		$defaults = array(
			'base' => add_query_arg( 'paged', '%#%' ),
			'format' => '',
			'total' => $max_num_pages,
			'current' => $current,
			'prev_next' => true,
			'prev_text' => __( '&laquo;', 'localize' ), 
			'next_text' => __( '&raquo;', 'localize' ), 
			'show_all' => false,
			'end_size' => 1,
			'mid_size' => 1,
			'add_fragment' => '',
			'type' => 'plain',
			'before' => '<div class="pagination">', 
			'after' => '</div>',
			'echo' => true,
		);
	
		if( $wp_rewrite->using_permalinks() )
			$defaults['base'] = user_trailingslashit( trailingslashit( get_pagenum_link() ) . 'page/%#%' );
	
		if ( is_search() ) {
			if ( class_exists( 'BP_Core_User' ) ) {
				
				$search_query = get_query_var( 's' );
				$paged = get_query_var( 'paged' );				
				$base = user_trailingslashit( home_url() ) . '?s=' . $search_query . '&paged=%#%';
				
				$defaults['base'] = $base;
			} else {
				$search_permastruct = $wp_rewrite->get_search_permastruct();
				if ( !empty( $search_permastruct ) )
					$defaults['base'] = user_trailingslashit( trailingslashit( get_search_link() ) . 'page/%#%' );
			}
		}
	
		$args = wp_parse_args( $args, $defaults );
	
		if ( 'array' == $args['type'] )
			$args['type'] = 'plain';
	
		$page_links = paginate_links( $args );	
		$page_links = str_replace( array( '&#038;paged=1\'', '/page/1\'' ), '\'', $page_links );	
		$page_links = $args['before'] . $page_links . $args['after'];		
		do_action( 'nets_pagination_end' );
		
		if ( $args['echo'] )
			echo $page_links;
		else
			return $page_links;
			
	} 

} 
 
 
?>