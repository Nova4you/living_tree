<?php
/*
 Plugin Name: Business Form
Plugin URI: http://www.daronet.com.au
Description: Search bar with auto completed location field and categories.
Version: 1.00
Author: Justin Wang
Author URI: http://www.daronet.com.au
*/

//wp_enqueue_script("jquery");
//wp_enqueue_script('jquery-ui-tabs');
wp_enqueue_script('business_form_utils',plugins_url('/js/business_form_utils.js', __FILE__),array(),FALSE,TRUE);

class BusinessForm{
	private $top_category_wrapper_id = 'top_categories';
	private $child_category_wrapper_id = 'child_categories_wrapper';
	private $cats_in_array = array();
	
	private $default_form_elements = null;
	
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
		$form = '<form>';
		
		if ($this->default_form_elements) {
			foreach ($this->default_form_elements as $key => $fieldset) {
				$new_fieldset = '<fieldset><legend>'.$fieldset['fieldset_name'].'</legend>';
				foreach ($fieldset['elements'] as $name => $element) {
					$input = '<label>'.$element['label'].( ($element['required'])?'<b style="color:#CD2122;">*</b>':NULL ).'</label>';
					if ($element['input_type'] == 'text') {
						$input .= '<input type="text" name="'.$name.'" placeholder="'.$element['label'].'" id="input'.$name.'">';
					}else if($element['input_type'] = 'options'){
						$input .= $element['options'];
					}
					
				}
				$form .= $new_fieldset.'</fieldset>';
			}
		}
		
		return $form.'</form>'.$this->_generate_child_category_select_in_html($this->cats_in_array);
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
		
		return '<div class="controls row">
                <select name="top_category_id" class="span4" id="top_category_id">
                    <option value="">All Categories</option>
				'.$top_categories_options_html.'
                </select>
                <select name="child_category_id" class="span4" id="child_category_id">
                    <option value="">All Subcategories</option>
                </select>
        </div>';
	}
	
	private function _parse_categories($_atts){
		if($_atts AND is_array($_atts)){
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
										'required'=>TRUE
								),
								'account_manager'=>array(
										'label'=>'Account Manager',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'email'=>array(
										'label'=>'Email',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'telephone'=>array(
										'label'=>'Telephone',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'opening_hours'=>array(
										'label'=>'Opening hours',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'website'=>array(
										'label'=>'Website',
										'input_type'=>'text',
										'required'=>TRUE
								)
						),
						'seperator'=>true
				),
				array(
						'fieldset_name'=>'Where is your business trading location?',
						'elements'=>array(
								'unit_no'=>array(
										'label'=>'Unit No.',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'street_no'=>array(
										'label'=>'Street No.',
										'input_type'=>'textarea',
										'required'=>TRUE
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
										'options'=>array()
								),
								'postcode'=>array(
										'label'=>'Postcode',
										'input_type'=>'text',
										'required'=>TRUE
								)
						),
						'seperator'=>true
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
						),
						'seperator'=>true
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
						),
						'seperator'=>true
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
										'required'=>TRUE
								),
								'reg_street_no'=>array(
										'label'=>'Street No.',
										'input_type'=>'textarea',
										'required'=>TRUE
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
										'options'=>array()
								),
								'reg_postcode'=>array(
										'label'=>'Postcode',
										'input_type'=>'text',
										'required'=>TRUE
								),
								'captcha'=>array(
										'label'=>'Type the code below:',
										'input_type'=>'text',
										'required'=>TRUE
								)
						),
						'seperator'=>true
				)
		);
	}
}

$obj = new BusinessForm();