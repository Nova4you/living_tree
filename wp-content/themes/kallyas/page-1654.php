<?php
function form_validation($form_data){
	
	return TRUE;
}

function make_content($images = array()){
	$content = '';
	$carousel = '';
	
	foreach ($images as $key=>$value) {
		$carousel .= '<div class="item'.(($key==0)?' active':NULL).'"><img alt="" src="'.$value.'"></div>';
	}
	
	$content .= '
	<div class="row-fluid">
		<div class="span3">
		    <div id="myCarousel" class="carousel slide">
		    <div class="carousel-inner">
			    '.$carousel.'
		    </div>
		    <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		    <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
		    </div>		
		</div>
		<div class="span9">
	<address><strong>'.$_POST['business_name'].'</strong><br>'.
	(empty($_POST['reg_unit_no'])?NULL:($_POST['reg_unit_no'].'/')).''.
    (empty($_POST['reg_street_no'])?NULL:($_POST['reg_street_no'].' ')).
    (empty($_POST['reg_street_name'])?NULL:$_POST['reg_street_name']).'<br>'.
    (empty($_POST['reg_suburb'])?NULL:($_POST['reg_suburb'].' ') ).
    (empty($_POST['reg_state'])?NULL:($_POST['reg_state'].' ') ).
    (empty($_POST['reg_postcode'])?NULL:($_POST['reg_postcode'].' ') ).
    (empty($_POST['reg_country'])?NULL:$_POST['reg_country']).
    '<br>
    <abbr title="Phone">P:</abbr>'.(empty($_POST['telephone'])?'N.A':$_POST['telephone']).'
    </address>
     
    <address>
    <strong>'.(empty($_POST['first_name'])?'N.A':$_POST['first_name']).' '.(empty($_POST['last_name'])?'N.A':$_POST['last_name']).'</strong><br>
    <a href="mailto:'.(empty($_POST['email'])?NULL:$_POST['email']).'">'.(empty($_POST['email'])?NULL:$_POST['email']).'</a><br>
    <a href="'.(empty($_POST['website'])?'#':$_POST['website']).'" target="_blank">'.(empty($_POST['website'])?'N.A':$_POST['website']).'</a>
    </address>
    <address>
    <strong>Opening Hourse: '.(empty($_POST['opening_hours'])?'N.A':$_POST['opening_hours']).'</strong><br>
    </address>
    <hr>
    <p>'.$_POST['description'].'</p></div></div>';
	
	return $content;
}

function add_new_business_post_page($business){
	//check how many images uploaded
	$images = array();
	for ($i = 1; $i < 4; $i++) {
		if (isset($business['image'.$i]) && strlen(isset($business['image'.$i]))>0 ) {
			$images[] = $business['image'.$i];
		}
	}
	
	if ( count($images)==0 ) {
		$images[] = get_bloginfo('siteurl').'/Default.jpg';
	}
	
	
	// Create post object
	$my_post = array(
			'post_title'    => $business['business_name'],
			'post_content'  => make_content($images),
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
		wp_redirect( home_url().'/business-register-success' );
	}else{
		//can not save in database
		wp_redirect( home_url().'/business-register-failed' );
	}
}else{
	//Form validate failed
}
/*
echo '<pre>';
var_dump($_FILES);
echo '</pre>';
*/