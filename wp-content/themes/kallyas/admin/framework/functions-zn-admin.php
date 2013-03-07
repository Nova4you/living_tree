<?php

/**************************************************
*	Get default options
**************************************************/



function zn_get_default_values() 
{
	
	global $zn_options;
	
	$defaults = array();
	
	foreach ( $zn_options as $option)
	{
		
		if ( isset( $option['std'] ) )
		{
			// Add default Fonts also
			if ( $option['type'] == 'typography' )
			{
				if ( array_key_exists('face',$option['std'] ) )
				{
					$defaults['fonts'][$option['id']] = $option['std']['face'];
				}
			}
			
			$defaults[$option['id']] = $option['std'];
		}
		
	}
	
	return $defaults;
}

/**************************************************
*	Set default options on theme activation
**************************************************/
function zn_admin_init()
{	
	
	if (!get_option(OPTIONS)){
		
		$defaults = zn_get_default_values();
		
		generate_options_css($defaults); 
		generate_options_js($defaults); 
		update_option(OPTIONS,$defaults);
	}
	
}

	global $pagenow;
	if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
		//Call action that sets the default options
		add_action('admin_head','zn_admin_init');
	}

/**************************************************
*	Set default options on Reset Button Click
**************************************************/
function zn_admin_reset() 
{

	$nonce=$_POST['security'];

	if (!wp_verify_nonce($nonce, 'zn_ajax_nonce') ) {
	
		//header('Location: admin.php?page='.THEMENAME.'&reset=error');
		die('Security Check'); 
		
	} else {	
	
		$defaults = zn_get_default_values();
		
		update_option(OPTIONS,$defaults);
		generate_options_css($defaults); //generate static css file
		generate_options_js($defaults); //generate static js file
		
		//header('Location: admin.php?page='.THEMENAME);
		
	} 

}

if ( isset($_REQUEST['page']) && $_REQUEST['page'] == THEMENAME ) {
	if (isset($_REQUEST['zn_reset']) && 'reset' == $_REQUEST['zn_reset']) {
		
		$nonce=$_POST['security'];
		//Call action that sets the default options
		add_action('admin_head','zn_admin_reset');
		
	}
}


/**************************************************
*	Use new media gallery
*************************************************/
	global $wp_version;
	if ( $wp_version < 3.5 ) {

	}
	else {
		function enqueue_media_stuff(){
		
			if ( ! did_action( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			}
		}
		add_action('admin_enqueue_scripts', 'enqueue_media_stuff');
	}

/**************************************************
*	Create the shortcodes button
*************************************************/

add_action('init', 'zn_sc_button');
add_action( 'admin_footer', 'zn_sc_dialog' );

function zn_sc_button() {
 
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
     return;
   }
 
   if ( get_user_option('rich_editing') == 'true' ) {
     add_filter( 'mce_external_plugins', 'add_plugin' );
     add_filter( 'mce_buttons', 'register_button' );
   }
 
}

function register_button( $buttons ) {
	array_push( $buttons, "|", "zn_button" );
	return $buttons;
}

function add_plugin( $plugin_array ) {
   $plugin_array['zn_button'] = get_template_directory_uri() . '/admin/js/zn_sc_button.js';
   return $plugin_array;
}

