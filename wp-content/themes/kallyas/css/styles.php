/*----------------------  Logo --------------------------*/
<?php 

if(isset($data['logo_upload']) && !empty($data['logo_upload'])) {

	if($data['logo_size'] == 'yes'){
		$logo_size = getimagesize($data['logo_upload']);
		
		if (isset($logo_size[0]) && isset($logo_size[1])) {
			$logo_width = 'width:auto;';
			$logo_height = 'height:auto;';
		}
		else {
			$logo_width = '';
			$logo_height = '';
		}
	}
	if($data['logo_size'] == 'no'){
		if ( isset( $data['logo_manual_size']['width'] ) && !empty( $data['logo_manual_size']['width'] ) ) {
			$logo_width = 'width:'.$data['logo_manual_size']['width'].'px;';
		}
		else {
			$logo_width = '';
		}
		
		if(isset($data['logo_manual_size']['height']) && !empty($data['logo_manual_size']['height'])) {
			$logo_height = 'height:'.$data['logo_manual_size']['height'].'px;';
		}
		else {
			$logo_height = '';
		}
	}
?>
#logo a img{
	max-width:none;
	<?php echo $logo_width; ?>
	<?php echo $logo_height; ?>
	
}

<?php } 
else { ?>
#logo ,#logo a  {
	<?php if ( isset ( $data['fonts']['logo_font'] ) && !empty ( $data['fonts']['logo_font'] ) ) { echo 'font-family:'.$data['fonts']['logo_font'].';'; } ?>
	<?php if ( isset ( $data['logo_font']['size'] ) && !empty ( $data['logo_font']['size'] ) ) { echo 'font-size:'.$data['logo_font']['size'].';'; } ?>
	<?php if ( isset ( $data['logo_font']['height'] ) && !empty ( $data['logo_font']['height'] ) ) { echo 'line-height:'.$data['logo_font']['height'].';'; } ?>
	<?php if ( isset ( $data['logo_font']['color'] ) && !empty ( $data['logo_font']['color'] ) ) { echo 'color:'.$data['logo_font']['color'].';'; } ?>
	text-decoration:none;
	<?php
		if( isset ( $data['logo_font']['style'] ) ){
			switch ($data['logo_font']['style']) {
				case 'normal':
					echo 'font-style:normal;';
				break;
				case 'italic':
					echo 'font-style:italic;';
				break;
				case 'bold':
					echo 'font-weight:bold;';
				break;
				case 'bold italic':
					echo  'font-weight:bold;';
					echo  'font-style:italic;'. "\n";
				break;
			}
		}
	?>

}

#logo a:hover , #logo a:hover{
	<?php if ( isset ( $data['logo_hover']['color'] ) && !empty ( $data['logo_hover']['color'] ) ) { echo 'color:'.$data['logo_hover']['color'].';'; } ?>
}

<?php } ?>

/*----------------------  Header --------------------------*/


#page_header.zn_def_header_style , #slideshow.zn_def_header_style {
<?php if ( isset ( $data['def_header_color'] ) && !empty ( $data['def_header_color'] ) ) { echo 'background-color:'.$data['def_header_color'].';'; } ?>
}

#page_header.zn_def_header_style #sparkles, #slideshow.zn_def_header_style #sparkles{
<?php if ($data['def_header_animate'] == '1' ) { echo 'display:block;'; } ?>
}

#page_header.zn_def_header_style .bgback , #slideshow.zn_def_header_style .bgback {
<?php if ( isset ( $data['def_header_background'] ) && !empty ( $data['def_header_background'] ) ) { echo 'background-image:url("'.$data['def_header_background'].'");'; } ?>
}

/*----------------------  Unlimited Headers --------------------------*/

