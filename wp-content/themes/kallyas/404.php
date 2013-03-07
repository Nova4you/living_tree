<?php get_header(); 
global $data;

$style = 'uh_'.$data['404_header_style'];

?>


<div class="error404-page">

		<div id="page_header" class="<?php echo $style; ?> bottom-shadow">
			<div class="bgback"></div>
			
			<div data-images="<?php echo THEME_DIR; ?>/images/" id="sparkles"></div>

			
			<div class="zn_header_bottom_style"></div>
		</div><!-- end page_header -->

	<section id="content">
		<div class="container">
			
			<div id="mainbody">
				
				<div class="row">
					<div class="span12">
						
						<div class="error404">
							<h2><span>404</span></h2>
							<h3><?php echo __("The page cannot be found.",THEMENAME);?></h3>
						</div>
						
					</div>
				</div><!-- end row -->
				
			</div><!-- end mainbody -->
			
		</div><!-- end container -->
	</section><!-- end #content -->
</div>
<?php get_footer(); ?>