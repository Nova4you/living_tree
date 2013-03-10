<?php get_header(); ?>

	<section id="content">
		<div class="container">
			
			<div id="mainbody">
				<div class="row">
				<?php
				
					// Here will check if sidebar is enabled
					$content_css = 'span12'; 
					$sidebar_css = ''; 
					$has_sidebar = false;
					
					if ( $data['archive_sidebar_position'] == 'left_sidebar'   )
					{
						$content_css = 'span9 zn_float_right';
						$sidebar_css = 'sidebar-left';
						$has_sidebar = true;
					}
					elseif ( $data['archive_sidebar_position'] == 'right_sidebar'   )
					{
						$content_css = 'span9';
						$sidebar_css = 'sidebar-right';
						$has_sidebar = true;
					}

				?>
				
					<div class="<?php echo $content_css; ?>">
						 
						 <div class="itemListView clearfix eBlog">

							<div class="itemList">
							
							<?php
							if ( have_posts() ) :
								while( have_posts() ){

									the_post();
									
									$image = '';
									$short_desription = '';
									
									// Create the featured image html
									if ( has_post_thumbnail( $post->ID ) ) {
										$thumb = get_post_thumbnail_id($post->ID) ;
										$f_image = wp_get_attachment_url($thumb) ;
										if ( !empty ( $f_image ) ) {
											$feature_image = wp_get_attachment_url( $thumb );
											$image = vt_resize( '', $f_image  , 280,187 , true );
											$image = '<a href="'.get_permalink().'" class="hoverBorder pull-left" style="margin-right: 20px;margin-bottom:4px;"><img class="shadow" src="'.$image['url'].'" alt=""/></a>';
										}
									}else{
										//try to get thumbnail from business workshop table by post id
										$mylink = $wpdb->get_row('SELECT image1,description FROM business_info WHERE post_id = '.$post->ID);
										$image = '<a href="'.get_permalink().'" class="hoverBorder pull-left" style="margin-right: 20px;margin-bottom:4px;"><img width="280px" height="187px" class="shadow" src="'.$mylink->image1.'" alt=""/></a>';
										$short_desription = $mylink->description;
									}

									?>
									
									<div class="itemContainer post-<?php the_ID(); ?>"> 
								
										<div class="itemHeader">
											<h3 class="itemTitle">
												<a href="<?php the_permalink(); ?>" class="pages-blogitem.html"><?php the_title();?></a>
											</h3>
										</div><!-- end itemHeader -->
								
										<div class="itemBody">
											<div class="itemIntroText">
											<?php
												if ( preg_match('/<!--more(.*?)?-->/', $post->post_content) ) {
													echo $image;
													if (strlen($short_desription)>0) {
														echo '<p>'.$short_desription.'</p>';
													}else{
														the_content('');
													}
												}
												else {
													echo $image;
													
													if (strlen($short_desription)>0) {
														echo '<p>'.$short_desription.'</p>';
													}else{
														the_excerpt();
													}
												}
											?>
											
											</div><!-- end Item Intro Text -->
											<div class="clear"></div>
											<div class="itemReadMore">
												<a class="readMore" href="<?php the_permalink(); ?>"><?php echo __( 'Read more...', THEMENAME );?></a>
											</div><!-- end read more -->
											<div class="clear"></div>
										</div><!-- end Item BODY -->
								
										<ul class="itemLinks clearfix">
											<li class="itemCategory">
												<span class="icon-folder-close"></span> 
												<span><?php echo __( 'In: ', THEMENAME );?></span>
												<?php the_category(", ");  ?>
											</li>
										</ul><!-- item links -->
										<div class="clear"></div>
									<?php	if (has_tag()) { ?>
											<div class="itemTagsBlock">
												<span class="icon-tags"></span>
												<span><?php echo __( 'Tagged under:', THEMENAME );?></span>
												<?php the_tags('');?>
												<div class="clear"></div>
											</div><!-- end tags blocks -->
									<?php	}	?>	
										

									
								</div><!-- end Blog Item -->
								<div class="clear"></div>
								
							<?php 
								} 
							else: ?>
								<div class="itemContainer noPosts"> 
									<p><?php echo __('Sorry, no posts matched your criteria.', THEMENAME ); ?></p>
								</div><!-- end Blog Item -->
								<div class="clear"></div>
							<?php endif; ?>
							
							</div><!-- end .itemList -->
						
							<!-- Pagination -->
							<?php zn_pagination(); ?>
						
						</div><!-- end blog items list (.itemListView) -->

					</div>
					
					
				<?php if ( $data['archive_sidebar_position'] != 'no_sidebar' && !empty( $data['archive_sidebar'] ) ) { ?>
						
						<div class="span3">
							<div id="sidebar" class="sidebar <?php echo $sidebar_css; ?>">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['archive_sidebar']) ) : endif; ?>
							</div>
						</div>
				<?php } ?>
										
				</div><!-- end row -->
				
			</div><!-- end mainbody -->
			
		</div><!-- end container -->
	</section><!-- end content -->

<?php get_footer(); ?>