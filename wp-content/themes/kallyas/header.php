<!DOCTYPE html>

<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->

<head>
    <title>
        <?php bloginfo( 'name'); ?>
        <?php wp_title( '|',true, '');?>
    </title>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css' type='text/css' media='all' />
	<?php 
		global $data;
		zn_favicon();
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); 
		wp_head(); 
	?>
</head>
<body  <?php body_class(); ?>>
	<?php zn_page_loading();?>
	<?php zn_hidden_pannel(); ?>
    <?php zn_login_form();?>
	<?php zn_f_o_g();?> 

    <div id="page_wrapper">
        <header id="header" class="<?php echo $data['zn_header_layout']; ?>">
            <div class="container">
                <!-- logo -->
                <?php echo zn_logo(); ?>
								
				<!-- HEADER ACTION -->
				<?php do_action( 'zn_head_right_area' ); ?>
               
				<!-- search -->
				<div id="search">
					<a href="#" class="searchBtn"><span class="icon-search icon-white"></span></a>
					<div class="search">
						<form id="searchform" action="<?php echo home_url(); ?>" method="get">
							<input name="s" maxlength="20" class="inputbox" type="text" size="20" value="<?php echo __( 'SEARCH ...', THEMENAME );?>" onblur="if (this.value=='') this.value='<?php echo __( 'SEARCH ...', THEMENAME );?>';" onfocus="if (this.value=='<?php echo __( 'SEARCH ...', THEMENAME );?>') this.value='';" />
							<input type="submit" id="searchsubmit" value="go" class="icon-search"/>
						</form>
					</div>
				</div>
				<!-- end search -->

				<!-- main menu -->
				<nav id="main_menu">
					<?php zn_show_nav('main_navigation'); ?>
				</nav>
				<!-- end main_menu -->
			</div>
		</header>
<?php

	if($post) {
	    $meta_fields = get_post_meta($post -> ID, 'zn_meta_elements', true);
	    $meta_fields = maybe_unserialize($meta_fields);
	}

	
/*--------------------------------------------------------------------------------------------------

	HEADER AREA

--------------------------------------------------------------------------------------------------*/
	if(isset($meta_fields['header_area']) && is_array($meta_fields['header_area'])) {
	    zn_get_template_from_area('header_area', $post -> ID, $meta_fields);
	}
	elseif(is_404()) {
	    return;
	} else {
	    global $wp_query; ?>

			<div id="page_header" class="gradient zn_def_header_style bottom-shadow">
				<div class="bgback"></div>

				<?php
					if ( isset ( $data['def_header_animate'] ) && !empty ( $data['def_header_animate'] ) ) {
						echo '<div data-images="'.IMAGES_URL.'/" id="sparkles"></div>';
					}
				?>

					<!-- DEFAULT HEADER STYLE -->
					<div class="container">
						<div class="row">
							<div class="span6">
							 
								<?php 
							
									// Breadcrumbs check
									if ( isset ( $data['def_header_bread'] ) && !empty ( $data['def_header_bread'] ) ) {
										zn_breadcrumbs();
									}
									
									// Date check
									if ( isset ( $data['def_header_date'] ) && !empty ( $data['def_header_date'] ) ) {
										echo '<span id="current-date">'.date("l M d, Y").'</span>';
									}
									
								?>
							</div>
							<div class="span6">
								<div class="header-titles">
									<?php
									// Title check

									if ( isset ( $data['def_header_title'] ) && !empty ( $data['def_header_title'] ) ) {

										if ( isset ( $meta_fields['page_title'] ) && !empty ( $meta_fields['page_title'] ) ) {
											echo '<h2>'.do_shortcode( stripslashes( $meta_fields['page_title'] ) ).'</h2>';
										}

										elseif ( is_post_type_archive( 'post' ) || is_home() ) { 
											if ( isset ( $data['archive_page_title'] ) && !empty ( $data['archive_page_title'] ) ) {
												if ( function_exists ('icl_t') )
												{
													$title = icl_t(THEMENAME, 'Archive Page Title', do_shortcode(stripslashes($data['archive_page_title'])));
												}
												else
												{
													$title = do_shortcode(stripslashes($data['archive_page_title']));
												}
												echo '<h2>'.$title.'</h2>';
											}
										}
										elseif ( is_category() ) {
											echo '<h2>'.single_cat_title('', false).'</h2>';
										}
										elseif ( is_tax('product_cat') ) {
											$queried_object = $wp_query->get_queried_object();
											echo '<h2>'. $queried_object->name . '</h2>';
										}
										elseif ( is_search() ) {
											echo '<h2>'. __("Search results for ",THEMENAME).'"' . get_search_query() . '"</h2>';
										}
										elseif ( is_day() ) {
											echo '<h2>'.get_the_time('d').'</h2>';					 
										} elseif ( is_month() ) {
											echo '<h2>'.get_the_time('F').'</h2>';
										} elseif ( is_year() ) {
											echo '<h2>'.get_the_time('Y').'</h2>';
										}
										elseif ( is_tag() ) {
											echo '<h2>'. __("Posts tagged ",THEMENAME).'"'.single_tag_title('', false).'"</h2>';
										}
										elseif ( is_author() ) {
											global $author;
											$userdata = get_userdata($author);
											echo '<h2>'. __("Articles posted by ",THEMENAME) . $userdata->display_name .'</h2>';
										}
										else {
											echo '<h2>'.wp_title('',false).'</h2>';
										}
									}

									// Subtitle check
									if ( isset ( $data['def_header_subtitle'] ) && !empty ( $data['def_header_subtitle'] ) ) {

										if ( isset ( $meta_fields['page_subtitle'] ) && !empty ( $meta_fields['page_subtitle'] ) ) {
											echo '<h4>'.do_shortcode( stripslashes( $meta_fields['page_subtitle'] ) ).'</h4>';
										}
										elseif ( is_post_type_archive( 'post' ) || is_home() ) { 
											if ( isset ( $data['archive_page_subtitle'] ) && !empty ( $data['archive_page_subtitle'] ) ) {
												if ( function_exists ('icl_t') )
												{

													$subtitle = icl_t(THEMENAME, 'Archive Page Subtitle', do_shortcode(stripslashes($data['archive_page_subtitle'])));
												}
												else
												{
													$subtitle = do_shortcode(stripslashes($data['archive_page_subtitle']));
												}
												echo '<h4>'.$subtitle.'</h4>';
											}
										}
									}
									?>
								</div>
							</div>
						</div><!-- end row -->
					</div>
				<div class="shadowUP"></div>
			</div><!-- end page_header -->
		<?php
	}
?>