function zn_sc_dialog() {

$headings = array (
	'Page Subtitle' => '[subtitle] Content [/subtitle]',
	'H1 Alternative' => '[h1a] Content [/h1a]',
	'H2 Alternative' => '[h2a] Content [/h2a]',
	'H3 Alternative' => '[h3a] Content [/h3a]',
	'H4 Alternative' => '[h4a] Content [/h4a]',
	'H5 Alternative' => '[h5a] Content [/h5a]',
	'H6 Alternative' => '[h6a] Content [/h6a]'
);

$lists = array (
	'Arrow list' => '[list type="list-style1"] <ul><li> First list item </li> <li> Second list item </li> </ul> [/list]',
	'Check list' => '[list type="list-style2"] <ul><li> First list item </li> <li> Second list item </li> </ul> [/list]'
);

$blockquotes = array (
	'Left aligned' => '[blockquote author=""] Content [/blockquote]',
	'Right aligned' => '[blockquote author="" align=""] Content [/blockquote]'
);

$buttons = array (
	'Button' => '[button style="" size="" block="false"] BUTTON TEXT [/button]',
	'Button Primary' => '[button style="btn-primary" size="" block="false"] BUTTON TEXT [/button]',
	'Button info' => '[button style="btn-info" size="" block="false"] BUTTON TEXT [/button]',
	'Button success' => '[button style="btn-success" size="" block="false"] BUTTON TEXT [/button]',
	'Button warning' => '[button style="btn-warning" size="" block="false"] BUTTON TEXT [/button]',
	'Button danger' => '[button style="btn-danger" size="" block="false"] BUTTON TEXT [/button]',
	'Button inverse' => '[button style="btn-inverse" size="" block="false"] BUTTON TEXT [/button]'
);

$accordions = array(
	'Style 1' => '[accordion title="" style="default-style"] Content [/accordion]', 
	'Style 2' => '[accordion title="" style="style2"] Content [/accordion]', 
	'Style 3' => '[accordion title="" style="style3"] Content [/accordion]', 
	);

$misc = array (
	'QR Code' => '[qr align="right" size="140"] MECARD:N:Marius Hogas;ADR:MyStreet 22, Bucuresti;TEL:+ (50) 555 89 89;TEL:+ (50) 555 88 88;TEL:+ (50) 555 87 87;TEL:+ (50) 555 86 86;EMAIL:mhogas@gmail.com;URL:http://www.hogash.com/; [/qr]',
	'Code' => '[code] Content [/code]',	
	'Skills' => '[skills main_text="skills" main_color="#193340" text_color="#ffffff"] <br/>

[skill main_color="#97BE0D" percentage="95"] JavaScript [/skill]<br/>

[skill main_color="#D84F5F" percentage="90"] CSS3[/skill]<br/>

[skill main_color="#88B8E6" percentage="80"] HTML5[/skill]<br/>

[skill main_color="#BEDBE9" percentage="53"] PHP[/skill]<br/>

[skill main_color="#EDEBEE" percentage="45"] MySQL[/skill]<br/>

[/skills]',
	'Tooltip' => '[tooltip placement="" border="yes" title=""] Content [/tooltip]',
	'Icon' => '[icon white="false" ] icon-glass [/icon]',
);


$tables = array (
	'Striped' => '[table type="table-striped"] <table>
<thead>
<tr>
<th>#</th>
<th>First Name</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>Mark</td>
</tr>
<tr>
<td>2</td>
<td>Jacob</td>
</tr>
<tr>
<td>3</td>
<td>Larry</td>
</tr>
</tbody>
</table> [/table]',
	'Bordered' => '[table type="table-bordered"] <table>
<thead>
<tr>
<th>#</th>
<th>First Name</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>Mark</td>
</tr>
<tr>
<td>2</td>
<td>Jacob</td>
</tr>
<tr>
<td>3</td>
<td>Larry</td>
</tr>
</tbody>
</table> [/table]',
	'Hover Table' => '[table type="table-hover"] <table>
<thead>
<tr>
<th>#</th>
<th>First Name</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>Mark</td>
</tr>
<tr>
<td>2</td>
<td>Jacob</td>
</tr>
<tr>
<td>3</td>
<td>Larry</td>
</tr>
</tbody>
</table> [/table]',
	'Condensed Table' => '[table type="table-condensed"] <table>
<thead>
<tr>
<th>#</th>
<th>First Name</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>Mark</td>
</tr>
<tr>
<td>2</td>
<td>Jacob</td>
</tr>
<tr>
<td>3</td>
<td>Larry</td>
</tr>
</tbody>
</table> [/table]',
);

$layouts = array (
	'Row' => '[row] Content [/row]',
	'Two Columns' => '[one_half_column] Content [/one_half_column]',
	'1/3 Columns' => '[one_third_column] Content [/one_third_column]',
	'1/4 Columns' => '[one_fourth_column] Content [/one_fourth_column]',
	'2/3 Columns' => '[two_third_column] Content [/two_third_column]',
	'3/4 Columns' => '[three_fourth_column] Content [/three_fourth_column]',
);

$pricing = array (
	'Red' => '[pricing_table color="red" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Blue' => '[pricing_table color="blue" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Green' => '[pricing_table color="green" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Turquoise' => '[pricing_table color="turquoise" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Orange' => '[pricing_table color="orange" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Purple' => '[pricing_table color="purple" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Yellow' => '[pricing_table color="yellow" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Green Lemon' => '[pricing_table color="green_lemon" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Dark' => '[pricing_table color="dark" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Light' => '[pricing_table color="light" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Caption' => '[pricing_table color="red" columns="4" space="no" rounded="no"]
[pricing_caption name="TITLE"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_caption]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

);

$tabs = array (
	'Style 1' => '[tabs style="style1"]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[/tabs]<br/>',
	'Style 2' => '[tabs style="style2"]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[/tabs]<br/>',
	'Style 3' => '[tabs style="style3"]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[/tabs]<br/>',
	'Style 4' => '[tabs style="style4"]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[/tabs]<br/>'
);

$categories = array (  
						'Headings' => $headings,
						'Lists' => $lists,
						'Tables' => $tables,
						'Blockquotes' => $blockquotes,
						'Misc' => $misc,
						'Layouts' => $layouts,
						'Buttons' => $buttons,
						'PricingTables' => $pricing,
						'Accordions' => $accordions,
						'Tabs' => $tabs
					);




$page = '';
$i = '0';


	echo '<div class="zn_sc_dialog">';
	
	
	?>
	
	<div id="zn_sidebar">
		<div id="zn-nav">
			<ul class="zn_activate_nav">
				<?php
					foreach ( $categories as $name => $shortcodes ) {
						$cls = '';
						if ( $i == '0') { $cls = 'active'; }
						echo '<li><a rel="" href="#zn_page_'.$name.'" class="normal '.$cls.'">'.$name.'</a></li>';
					
						
							$page .= '<div id="zn_page_'.$name.'" class="zn_page">';
								$page .= '<h4 class="heading">'.$name.'</h4>';
								foreach ( $shortcodes as $shortcode_name => $shortcode_value ) {
									$page .= '<div class="zn_sc_container"><div class="zn_sc_title">'.$shortcode_name.'</div><div class="zn_shortcode_text">'.$shortcode_value.'</div></div>';
								}
							$page .= '</div>';
						
						$i++;
					}
				?>
			
			</ul>
		</div>
	</div>
	
	<div id="content">

		<?php echo $page;?>
		
	</div>
	
	<?php
	
	

	
	echo '</div>';
}

