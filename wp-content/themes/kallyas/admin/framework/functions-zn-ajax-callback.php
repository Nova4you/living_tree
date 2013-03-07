<?php

/*-----------------------------------------------------------------------------------*/
/* Ajax Save Action - of_ajax_callback */
/*-----------------------------------------------------------------------------------*/

add_action('wp_ajax_zn_ajax_post_action', 'zn_ajax_callback');

function zn_ajax_callback() {
	global $options_machine, $zn_options;

	$nonce=$_POST['security'];
	
	if (! wp_verify_nonce($nonce, 'zn_ajax_nonce') ) die('-1'); 
			
	//get options array from db
	$all = get_option(OPTIONS);
		
	$save_type = $_POST['type'];
	
	//Uploads
	if($save_type == 'upload'){
		
		$clickedID = $_POST['data']; // Acts as the name
		$filename = $_FILES[$clickedID];
       	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
		
		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';    
		$uploaded_file = wp_handle_upload($filename,$override);
		 
			$upload_tracking[] = $clickedID;
				
			//update $options array w/ image URL			  
			$upload_image = $all; //preserve current data
			
			$upload_image[$clickedID] = $uploaded_file['url'];
			
			update_option(OPTIONS, $upload_image ) ;
			generate_options_css($upload_image); //generate static css file
			generate_options_js($upload_image); //generate static js file
				
		 if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . $uploaded_file['error']; }	
		 else { echo $uploaded_file['url']; } // Is the Response
		 
	}
	elseif($save_type == 'image_reset'){
			
			$id = $_POST['data']; // Acts as the name
			
			$delete_image = $all; //preserve rest of data
			$delete_image[$id] = ''; //update array key with empty value	 
			update_option(OPTIONS, $delete_image ) ;
			generate_options_css($delete_image); //generate static css file
			generate_options_js($delete_image); //generate static js file
	}
	elseif($save_type == 'backup_options'){
			
		$backup = $all;
		$backup['backup_log'] = date('r');
		
		update_option(BACKUPS, $backup ) ;
			
		die('1'); 
	}
	elseif($save_type == 'restore_options'){
			
		$data = get_option(BACKUPS);
		
		update_option(OPTIONS, $data);
		generate_options_css($data); //generate static css file
		generate_options_js($data); //generate static js file
		
		die('1'); 
	}
	
	elseif ($save_type == 'save') {
	/*	
		echo '<pre>';
		var_dump($_POST['data']);
		echo '</pre>';
	*/	
	
		$_POST      = array_map( 'stripslashes_deep', $_POST );
		parse_str($_POST['data'], $data);
		unset($data['security']);
		unset($data['of_save']);
   
		update_option(OPTIONS, $data);
		generate_options_css($data); //generate static css file
		generate_options_js($data); //generate static js file
		
		echo '1'; 
		
	} 
	elseif ($save_type == 'install_dummy') {
	/*	
		echo '<pre>';
		var_dump($_POST['data']);
		echo '</pre>';
	*/	
		locate_template(array('admin/dummy_content/zn_importer.php'), true, true);
		installDummy();

		
	} 
	elseif ($save_type == 'add_element') {
		
		//$what_element = $_POST['data'];
		
		$html = new zn_html();
		parse_str(($_POST['data']),$data);
		
		
		// Make a check to see if the element is a subelement 
		// All subelements options must be placed in the same array that is passed to zn_get_element_from_id() function in functions-zn-admin.php !!
		$full_id = $data['element_type'];
		
		if( preg_match( '/\[(\d+)\]/', $full_id, $matches ) )
		{
			
			$split_element_type = preg_split('/\[(\d+)\]/', $full_id);
			$number_of_ids = count($split_element_type)-1;
			$string = str_replace('[','',$split_element_type[$number_of_ids]);
			$string = str_replace(']','',$string);
			
			$data['element_type'] = $string;
			
		}
		
		$option = zn_get_element_from_id($data['element_type']);
				
		if ( isset ( $option['link'] ) ) 
		{
			$option['is_dynamic'] = true;
		}
		
		$option['id'] = $full_id;
		if ( isset ( $data['pb_area'] ) && !empty ( $data['pb_area'] ) ) {
			$option['pb_area'] = $data['pb_area'];		
		}
		
		
		echo $html->zn_render_element($option); 
		
		//print_r($option);
		
		unset($data['security']);
		unset($data['of_save']);
				
		die(1); 
		
	} 
	elseif ($save_type == 'reset') {
		update_option(OPTIONS,$options_machine->Defaults);
		
        die(1); //options reset
        
	}

  die();

}

?>