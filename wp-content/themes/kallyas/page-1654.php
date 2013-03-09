<?php
function form_validation($form_data){
	
	return TRUE;
}

function add_new_business_post_page($business){
	// Create post object
	$my_post = array(
			'post_title'    => $business['business_name'],
			'post_content'  => 'This is my post.',
			'post_status'   => $business['on_site_now'],
			'post_author'   => 1,
			'post_category' => array($business['main_category'],$business['child_category'])
	);
	
	// Insert the post into the database
	wp_insert_post( $my_post ,TRUE);
}

//$wpdb->show_errors();
if (form_validation($_POST)) {
	/* Remove CAPTCHA */
	unset($_POST['captcha']);
	unset($_POST['password_confirm']);
	unset($_POST['terms']);
	$table_name = 'business_info';
	
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
var_dump($_POST);
echo '</pre>';
*/