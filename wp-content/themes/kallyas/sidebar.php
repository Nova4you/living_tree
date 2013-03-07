	<div id="sidebar" class="<?php //echo $sidebar_position; ?>">
	    <div id="sidebarSubnav">

<?php		    // Widgetized sidebar
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Slider') ) : ?>

			<div class="custom-formatting">
			    <h3><?php esc_html_e('About This Sidebar', 'webiana'); ?></h3>
			    <ul>
				<?php _e("To edit this sidebar, go to admin backend's <strong><em>Appearance -> Widgets</em></strong> and place widgets into the <strong><em>Pages Sidebar</em></strong> Widget Area", 'webiana'); ?>
			    </ul>
			</div>

<?php		    endif; ?>
	    </div>
	    <!-- end sidebarSubnav -->
	</div>
	<!-- end sidebar -->