/*-----------------------------------------------------------------------------------*/
/* ZN Framework Admin Interface - zn_framework_add_admin */
/*-----------------------------------------------------------------------------------*/

function zn_framework_add_admin() {
	
    $zn_page = add_menu_page(THEMENAME, THEMENAME . ' Options', 'edit_theme_options', THEMENAME,'zn_framework_options_page',ADMIN_IMAGES_DIR.'/favicon.png');

	// Add framework functionaily to the head individually
	add_action("admin_print_scripts-$zn_page", 'of_load_only');
	add_action("admin_print_styles-$zn_page",'of_style_only');

	of_load_only();
	of_style_only();
	
	new zn_metabox();
} 

add_action('admin_menu', 'zn_framework_add_admin');


/*-----------------------------------------------------------------------------------*/
/* Load Inline scripts to footer
/*-----------------------------------------------------------------------------------*/
function add_this_script_footer(){ 
	global $wp_version;
	if ( $wp_version < 3.5 ) {
		?>
		<script type="text/javascript">
			(function ($) {
				zn_media = {
					
					field : false,
					
					init: function () {

						$('.zn_upload_image_button').live('click', function()
						{
						
							zn_media.field = jQuery(this).prev();
							tb_show('', 'media-upload.php?type=image&amp;post_id=0&amp;TB_iframe=true');
							zn_media.insert();
							
						})
					},
					insert : function () {
						if (zn_media.field !=false) {
							window.send_to_editor = function(html) {
							
							if ( jQuery('img',html).length >0 ) {
								imgurl = jQuery('img',html).attr('src');
								zn_media.field.val(imgurl);
								
								if(imgurl.match(/.jpg$|.jpeg$|.png$|.gif$/))
								{
									image = '<a href="#" class="zn-remove-image">remove</a><img src="'+imgurl+'" alt="" />';
								}
								
								zn_media.field.parent().children('.zn-image-holder').html(image);
								
								tb_remove();
							}
							else {

								imgurl = jQuery(html).attr('href');
								zn_media.field.val(imgurl);
								image = '<a href="#" class="zn-remove-image">remove</a>Media Selected';
								zn_media.field.parent().children('.zn-image-holder').html(image);
								tb_remove();
							}
							} 
						}
					}
					
					
					
			};
				
				
				
				$(document).ready(function () {
					zn_media.init();

					
					jQuery('.zn-remove-image').live('click',function(){
						jQuery(this).parents('.controls').children('.zn_upload_image_button').prev().val('');
						jQuery(this).parent().html('Nothing selected...<a class="zn-remove-image" href="#">remove</a>');
						return false; 
					})
					
				})
				
			})(jQuery);
		</script>
		<?php
	}
	else {
	?>
	<script type="text/javascript">
		(function($){
			var doc = {
				ready: function(){
					slider.init();
					
					jQuery('.zn-remove-image').live('click',function(){
						jQuery(this).parents('.controls').children('.zn_upload_image_button').prev().val('');
						jQuery(this).parent().html('Nothing selected...<a class="zn-remove-image" href="#">remove</a>');
						return false; 
						
					})
				}
			},
			
			slider = {
				// the following 2 objects would be our backup containers
				// as we will be replacing the default media handlers
				media_send_attachment: null,
				field : false,
				media_close_window: null,
				init: function(){
					// bind the button's click the browse_clicked handler

						$('.zn_upload_image_button').live("click", 	slider.browse_clicked);

					
				},
				browse_clicked: function(event){
					// cancel the event so we won't be navigated to href="#"
					event.preventDefault();
					
					slider.field = jQuery(this).prev();
					
					// backup editor objects first
					slider.media_send_attachment = wp.media.editor.send.attachment;
					slider.media_close_window = wp.media.editor.remove;

					// override the objects with our own
					wp.media.editor.send.attachment = slider.media_accept;
					wp.media.editor.remove = slider.media_close;

					// open up the media manager window
					wp.media.editor.open();
				},
				media_accept: function(props, attachment){
					// this function is called when the media manager sends in media info
					// when the user clicks the "Insert into Post" button
					// this may be called multiple times (one for each selected file) 
					// you might be interested in the following:
					// alert(attachment.id); // this stands for the id of the media attachment passed
					// alert(attachment.url); // this is the url of the media attachment passed
					// for now let's log it the console
					// not you can do anything Javascript-ly possible here
					
						if (slider.field !=false) {
							
							
							if ( attachment.filename.match(/.jpg$|.jpeg$|.ico$|.png$|.gif$/) ) {
								imgurl = attachment.url;
								slider.field.val(imgurl);

									image = '<a href="#" class="zn-remove-image">remove</a><img class="zn_mu_image" src="'+imgurl+'" alt="" />';
								
								slider.field.parent().children('.zn-image-holder').html(image);
								
								
							}
							else {

								imgurl = attachment.url;
								slider.field.val(imgurl);
								
								image = '<div class="attachment-preview type-video subtype-mp4 landscape"><img draggable="false" class="icon" src="<?php echo IMAGES_URL; ?>/video.png"><div class="filename"><div>'+ attachment.filename +'</div></div></div>'
								
								//image = '<a href="#" class="zn-remove-image">remove</a>Media Selected';
								slider.field.parent().children('.zn-image-holder').html(image);
								
							}
							
						}
					
				//	console.log(props);
				//	console.log(attachment);
				},
				media_close: function(id){
					// this function is called when the media manager wants to close
					// (either close button or after sending the selected items)

					// restore editor objects from backup
					wp.media.editor.send.attachment = slider.media_send_attachment;
					wp.media.editor.remove = slider.media_close_window;

					// nullify the backup objects to free up some memory
					slider.media_send_attachment= null;
					slider.media_close_window= null;

					// trigger the actual remove
					wp.media.editor.remove(id);
				}
			};
			$(document).ready(doc.ready);
		})(jQuery);
	</script> 
	<?php
	}
 } 