<?php 
	if ( isset ( $data['header_generator'] ) && is_array ( $data['header_generator'] ) ) {
		foreach ( $data['header_generator'] as $header ) {
		
			if ( isset ( $header['uh_style_name'] ) && !empty ( $header['uh_style_name'] ) ) {
			
				//$header_name_striped = explode ( '|', $header['uh_style_name']);
			
				$header_name = strtolower ( str_replace(' ','_',$header['uh_style_name'] ) );
				
				// Page header + BGBACK
				echo '#page_header.uh_'.$header_name.' .bgback , #slideshow.uh_'.$header_name.' .bgback {';
				
				if ( isset ( $header['uh_background_image'] ) && !empty ( $header['uh_background_image'] ) ) {
					echo 'background-image:url("'.$header['uh_background_image'].'");';
				}
				
				echo '}';
				
				// Animate - Page header + SPARKLES
				if ( isset ( $header['uh_anim_bg'] ) && !empty ( $header['uh_anim_bg'] ) ) {
					echo '#page_header.uh_'.$header_name.' #sparkles , #slideshow.uh_'.$header_name.' #sparkles {display:block}';
				}
				else {
					echo '#page_header.uh_'.$header_name.' #sparkles , #slideshow.uh_'.$header_name.' #sparkles{display:none}';
				}
				
				// COLOR - Page header 
				echo '#page_header.uh_'.$header_name.' , #slideshow.uh_'.$header_name.' {';
				
				if ( isset ( $header['uh_header_color'] ) && !empty ( $header['uh_header_color'] ) ) {
					echo 'background-color:'.$header['uh_header_color'].';';
				}
				
				// GRADIENT OVER COLOR
				if ( isset ( $header['uh_grad_bg'] ) && !empty ( $header['uh_grad_bg'] ) ) {

					echo 'background-image: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 100%); /* FF3.6+ */ ';
					echo 'background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.5))); /* Chrome,Safari4+ */';
					echo 'background-image: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* Chrome10+,Safari5.1+ */';
					echo 'background-image: -o-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* Opera 11.10+ */';
					echo 'background-image: -ms-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* IE10+ */';
					echo 'background-image: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* W3C */';
					echo "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#80000000',GradientType=0 ); /* IE6-9 */";
				}
				
				echo '}';
				
				// GLARE EFFECT
				if ( isset ( $header['uh_glare'] ) && !empty ( $header['uh_glare'] ) ) {
				
					echo '#page_header.uh_'.$header_name.' .bgback:after , #slideshow.uh_'.$header_name.' .bgback:after {';
						echo 'content:""; position:absolute; top:0; left:0; width:100%; height:100%; z-index:-1;background-image: url(../images/glare-effect.png); background-repeat: no-repeat; background-position: center top;';
					echo '}';
				
				}
				
				// Default SHADOW
				if ( isset ( $header['uh_bottom_style'] ) && $header['uh_bottom_style'] == 'shadow' ) {
				
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style , #slideshow.uh_'.$header_name.' .zn_header_bottom_style {';
						echo 'position:absolute; bottom:0; left:0; width:100%; height:20px; background:url(../images/shadow-up.png) no-repeat center bottom; z-index: 2;';
					echo '}';
					
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style:after , #slideshow.uh_'.$header_name.' .zn_header_bottom_style:after {';
						echo 'content:\'\'; position:absolute; bottom:-18px; left:50%; border:6px solid transparent; border-top-color:#fff; margin-left:-6px;';
					echo '}';
					
					echo '#page_header.uh_'.$header_name.', #slideshow.uh_'.$header_name.' {';
						echo 'border-bottom:6px solid #FFFFFF';
					echo '}';
					
				}
				
				
				// SHADOW UP AND DOWN
				if ( isset ( $header['uh_bottom_style'] ) && $header['uh_bottom_style'] == 'shadow_ud' ) {
				
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style , #slideshow.uh_'.$header_name.' .zn_header_bottom_style {';
						echo 'position:absolute; bottom:0; left:0; width:100%; height:20px; background:url(../images/shadow-up.png) no-repeat center bottom; z-index: 2;';
					echo '}';
					
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style:after , #slideshow.uh_'.$header_name.' .zn_header_bottom_style:after {';
						echo 'content:\'\'; position:absolute; bottom:-18px; left:50%; border:6px solid transparent; border-top-color:#fff; margin-left:-6px;';
					echo '}';
					
					echo '#page_header.uh_'.$header_name.', #slideshow.uh_'.$header_name.' {';
						echo 'border-bottom:6px solid #FFFFFF';
					echo '}';
					
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style:before , #slideshow.uh_'.$header_name.' .zn_header_bottom_style:before {';
						echo 'content:\'\'; position:absolute; bottom:-26px; left:0; width:100%; height:20px; background:url(../images/shadow-down.png) no-repeat center top; opacity:.6; filter:alpha(opacity=60);';
					echo '}';
					
				}
				
				// MASK 1
				if ( isset ( $header['uh_bottom_style'] ) && $header['uh_bottom_style'] == 'mask1' ) {
				
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style , #slideshow.uh_'.$header_name.' .zn_header_bottom_style {';
						echo 'position:absolute; bottom:0; left:0; width:100%; height:27px; z-index:99; background:url(../images/bottom_mask.png) no-repeat center top;';
					echo '}';
										
				}
				
				// MASK 2
				if ( isset ( $header['uh_bottom_style'] ) && $header['uh_bottom_style'] == 'mask2' ) {
				
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style , #slideshow.uh_'.$header_name.' .zn_header_bottom_style {';
						echo 'position:absolute; bottom:0; left:0; width:100%; height:27px; z-index:99; background:url(../images/bottom_mask.png) no-repeat center top;';
						echo 'height:33px; background:url(../images/bottom_mask2.png) no-repeat center top;';
					echo '}';
										
				}
				
			}

		}
	}
