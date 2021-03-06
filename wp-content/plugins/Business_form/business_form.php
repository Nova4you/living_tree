<?php
/*
 Plugin Name: Business Form
Plugin URI: http://www.daronet.com.au
Description: Generate a business registration form. Shortcode: [business_form top_categories="1,2,3,4" action="action_name"]
Version: 1.00
Author: Justin Wang
Author URI: http://www.daronet.com.au
*/

//wp_enqueue_script("jquery");
//wp_enqueue_script('jquery-ui-tabs');
wp_enqueue_script('bootstrap-carousel',plugins_url('/js/bootstrap-carousel.js', __FILE__),array(),FALSE,TRUE);
wp_enqueue_script('business_form_utils',plugins_url('/js/business_form_utils.js', __FILE__),array(),FALSE,TRUE);

class BusinessForm{
	private $top_category_wrapper_id = 'top_categories';
	private $child_category_wrapper_id = 'child_categories_wrapper';
	private $cats_in_array = array();
	
	private $default_form_elements = null;
	
	private $action = '#';
	
	function __construct() {
		if (is_admin()) {
		} else {
			//wp_enqueue_style('search_bar', plugins_url('/css/search_bar.css', __FILE__),array(),FALSE);
			add_shortcode('business_form', array(&$this, "shortcode_handler"));
		}
	}
	
	/**
	 * 
	 * @param Array $_atts
	 * 
	 * $_atts = array('top_categories'=>'1,2,3')
	 */
	function shortcode_handler($_atts=NULL) {
		
		$this->cats_in_array = $this->_parse_categories($_atts);
		$this->_init_elements();
		echo $this->_output();
	}
	
	private function _output(){
		$form = '<form class="form-horizontal" enctype="multipart/form-data" method="post" action="'.get_bloginfo('siteurl').'/'.$this->action.'">';
		
		if ($this->default_form_elements) {
			foreach ($this->default_form_elements as $key => $fieldset) {
				$new_fieldset = '<fieldset><legend>'.$fieldset['fieldset_name'].'</legend>';
				foreach ($fieldset['elements'] as $name => $element) {
					$input = '<div class="row-fluid">';
					$label = '<label>'.$element['label'].( ($element['required'])?' <b style="color:#CD2122;">*</b>':NULL ).'</label>';
					if ($element['input_type'] == 'text') {
						$input .= $label .'<input type="text" name="'.$name.'" class="span8" placeholder="'.$element['label'].'" id="input'.$name.'">';
					}else if($element['input_type'] == 'options'){
						$input .= $label .'<select name="'.$name.'" class="span8" id="input'.$name.'">'.$element['options'].'</select>';
					}else if($element['input_type'] == 'textarea'){
						$input .= $label .'<textarea class="span8" name="'.$name.'" rows="6"></textarea>';
					}else if($element['input_type'] == 'password'){
						$input .= $label .'<input type="password" name="'.$name.'" class="span8" placeholder="'.$element['label'].'" id="input'.$name.'">';
					}elseif ($element['input_type'] == 'file'){
						$input .= $label .'<input type="file" name="'.$name.'">';
					}elseif ($element['input_type'] == 'captcha'){
						$label = '<label>'.$element['label'].( ($element['required'])?' "<b style="color:blue;">ABC 123</b>" <b style="color:#CD2122;">*</b>':NULL ).'</label>';
						$input .= $label.'<input type="text" name="'.$name.'" class="span4" id="input'.$name.'">';
					}elseif ($element['input_type'] == 'checkbox'){
						$input .= '<label class="checkbox"><input '.($element['required']?'checked':NULL).' type="checkbox" name="'.$name.'"> '.$element['label'].'</label>';
					}
					$new_fieldset .= $input .'</div>';
				}
				$form .= $new_fieldset.'</fieldset>';
			}
		}
		
		$submit_button = '<p style="float:right;"><button class="btn btn-large btn-danger" type="submit">Submit</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-large" type="reset">Reset</button></p>';
		
		return $form.$submit_button.'</form>'.$this->_generate_child_category_select_in_html($this->cats_in_array);
	}
	
	
	private function _generate_child_category_select_in_html($categoris = NULL){
		$html = '<div style="display:none;" id="'.$this->child_category_wrapper_id.'">';
		if ($categoris) {
			foreach ($categoris as $value) {
				$html .= '<div id="child_categories'.$value['id'].'">';
				if (isset($value['subs'])) {
					foreach ($value['subs'] as $v) {
						$html .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
					};
				}
				$html .= '</div>';
			}
		}
		return $html.'</div>';
	}
	
