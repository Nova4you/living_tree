<?php
function form_validation($form_data){
	
	return TRUE;
}

function make_content(){
	$content = '';
	
	
	return $content;
}

function add_new_business_post_page($business){
	// Create post object
	$my_post = array(
			'post_title'    => $business['business_name'],
			'post_content'  => make_content(),
			'post_status'   => $business['on_site_now'],
			'post_author'   => 1,
			'post_category' => array($business['main_category'],$business['child_category'])
	);
	
	// Insert the post into the database
	wp_insert_post( $my_post ,TRUE);
}

function save_images($images_data){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$uploads = wp_upload_dir();
	foreach ($images_data as $field_name => $img) {
		if ( strlen($img['name'])>0 ) {
			$extension = end(explode(".", $_FILES[$field_name]["name"]));
			if ((($_FILES[$field_name]["type"] == "image/gif")
					|| ($_FILES[$field_name]["type"] == "image/jpeg")
					|| ($_FILES[$field_name]["type"] == "image/png")
					|| ($_FILES[$field_name]["type"] == "image/pjpeg"))
					&& ($_FILES[$field_name]["size"] < 500000)  //500k max per image
					&& in_array($extension, $allowedExts))
			{
				if ($_FILES[$field_name]["error"] > 0)
				{
					//$_POST[$field_name] = $uploads['url'].$_FILES[$field_name]["name"];
				}
				else
				{
			
					if ( ! file_exists($uploads['path'] . $_FILES[$field_name]["name"]))
					{
						$file_location = $uploads['path'] .'/'. $_FILES[$field_name]["name"];
					}else{
						$file_location = $uploads['path'].'/' .time().$_FILES[$field_name]["name"];
					}
					move_uploaded_file(
						$_FILES[$field_name]["tmp_name"],
						$file_location
					);
					$_POST[$field_name] = $uploads['url'].'/'.$_FILES[$field_name]["name"];
				}
			}
			else
			{
				//echo "Invalid file";
			}
		}
	}
}

//$wpdb->show_errors();
if (form_validation($_POST)) {
	/* Remove CAPTCHA */
	unset($_POST['captcha']);
	unset($_POST['password_confirm']);
	unset($_POST['terms']);
	$table_name = 'business_info';
	
	save_images($_FILES);
	
	if ($wpdb->insert($table_name, $_POST)) {
		//Save in database succeed;
		
		if (isset($_POST['on_site_now'])) {
			$_POST['on_site_now'] = 'publish';
		}else{
			$_POST['on_site_now'] = 'private';
		}
		add_new_business_post_page($_POST);
		//wp_redirect( home_url().'/business-register-success' );
	}else{
		//can not save in database
		//wp_redirect( home_url().'/business-register-failed' );
	}
}else{
	//Form validate failed
}
echo '<pre>';
var_dump($_FILES);
echo '</pre>';
