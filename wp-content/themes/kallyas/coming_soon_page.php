<!DOCTYPE html>
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->

<head>
	<title><?php bloginfo('name'); ?> <?php wp_title('|',true,'');?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	
	<link rel="profile" href="http://gmpg.org/xfn/11" /> 
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />  
	
	
	<?php global $data; ?>
	
	<?php zn_favicon(); ?>

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<!--[if lte IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo THEME_DIR; ?>/css/fixes.css" />
	<![endif]-->
	
	<!--[if lte IE 8]>
		<script src="js/respond.js"></script>
		<script type="text/javascript"> 
		var $buoop = {vs:{i:8,f:6,o:10.6,s:4,n:9}} 
		$buoop.ol = window.onload; 
		window.onload=function(){ 
		 try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
		 var e = document.createElement("script"); 
		 e.setAttribute("type", "text/javascript"); 
		 e.setAttribute("src", "http://browser-update.org/update.js"); 
		 document.body.appendChild(e); 
		} 
		</script> 
	<![endif]-->
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
    <?php wp_head(); ?>

	<!-- TO BE MOVED IN FUNCTIONS -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:300,400,700,900&amp;v1&mp;subset=latin,latin-ext" type="text/css" media="screen" id="google_font" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700&amp;v1&mp;subset=latin,latin-ext" type="text/css" media="screen" id="google_font_body" />
	
	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.1/modernizr.min.js" type="text/javascript"></script>
	

	
</head>

<body class="offline-page">

			<!-- ADD AN APPLICATION ID !!
			If you want to know how to find out your app id, either search on google for: facebook appid, either go to http://rieglerova.net/how-to-get-a-facebook-app-id/ -->
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "http://connect.facebook.net/en_US/all.js#xfbml=1&appId="; // addyour appId here
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
				<div id="background"></div>
				
				
				<div class="containerbox">
					<?php echo zn_logo(); ?>
					<div class="content">
						<p><?php echo stripslashes( $data['cs_desc'] ); ?></p>
						
						<?php
							if ( !empty ( $data['cs_date']['date'] ) && !empty ( $data['cs_date']['time'] ) ) {
								
								echo '<div class="ud_counter">';
									echo '<ul id="Counter">';
										echo '<li>0<span>day</span></li>';
										echo '<li>00<span>hours</span></li>';
										echo '<li>00<span>min</span></li>';
										echo '<li>00<span>sec</span></li>';
									echo '</ul>';
									echo '<span class="till_lauch"><img src="'.THEME_DIR.'/images/rocket.png"></span>';
								echo '</div><!-- end counter -->';
								
							}

							if ( !empty ( $data['cs_lsit_id'] ) && !empty ( $data['mailchimp_api'] ) ) {
							
								echo '<div class="mail_when_ready">';
								echo	'		<form method="post" class="newsletter_subscribe newsletter-signup" data-url="'.trailingslashit(home_url()).'" name="newsletter_form">';
								echo	'			<input type="text" name="zn_mc_email" class="nl-email" value="" placeholder="your.address@email.com" />';
								echo	'			<input type="hidden" name="zn_list_class" class="nl-lid" value="'.$data['cs_lsit_id'].'" />';
								echo	'			<input type="submit" name="submit" class="nl-submit" value="JOIN US" />';
								echo	'		</form>';
								echo 	'<span class="zn_mailchimp_result"></span>';
								echo 	'</div>';
								
							}
							
							if ( isset( $data['cs_social_icons'] ) && is_array( $data['cs_social_icons'] ) ) {
							
								
								echo '<ul class="social-icons fixclear">';
																		
									foreach ( $data['cs_social_icons'] as $key=>$icon ){
									
										$link = '';
										$target = '';
									
										if ( isset ( $icon['cs_social_link'] ) && is_array ( $icon['cs_social_link'] )) {
											$link = $icon['cs_social_link']['url'];
											$target = 'target="'.$icon['cs_social_link']['target'].'"';
										}
										
									
										echo '<li class="'.$icon['cs_social_icon'].'"><a href="'.$link.'" '.$target.'>'.$icon['cs_social_title'].'</a></li>';
									}
									
								echo '</ul>';
								
							}
							
						?>				
						
						<div class="clear"></div>
					</div><!-- end content -->
					<div class="clear"></div>
				</div>

	<!-- Start the script holder -->
	<div id="wp-scripts">

		<?php wp_footer(); ?>
		
		<?php

		// Load the ZN_SCRIPT.js
		wp_print_scripts( 'zn-script');
		smart_load();
		global $zn_array;
		
		echo '<script type="text/javascript">';
			foreach ( $zn_array as $inline_script ){
				echo $inline_script;
			}
		echo '</script>';
		
		// Load the OPTIONS.js
		wp_print_scripts( 'options');
		
		?>
		
	</div>
	<!-- End the script holder -->

</body>
</html>