<?php
add_action('init', 'zn_options');
add_action('init', 'zn_admin_menu');



if (!function_exists('zn_admin_menu'))
{
	function zn_admin_menu()
	{

		// Set the Options Array

		global $zn_admin_menu;
		$zn_admin_menu = array();
		$zn_admin_menu[] = array(
			"name" => "General Options",
			"id" => "general_options",
			"submenus" => array(
				array(
					"name" => "General options",
					"id" => "zn_gen_options",
					"class" => "active"
				) ,
				array(
					"name" => "Logo options",
					"id" => "logo_options",
					"class" => "active"
				) ,
				array(
					"name" => "Favicon options",
					"id" => "favicon_options"
				) ,
				array(
					"name" => "Font Options",
					"id" => "font_options"
				) ,
				array(
					"name" => "WPML Options",
					"id" => "wpml_options"
				) ,
				array(
					"name" => "Header options",
					"id" => "theader_options"
				) ,
				array(
					"name" => "Footer options",
					"id" => "copyright_options"
				) ,
				array(
					"name" => "Default Header options",
					"id" => "def_header"
				) ,
				array(
					"name" => "Google Analytics",
					"id" => "google_analytics"
				) ,
				array(
					"name" => "Mailchimp",
					"id" => "mailchimp_api"
				) ,
				array(
					"name" => "Facebook",
					"id" => "facebook_options"
				)
			)
		);
		$zn_admin_menu[] = array(
			"name" => "Blog Options",
			"id" => "blog_options",
			"submenus" => array(
				array(
					"name" => "Archive options",
					"id" => "archive_blog_options"
				) ,
				array(
					"name" => "Single blog item options",
					"id" => "single_blog_option"
				)
			)
		);
		$zn_admin_menu[] = array(
			"name" => "Page options",
			"id" => "page_default_options"
		);
		$zn_admin_menu[] = array(
			"name" => "Portfolio options",
			"id" => "portfolio_options"
		);
		$zn_admin_menu[] = array(
			"name" => "Layout options",
			"id" => "layout_options"
		);
		$zn_admin_menu[] = array(
			"name" => "Color options",
			"id" => "color_options"
		);
		$zn_admin_menu[] = array(
			"name" => "Unlimited headers",
			"id" => "uh_headers"
		);
		$zn_admin_menu[] = array(
			"name" => "Unlimited sidebars",
			"id" => "sidebar_options"
		);
		$zn_admin_menu[] = array(
			"name" => "Coming Soon Options",
			"id" => "cs_options"
		);
		$zn_admin_menu[] = array(
			"name" => "404 Page Options",
			"id" => "404_options"
		);
		$zn_admin_menu[] = array(
			"name" => "Woocommerce Options",
			"id" => "woo_options",
			"submenus" => array(
				array(
					"name" => "General options",
					"id" => "woo_general_options"
				) ,
				array(
					"name" => "Categories page",
					"id" => "woo_category_options"
				) ,
				array(
					"name" => "Categories page",
					"id" => "woo_single_options"
				)
			)
		);
		
		$zn_admin_menu[] = array(
			"name" => "Advanced",
			"id" => "advanced_options"
		);
		
	}
}