	private function _generate_top_category_select_in_html($categoris = NULL){
		$top_categories_options_html = '';
		foreach ($this->cats_in_array as $value) {
			$top_categories_options_html .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
		}
		
		return '<option value="">All Categories</option>'.$top_categories_options_html;
	}
	
	private function _parse_categories($_atts){
		if($_atts AND is_array($_atts)){
			if (isset($_atts['action'])) {
				$this->action = $_atts['action'];
			}
			
			$cats = $this->_get_top_category_in_array_format($_atts['top_categories']);
			$cats_in_array = array();
			//echo '<pre>';
			
			foreach ($cats as $c) {
				$subs = $this->_get_child_category_in_array_format($c->term_id);
				$subs_in_array = array();
			
				foreach ($subs as $sc) {
					$subs_in_array[] = array(
							'id'=>$sc->term_id,
							'name'=>$sc->name
					);
				}
			
				$cats_in_array[] = array(
						'id'=>	$c->term_id,
						'name'=>$c->name,
						'subs' => $subs_in_array
				);
			}
			//var_dump( $cats_in_array ) ;
			//echo '</pre>';
			return $cats_in_array;
		}
		else{
			return NULL;
		}
	}
	
	private function _get_top_category_in_array_format($top_categories_id){
		return get_categories(array(
			'orderby'=>'name',
			'order'=>'asc',
			'hide_empty'=>FALSE,
			'include'=>$top_categories_id,
			'pad_counts'=>TRUE
		));
	}
	
	private function _get_child_category_in_array_format($top_category_id = NULL){
		return get_categories(array(
				'orderby'=>'name',
				'order'=>'asc',
				'hide_empty'=>FALSE,
				'child_of'=>$top_category_id,
				'pad_counts'=>TRUE
		));
	}
	
	private function _get_states_in_options_html(){
		$states = array(
			'Please choose ...', 'VIC','NSW','WA','SA','QLD','TAS','ACT','NT'	
		);
		$options = '';
		foreach ($states as $key=>$value) {
			if ($key>0) {
				$options .= '<option value="'.$value.'">'.$value.'</option>';
			}else{
				$options .= '<option value="">'.$value.'</option>';
			}
		}
		return $options;
	}
	
