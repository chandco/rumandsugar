<?php
/**
 * The shortcode controller
 *
 */
 

 /********** Code Index
 *
 * -01- INITIALIZE SHORTCODE MANAGER
 * -02- CREATE THE AJAX FUNCTION FOR THE FORM.
 * 
 */


 /**
 * -01- INITIALIZE SHORTCODE MANAGER
 */ 


add_action('admin_head', 'cro_load_jquery');
add_action('init', 'cro_addbuttons');


function cro_load_jquery() {
  echo '<script type="text/javascript">cro_shortcodeicon = "' .  get_template_directory_uri()  . '/inc/scripts/iconify.png";</script>';
}


function cro_addbuttons() {
     if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) return;
     if ( get_user_option('rich_editing') == 'true') {
     	add_filter("mce_external_plugins", "cro_tinymce_plugin");
     	add_filter('mce_buttons', 'cro_register_button');
     }
}
 
function cro_register_button( $buttons ) {
    // add a separation before our button, here our button's id is &quot;mygallery_button&quot;
    array_push( $buttons, '|', 'croshortcode_button' );
    return $buttons;
}
 
function cro_tinymce_plugin( $plugins ) {
    $plugins['croshortcode'] = get_template_directory_uri() . '/inc/scripts/shortcode_app.js';
    return $plugins;
}


function croma_refresh_mce($ver) {
  $ver += 3;
  return $ver;
}

add_filter( 'tiny_mce_version', 'croma_refresh_mce');



add_action( 'admin_enqueue_scripts', 'croma_fetch_shortcodestyle' );

function croma_fetch_shortcodestyle() {     

    wp_enqueue_style('croma_site', get_template_directory_uri() . '/inc/shortcodes/shortcode.css', array(), null, 'all');
}



function get_cat_list($types) {

    $op = '';
    $cro_t = '';

    if (isset($types)) {
        foreach($types as $cro_v) {

            $tax_terms = get_terms($cro_v);

            foreach($tax_terms as $cro_t) {
                $op .= '<option value="' .  $cro_t->term_id  . '">' . $cro_t->name  . '</option>';
            }
        }
    }

    return $op;
}



/**
* -02- CREATE THE AJAX FUNCTION FOR THE FORM.
 */ 