if (!function_exists('zn_options'))
{
	function zn_options()
	{
		global $data;
		global $all_icon_sets;
		$bg_images_path = get_stylesheet_directory() . '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri() . '/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		if (is_dir($bg_images_path))
		{
			if ($bg_images_dir = opendir($bg_images_path))
			{
				while (($bg_images_file = readdir($bg_images_dir)) !== false)
				{
					if (stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false)
					{
						$bg_images[] = $bg_images_url . $bg_images_file;
						natsort($bg_images);
					}
				}
			}
		}

		global $zn_options;
		$zn_options = array();

		// SET THEME DEFAULTS

		$color1 = '#81C50A'; // GREEN
		$color2 = '#CCCCCC';
		$color3 = '#FFFFFF'; // WHITE
		$color4 = '#666666';
		$color5 = '#999999';
		$color6 = '#EBEBEB'; // Separator color
		$color7 = '#ADADAD'; // Blog info link color


		/*
		*			START GENERAL OPTIONS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'zn_gen_options'
		);

		$zn_options[] = array(
			"name" => "Show Follow menu?",
			"description" => "Chose yes if you want the menu to follow the user on the page.",
			"id" => "menu_follow",
			"std" => '',
			"options" => array ( 'yes'=>"Yes" , 'no'=> "No"),
			"type" => "select"
		);

		$zn_options[] = array(
			"name" => "Use page preloader?",
			"description" => "Chose yes if you want to show a page preloader.",
			"id" => "page_preloader",
			"std" => 'no',
			"options" => array ( 'yes'=>"Yes" , 'no'=> "No"),
			"type" => "select"
		);

		$zn_options[] = array(
			"type" => 'option_page_end'
		);

		/*
		*			START LOGO OPTIONS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'logo_options'
		);

		// Logo Upload

		$zn_options[] = array(
			"name" => "Logo Upload",
			"description" => "Upload your logo.",
			"id" => "logo_upload",
			"std" => '',
			"type" => "media"
		);

		// Logo auto size ?

		$logo_size = array(
			"yes" => "Auto resize logo",
			"no" => "Manually set the logo size"
		);
		$zn_options[] = array(
			"name" => "Logo Size :",
			"description" => "Select \"Auto resize logo\" if you want your logo to use the image size or select \"Manually set the logo size\" if you want to mannualy set your logo size.",
			"id" => "logo_size",
			"std" => "yes",
			"type" => "zn_radio",
			"options" => $logo_size,
			"class" => "zn_hide"
		);

		// Logo Dimensions

		$default_size = array(
			'height' => '42',
			'width' => '126'
		);
		$zn_options[] = array(
			"name" => "Logo manual sizes",
			"description" => "Please insert your desired logo size in pixels ( for example \"35\" )",
			"id" => "logo_manual_size",
			"std" => $default_size,
			"type" => "image_size",
			"class" => "logo_size-no"
		);

		// Logo typography for link

		$zn_options[] = array(
			"name" => "Logo Link Options",
			"description" => "Specify the logo typography properties. Will only work if you don't upload a logo image.",
			"id" => "logo_font",
			"std" => array(
				'size' => '36px',
				'face' => 'Open Sans',
				'style' => 'normal',
				'color' => '#000',
				'height' => '40px'
			) ,
			"type" => "typography"
		);

		// Logo Hover Typography

		$zn_options[] = array(
			"name" => "Logo Link Hover Color",
			"description" => "Specify the logo hover color. Will only work if you don't upload a logo image. ",
			"id" => "logo_hover",
			"std" => array(
				'color' => '#CD2122',
				'face' => ''
			) ,
			"type" => "typography"
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);

		/*
		*			Start FAVICON OPTIONS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'favicon_options'
		);
		$zn_options[] = array(
			"name" => "Favicon Image",
			"description" => "Upload your desired favicon image.",
			"id" => "custom_favicon",
			"std" => '',
			"type" => "media"
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);



		/*
		*			Start FONT OPTIONS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'font_options'
		);

		$zn_options[] = array(
			"name" => "H1 Typography",
			"description" => "Specify the typography properties for headings.",
			"id" => "h1_typo",
			"std" => array(
				'size' => '36px',
				'face' => 'Open Sans',
				'height' => '40px'
			) ,
			"type" => "typography"
		);

		$zn_options[] = array(
			"name" => "H2 Typography",
			"description" => "Specify the typography properties for headings.",
			"id" => "h2_typo",
			"std" => array(
				'size' => '30px',
				'face' => 'Open Sans',
				'height' => '40px'
			) ,
			"type" => "typography"
		);

		$zn_options[] = array(
			"name" => "H3 Typography",
			"description" => "Specify the typography properties for headings.",
			"id" => "h3_typo",
			"std" => array(
				'size' => '24px',
				'face' => 'Open Sans',
				'height' => '40px'
			) ,
			"type" => "typography"
		);

		$zn_options[] = array(
			"name" => "H4 Typography",
			"description" => "Specify the typography properties for headings.",
			"id" => "h4_typo",
			"std" => array(
				'size' => '14px',
				'face' => 'Open Sans',
				'height' => '20px'
			) ,
			"type" => "typography"
		);

		$zn_options[] = array(
			"name" => "H5 Typography",
			"description" => "Specify the typography properties for headings.",
			"id" => "h5_typo",
			"std" => array(
				'size' => '12px',
				'face' => 'Open Sans',
				'height' => '20px'
			) ,
			"type" => "typography"
		);

		$zn_options[] = array(
			"name" => "H6 Typography",
			"description" => "Specify the typography properties for headings.",
			"id" => "h6_typo",
			"std" => array(
				'size' => '12px',
				'face' => 'Open Sans',
				'height' => '20px'
			) ,
			"type" => "typography"
		);


		$zn_options[] = array(
			"type" => 'option_page_end'
		);

		/*
		*			Start WPML
		------------------------------------------------------------*/
		
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'wpml_options'
		);

		// Show LINK to LOGIN

		$zn_options[] = array(
			"name" => "Show WPML flags ?",
			"description" => "Choose yes if you want to show WPML flags in header. Please note that you will need WPML installed.",
			"id" => "head_show_flags",
			"std" => "1",
			"type" => "zn_radio",
			"options" => array(
				"1" => "Show",
				"0" => "Hide"
			)
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		
		/*
		*			Start TOP HEADER OPTIONS
		------------------------------------------------------------*/
		
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'theader_options'
		);

		$zn_options[] = array( 
			"name" => "Heaeder Layout",
			"description" => "Please choose the desired header layout.",
			"id" => "zn_header_layout",
			"std" => "style2",
			"options" => array ( 'style1' => 'Style 1' , 'style2' => 'Style 2 (default)' , 'style3' => 'Style 3' , 'style4' => 'Style 4'  ),
			"type" => "select"
		);
		
		// HEADER STYLE
		$zn_options[] = array(
			"name" => "Header Style",
			"description" => "Select the desired style for the header",
			"id" => "header_style",
			"std" => "default",
			"type" => "zn_radio",
			"options" => array( 'default' => "Default", 'image_color'=>'Background Image & color' ),
			"class" => "zn_hide"
		);

		// HEADER IMAGE
		$zn_options[] = array(
			"name" => "Header Background Image",
			"description" => "Please choose your desired image to be used as a background",
			"id" => "header_style_image",
			"std" => '',
			"options" => array( "repeat" => true , "position" => true , "attachment" => true ),
			"type" => "background",
			"class" => "header_style-image_color"
		);
		
		// HEADER Color
		$zn_options[] = array(
			"name" => "Background Color",
			"description" => "Please choose your desired background color for the header",
			"id" => "header_style_color",
			"std" => '#000',
			"type" => "color",
			"class" => "header_style-image_color"
		);
		
		// Show LINK to LOGIN
		$zn_options[] = array(
			"name" => "Show Login in header",
			"description" => "Choose yes if you want to show a link that will let users login/register or retrieve their lost password. Please note that in order to show the registration page, you need to allow user registration from General settings.",
			"id" => "head_show_login",
			"std" => "1",
			"type" => "zn_radio",
			"options" => array(
				"1" => "Show",
				"0" => "Hide"
			)
		);
		
		// Show LOGO In header
		$zn_options[] = array(
			"name" => "Show LOGO in header",
			"description" => "Please choose if you want to display the logo or not.",
			"id" => "head_show_logo",
			"std" => "yes",
			"type" => "zn_radio",
			"options" => array(
				"yes" => "Show",
				"no" => "Hide"
			)
		);
		
		$zn_options[] = array(
			"name" => "Social Icons",
			"description" => "Here you can configure what social icons to appear on the right side of the header.",
			"id" => "header_social_icons",
			"std" => "",
			"type" => "group",
			"add_text" => "Social Icon",
			"remove_text" => "Social Icon",
			"subelements" => array(
				array(
					"name" => "Icon title",
					"description" => "Here you can enter a title for this social icon.Please note that this is just for your information as this text will not be visible on the site.",
					"id" => "header_social_title",
					"std" => "",
					"type" => "text"
				) ,
				array(
					"name" => "Social icon link",
					"description" => "Please enter your desired link for the social icon. If this field is left blank, the icon will not be linked.",
					"id" => "header_social_link",
					"std" => "",
					"type" => "link",
					"options" => array(
						'_blank' => "New window",
						'_self' => "Same window"
					)
				) ,
				array(
					"name" => "Social icon",
					"description" => "Select your desired social icon.",
					"id" => "header_social_icon",
					"std" => "",
					"options" => $all_icon_sets,
					"type" => "zn_icon_font"
				)
			) ,
			"class" => ""
		);
		$footer_colored_icons = array(
			'normal' => 'Normal Icons',
			'colored' => 'Colored icons'
		);
		$zn_options[] = array(
			"name" => "Use normal or colored social icons?",
			"description" => "Here you can choose to use the normal social icons or the colored version of each icon.",
			"id" => "header_which_icons_set",
			"std" => "",
			"type" => "select",
			"options" => $footer_colored_icons,
			"class" => ""
		);
		
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		
		
		/*
		*			Start COPYRIGHT OPTIONS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'copyright_options'
		);
		
		// Show Footer
		$zn_options[] = array(
			"name" => "Show Footer",
			"description" => "Using this option you can choose to display the footer or not.",
			"id" => "footer_show",
			"std" => "yes",
			"type" => "zn_radio",
			"options" => array(
				"yes" => "Show",
				"no" => "Hide"
			)
		);
		
		$zn_options[] = array(
			"name" => "Copyright text",
			"description" => "Enter your desired copyright text. Please note that you can copy ' &copy; ' and place it in the text.",
			"id" => "copyright_text",
			"std" => "&copy; 2013 Copyright by ZnThemes. All rights reserved.",
			"type" => "textarea"
		);
		$zn_options[] = array(
			"name" => "Footer Row 1 Widget positions",
			"description" => "Here you can select how your footer row 1 widgets will be displayed. You can select to use up to 4 widgets positions in various sizes.",
			"id" => "footer_row1_widget_positions",
			"std" => '{"3":[["4","4","4"]]}',
			"type" => "widget_positions",
			"number_of_columns" => "4",
			"columns_positions" => array(
				"1" => array(
					array(
						"12"
					)
				) ,
				"2" => array(
					array(
						"6",
						"6"
					)
				) ,
				"3" => array(
					array(
						"4",
						"4",
						"4"
					) ,
					array(
						"5",
						"4",
						"3"
					) ,
					array(
						"5",
						"3",
						"4"
					) ,
					array(
						"4",
						"5",
						"3"
					) ,
					array(
						"4",
						"3",
						"5"
					) ,
					array(
						"3",
						"4",
						"5"
					) ,
					array(
						"3",
						"5",
						"4"
					)
				) ,
				"4" => array(
					array(
						"3",
						"3",
						"3",
						"3"
					) ,
					array(
						"5",
						"4",
						"2",
						"1"
					)
				)
			)
		);
		$zn_options[] = array(
			"name" => "Footer Row 2 Widget positions",
			"description" => "Here you can select how your footer row 2 widgets will be displayed. You can select to use up to 4 widgets positions in various sizes.",
			"id" => "footer_row2_widget_positions",
			"std" => '{"2":[["6","6"]]}',
			"type" => "widget_positions",
			"number_of_columns" => "4",
			"columns_positions" => array(
				"1" => array(
					array(
						"12"
					)
				) ,
				"2" => array(
					array(
						"6",
						"6"
					)
				) ,
				"3" => array(
					array(
						"4",
						"4",
						"4"
					) ,
					array(
						"5",
						"4",
						"3"
					) ,
					array(
						"5",
						"3",
						"4"
					) ,
					array(
						"4",
						"5",
						"3"
					) ,
					array(
						"4",
						"3",
						"5"
					) ,
					array(
						"3",
						"4",
						"5"
					) ,
					array(
						"3",
						"5",
						"4"
					)
				) ,
				"4" => array(
					array(
						"3",
						"3",
						"3",
						"3"
					) ,
					array(
						"5",
						"4",
						"2",
						"1"
					)
				)
			)
		);
		$zn_options[] = array(
			"name" => "Copyright Logo image",
			"description" => "Upload your desired logo image that will appear on the left side of the copyright text.",
			"id" => "footer_logo",
			"std" => '',
			"type" => "media"
		);
		
		// FOOTER STYLE
		$zn_options[] = array(
			"name" => "Style",
			"description" => "Select the desired style for the footer",
			"id" => "footer_style",
			"std" => "default",
			"type" => "zn_radio",
			"options" => array( 'default' => "Default", 'image_color'=>'Background Image & color' ),
			"class" => "zn_hide"
		);

		// FOOTER IMAGE
		$zn_options[] = array(
			"name" => "Background Image",
			"description" => "Please choose your desired image to be used as a background",
			"id" => "footer_style_image",
			"std" => '',
			"options" => array( "repeat" => true , "position" => true , "attachment" => true ),
			"type" => "background",
			"class" => "footer_style-image_color"
		);
		
		// FOOTER Color
		$zn_options[] = array(
			"name" => "Background Color",
			"description" => "Please choose your desired background color for the footer",
			"id" => "footer_style_color",
			"std" => '#000',
			"type" => "color",
			"class" => "footer_style-image_color"
		);
		
		// FOOTER Color
		$zn_options[] = array(
			"name" => "Border Color",
			"description" => "Please choose your desired color for the footer border",
			"id" => "footer_border_color",
			"std" => '#484848',
			"type" => "color"
		);
		
		$zn_options[] = array(
			"name" => "Social Icons",
			"description" => "Here you can configure what social icons to appear on the right side of the copyright text.",
			"id" => "footer_social_icons",
			"std" => "",
			"type" => "group",
			"add_text" => "Social Icon",
			"remove_text" => "Social Icon",
			"subelements" => array(
				array(
					"name" => "Icon title",
					"description" => "Here you can enter a title for this social icon.Please note that this is just for your information as this text will not be visible on the site.",
					"id" => "footer_social_title",
					"std" => "",
					"type" => "text"
				) ,
				array(
					"name" => "Social icon link",
					"description" => "Please enter your desired link for the social icon. If this field is left blank, the icon will not be linked.",
					"id" => "footer_social_link",
					"std" => "",
					"type" => "link",
					"options" => array(
						'_blank' => "New window",
						'_self' => "Same window"
					)
				) ,
				array(
					"name" => "Social icon",
					"description" => "Select your desired social icon.",
					"id" => "footer_social_icon",
					"std" => "",
					"options" => $all_icon_sets,
					"type" => "zn_icon_font"
				)
			) ,
			"class" => ""
		);
		$footer_colored_icons = array(
			'normal' => 'Normal Icons',
			'colored' => 'Colored icons'
		);
		$zn_options[] = array(
			"name" => "Use normal or colored social icons?",
			"description" => "Here you can choose to use the normal social icons or the colored version of each icon.",
			"id" => "footer_which_icons_set",
			"std" => "",
			"type" => "select",
			"options" => $footer_colored_icons,
			"class" => ""
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*
		*			Start DEFAULT HEADER
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'def_header'
		);

		// Header background image

		$zn_options[] = array(
			"name" => "Header Background image",
			"description" => "Upload your desired background image for the header.",
			"id" => "def_header_background",
			"std" => '',
			"type" => "media"
		);

		// Header background color

		$zn_options[] = array(
			"name" => "Header Background Color",
			"description" => "Here you can choose a default color for your header.If you do not select a background image, this color will be used as background.",
			"id" => "def_header_color",
			"std" => '#AAAAAA',
			"type" => "color"
		);

		// HEADER - Animate

		$def_header_anim = array(
			'1' => 'Yes',
			'0' => 'No'
		);
		$zn_options[] = array(
			"name" => "Use animated header",
			"description" => "Select if you want to add an animation on top of your image/color.",
			"id" => "def_header_animate",
			"std" => "0",
			"type" => "select",
			"options" => $def_header_anim,
			"class" => ""
		);

		// HEADER show breadcrumbs

		$def_header_bread = array(
			'1' => 'Show',
			'0' => 'Hide'
		);
		$zn_options[] = array(
			"name" => "Show Breadcrumbs",
			"description" => "Select if you want to show the breadcrumbs or not.",
			"id" => "def_header_bread",
			"std" => "",
			"type" => "select",
			"options" => $def_header_bread,
			"class" => ""
		);

		// HEADER show date

		$def_header_date = array(
			'1' => 'Show',
			'0' => 'Hide'
		);
		$zn_options[] = array(
			"name" => "Show Date",
			"description" => "Select if you want to show the current date under breadcrumbs or not.",
			"id" => "def_header_date",
			"std" => "",
			"type" => "select",
			"options" => $def_header_date,
			"class" => ""
		);

		// HEADER show title

		$def_header_title = array(
			'1' => 'Show',
			'0' => 'Hide'
		);
		$zn_options[] = array(
			"name" => "Show Page Title",
			"description" => "Select if you want to show the page title or not.",
			"id" => "def_header_title",
			"std" => "",
			"type" => "select",
			"options" => $def_header_title,
			"class" => ""
		);

		// HEADER show subtitle

		$def_header_subtitle = array(
			'1' => 'Show',
			'0' => 'Hide'
		);
		$zn_options[] = array(
			"name" => "Show Page Subtitle",
			"description" => "Select if you want to show the page subtitle or not.",
			"id" => "def_header_subtitle",
			"std" => "",
			"type" => "select",
			"options" => $def_header_subtitle,
			"class" => ""
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*
		*			Start GOOGLE ANALYTICS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'google_analytics'
		);
		$zn_options[] = array(
			"name" => "Google Analytics Code",
			"description" => "Paste your google analytics code bellow.",
			"id" => "google_analytics",
			"std" => '',
			"type" => "textarea"
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*
		*			Start MAILCHIMP API
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'mailchimp_api'
		);
		$zn_options[] = array(
			"name" => "Mailchimp API KEY",
			"description" => "Paste your mailchimp api key that will be used by the mailchimp widget.",
			"id" => "mailchimp_api",
			"std" => '',
			"type" => "text"
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*
		*			Start General Blog options
		------------------------------------------------------------*/
		$sidebar_option = array();
		$sidebar_option['defaultsidebar'] = 'Default Sidebar';
		if (isset($data['sidebar_generator']) && is_array($data['sidebar_generator']))
		{
			$sidebars = $data['sidebar_generator'];
			foreach($data['sidebar_generator'] as $sidebar)
			{
				if ($sidebar['sidebar_name'])
				{
					$sidebar_option[$sidebar['sidebar_name']] = $sidebar['sidebar_name'];
				}
			}
		}

		// Add default sidebar

		/*
		*			Start Archive Blog options
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'archive_blog_options'
		);
		$zn_options[] = array(
			"name" => "Archive Page Title",
			"description" => "Enter the desired page title for the blog archive page.",
			"id" => "archive_page_title",
			"std" => "BLOG & Gossip",
			"type" => "text",
			"translate_name" => "Archive Page Title",
			"class" => ""
		);
		$zn_options[] = array(
			"name" => "Archive Page Subitle",
			"description" => "Enter the desired page subtitle for the blog archive page.",
			"id" => "archive_page_subtitle",
			"std" => "This would be the blog category page",
			"type" => "text",
			"translate_name" => "Archive Page Subtitle",
			"class" => ""
		);
		$zn_options[] = array(
			"name" => "Archive Sidebar Position",
			"description" => "Select the position of the sidebar on archive pages.",
			"id" => "archive_sidebar_position",
			"std" => "right_sidebar",
			"type" => "select",
			"options" => array(
				'left_sidebar' => "Left Sidebar",
				'right_sidebar' => "Right sidebar",
				"no_sidebar" => "No sidebar"
			) ,
			"class" => ""
		);
		$zn_options[] = array(
			"name" => "Archive Default Sidebar",
			"description" => "Select the default sidebar that will be used on archive pages.",
			"id" => "archive_sidebar",
			"std" => "",
			"type" => "select",
			"options" => $sidebar_option,
			"class" => ""
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*
		*			Start Single Blog options
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'single_blog_option'
		);
		$zn_options[] = array(
			"name" => "Default Sidebar Position",
			"description" => "Select the default position of the sidebars troughout the site.",
			"id" => "default_sidebar_position",
			"std" => "right_sidebar",
			"type" => "select",
			"options" => array(
				'left_sidebar' => "Left Sidebar",
				'right_sidebar' => "Right sidebar",
				"no_sidebar" => "No sidebar"
			) ,
			"class" => ""
		);
		$zn_options[] = array(
			"name" => "Single Post Default Sidebar",
			"description" => "Select the default sidebar that will be used on single post pages. Please note you can select a different sidebar from the post edit page.",
			"id" => "single_sidebar",
			"std" => "defaultsidebar",
			"type" => "select",
			"options" => $sidebar_option,
			"class" => ""
		);
		$zn_options[] = array(
			"name" => "Show Social Share Buttons ?",
			"description" => "Choose if you want to show the social share buttons bellow the post's content.",
			"id" => "show_social",
			"std" => "show",
			"type" => "select",
			"options" => array(
				'show' => 'Show social buttons',
				'hide' => 'Do not show social buttons'
			)
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*
		*			Start PAGE DEFAULT options
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'page_default_options'
		);
		$zn_options[] = array(
			"name" => "Page Sidebar Position",
			"description" => "Select the position of the sidebar on archive pages.",
			"id" => "page_sidebar_position",
			"std" => "no_sidebar",
			"type" => "select",
			"options" => array(
				'left_sidebar' => "Left Sidebar",
				'right_sidebar' => "Right sidebar",
				"no_sidebar" => "No sidebar"
			) ,
			"class" => ""
		);
		$zn_options[] = array(
			"name" => "Page Default Sidebar",
			"description" => "Select the default sidebar that will be used on archive pages.",
			"id" => "page_sidebar",
			"std" => "",
			"type" => "select",
			"options" => $sidebar_option,
			"class" => ""
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);

		/*
		*			Start PORTFOLIO options
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'portfolio_options'
		);

		$zn_options[] = array(
			"name" => "Portfolio Archive style",
			"description" => "Select the desired style for the portfolio archive pages.",
			"id" => "portfolio_style",
			"std" => "portfolio_sortable",
			"type" => "select",
			"options" => array(
				'portfolio_category' => 'Portfolio Category',
				'portfolio_sortable' => 'Portfolio Sortable',
				'portfolio_carousel' => 'Portfolio Carousel Layout',
			) ,
			"class" => ""
		);

		$zn_options[] = array(
			"name" => "Portfolio items to show",
			"description" => "Please enter the desired number of portfolio items that will be loaded.(-1 will display all posts. Default is -1).",
			"id" => "portfolio_per_page",
			"std" => "-1",
			"type" => "text",
		);

		$zn_options[] = array(
			"name" => "Portfolio items per page",
			"description" => "Please enter the desired number of portfolio items that will be displayed on a page.",
			"id" => "portfolio_per_page_show",
			"std" => "4",
			"type" => "text",
		);



		$zn_options[] = array( 
			"name" => "Number of columns",
			"description" => "Please enter how many portfolio items you want to load on a page if you choose to use the portfolio category style.",
			"id" => "ports_num_columns",
			"std" => "4",
			"options" => array ( '1' => '1' , '2' => '2' , '3' => '3' , '4' => '4' , ),
			"type" => "select"
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);

		/*
		*			Start LAYOUT options
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'layout_options'
		);

		$zn_options[] = array( 
			"name" => "Responsive options",
			"description" => "Please choose if you want to enable or not the responsive styles of the theme.",
			"id" => "zn_responsive",
			"std" => "1",
			"options" => array ( 'yes' => 'Enable Responsive Style' , 'no' => 'Disable Responsive Style'  ),
			"type" => "select"
		);

		// BOXED LAYOUT
		$zn_options[] = array(
			"name" => "Use Boxed Layout",
			"description" => "Choose yes if you want to use the boxed layour instead of the full width.",
			"id" => "zn_boxed_layout",
			"std" => "no",
			"type" => "zn_radio",
			"options" => array ( 'no' => 'No' , 'yes' => 'Yes'  ),
			"class" => "zn_hide"
		);
		

		// BACKGROUND IMAGE
		$zn_options[] = array(
			"name" => "Background Image",
			"description" => "Please choose your desired image to be used as a background",
			"id" => "boxed_style_image",
			"std" => '',
			"options" => array( "repeat" => true , "position" => true , "attachment" => true ),
			"type" => "background",
			"class" => "zn_boxed_layout-yes"
		);
		
		// BACKGROUND COLOR
		$zn_options[] = array(
			"name" => "Background Color",
			"description" => "Please choose your desired background color",
			"id" => "boxed_style_color",
			"std" => '#fff',
			"type" => "color",
			"class" => "zn_boxed_layout-yes"
		);
		
		// BOXED LAYOUT FOR HOMEPAGE
		$zn_options[] = array(
			"name" => "Homepage Boxed Layout",
			"description" => "Here you can choose a specific layout setting for the homepage that will overrite the seting from above.",
			"id" => "zn_home_boxed_layout",
			"std" => "def",
			"type" => "zn_radio",
			"options" => array ( 'def'=>'Default','no' => 'No' , 'yes' => 'Yes'  ),
			"class" => "zn_hide"
		);
		
		$zn_options[] = array( 
			"name" => "Content size",
			"description" => "Please choose the desired default size for the content.",
			"id" => "zn_width",
			"std" => "1170",
			"options" => array ( '1170' => '1170px' , '960' => '960px'  ),
			"type" => "select"
		);


		$zn_options[] = array(
			"type" => 'option_page_end'
		);

		/*
		*			Start COLOR options
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'color_options'
		);

		$zn_options[] = array( 
			"name" => "Main Color",
			"description" => "Please choose a main color for your site.",
			"id" => "zn_main_color",
			"std" => "#cd2122",
			"type" => "color"
		);
		
		$zn_options[] = array( 
			"name" => "Menu default Color",
			"description" => "Please choose a default color for the main menu.",
			"id" => "zn_mainmenu_color",
			"std" => "#fff",
			"type" => "color"
		);

		$zn_options[] = array( 
			"name" => "Color Style",
			"description" => "Please choose the desired default size for the content.",
			"id" => "zn_main_style",
			"std" => "1170",
			"options" => array ( 'light' => 'Light Style ( default )' , 'dark' => 'Dark Style'  ),
			"type" => "select"
		);

		$zn_options[] = array(
			"type" => 'option_page_end'
		);


		/*--------------------------------------------------------------------------------------------------
		Unlimited headers
		--------------------------------------------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'uh_headers'
		);
		$zn_options[] = array(
			"name" => "Header Styles Generator",
			"description" => "Here you can create unlimited header styles to be used on different pages.",
			"id" => "header_generator",
			"std" => "",
			"type" => "group",
			"add_text" => "Header Style",
			"remove_text" => "Header Style",
			"group_sortable" => false,
			"subelements" => array(
				array(
					"name" => "Header Style Name",
					"description" => "The name of this header style.Please note that all names must be unique.",
					"id" => "uh_style_name",
					"std" => '',
					"type" => "text",
					"mod" => 'disabled'
				) ,
				array(
					"name" => "Background image",
					"description" => "Select a background image for your header.",
					"id" => "uh_background_image",
					"std" => "",
					"type" => "media",
					"class" => ''
				) ,
				array(
					"name" => "Header Background Color",
					"description" => "Here you can choose a default color for your header.If you do not select a background image, this color will be used as background.",
					"id" => "uh_header_color",
					"std" => '#AAAAAA',
					"type" => "color"
				) ,
				array(
					"name" => "Add gradient over color ?",
					"description" => "Select yes if you want add a gradien over the selected color",
					"id" => "uh_grad_bg",
					"std" => "1",
					"type" => "select",
					"options" => array(
						"1" => "Yes",
						"0" => "No"
					) ,
					"class" => ""
				) ,
				array(
					"name" => "Animate Background ?",
					"description" => "Select yes if you want to make your background animated",
					"id" => "uh_anim_bg",
					"std" => "0",
					"type" => "select",
					"options" => array(
						"1" => "Yes",
						"0" => "No"
					) ,
					"class" => ""
				) ,
				array(
					"name" => "Add Glare effect ?",
					"description" => "Select yes if you want to add a glare effect over the background",
					"id" => "uh_glare",
					"std" => "0",
					"type" => "select",
					"options" => array(
						"1" => "Yes",
						"0" => "No"
					) ,
					"class" => ""
				) ,
				array(
					"name" => "Bottom style ?",
					"description" => "Select the header bottom style you want to use",
					"id" => "uh_bottom_style",
					"std" => "0",
					"type" => "select",
					"options" => array(
						"none" => "None",
						"shadow" => "Shadow Up",
						"shadow_ud" => "Shadow Up and down",
						"mask1" => "Bottom mask 1",
						"mask2" => "Bottom mask 2"
					) ,
					"class" => ""
				)
			) ,
			"class" => ""
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*--------------------------------------------------------------------------------------------------
		Sidebar Generator
		--------------------------------------------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'sidebar_options'
		);
		$zn_options[] = array(
			"name" => "Sidebar Generator",
			"description" => "Here you can create unlimited sidebars to be used on different pages.",
			"id" => "sidebar_generator",
			"std" => "",
			"type" => "group",
			"add_text" => "Sidebar",
			"remove_text" => "Sidebar",
			"subelements" => array(
				array(
					"name" => "Sidebar name",
					"description" => "Enter your desired name for this sidebar. Please note that this name must be unique and if multiple sidebars are registered with the same name , only the first sidebar will be shown",
					"id" => "sidebar_name",
					"std" => "",
					"type" => "text"
				)
			) ,
			"class" => ""
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*--------------------------------------------------------------------------------------------------
		Coming Soon Options
		--------------------------------------------------------------------------------------------------*/
		$mail_lists = array();
		if (!empty($data['mailchimp_api']))
		{
			include_once (TEMPLATEPATH . '/widgets/mailchimp/MCAPI.class.php');
			
			$api_key = $data['mailchimp_api'];
			$mcapi = new MCAPI($api_key);
			$lists = $mcapi->lists();
			if ( !empty($lists['data']) ){
				foreach($lists['data'] as $key => $value)
				{
					$mail_lists[$value['id']] = $value['name'];
				}
			}
		}

		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'cs_options'
		);

		// ENABLE COMING SOON PAGE

		$zn_options[] = array(
			"name" => "Enable Coming Soon?",
			"description" => "If enabled, the visitators will be displayed the coming soon page. Please note that all logged in users will still be able to see your site.",
			"id" => "cs_enable",
			"std" => "no",
			"type" => "zn_radio",
			"options" => array(
				'yes' => 'Enable',
				'no' => 'Disable'
			) ,
			"class" => "zn_hide"
		);

		// ENABLE COMING SOON PAGE

		$zn_options[] = array(
			"name" => "Description",
			"description" => "Enter a description that will appear above the countdown clock.",
			"id" => "cs_desc",
			"std" => "We are currently working on a new website and won't take long. Please don't forget to check out our tweets and to subscribe to be notified!",
			"type" => "textarea",
			"translate_name" => "Coming Soon Page Description",
			"class" => "cs_enable-yes"
		);

		// ENABLE COMING SOON PAGE

		$zn_options[] = array(
			"name" => "Launch date",
			"description" => "Please select the date when your site will be available.",
			"id" => "cs_date",
			"std" => "",
			"type" => "date_picker",
			"class" => "cs_enable-yes"
		);

		// MAILCHIMP LIST ID

		$zn_options[] = array(
			"name" => "Mailchimp List ID",
			"description" => "Please select the mailchimp list ID you want to use. Please note that in order for the theme to display your list id's ,you will need to enter your Mailchimp API id in the General options > Mailchimp API option",
			"id" => "cs_lsit_id",
			"std" => "",
			"type" => "select",
			"options" => $mail_lists,
			"class" => "cs_enable-yes"
		);
		$zn_options[] = array(
			"name" => "Social Icons",
			"description" => "Here you can configure what social icons to appear on the right side of the MailChimp form.",
			"id" => "cs_social_icons",
			"std" => "",
			"type" => "group",
			"add_text" => "Social Icon",
			"remove_text" => "Social Icon",
			"subelements" => array(
				array(
					"name" => "Icon title",
					"description" => "Here you can enter a title for this social icon.Please note that this is just for your information as this text will not be visible on the site.",
					"id" => "cs_social_title",
					"std" => "",
					"type" => "text"
				) ,
				array(
					"name" => "Social icon link",
					"description" => "Please enter your desired link for the social icon. If this field is left blank, the icon will not be linked.",
					"id" => "cs_social_link",
					"std" => "",
					"type" => "link",
					"options" => array(
						'_blank' => "New window",
						'_self' => "Same window"
					)
				) ,
				array(
					"name" => "Social icon",
					"description" => "Select your desired social icon.",
					"id" => "cs_social_icon",
					"std" => "",
					"options" => $all_icon_sets,
					"type" => "zn_icon_font"
				)
			) ,
			"class" => "cs_enable-yes"
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*--------------------------------------------------------------------------------------------------
		Get all dynamic headers
		--------------------------------------------------------------------------------------------------*/
		$header_option = array();
		$header_option['zn_def_header_style'] = 'Default style';
		if (isset($data['header_generator']) && is_array($data['header_generator']))
		{

			// $sidebars = $data['sidebar_generator'];

			foreach($data['header_generator'] as $header)
			{
				if (isset($header['uh_style_name']) && !empty($header['uh_style_name']))
				{
					$header_name = strtolower(str_replace(' ', '_', $header['uh_style_name']));
					$header_option[$header_name] = $header['uh_style_name'];
				}
			}
		}

		/*--------------------------------------------------------------------------------------------------
		404 PAGE OPTIONS
		--------------------------------------------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => '404_options'
		);
		$zn_options[] = array(
			"name" => "Header Style",
			"description" => "Select the background style you want to use.Please note that the styles can be created from the \"Unlimited Headers\" options in the theme admin's page.",
			"id" => "404_header_style",
			"std" => "",
			"type" => "select",
			"options" => $header_option,
			"class" => ""
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		
		
		/*--------------------------------------------------------------------------------------------------
		ADVANCED OPTIONS
		--------------------------------------------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'advanced_options'
		);
		
		$zn_options[] = array(
			"name" => "Themeforest Username",
			"description" => "Please fill in your Themeforest username.",
			"id" => "zn_theme_username",
			"std" => "",
			"type" => "text",
		);
		
		$zn_options[] = array(
			"name" => "Themeforest API key",
			"description" => "Please fill in your Themeforest API key.",
			"id" => "zn_theme_api",
			"std" => "",
			"type" => "text",
		);
		
		$zn_options[] = array(
			"name" => "Custom CSS",
			"description" => "Here you can add your own custom css.",
			"id" => "zn_custom_css",
			"std" => "",
			"type" => "textarea",
		);
		
		$zn_options[] = array(
			"name" => "Install Dummy Data",
			"description" => "Press this button if you want your blog filled with demo data as seen on the demo site. Please note that the images will not be imported.",
			"id" => "install_dummy",
			"type" => "one_click_install",
		);

		
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		
		/*--------------------------------------------------------------------------------------------------
		WooCommerce options
		--------------------------------------------------------------------------------------------------*/
		$sidebar_option = array();
		$sidebar_option['defaultsidebar'] = 'Default Sidebar';
		if (isset($data['sidebar_generator']) && is_array($data['sidebar_generator']))
		{
			$sidebars = $data['sidebar_generator'];
			foreach($data['sidebar_generator'] as $sidebar)
			{
				if ($sidebar['sidebar_name'])
				{
					$sidebar_option[$sidebar['sidebar_name']] = $sidebar['sidebar_name'];
				}
			}
		}

		// Add default sidebar

		/*
		*			Start WOO GENERAL OPTIONS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'woo_general_options'
		);

		// Show CART in header

		$zn_options[] = array(
			"name" => "Show MY CART in header",
			"description" => "Choose yes if you want to show a link to MY CART and the total value of the cart in the header",
			"id" => "woo_show_cart",
			"std" => "1",
			"type" => "zn_radio",
			"options" => array(
				"1" => "Show",
				"0" => "Hide"
			) ,
			"class" => "zn_hide"
		);

		// Show new items badge

		$show_new_badge = array(
			"1" => "Show",
			"0" => "Hide"
		);
		$zn_options[] = array(
			"name" => "Show new items badge ?",
			"description" => "Choose yes if you want to show a NEW item badge over the new products",
			"id" => "woo_new_badge",
			"std" => "1",
			"type" => "zn_radio",
			"options" => $show_new_badge,
			"class" => "zn_hide"
		);

		// Days to show as new

		$zn_options[] = array(
			"name" => "Days to show badge",
			"description" => "Please insert the number of days after a product is published to display the badge",
			"id" => "woo_new_badge_days",
			"std" => '3',
			"type" => "text",
			"class" => "woo_new_badge-1"
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*
		*			Start WOO CATEGORY OPTIONS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'woo_category_options'
		);
		$zn_options[] = array(
			"name" => "Shop Archive Page Title",
			"description" => "Enter the desired page title for the shop archive page.",
			"id" => "woo_arch_page_title",
			"std" => "OUR PRODUCTS",
			"type" => "text",
			"translate_name" => "Shop Archive Page Title",
			"class" => ""
		);
		$zn_options[] = array(
			"name" => "Shop Archive Page Subitle",
			"description" => "Enter the desired page subtitle for the Shop archive page.",
			"id" => "woo_arch_page_subtitle",
			"std" => "Shop category here with product list",
			"type" => "text",
			"translate_name" => "Shop Archive Page Subtitle",
			"class" => ""
		);
		$zn_options[] = array(
			"name" => "Shop Archive Sidebar Position",
			"description" => "Select the position of the sidebar on Shop archive pages.",
			"id" => "woo_arch_sidebar_position",
			"std" => "right_sidebar",
			"type" => "select",
			"options" => array(
				'left_sidebar' => "Left Sidebar",
				'right_sidebar' => "Right sidebar",
				"no_sidebar" => "No sidebar"
			) ,
			"class" => ""
		);
		$zn_options[] = array(
			"name" => "Shop Archive Default Sidebar",
			"description" => "Select the default sidebar that will be used on Shop archive pages.",
			"id" => "woo_arch_sidebar",
			"std" => "",
			"type" => "select",
			"options" => $sidebar_option,
			"class" => ""
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*
		*			Start WOO SINGLE OPTIONS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'woo_single_options'
		);
		$zn_options[] = array(
			"name" => "Shop Single Sidebar Position",
			"description" => "Select the position of the sidebar on Shop Single pages.",
			"id" => "woo_single_sidebar_position",
			"std" => "right_sidebar",
			"type" => "select",
			"options" => array(
				'left_sidebar' => "Left Sidebar",
				'right_sidebar' => "Right sidebar",
				"no_sidebar" => "No sidebar"
			) ,
			"class" => ""
		);
		$zn_options[] = array(
			"name" => "Shop Single Default Sidebar",
			"description" => "Select the default sidebar that will be used on Shop Single pages.",
			"id" => "woo_single_sidebar",
			"std" => "",
			"type" => "select",
			"options" => $sidebar_option,
			"class" => ""
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);

/*--------------------------------------------------------------------------------------------------
	Facebook Options
--------------------------------------------------------------------------------------------------*/

		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'facebook_options'
		);

		$zn_options[] = array(
			"name" => "Add Facebook OpenGraph Tags?",
			"description" => "Choose yes if you want to enable the facebook OpenGraph for your site.",
			"id" => "face_og",
			"std" => "1",
			"type" => "zn_radio",
			"options" => array(
				"1" => "Show",
				"0" => "Hide"
			) 
		);

		$zn_options[] = array(
			"name" => "Facebook Application ID",
			"description" => "Please enter your facebook application ID. The share buttons will not work correctly if you don't fill this in.",
			"id" => "face_AP_ID",
			"std" => "",
			"type" => "text"
		);

		$zn_options[] = array(
			"type" => 'option_page_end'
		);
	}
}

?>