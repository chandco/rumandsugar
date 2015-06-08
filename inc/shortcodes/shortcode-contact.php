<?php
/**
 * The team shortcodes
 *
 */
 

 /********** Code Index
 *
 * -01- ADD A TEAM
 * 
 */


 /**
 * -01- ADD A TEAM  [team no="category number"]
 */ 


function cro_contactlist_func( $atts ) {
	global $post, $wp_query;
    $op = '';
    $settings   = get_option( 'tlset' );
    $mshead     = (isset($settings['cro_ctchead'])) ? $settings['cro_ctchead'] : '' ;
    $goodmsg    = (isset($settings['cro_ctcsuc'])) ? $settings['cro_ctcsuc'] : '' ;
    $badmsg     = (isset($settings['cro_ctcerr'])) ? $settings['cro_ctcerr'] : '' ;
    $count_pages = wp_count_posts('locations');

    extract( shortcode_atts( array(
        'no'    => 'menucat',
        'type'  => 'typenumber'
    ), $atts ) );




    switch ($type) {

        case 1:
            $op .= '<ul class="ctclabels">';

            if (isset($settings['cro_ctcdethead']) && $settings['cro_ctcdethead']){
            $op .= '<li class="ctcclearside" style="height: auto;">';
            $op .= '<h4 class="cro_accent">' .     stripslashes(esc_attr($settings['cro_ctcdethead'])) .   '</h4>';
            $op .= '</li>';
            }


            $p = get_post_meta( $no, 'cro_operatinghrs' , true );
            if ($p){
                $op .= '<li class="ctclabelside">' .  __('Operating hours:','localize') . '</li>';
                $op .= '<li class="ctcinfoside">' .  $p  . '</li>';
                $op .= '<li class="ctcclearside"></li>';
            }

            $p = get_post_meta( $no, 'cro_streetaddr' , true );
            if ($p){
                $op .= '<li class="ctclabelside">' .  __('Address:','localize') . '</li>';
                $op .= '<li class="ctcinfoside">' .  $p  . '</li>';
                $op .= '<li class="ctcclearside"></li>';
            }

            $p = get_post_meta( $no, 'cro_telephone' , true );
            if ($p){
                $op .= '<li class="ctclabelside">' .  __('Telephone:','localize') . '</li>';
                $op .= '<li class="ctcinfoside">' .  $p  . '</li>';
                $op .= '<li class="ctcclearside"></li>';
            }

            $p = get_post_meta( $no, 'cro_fax' , true );
            if ($p){
                $op .= '<li class="ctclabelside">' .  __('Fax:','localize') . '</li>';
                $op .= '<li class="ctcinfoside">' .  $p  . '</li>';
                $op .= '<li class="ctcclearside"></li>';
            }

            $p = get_post_meta( $no, 'cro_contactmail' , true );
            if ($p){
                $op .= '<li class="ctclabelside">' .  __('Email:','localize') . '</li>';
                $op .= '<li class="ctcinfoside">' .  $p  . '</li>';
                $op .= '<li class="ctcclearside"></li>';
            }



            $op .= '</ul>';
      
        break;



        case 2:
        $postltlg = get_post_meta( $no, 'cro_latlong', true);
        $postzoom = get_post_meta( $no, 'cro_mapzoom', true);
        $postnum = get_post_meta( $no, 'cro_mapheight', true);
        $postdrv = get_post_meta( $no, 'cro_dirhttp', true);


         if (isset($settings['cro_maparray'])) {
            if (!in_array($post->ID, $settings['cro_maparray'])){
                $maparray = $settings['cro_maparray'];
                $maparray[] = $post->ID;
                $settings['cro_maparray'] = $maparray;
                update_option( 'tlset', $settings);
            } 

        } else {
            $maparray[] = $post->ID;
            $settings['cro_maparray'] = $maparray;
            update_option( 'tlset', $settings);
        }


        $pp = ($postnum && is_numeric($postnum)) ? ' style="height: ' .  $postnum  . 'px;" ' : '' ;

        $op .= '';
        $op .= '<script type="text/javascript">
                    function initialize() {
                        var myLatlng = new google.maps.LatLng(' .  $postltlg  . ');


                        var myOptions = {
                            zoom: ' .  $postzoom  . ',
                            center: myLatlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            streetViewControl: true

                        }

                        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        
                        var marker = new google.maps.Marker({
                            position: myLatlng, 
                            map: map, 
                            title:"Hello World!"
                        }); 
                    }
                </script>              
            ';

            if ($postdrv) {
                $op .= '<div class="cro_drivedirections">';
                $op .= '<a href="' . $postdrv  . '">' . $settings['cro_drivdirlabel'] . '</a>';
                $op .= '</div>';
            }
            $op .= '<div id="map_canvas" class="singlecanvas" ' . $pp  . '></div>  ';

        break;


        case 3:
        $postltlg = get_post_meta( $no, 'cro_latlong', true);
        $postzoom = get_post_meta( $no, 'cro_mapzoom', true);
        $postnum = get_post_meta( $no, 'cro_mapheight', true);
        $so = get_post_meta( $no, 'cro_sworient', true);
        $postdrv = get_post_meta( $no, 'cro_dirhttp', true);

        if (!$so) { $so = 0;}


         if (isset($settings['cro_maparray'])) {
            if (!in_array($post->ID, $settings['cro_maparray'])){
                $maparray = $settings['cro_maparray'];
                $maparray[] = $post->ID;
                $settings['cro_maparray'] = $maparray;
                update_option( 'tlset', $settings);
            } 

        } else {
            $maparray[] = $post->ID;
            $settings['cro_maparray'] = $maparray;
            update_option( 'tlset', $settings);
        }

        $pp = ($postnum && is_numeric($postnum)) ? ' style="height: ' .  $postnum  . 'px;" ' : '' ;


        $op .= '';
        $op .= '<script type="text/javascript">
                    function initialize() {
                        var myLatlng = new google.maps.LatLng(' .  $postltlg  . ');


                        var myOptions = {
                            zoom: ' .  $postzoom  . ',
                            center: myLatlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            streetViewControl: true

                        }

                        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        
                        var marker = new google.maps.Marker({
                            position: myLatlng, 
                            map: map, 
                            title:"Hello World!"
                        }); 
                        panoramaOptions = {
                            addressControl: false,
                            position: myLatlng,
                            pov: {
                                heading: ' .  $so . ',
                                pitch: +10,
                                zoom: 2
                            }
                        };
                        panorama = new  google.maps.StreetViewPanorama(document.getElementById("map_canvas2"), panoramaOptions);
                        map.setStreetView(panorama);
                    }
                </script>
            ';

             if ($postdrv) {
                $op .= '<div class="cro_drivedirections">';
                $op .= '<a href="' . $postdrv  . '">' . $settings['cro_drivdirlabel'] . '</a>';
                $op .= '</div>';
            }
            $op .= '<div id="map_canvas" ' . $pp  . '></div>  ';
             $op .= '<div id="map_canvas2" ' . $pp  . '></div>  ';
      
        break;



        case 4:


        if (isset($settings['primcolor']) && $settings['primcolor'] == '2') {
            $op .= '<form id="ctcform" class="blackform" action="post">';
        } else {
             $op .= '<form id="ctcform" action="post">';
        }


        if (isset($settings['cro_ctchead']) && $settings['cro_ctchead']){
            $op .= '<h4 class="cro_accent">' .     stripslashes(esc_attr($settings['cro_ctchead'])) .   '</h4>';
        }


        $op .= '<p>';
        $op .= '<label for="cro_form_name">' .     __('Name:','localize') .   '</label>';
        $op .= '<input type="text" name="cro_form_name" class="cro_validateform" contents="cro_ct" id="cro_form_name" val="">';
        $op .= '</p>';

        $op .= '<p>';
        $op .= '<label for="cro_form_name">' .     __('Telephone:','localize') .   '</label>';
        $op .= '<input type="text" name="cro_form_tel" class="cro_validateform" contents="cro_ct" id="cro_form_tel" val="">';
        $op .= '</p>';

        $op .= '<p>';
        $op .= '<label for="cro_form_mail">' .     __('Email:','localize') .   '</label>';
        $op .= '<input type="text" name="cro_form_mail" class="cro_validateform" contents="cro_ct" id="cro_form_mail" val="">';
        $op .= '</p>';

        $op .= '<p>';
        $op .= '<label for="cro_form_mail">' .     __('Comments:','localize') .   '</label>';
        $op .= '<textarea name="cro_form_cmmt" class="cro_validateform" contents="cro_ct" id="cro_form_cmmt"></textarea>';
        $op .= '</p>';


        if ($settings['cro_multiplerecipient'] == '2' && $count_pages->publish >= 2) {
            $pargs = array('post_type' => 'locations');
            $locposts = get_posts( $pargs );
            $op .= '<p>';
            $op .= '<label for="cro_email rcpnt">' .     __('Recipient:','localize') .   '</label>';
            $op .= '<select name="cro_formloc" class="ctcformselect" id="cro_form_loc">';
            foreach( $locposts as $lpost ) : setup_postdata($lpost);
                $op .= '<option value="' .  $lpost->ID . '">' .  $lpost->post_title . '</option>';
            endforeach;
            $op .= '</select>';
            $op .= '</p>';
        } else {
            $op .= '<input type="hidden" name="cro_formloc" id="cro_form_loc" val="0">';
        }


        $op .= '<p class="locmail">';
        $op .= '<label for="cro_form_mail">' .     __('Location:','localize') .   '</label>';
        $op .= '<input type="text" name="cro_form_loc" class="cro_validateform" contents="cro_loc" id="cro_form_loc" val="">';
        $op .= '</p>';



        $op .= '<div class="valmess">
                    <div class="booksuccess">' . stripslashes(esc_attr($settings['cro_ctcsuc'])) . '</div>
                    <div class="bookerror">' . stripslashes(esc_attr($settings['cro_ctcerr'])) . '</div>
                </div>';


        $op .= '<p>';
        $op .= '<input type="submit" name="cro_form_sub" id="cro_form_sub" val="' .   __('Submit','localize') .  '">';
        $op .= '</p>';


        $op .= '<div class="cro_bookingsoverlay1">
                <div class="bookingsldr"></div>
                <div class="cro_ldrmess">
                    ' . __( 'Submitting form', 'localize' ) . '
                </div>
            </div>';


        $op .= '</form>';
 
        break;



        case 5:
        $postaddr = get_post_meta( $no, 'cro_streetaddr', true);
        $postltlg = get_post_meta( $no, 'cro_latlong', true);

        if (isset($settings['cro_maparray'])) {
            if (!in_array($post->ID, $settings['cro_maparray'])){
                $maparray = $settings['cro_maparray'];
                $maparray[] = $post->ID;
                $settings['cro_maparray'] = $maparray;
                update_option( 'tlset', $settings);
            } 

        } else {
            $maparray[] = $post->ID;
            $settings['cro_maparray'] = $maparray;
            update_option( 'tlset', $settings);
        }

        $op .= '<div class="six column">';
        $op .= '<ul class="cro_directionscal">
                    <li class="dir-label">' .  __('To:','localize')   . '</li>
                    <li><strong>' .   stripslashes($postaddr)  .     '</strong></li>
                    <li class="dir-label">' .  __('From:','localize')   . '</li>
                    <li><input id="from-input" type=text value=""/></li>
                     <li><input id="to-input" type=hidden value="' .   stripslashes($postaddr)  .     '"/></li>
                    <li><input id="driveclick" class="" onclick="Demo.getDirections();" type=button value="' .  __('Calculate:','localize')   . '"/></li>
                </ul>
                <p>' . __('The driving directions are interactive. Click on any bold text for further explanation of the route.', 'localize' ) . '</p>
                <div id="dir-container"></div>';

        $op .= '</div>';







        $op .= '<div class="six column">';

        $op .= '<div id="map-container"></div>';

        $op .= '</div><div class="clearfix"></div>';

        $op .= '
        <script type="text/javascript">
                    var Demo = {
                        mapContainer: document.getElementById("map-container"),
                        dirContainer: document.getElementById("dir-container"),
                        fromInput: document.getElementById("from-input"),
                        toInput: document.getElementById("to-input"),

                        dirService: new google.maps.DirectionsService(),
                        dirRenderer: new google.maps.DirectionsRenderer(),
                        map: null,

                        showDirections: function(dirResult, dirStatus) {
                            if (dirStatus != google.maps.DirectionsStatus.OK) {
                                alert("Directions failed: " + dirStatus);
                                return;
                            }

                            Demo.dirRenderer.setMap(Demo.map);
                             Demo.dirRenderer.setPanel(Demo.dirContainer);
                             Demo.dirRenderer.setDirections(dirResult);
                        },

                        getDirections: function() {
                            var fromStr = Demo.fromInput.value;
                            var toStr = Demo.toInput.value;
                            var dirRequest = {
                                origin: fromStr,
                                destination: toStr,
                                travelMode: google.maps.DirectionsTravelMode.DRIVING,
                                unitSystem: google.maps.DirectionsUnitSystem.METRIC,
                                provideRouteAlternatives: true
                            };
                            Demo.dirService.route(dirRequest, Demo.showDirections);
                        },

                        init: function() {
                            var image = "' .  get_template_directory_uri() . '/public/styles/images/mpmrk.png";
                            var latLng = new google.maps.LatLng(' . $postltlg  . ');
                                Demo.map = new google.maps.Map(Demo.mapContainer, {
                                zoom: 16,
                                center: latLng,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            });
                                    
                        var marker = new google.maps.Marker({
                            position: latLng, 
                            map: Demo.map,
                            icon: image
                        });  
                     }                               
                };
                google.maps.event.addDomListener(window, "load", Demo.init);
            </script>';

        

        break;
    }

    

    return $op;
}
add_shortcode( 'cro_contact', 'cro_contactlist_func' );
?>