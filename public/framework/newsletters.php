<?php
/**
 * Structure for the newsletters
 */ 
   
/********** Code Index
 *
 * -01- NEWSLETTER PREPROCESSOR
 * -02- NEWSLETTER PROCESSOR
 * 
 */


function cro_process_bookingsdata($datas){
	$op = '';
	foreach ($datas as $k => $v) {
		if ($k == '_datetime'){
			$tvalue = $v['time'] + $v['date'];

			$op .= '<tr>
				<td valign="top" style="padding: 0;">
                    <div mc:edit="std_content00" style="text-align: right; padding-right: 10px;">
                      <strong style="text-transform: uppercase;">' . $v['name'] . ':</strong>
                    </div>
				</td>
				<td valign="top" style="padding: 0;">
                    <div mc:edit="std_content00" style="padding-left: 10px;">
                        ' . date_i18n( get_option('date_format') . ' ' . get_option('time_format') , $tvalue , false ) . '
                    </div>
				</td>
                </tr>';

		} else {

			$op .= '<tr>
				<td valign="top" style="padding: 0;">
                    <div mc:edit="std_content00" style="text-align: right; padding-right: 10px;">
                        <strong style="text-transform: uppercase;">' . $k . ':</strong>
                    </div>
				</td>
				
				<td valign="top" style="padding: 0;">
                    <div mc:edit="std_content00" style="padding-left: 10px;">
                        ' . $v . '
                    </div>
				</td>
            </tr>';

		}

	}

	return $op;

}


/* 
 * -04- NEWSLETTER PREPROCESSOR
 * */

