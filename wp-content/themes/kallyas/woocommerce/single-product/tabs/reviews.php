<?php
/**
 * Reviews tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce, $post;

if ( comments_open() ) : ?>
	<div class="tab-pane" id="tab-reviews">
		<div class="disqusForm">
			<div class="zn_comments sixteen columns">
				<?php comments_template(); ?>
			</div>
		</div>
	</div>
<?php endif; ?>