?>
/* GENERAL COLOR */

	a:hover, 
	.cart_details .checkout, 
	.info_pop .buyit, 
	.m_title, 
	.smallm_title, 
	.circle_title, 
	.feature_box .title, 
	.services_box .title, 
	.latest_posts.default-style .hoverBorder:hover h6, 
	.latest_posts.style2 ul.posts .title, 
	.latest_posts.style3 ul.posts .title, 
	.recentwork_carousel li .details h4, 
	.acc-group.default-style > button, 
	.acc-group.style3 > button:after, 
	.screenshot-box .left-side h3.title, 
	.vertical_tabs .tabbable .nav>li>a:hover, 
	.vertical_tabs .tabbable .nav>li.active>a, 
	.services_box.style2 .box .list li, 
	.shop-latest .tabbable .nav li.active a, 
	.product-list-item:hover .details h3, 
	.latest_posts.style3 ul.posts .title a,
	.statbox h4 
	{color:<?php echo $data['zn_main_color']; ?>;}
	
	.acc-group.style3 > button:hover, 
	.acc-group.style3 > button:hover:after 
	{ color:<?php echo $data['zn_main_color'];?> ;}

	.tabs_style1 > ul.nav > li.active > a, 
	header.style1, 
	header.style2 #logo a, 
	header.style3 #logo a 
	{border-top: 3px solid <?php echo $data['zn_main_color'];?>;}

	nav#main_menu > ul > li.active > a, 
	nav#main_menu > ul > li > a:hover, 
	nav#main_menu > ul > li:hover > a, 
	.social-icons li a:hover, 
	#action_box, 
	.circlehover,
	body .flex-direction-nav li a:hover , 
	body .iosSlider .item .caption.style1 .more::before, 
	body .iosSlider .item .caption.style1 .more::after, 
	body .iosSlider .item .caption.style2 .more ,
	body .nivo-directionNav a:hover,
	body #wowslider-container a.ws_next:hover, 
	body #wowslider-container a.ws_prev:hover,
	.br-next:hover, .br-previous:hover,
	body .ca-more,
	body .title_circle,
	body .title_circle::before,
	body ul.links li a,
	.hg-portfolio-sortable #portfolio-nav li a:hover, .hg-portfolio-sortable #portfolio-nav li.current a,
	.iosSlider .item .caption.style1 .more:before, .iosSlider .item .caption.style1 .more:after
	{background-color:<?php echo $data['zn_main_color'];?> ;}

	.how_to_shop .number, .newsletter-signup input[type=submit], .vertical_tabs .tabbable .nav>li.active>a>span, .vertical_tabs .tabbable .nav>li>a:hover>span, #map_controls, .hg-portfolio-sortable #portfolio-nav li.current a, .ptcarousel .controls > a:hover, .itemLinks span a:hover, .product-list-item .details .actions a, .shop-features .shop-feature:hover, .btn-flat, .redbtn, #sidebar ul.menu li a:hover, .imgboxes_style1 .hoverBorder h6, .feature_box.style3 .box:hover, .services_box .box:hover .icon, .latest_posts.default-style .hoverBorder h6, .process_steps .step.intro, .recentwork_carousel.style2 li a .details .plus, .gobox.ok, .hover-box:hover, .recentwork_carousel li .details > .bg, .circlehover:before,.iosSlider .item .caption.style1 .more:before, .iosSlider .item .caption.style1 .more:after ,.iosSlider .item .caption.style2 .more {background-color:<?php echo $data['zn_main_color'];?>;}
	#action_box:before {border-top-color:<?php echo $data['zn_main_color'];?>;}

	/* BORDER LEFT */
	.process_steps .step.intro:after,
	body .nivo-caption,
	body .flex-caption,
	body #wowslider-container .ws-title
	{border-left-color:<?php echo $data['zn_main_color'];?>; }

	.theHoverBorder:hover {box-shadow:0 0 0 5px <?php echo $data['zn_main_color'];?> inset;}

	.offline-page .containerbox {border-bottom:5px solid <?php echo $data['zn_main_color'];?>; }

	.offline-page .containerbox:after {border-top: 20px solid <?php echo $data['zn_main_color'];?>;}

	header#header.style2 #logo a {border-top: 3px solid <?php echo $data['zn_main_color'];?>;}

	body .iosSlider .item .caption.style2 .title_big, body .iosSlider .item .caption.style2 .title_small {border-left: 5px solid <?php echo $data['zn_main_color'];?>; }
	body .iosSlider .item .caption.style2.fromright .title_big, body .iosSlider .item .caption.style2.fromright .title_small {border-right: 5px solid <?php echo $data['zn_main_color'];?> ; }

	nav#main_menu > ul > li > a {
	<?php if ( !empty( $data['zn_mainmenu_color'] ) ) { echo 'color:'.$data['zn_mainmenu_color'].';'; } ?>
	}