add_action('admin_footer', 'add_this_script_footer');

/*-----------------------------------------------------------------------------------*/
/* Load required styles for Options Page - of_style_only */
/*-----------------------------------------------------------------------------------*/

function of_style_only(){
	// Needed for image upload
	wp_enqueue_style('thickbox');
	
	wp_enqueue_style('zn-admin-style', ADMIN_MASTER_ADMIN_DIR . 'css/zn-admin-style.css');
	
	
	wp_enqueue_style('color-picker', ADMIN_MASTER_ADMIN_DIR . 'css/colorpicker.css');
	wp_enqueue_style('time-picker', ADMIN_MASTER_ADMIN_DIR . 'css/jquery.timepicker.css');
	wp_enqueue_style('jquery-ui', ADMIN_MASTER_ADMIN_DIR . 'css/jquery-ui-1.8.16.custom.css');
}	

/*-----------------------------------------------------------------------------------*/
/* Load required javascripts for Options Page - of_load_only */
/*-----------------------------------------------------------------------------------*/

function of_load_only() {

	
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-ui-button');
	
	// Needed for image upload
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	
	
	wp_register_script('jquery-input-mask', ADMIN_MASTER_ADMIN_DIR .'js/jquery.maskedinput-1.2.2.js', array( 'jquery' ));
	wp_enqueue_script('jquery-input-mask');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('color-picker', ADMIN_MASTER_ADMIN_DIR .'js/colorpicker.js', array('jquery'));
	wp_enqueue_script('time-picker', ADMIN_MASTER_ADMIN_DIR .'js/jquery.timepicker.min.js', array('jquery'));
	wp_enqueue_script('ajaxupload', ADMIN_MASTER_ADMIN_DIR .'js/ajaxupload.js', array('jquery'));
	wp_enqueue_script('cookie', ADMIN_MASTER_ADMIN_DIR . '/js/jquery.cookie.js', 'jquery');
	wp_enqueue_script('tipsy', ADMIN_MASTER_ADMIN_DIR . '/js/jquery.tipsy.js', 'jquery');
	wp_enqueue_script('asmselect', ADMIN_MASTER_ADMIN_DIR . '/js/jquery.asmselect.js', 'jquery');
	wp_enqueue_script('zn-admin-scripts', ADMIN_MASTER_ADMIN_DIR . '/js/zn-admin-scripts.js', 'jquery');
	wp_enqueue_script('zn-ajax-options', ADMIN_MASTER_ADMIN_DIR . '/js/zn-ajax-options.js', 'jquery');
		// Registers custom scripts for the Media Library AJAX uploader.
}