add_action('wp_ajax_croma_shortcode_action', 'croma_shortcode_ajax');

 function croma_shortcode_ajax() {

    if (isset($_POST['type'])) {
        $save_type = $_POST['type'];
        $cro_p = '';

        if($save_type == 'short_form'){ 

            $cro_p .= '<div class="cro_shcode_main">
                        <ul class="cro_shccode_men">
                            <li class=" tabber cro_topcurrent" rel="#crol11"><span>' . __('Accordions','localize')  . '</span></li>
                            <li class=" tabber" rel="#crol10"><span>' . __('Buttons','localize')  . '</span></li>
                            <li class=" tabber" rel="#crol3"><span>' . __('Calendar','localize')  . '</span></li>
                            <li class=" tabber" rel="#crol9"><span>' . __('Call Outs','localize')  . '</span></li>
                            <li class=" tabber" rel="#crol6"><span>' . __('Contacts','localize')  . '</span></li>
                            <li class=" tabber" rel="#crol2"><span>' . __('Gallery','localize')  . '</span></li>
                            <li class=" tabber" rel="#crol7"><span>' . __('Layout','localize')  . '</span></li>
                            <li class=" tabber" rel="#crol5"><span>' . __('Menu','localize')  . '</span></li>
                            <li class=" tabber" rel="#crol8"><span>' . __('Specials','localize')  . '</span></li>
                            <li class=" tabber" rel="#crol1"><span>' . __('Team','localize')  . '</span></li>
                            <li class=" tabber" rel="#crol4"><span>' . __('Video','localize')  . '</span></li>
                        </ul>

            <div class="tabstrap">';


            // ==========   CALL OUTS SHORTCODE GOES HERE ================
            $cro_p .= '
            <div id="crol9" class="cro_tabpage">
                <p class="cro_titler">' . __('Call Outs','localize')  . '</p>
                <p>
                 <select id="teamcatselector" rel="calloutbg">
                    <option value="1">' . __('Themecolor','localize')  . '</option>
                    <option value="#FBFBFB">' . __('Grey','localize')  . '</option>
                    <option value="#3A3A3A">' . __('Dark','localize')  . '</option>
                    <option value="#52BFD3">' . __('Light Blue','localize')  . '</option>
                    <option value="#E9510E">' . __('Orange','localize')  . '</option>
                    <option value="#886D64">' . __('Brown','localize')  . '</option>
                    <option value="#FFDA07">' . __('Yellow','localize')  . '</option>
                    <option value="#DC042B">' . __('Red','localize')  . '</option>
                    <option value="#EB5777">' . __('Peach','localize')  . '</option>
                    <option value="#CCCE01">' . __('Lime','localize')  . '</option>
                    <option value="#BA265B">' . __('Purple','localize')  . '</option>
                    <option value="#891C09">' . __('Rust','localize')  . '</option>
                </select> 
                </p>
                <p>
                    <select id="teamcatselector" rel="calloutpos">
                        <option value="1">' . __('Fullwidth','localize')  . '</option>
                        <option value="2">' . __('Half width aligned left','localize')  . '</option>
                        <option value="3">' . __('Half width aligned right','localize')  . '</option>
                        <option value="4">' . __('Half width aligned center;','localize')  . '</option>                 
                    </select> 
                </p>  
                <p>
                     <textarea id="teamcatselector" rel="callouttext"></textarea>
                </p>
                 <p class="cro_shortcode_submit">
                    <input type="button" id="cro-shortcode-submit" class="button" value="' . __('Insert Callout Shortcode','localize')  . '" name="cro-shortcode-submit" rel="callout" />
                </p>
                <p class="shcode-explain">' .  __('Add an callout to a post or page. ','localize')  .   '</p>
            </div>';



             // ==========   ACCORDIONS SHORTCODE GOES HERE ================
            $cro_p .= '
            <div id="crol11" class="cro_tabpage  cro_tabcurrent">
                <p class="cro_titler">' . __('Accordions','localize')  . '</p>
                <p>
                 <select id="teamcatselector" rel="accordion">
                    <option value="2">' . __('2 Tabs','localize')  . '</option>
                    <option value="3">' . __('3 Tabs','localize')  . '</option>
                    <option value="4">' . __('4 Tabs','localize')  . '</option>
                    <option value="5">' . __('5 Tabs','localize')  . '</option>
                    <option value="6">' . __('6 Tabs','localize')  . '</option>
                    <option value="7">' . __('7 Tabs','localize')  . '</option>
                    <option value="8">' . __('8 Tabs','localize')  . '</option>
                    <option value="9">' . __('9 Tabs','localize')  . '</option>
                    <option value="10">' . __('10 Tabs','localize')  . '</option>
                </select>  
                </p> 
                <p class="cro_shortcode_submit">
                    <input type="button" id="cro-shortcode-submit" class="button" value="' . __('Insert Accordion Shortcode','localize')  . '" name="cro-shortcode-submit" rel="accordion" />
                </p>
                <p class="shcode-explain">' .  __('Add an accordion to a post or page. ','localize')  .   '</p>
            </div>';





                    // ==========   BUTTONS SHORTCODE GOES HERE ================
            $cro_p .= '
            <div id="crol10" class="cro_tabpage">
                <p class="cro_titler">' . __('Buttons','localize')  . '</p>  
                <p>
                    <label class="frlabel">' . __('Button text','localize')  . '</label>
                     <input type="text" id="cro-shortcode-input_text" class="finput" value="" rel="button_text" />
                </p>
                <p>
                    <label  class="frlabel">' . __('Button link','localize')  . '</label>
                     <input type="text" id="cro-shortcode-input_link" class="finput" value="" rel="button_link" />
                </p>   
                <p>
                 <select id="teamcatselector" rel="buttoncol">
                   <option value="1">' . __('Themecolor','localize')  . '</option>
                    <option value="#FBFBFB">' . __('Grey','localize')  . '</option>
                    <option value="#3A3A3A">' . __('Dark','localize')  . '</option>
                    <option value="#52BFD3">' . __('Light Blue','localize')  . '</option>
                    <option value="#E9510E">' . __('Orange','localize')  . '</option>
                    <option value="#886D64">' . __('Brown','localize')  . '</option>
                    <option value="#FFDA07">' . __('Yellow','localize')  . '</option>
                    <option value="#DC042B">' . __('Red','localize')  . '</option>
                    <option value="#EB5777">' . __('Peach','localize')  . '</option>
                    <option value="#CCCE01">' . __('Lime','localize')  . '</option>
                    <option value="#BA265B">' . __('Purple','localize')  . '</option>
                    <option value="#891C09">' . __('Rust','localize')  . '</option>
                </select>  
                </p>          
                <p class="cro_shortcode_submit">
                    <input type="button" id="cro-shortcode-submit" class="button" value="' . __('Insert Button Shortcode','localize')  . '" name="cro-shortcode-submit" rel="button" />
                </p>
                <p class="shcode-explain">' .  __('Add an button to a post or page. ','localize')  .   '</p>
            </div>';




            // ==========   FOOD MENU SHORTCODE GOES HERE ================
            $cro_p .= '<div  id="crol5" class="cro_tabpage">
                            <p class="cro_titler">' . __('Menu','localize')  . '</p>

                            <p>
                                <select id="teamcatselector" rel="menuno">
                                    <option value="0">' . __('All menu items','localize')  . '</option>';
            $cro_p .= get_cat_list(array('foodmenu'));

            $cro_p .= '         </select>
                            </p>';

            $cro_p .= '     <p>
                                <select id="teamtypeselector" rel="menutype">
                                    <option value="1">' . __('The Mainstay','localize') . '</option>
                                    <option value="2">' . __('The Masthead','localize') . '</option>
                                    <option value="4">' . __('The Quickie','localize') . '</option>
                                </select>
                            </p>

                            <p class="cro_shortcode_submit">
                                <input type="button" id="cro-shortcode-submit" class="button" value="' . __('Insert Team Shortcode','localize')  . '" name="cro-shortcode-submit" rel="menu" />
                            </p>
                            <p class="shcode-explain">' .  __('Add food menu items to a post or page. ','localize')  .   '</p>
                        </div>';





            // ==========   SPECIALS SHORTCODE GOES HERE ================
            $cro_p .= '<div  id="crol8" class="cro_tabpage">
                            <p class="cro_titler">' . __('Specials','localize')  . '</p>
                            <p class="cro_shortcode_submit">
                                <input type="button" id="cro-shortcode-submit" class="button" value="' . __('Insert Special Shortcode','localize')  . '" name="cro-shortcode-submit" rel="special" />
                            </p>
                             <p class="shcode-explain">' .  __('Add your specials to a post or a page','localize')  .   '</p>
                        </div>';



             // ========== CONTACTS SHORTCODE GOES HERE ================     
            $cro_p .= '
            <div id="crol6" class="cro_tabpage">
                <p class="cro_titler">' . __('Contacts','localize')  . '</p>
                <p>
                    <select id="ctctypeselector" rel="ctctype">
                        <option value="0">' . __('Select a type...','localize') . '</option>
                        <option value="1">' . __('Contact Details','localize') . '</option>
                        <option value="2">' . __('Map','localize') . '</option>
                        <option value="3">' . __('Map with Streetview','localize') . '</option>
                        <option value="4">' . __('Contact Form','localize') . '</option>
                        <option value="5">' . __('Get Directions','localize') . '</option>
                    </select>
                </p>
                <p>
                    <select id="ctctypeselector" rel="ctcname">
                        <option value="0">' . __('Select a location...','localize') . '</option>';         
            $ctcargs = array(
                'post_type' => 'locations', 
                'numberposts' => -1, 
            );
            $ctcposts = get_posts( $ctcargs);
            foreach( $ctcposts as $cpost ) : setup_postdata($cpost);
            $cro_p .= '<option value="' .  $cpost->ID . '">'   .  $cpost->post_title    . '</option>';

            endforeach; 
            $cro_p .= '
                    </select>
                </p>
                <p class="cro_shortcode_submit">
                    <input type="button" id="cro-shortcode-submit" class="button" value="' . __('Insert contacts Shortcode','localize')  . '" name="cro-shortcode-submit" rel="ctc" />
                </p>
                <p class="shcode-explain">' .  __('Add contacts, contact forms, maps and directions to a post or page. ','localize')  .   '</p>
            </div>';



           // ========== LAYOUT SHORTCODE GOES HERE ================  
            $cro_p .= '
            <div id="crol7" class="cro_tabpage">
                <p class="cro_titler">' . __('Layout','localize')  . '</p>
                <p>
                    <select id="laytypeselector" rel="laytype">
                        <option value="0">' . __('Select a layout...','localize') . '</option>
                        <option value="1">' . __('Halves','localize') . '</option>
                        <option value="2">' . __('Thirds','localize') . '</option>
                        <option value="3">' . __('2/3 and 1/3','localize') . '</option>
                        <option value="4">' . __('1/3 and 2/3','localize') . '</option>
                        <option value="5">' . __('quarters','localize') . '</option>
                        <option value="6">' . __('half & quarters','localize') . '</option>
                        <option value="7">' . __('quarters & half','localize') . '</option>
                    </select>
                </p>
                <p class="cro_shortcode_submit">
                     <input type="button" id="cro-shortcode-submit" class="button" value="' . __('Insert layout Shortcode','localize')  . '" name="cro-shortcode-submit" rel="lte" />
                </p>
                <p class="shcode-explain">' .  __('Divide your page into two equal halves.','localize')  .   '</p>
            </div>';




            // ========== TEAM SHORTCODE GOES HERE ================  
            $cro_p .= '
            <div id="crol1" class="cro_tabpage">
                <p class="cro_titler">' . __('Team','localize')  . '</p>
                <p>
                    <select id="teamcatselector" rel="teamno">
                        <option value="0">' . __('All members','localize')  . '</option>';            
            $cro_p .= get_cat_list(array('team'));
            $cro_p .= '</select>
                </p>   
                <p class="cro_shortcode_submit">
                    <input type="button" id="cro-shortcode-submit" class="button" value="' . __('Insert Team Shortcode','localize')  . '" name="cro-shortcode-submit" rel="team" />
                </p>
                <p class="shcode-explain">' .  __('Add team members to a post or page. ','localize')  .   '</p>
            </div>';




            // ========== GALLERIES SHORTCODE GOES HERE ================  
            $cro_p .= '
            <div id="crol2" class="cro_tabpage">
                <p class="cro_titler">' . __('Gallery','localize')  . '</p>
                <p>
                    <select id="teamcatselector" rel="galno">
                        <option value="0">' . __('All Galleries','localize')  . '</option>';
            $cro_p .= get_cat_list(array('photobook'));
             $cro_p .= '</select>
                </p>
                <p class="cro_shortcode_submit">
                    <input type="button" id="cro-shortcode-submit" class="button" value="' . __('Insert Gallery Shortcode','localize')  . '" name="cro-shortcode-submit" rel="gallery" />
                </p>
                <p class="shcode-explain">' .  __('Add your galleries to a post or page.','localize')  .   '</p>
            </div>';


             // ========== CALENDAR SHORTCODE GOES HERE ================  
            $cro_p .= '
            <div id="crol3" class="cro_tabpage">
                <p class="cro_titler">' . __('Calendar','localize')  . '</p>
                <p>
                    <select id="teamcatselector" rel="calno">
                        <option value="0">' . __('Full Calendar','localize')  . '</option>
                        <option value="1">' . __('Agenda type Calendar','localize')  . '</option>
                        <option value="2">' . __('Upcomming events','localize')  . '</option>
                    </select>
                </p>
                <p class="cro_shortcode_submit">
                    <input type="button" id="cro-shortcode-submit" class="button" value="' . __('Insert Calendar Shortcode','localize')  . '" name="cro-shortcode-submit" rel="calendar" />
                </p>
                <p class="shcode-explain">' .  __('Add your calendar to a post or page.','localize')  .   '</p>
            </div>';



            // ========== VIDEO SHORTCODE GOES HERE ================ 
            $cro_p .= '
            <div id="crol4" class="cro_tabpage">
                <p class="cro_titler">' . __('Video','localize')  . '</p>
                <p><textarea id="teamcatselector" rel="vidno"></textarea></p>
                <p class="cro_shortcode_submit">
                    <input type="button" id="cro-shortcode-submit" class="button" value="' . __('Insert Video Shortcode','localize')  . '" name="cro-shortcode-submit" rel="video" />
                </p>
                <p class="shcode-explain">' .  __('Add responsive video to a post or page. Paste a link to your youtube or vimeo video above','localize')  .   '</p>
            </div>';

            $cro_p .= '</div>';

            echo $cro_p;
            exit;
        }
    }

}



?>