/* HEADINGS */
h1 {
	
	<?php if ( isset ( $data['fonts']['h1_typo'] ) && !empty ( $data['fonts']['h1_typo'] ) ) { echo 'font-family:'.$data['fonts']['h1_typo'].';'; } ?>
	<?php if ( isset ( $data['h1_typo']['size'] ) && !empty ( $data['h1_typo']['size'] ) ) { echo 'font-size:'.$data['h1_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h1_typo']['height'] ) && !empty ( $data['h1_typo']['height'] ) ) { echo 'line-height:'.$data['h1_typo']['height'].';'; } ?>


}

h2 {
	
	<?php if ( isset ( $data['fonts']['h2_typo'] ) && !empty ( $data['fonts']['h2_typo'] ) ) { echo 'font-family:'.$data['fonts']['h2_typo'].';'; } ?>
	<?php if ( isset ( $data['h2_typo']['size'] ) && !empty ( $data['h2_typo']['size'] ) ) { echo 'font-size:'.$data['h2_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h2_typo']['height'] ) && !empty ( $data['h2_typo']['height'] ) ) { echo 'line-height:'.$data['h2_typo']['height'].';'; } ?>


}

h3 {
	
	<?php if ( isset ( $data['fonts']['h3_typo'] ) && !empty ( $data['fonts']['h3_typo'] ) ) { echo 'font-family:'.$data['fonts']['h3_typo'].';'; } ?>
	<?php if ( isset ( $data['h3_typo']['size'] ) && !empty ( $data['h3_typo']['size'] ) ) { echo 'font-size:'.$data['h3_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h3_typo']['height'] ) && !empty ( $data['h3_typo']['height'] ) ) { echo 'line-height:'.$data['h3_typo']['height'].';'; } ?>


}

h4 {
	
	<?php if ( isset ( $data['fonts']['h4_typo'] ) && !empty ( $data['fonts']['h4_typo'] ) ) { echo 'font-family:'.$data['fonts']['h4_typo'].';'; } ?>
	<?php if ( isset ( $data['h4_typo']['size'] ) && !empty ( $data['h4_typo']['size'] ) ) { echo 'font-size:'.$data['h4_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h4_typo']['height'] ) && !empty ( $data['h4_typo']['height'] ) ) { echo 'line-height:'.$data['h4_typo']['height'].';'; } ?>


}

h5 {
	
	<?php if ( isset ( $data['fonts']['h5_typo'] ) && !empty ( $data['fonts']['h5_typo'] ) ) { echo 'font-family:'.$data['fonts']['h5_typo'].';'; } ?>
	<?php if ( isset ( $data['h5_typo']['size'] ) && !empty ( $data['h5_typo']['size'] ) ) { echo 'font-size:'.$data['h5_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h5_typo']['height'] ) && !empty ( $data['h5_typo']['height'] ) ) { echo 'line-height:'.$data['h5_typo']['height'].';'; } ?>


}

h6 {
	
	<?php if ( isset ( $data['fonts']['h6_typo'] ) && !empty ( $data['fonts']['h6_typo'] ) ) { echo 'font-family:'.$data['fonts']['h6_typo'].';'; } ?>
	<?php if ( isset ( $data['h6_typo']['size'] ) && !empty ( $data['h6_typo']['size'] ) ) { echo 'font-size:'.$data['h6_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h6_typo']['height'] ) && !empty ( $data['h6_typo']['height'] ) ) { echo 'line-height:'.$data['h6_typo']['height'].';'; } ?>


}