function cro_newsletter_preprocessor($datas, $type){

	$tlset = get_option( "tlset" );
	$bset = get_option('cro_booksched');
	$mset = get_option("bookset");
	$data = array();

	$op = '<tr><td valign="top" colspan="2" style="padding: 20px; text-align: center; color: #666;">' .   __('Information submitted','localize')   . '</td></tr>';


	$data['color'] 		= $tlset['cro_themecolor'];
	$data['logo']		= $tlset['logo'];
	$data['copyright'] 	= __('Copyright','localize') . ' &copy; ' . date('Y', time()) . ' ' .  get_bloginfo('name');
	$data['sitename'] 	= get_bloginfo('name');
	$data['sitelink'] 	= home_url();

	if ($type == 'newsletter'){

		$aresult = array_values(array_slice($datas, 1, 1));
		$amail = $aresult[0];

		foreach ($datas as $k => $v) {
			$op .= '<tr>
					<td valign="top" style="padding: 0;">
                    	<div mc:edit="std_content00" style="text-align: right; padding-right: 10px;">
                       		<strong style="text-transform: uppercase;">' . $k . ':</strong>
                        </div>
					</td>
					<td valign="top" style="padding: 0;">
                        <div mc:edit="std_content00" style="padding-left: 10px;">
                            ' . $v . '
                        </div>
					</td>
                    </tr>';
		}

		$op .= '<tr><td  colspan="2" valign="top" style="padding: 20px;"><div>&nbsp;</div></td></tr>';

			$data['title'] 			= $tlset['cro_adminsubjectline'] . ' -- ' . get_bloginfo('name') ;
			$data['premessage'] 	= $tlset['cro_adminsubjectline'];
			$data['messageheader'] 	= $tlset['cro_adminsubjectline'];
			$data['mainmessage'] 	= $tlset['cro_adminmessage'];
			$data['messagedata'] 	= $op;
			$data['emailaddress'] 	= (isset($tlset['cro_newsletteremail']) && $tlset['cro_newsletteremail'] != '') ? $tlset['cro_newsletteremail'] : get_option('admin_email') ;

			$op .= cro_sendnewsletter($data);

			$data['title'] 			= $tlset['cro_subscribersubjectline'] . ' -- ' . get_bloginfo('name') ;
			$data['premessage'] 	= $tlset['cro_subscribersubjectline'];
			$data['messageheader'] 	= $tlset['cro_subscribersubjectline'];
			$data['mainmessage'] 	= $tlset['cro_subscribermessage'];
			$data['emailaddress'] 	= $amail;

			$op .= cro_sendnewsletter($data);	

	} elseif ($type == 'ctcform'){

		$aresult = array_values(array_slice($datas, 1, 1));
		$amail = $aresult[0];
		$datasloc = $datas['locdata'];
		unset($datas['locdata']);

		if ($datasloc != '0') {

			$mailsum = get_post_meta( $datasloc, 'cro_contactmail', true );

		} else {

			$mailsum = (isset($tlset['cro_ctcemail']) && $tlset['cro_ctcemail'] != '') ? $tlset['cro_ctcemail'] : get_option('admin_email') ;

		}

		foreach ($datas as $k => $v) {
			$op .= '<tr>
					<td valign="top" style="padding: 0;">
                    	<div mc:edit="std_content00" style="text-align: right; padding-right: 10px;">
                       		<strong style="text-transform: uppercase;">' . $k . ':</strong>
                        </div>
					</td>
					<td valign="top" style="padding: 0;">
                        <div mc:edit="std_content00" style="padding-left: 10px;">
                            ' . $v . '
                        </div>
					</td>
                    </tr>';
		}

		$op .= '<tr><td  colspan="2" valign="top" style="padding: 20px;"><div>&nbsp;</div></td></tr>';

			$data['title'] 			= $tlset['cro_ctcadmin_s'] . ' -- ' . get_bloginfo('name') ;
			$data['premessage'] 	= $tlset['cro_ctcadmin_s'];
			$data['messageheader'] 	= $tlset['cro_ctcadmin_s'];
			$data['mainmessage'] 	= $tlset['cro_ctcadmin'];
			$data['messagedata'] 	= $op;
			$data['emailaddress'] 	= $mailsum;

			$op .= cro_sendnewsletter($data);

			$data['title'] 			= $tlset['cro_ctccust_s'] . ' -- ' . get_bloginfo('name') ;
			$data['premessage'] 	= $tlset['cro_ctccust_s'];
			$data['messageheader'] 	= $tlset['cro_ctccust_s'];
			$data['mainmessage'] 	= $tlset['cro_ctccust'];
			$data['emailaddress'] 	= $amail;

			$op .= cro_sendnewsletter($data);	

	} elseif ($type == 'book_admin' || $type == 'book_customer' || $type == 'confirm_customer' || $type == 'decline_customer' || $type == 'cancel_customer' || $type == 'remind_customer') {

		$aresult = array_values(array_slice($datas, 1, 1));
		$amail = $aresult[0];

		switch ($type) {
			case 'book_admin':
				$astring = 'bookadmin';
				$amail = $mset['bookingmail'];
			break;
			case 'book_customer': $astring = 'bookclient';break;
			case 'confirm_customer': $astring = 'bookconf'; break;			
			case 'decline_customer': $astring = 'bookdec'; break;			
			case 'cancel_customer': $astring = 'bookcan'; break;	
			case 'remind_customer': $astring = 'bookrem'; break;				
		}

		$op .= cro_process_bookingsdata($datas);

			$op .= '<tr><td  colspan="2" valign="top" style="padding: 20px;"><div>&nbsp;</div></td></tr>';

			if (isset($mset['ntl_' . $astring . '_s'])) {
				$p_s = $mset['ntl_' . $astring . '_s'];
				$p_t = $mset['ntl_' . $astring];
			} else {
				$p_s = '';
				$p_t = '';
			}
			$data['title'] 			= $p_s . ' -- ' . get_bloginfo('name') ;
			$data['premessage'] 	= $p_s;
			$data['messageheader'] 	= $p_s;
			$data['mainmessage'] 	= $p_t;
			$data['messagedata'] 	= $op;
			$data['emailaddress'] 	= $amail;

			$op .= cro_sendnewsletter($data);

	}

	return $amail;
}



/* 
 * -04- NEWSLETTER PROCESSOR
 * */