	private function _init_elements(){
		$this->default_form_elements = array(
				array(
						'fieldset_name'=>'Please add your business brief here',
						'elements'=>array(
								'business_name'=>array(
										'label'=>'Business / Trading Name',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'description'=>array(
										'label'=>'Brief Description',
										'input_type'=>'textarea',
										'required'=>FALSE
								),
								'account_manager'=>array(
										'label'=>'Account Manager',
										'input_type'=>'text',
										'required'=>FALSE
								),
								'email'=>array(
										'label'=>'Email',
										'input_type'=>'text',
										'required'=>FALSE
								),
								'telephone'=>array(
										'label'=>'Telephone',
										'input_type'=>'text',
										'required'=>FALSE
								),
								'opening_hours'=>array(
										'label'=>'Opening hours',
										'input_type'=>'text',
										'required'=>FALSE
								),
								'website'=>array(
										'label'=>'Website',
										'input_type'=>'text',
										'required'=>FALSE
								)
						)
				),
				array(
						'fieldset_name'=>'Where is your business trading location?',
						'elements'=>array(
								'unit_no'=>array(
										'label'=>'Unit No.',
										'input_type'=>'text',
										'required'=>FALSE
								),
								'street_no'=>array(
										'label'=>'Street No.',
										'input_type'=>'text',
										'required'=>FALSE
								),
								'street_name'=>array(
										'label'=>'Street name',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'suburb'=>array(
										'label'=>'Suburb\town',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'country'=>array(
										'label'=>'Country',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'state'=>array(
										'label'=>'State',
										'input_type'=>'options',
										'required'=>TRUE,
										'options'=>$this->_get_states_in_options_html()
								),
								'postcode'=>array(
										'label'=>'Postcode',
										'input_type'=>'text',
										'required'=>TRUE
								)
						)
				),
				array(
						'fieldset_name'=>'Please select your main trading business category',
						'elements'=>array(
								'main_category'=>array(
										'label'=>'Main Category',
										'input_type'=>'options',
										'required'=>TRUE,
										'options'=>$this->_generate_top_category_select_in_html($this->cats_in_array)
								),
								'child_category'=>array(
										'label'=>'Sub Category',
										'input_type'=>'options',
										'required'=>TRUE,
										'options'=>'<option value="">Please select ...</option>'
								)
						)
				),
				array(
						'fieldset_name'=>'Please upload 3 pictures of your business',
						'elements'=>array(
								'image1'=>array(
										'label'=>'Image 1 (500x500 pix)',
										'input_type'=>'file',
										'required'=>FALSE
								),
								'image2'=>array(
										'label'=>'Image 2 (500x500 pix)',
										'input_type'=>'file',
										'required'=>FALSE
								),
								'image3'=>array(
										'label'=>'Image 3 (500x500 pix)',
										'input_type'=>'file',
										'required'=>FALSE
								),
						)
				),
				array(
						'fieldset_name'=>'Registration',
						'elements'=>array(
								'email_username'=>array(
										'label'=>'E-Mail',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'password'=>array(
										'label'=>'Password',
										'input_type'=>'password',
										'required'=>TRUE
								),
								'password_confirm'=>array(
										'label'=>'Confirm Password',
										'input_type'=>'password',
										'required'=>TRUE
								),
								'first_name'=>array(
										'label'=>'First Name',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'last_name'=>array(
										'label'=>'Last Name',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'company'=>array(
										'label'=>'Company',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'abn'=>array(
										'label'=>'ABN',
										'input_type'=>'text',
										'required'=>TRUE,
								),
								'contact_number'=>array(
										'label'=>'Contact No.',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'reg_unit_no'=>array(
										'label'=>'Unit No.',
										'input_type'=>'text',
										'required'=>FALSE
								),
								'reg_street_no'=>array(
										'label'=>'Street No.',
										'input_type'=>'text',
										'required'=>FALSE
								),
								'reg_street_name'=>array(
										'label'=>'Street name',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'reg_suburb'=>array(
										'label'=>'Suburb\town',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'reg_country'=>array(
										'label'=>'Country',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'reg_state'=>array(
										'label'=>'State',
										'input_type'=>'options',
										'required'=>TRUE,
										'options'=>$this->_get_states_in_options_html()
								),
								'reg_postcode'=>array(
										'label'=>'Postcode',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'captcha'=>array(
										'label'=>'Type the code below:',
										'input_type'=>'captcha',
										'required'=>TRUE
								),
								'send_me_update'=>array(
										'label'=>'Send me updates by email',
										'input_type'=>'checkbox',
										'required'=>FALSE,
								),
						)
				),
				array(
						'fieldset_name'=>'Terms',
						'elements'=>array(
								'terms'=>array(
										'label'=>'I read & accept Terms &amp; Conditions',
										'input_type'=>'checkbox',
										'required'=>TRUE,
								),
								'is_owner'=>array(
										'label'=>'I hereby represent and warrant that I am the owner of the property and not acting as an agent (or similar) of the owner.',
										'input_type'=>'checkbox',
										'required'=>TRUE,
								)
						)
				),
				array(
						'fieldset_name'=>'Post your business on site',
						'elements'=>array(
								'on_site_now'=>array(
										'label'=>'Click here to post your business on site',
										'input_type'=>'checkbox',
										'required'=>FALSE,
								)
						)
				)
		);
	}
}

$obj = new BusinessForm();