header#header {
	<?php if( !empty($data['header_style']) && $data['header_style'] == 'image_color'){ echo 'background-color:'.$data['header_style_color'].';'."\n";  } ?>
	<?php if( !empty($data['header_style']) && $data['header_style'] == 'image_color' && isset($data['header_style_image']['image']) && !empty($data['header_style_image']['image'])){ echo 'background-image:url("'.$data['header_style_image']['image'].'");'."\n"; } ?>
	<?php if( !empty($data['header_style']) && $data['header_style'] == 'image_color' && isset($data['header_style_image']['repeat']) && !empty($data['header_style_image']['repeat'])){ echo 'background-repeat:'.$data['header_style_image']['repeat'].';'."\n"; } ?>
	<?php if( !empty($data['header_style']) && $data['header_style'] == 'image_color' && isset($data['header_style_image']['position']) && !empty($data['header_style_image']['position'])){ echo 'background-position:'.$data['header_style_image']['position']['x'].' '.$data['header_style_image']['position']['y'].';'."\n"; } ?>
	<?php if( !empty($data['header_style']) && $data['header_style'] == 'image_color' && isset($data['header_style_image']['attachment']) && !empty($data['header_style_image']['attachment'])){ echo 'background-attachment:'.$data['header_style_image']['attachment'].';'."\n"; } ?>
}

footer#footer {
	<?php if( !empty($data['footer_style']) && $data['footer_style'] == 'image_color'){ echo 'background-color:'.$data['footer_style_color'].';'."\n";  } ?>
	<?php if( !empty($data['footer_style']) && $data['footer_style'] == 'image_color' && isset($data['footer_style_image']['image']) && !empty($data['footer_style_image']['image'])){ echo 'background-image:url("'.$data['footer_style_image']['image'].'");'."\n"; } ?>
	<?php if( !empty($data['footer_style']) && $data['footer_style'] == 'image_color' && isset($data['footer_style_image']['repeat']) && !empty($data['footer_style_image']['repeat'])){ echo 'background-repeat:'.$data['footer_style_image']['repeat'].';'."\n"; } ?>
	<?php if( !empty($data['footer_style']) && $data['footer_style'] == 'image_color' && isset($data['footer_style_image']['position']) && !empty($data['footer_style_image']['position'])){ echo 'background-position:'.$data['footer_style_image']['position']['x'].' '.$data['footer_style_image']['position']['y'].';'."\n"; } ?>
	<?php if( !empty($data['footer_style']) && $data['footer_style'] == 'image_color' && isset($data['footer_style_image']['attachment']) && !empty($data['footer_style_image']['attachment'])){ echo 'background-attachment:'.$data['footer_style_image']['attachment'].';'."\n"; } ?>

}

footer#footer .bottom{
	<?php if ( !empty ( $data['footer_border_color'] ) ) {echo 'border-top:5px solid '.$data['footer_border_color'].';';} ?>
}

<?php 
if ( !empty ( $data['zn_boxed_layout'] ) && $data['zn_boxed_layout'] == 'yes' ) {
	?>
	body {
		<?php if( !empty( $data['boxed_style_color'] ) ){ echo 'background-color:'.$data['boxed_style_color'].';'."\n";  } ?>
		<?php if( !empty( $data['boxed_style_image']['image'] ) ){ echo 'background-image:url("'.$data['boxed_style_image']['image'].'");'."\n"; } ?>
		<?php if( !empty($data['boxed_style_image']['repeat'])){ echo 'background-repeat:'.$data['boxed_style_image']['repeat'].';'."\n"; } ?>
		<?php if( !empty($data['boxed_style_image']['position'])){ echo 'background-position:'.$data['boxed_style_image']['position']['x'].' '.$data['boxed_style_image']['position']['y'].';'."\n"; } ?>
		<?php if( !empty($data['boxed_style_image']['attachment'])){ echo 'background-attachment:'.$data['boxed_style_image']['attachment'].';'."\n"; } ?>

	}
	<?php
}
?>

<?php
	if ( !empty ( $data['zn_custom_css'] ) ) {
		echo  stripslashes ( $data['zn_custom_css'] );
	}
?>