/*-----------------------------------------------------------------------------------*/
/* Build the Options Page - optionsframework_options_page */
/*-----------------------------------------------------------------------------------*/

function zn_framework_options_page(){
	global $options_machine;
		
	$html = new zn_html();

	global $zn_options;

	echo $html->zn_show_options($zn_options); 

}



/*-----------------------------------------------------------------------------------*/
/* Head Hook
/*-----------------------------------------------------------------------------------*/

function of_head() { do_action( 'of_head' ); }

/*-----------------------------------------------------------------------------------*/
/* Get element fields from id
/*-----------------------------------------------------------------------------------*/
function zn_get_element_from_id( $id ) {
	global $zn_options;
	global $zn_meta_elements;
	global $sliders;
	global $extra_options;
		
	$options = array_merge($zn_options,$zn_meta_elements,$sliders,$extra_options);	
	
	foreach($options as $option) {
		if(!isset($option['id'])) {$option['id'] = '';}
		if($option['id'] == $id) {
			
			$option['dynamic'] = true;
			return $option;
		}

	}
}

/*-----------------------------------------------------------------------------------*/
/* Re-ENABLE THE DUMMY ISNTALL BUTTON
/*-----------------------------------------------------------------------------------*/
if (is_admin() && isset($_GET['enable_dummy_install'] ) ) {
	//Call action that sets
	update_option(THEMENAME.'_dummy',0);
	header('Location: '.get_admin_url().'?page='.THEMENAME, true, 302);
}


