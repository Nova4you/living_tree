<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post,$woocommerce, $product,$data;

/*--------------------------------------------------------------------------------------------------
	New BADGE
--------------------------------------------------------------------------------------------------*/

	global $data;
	$new_badge = '';
	if ( $data['woo_new_badge'] ) {
	
		$now = time();
		$diff = (get_the_time('U') > $now) ? get_the_time('U') - $now : $now - get_the_time('U');
		$val = floor($diff/86400);
		$days = floor(get_the_time('U')/(86400));
		
		if ( $data['woo_new_badge_days'] >= $val ) {
			$new_badge = '<span class="znew">'.__('NEW!', 'woocommerce').'</span>';
		}

	} 
		
/*--------------------------------------------------------------------------------------------------
	SALE BADGE
--------------------------------------------------------------------------------------------------*/
	$on_sale = '';
	if ($product->is_on_sale()) : 

		$on_sale = '<span class="zonsale">'.__('SALE!', 'woocommerce').'</span>'; 

	endif; 

	$meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
	$meta_fields = maybe_unserialize( $meta_fields );

?>


	<?php if ( has_post_thumbnail() ) : ?>

		<div class="product-gallery">
			<div class="zn_badge_container">
				<?php echo $on_sale;?>
				<?php echo $new_badge;?>
			</div>
			<div class="big_image">
			
				<?php
					$image = vt_resize( get_post_thumbnail_id($post->ID), ''  , 260,'' , true );
				?>
			
			
				<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" rel="prettyPhoto"><img src="<?php echo $image['url'];?>" title="<?php echo get_the_title( get_post_thumbnail_id() ); ?>" alt="" /></a>
			</div>
			
			<?php
				
				if ( !empty ( $meta_fields['woo_image_gallery'] ) && is_array( $meta_fields['woo_image_gallery'] ) ) {
					
					echo '<ul class="thumbs">';
					
						foreach ( $meta_fields['woo_image_gallery'] as $simage ) {
						
							$image = '';
							
							if ( !empty ( $simage['woo_single_image'] ) ) {
								$image = vt_resize( '', $simage['woo_single_image']  , 50,'50' , true );
								echo '<li><a href="'.$simage['woo_single_image'].'" rel="prettyPhoto"><img src="'.$image['url'].'" alt="" /></a></li>';
							}
							
							
						}
					
					echo '</ul>';
					
				}
				
			?>

			<div class="clear"></div>
		</div>

	
	<?php else : ?>
		
			<div class="product-gallery">
				<div class="zn_badge_container">
					<?php echo $on_sale;?>
					<?php echo $new_badge;?>
				</div>
				<div class="big_image">
					<img src="<?php echo woocommerce_placeholder_img_src(); ?>" alt="Placeholder" />
				<div class="clear"></div>
				</div>
			</div>	
		
	<?php endif; ?>

	<?php do_action('woocommerce_product_thumbnails'); ?>