function cro_sendnewsletter($data){

	$op = '';

	$tpl = create_newslform();

	$replacearray = array(
		'::[cro_tmplclr]::' 	=> $data['color'],
		'::[Cro_title]::' 		=> $data['title'],
		'::[Cro_premsg]::' 		=> stripslashes($data['premessage']),
		'::[Cro_headimg]::' 	=> $data['logo'],
		'::[Cro_msg]::' 		=> stripslashes($data['messageheader']),
		'::[Cro_pghead]::' 		=> stripslashes($data['mainmessage']),
		'::[Cro_msgdata]::' 	=> stripslashes($data['messagedata']),
		'::[Cro_cpy]::' 		=> $data['copyright'],
		'::[cro_sitename]::' 	=> $data['sitename'],
		'::[cro_siteurl]::' 	=> $data['sitelink']
	);

	foreach ($replacearray as $k => $v) $tpl = str_replace($k,$v,$tpl);


	$realemail = (is_email($data['emailaddress'])) ? $data['emailaddress'] : get_option('admin_email');
	add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));	
	$headers = 'From: '. get_option('blogname') .' <' . $realemail . '>';


	if ($tpl && $data['title']) {
		wp_mail($realemail, $data['title'] , $tpl, $headers);	
	}

	return ;
}



function create_newslform() {

	return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <title>::[Cro_title]::</title>
		<style type="text/css">
		
			/* Browser specific */
			#outlook a{padding:0;} 
			body{width:100% !important;} .ReadMsgBody{width:100%;} 
			.ExternalClass{width:100%;} 
			body{-webkit-text-size-adjust:none;}

			/* Reset Styles */
			body{margin:0; padding:0;}
			img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
			table td{border-collapse:collapse;}
			#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}

			/* Template Styles */


			body, #backgroundTable{
				background-color:#F3f3f3;
				border-top: 5px solid ::[cro_tmplclr]::;
			}

			h1, .h1{
				color:#202020;
				display:block;
				font-family:Arial;
				font-size:34px;
				font-weight:bold;
				line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}

			h2, .h2{
				color:#202020;
				display:block;
				font-family:Arial;
				font-size:30px;
				font-weight:bold;
				line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}

			h3, .h3{
				color:#707677;
				display:block;
				font-family:Arial;
				font-size:26px;
				font-weight:bold;
				line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}


			h4, .h4{
				color: #707677;
				display:block;
				font-family:Arial;
				font-size:22px;
				font-weight:bold;
				line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}

			#templatePreheader{
				background-color:#F3f3f3;
			}

			.preheaderContent div{
				color:#505050;
				font-family:Arial;
				font-size:10px;
				line-height:100%;
				text-align:center;
			}

			.preheaderContent div a:link, .preheaderContent div a:visited, /* Yahoo! Mail Override */ .preheaderContent div a .yshortcuts /* Yahoo! Mail Override */{
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}

			#templateHeader{
				background-color:#FFFFFF;
				border-bottom:0;
			}

			.headerContent{
				color:#202020;
				font-family:Arial;
				font-size:34px;
				font-weight:bold;
				line-height:100%;
				padding:0;
				text-align:center;
				vertical-align:middle;
			}
			
			.headerContent a:link, .headerContent a:visited, /* Yahoo! Mail Override */ .headerContent a .yshortcuts /* Yahoo! Mail Override */{
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}

			#headerImage{
				height:auto;
				max-width:600px !important;
			}

			#templateContainer, .bodyContent{
				background-color:#FFFFFF;
			}

			.bodyContent div{
				color:#505050;
				 font-family:Arial;
				font-size:14px;
				line-height:150%;
				text-align:left;
			}

			
			.bodyContent div a:link, .bodyContent div a:visited, /* Yahoo! Mail Override */ .bodyContent div a .yshortcuts /* Yahoo! Mail Override */{
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}

			.bodyContent img{
				display:inline;
				height:auto;
			}


			#templateFooter{
				background-color:#FFFFFF;
				border-top:0;
			}

			.footerContent div{
				color:#707070;
				font-family:Arial;
				font-size:12px;
				line-height:125%;
				text-align:left;
			}

			.footerContent div a:link, .footerContent div a:visited, /* Yahoo! Mail Override */ .footerContent div a .yshortcuts /* Yahoo! Mail Override */{
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}

			.footerContent img{
				display:inline;
			}

			
			#social{
				background-color:#FAFAFA;
				border:0;
			}

			#social div{
				text-align:center;
			}

			#utility{
				background-color:#FFFFFF;
				border:0;
			}

			#utility div{
				text-align:center;
			}

			#monkeyRewards img{
				max-width:190px;
			}
		</style>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    	<center>
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
            	<tr>
                	<td align="center" valign="top">
                        <!--  Begin Template Preheader  -->
                        <table border="0" cellpadding="10" cellspacing="0" width="600" id="templatePreheader">
                            <tr>
                                <td valign="top" class="preheaderContent">
                                
                                	<!--  Begin Module: Standard Preheader  -->
                                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                    	<tr>
                                        	<td valign="top">
                                            	<div mc:edit="std_preheader_content">
                                                	::[Cro_premsg]::
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                	<!--  End Module: Standard Preheader  -->
                                
                                </td>
                            </tr>
                        </table>
                        <!-- // End Template Preheader  -->
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Header  -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader">
                                        <tr>
                                            <td class="headerContent" style="background: ::[cro_tmplclr]::;">
                                            
                                            	<img src="::[Cro_headimg]::" style="max-width:600px; padding: 30px 0;" id="headerImage campaign-icon" mc:label="header_image" mc:edit="header_image" mc:allowdesigner mc:allowtext />
                                          
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Header  -->
                                </td>
                           </tr>
                         </table>
                         <br/>
                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Body  -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                    	<tr>
                                            <td valign="top" class="bodyContent">
                                
                                                <!-- // Begin Module: Standard Content  -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top">
                                                            <div mc:edit="std_content00">
                                                                <h3 class="h3" style="text-align: center; margin: 0px;">::[Cro_msg]::</h3>
                                                            </div>
														</td>
                                                    </tr>
                                                </table>
                                                <!-- // End Module: Standard Content  -->
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Body  -->
                                </td>
                            </tr>
                           </table>
                         <br/>
                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Body  -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                    	<tr>
                                            <td valign="top" class="bodyContent">
                                
                                                <!-- // Begin Module: Standard Content  -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                    	<td valign="top" colspan="2" style="padding: 10px 0 0 0;">
                                                            <div mc:edit="std_content00">
                                                                <h4 style="text-align:center;">::[Cro_pghead]::</h4> 
                                                            </div>
														</td>
													</tr>
													::[Cro_msgdata]::
                                                </table>
                                                <!-- // End Module: Standard Content  -->
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Body  -->
                                </td>
                            </tr>
                         </table>
                         <br/>
                         <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer" style="border: 1px solid ::[cro_tmplclr]::; background: ::[cro_tmplclr]::; color: #FDAC43;">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Footer  -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" id="templateFooter" style="background: ::[cro_tmplclr]::; color: #FDAC43;">
                                    	<tr>
                                        	<td valign="top" class="footerContent">
                                            
                                                <!-- // Begin Module: Standard Footer  -->
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    
                                                    <tr>
                                                        <td valign="top" width="350">
                                                            <div mc:edit="std_footer" style="background: ::[cro_tmplclr]::; color: #232323; font-weight: bold;">
																<em>::[Cro_cpy]::</em>
                                                            </div>
                                                        </td>
                                                        <td valign="top" width="190" id="cro_ftr">
                                                            <div style="text-align: right;">
                                                               <a href="::[cro_siteurl]::" style="background: ::[cro_tmplclr]::; color: #232323; font-weight: bold; text-decoration: none;">::[cro_sitename]::</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // End Module: Standard Footer  -->
                                            
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Footer  -->
                                </td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>';
}



?>