/*-----------------------------------------------------------------------------------*/
/* Add default options after activation */
/*-----------------------------------------------------------------------------------*/
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	//Call action that sets
	add_action('admin_head','zn_option_setup');
}

/* set options=defaults if DB entry does not exist, else update defaults only */
function zn_option_setup()	{

}

/*-----------------------------------------------------------------------------------*/
/* Admin Backend */
/*-----------------------------------------------------------------------------------*/
function optionsframework_admin_message() { 
	
	//Tweaked the message on theme activate
	?>
    <script type="text/javascript">
    jQuery(function(){
    	
        var message = '<p>This theme comes with an <a href="<?php echo admin_url('admin.php?page='.THEMENAME.''); ?>">options panel</a> to configure settings. This theme also supports widgets, please visit the <a href="<?php echo admin_url('widgets.php'); ?>">widgets settings page</a> to configure them.</p>';
    	jQuery('.themes-php #message2').html(message);
    
    });
    </script>
    <?php
	
}

add_action('admin_head', 'optionsframework_admin_message'); 




/* For use in themes */
$data = get_option(OPTIONS);

/*-----------------------------------------------------------------------------------*/
/* Create Dynamic Css*/
/*-----------------------------------------------------------------------------------*/
function generate_options_css($newdata) {

	$data = $newdata;
	$css_dir = get_template_directory() . '/css/'; // Shorten code, save 1 call
	ob_start(); // Capture all output (output buffering)

	
	require($css_dir . 'styles.php'); // Generate CSS

	$css = ob_get_clean(); // Get generated CSS (output buffering)
	file_put_contents($css_dir . 'options.css', $css, LOCK_EX); // Save it
}

/*-----------------------------------------------------------------------------------*/
/* Create Dynamic Js*/
/*-----------------------------------------------------------------------------------*/
function generate_options_js($newdata) {

	$data = $newdata;
	$js_dir = get_template_directory() . '/js/'; // Shorten code, save 1 call
	ob_start(); // Capture all output (output buffering)

	require($js_dir . 'js.php'); // Generate CSS
		
	$js = ob_get_clean(); // Get generated CSS (output buffering)
	file_put_contents($js_dir . 'options.js', $js, LOCK_EX); // Save it
}
/*
	if ( get_magic_quotes_gpc() ) {
		$_POST      = array_map( 'stripslashes_deep', $_POST );
		$_GET       = array_map( 'stripslashes_deep', $_GET );
		$_COOKIE    = array_map( 'stripslashes_deep', $_COOKIE );
		$_REQUEST   = array_map( 'stripslashes_deep', $_REQUEST );
	}
*/

/*-----------------------------------------------------------------------------------*/
/* Auto Update the theme
/*-----------------------------------------------------------------------------------*/
	if ( !empty( $data['zn_theme_username'] ) && !empty( $data['zn_theme_api'] ) ) {
		$username = $data['zn_theme_username'];
		$apikey = $data['zn_theme_api'];
		$author = 'Hogash';

		require_once("class-pixelentity-theme-update.php");
		PixelentityThemeUpdate::init($username,$apikey,$author);
			
	}





?>
