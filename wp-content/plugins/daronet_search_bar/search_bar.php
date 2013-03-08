<?php
/*
 Plugin Name: Nova4you Advanced Search Bar
Plugin URI: http://www.daronet.com.au
Description: Search bar with auto completed location field and categories.
Version: 1.00
Author: Justin Wang
Author URI: http://www.daronet.com.au
*/

//wp_enqueue_script("jquery");
//wp_enqueue_script('jquery-ui-tabs');
wp_enqueue_script('location_search_utils',plugins_url('/js/location_search_utils.js', __FILE__),array(),FALSE,TRUE);

class SearchBar{
	private $top_category_wrapper_id = 'top_categories';
	private $child_category_wrapper_id = 'child_categories_wrapper';
	private $cats_in_array = array();
	
	function __construct() {
		if (is_admin()) {
		} else {
			wp_enqueue_style('search_bar', plugins_url('/css/search_bar.css', __FILE__),array(),FALSE);
			add_shortcode('search_bar', array(&$this, "shortcode_handler"));
		}
	}
	
	/**
	 * 
	 * @param Array $_atts
	 * 
	 * $_atts = array('top_categories'=>'1,2,3')
	 */
	function shortcode_handler($_atts=NULL) {
		
		//$top_categories_id = explode(',', $_atts['top_categories']);
		$this->cats_in_array = $this->_parse_categories($_atts);
		echo $this->_generate_top_category_select_in_html($this->cats_in_array);
		echo $this->_generate_child_category_select_in_html($this->cats_in_array);
		echo $this->_get_search_bar_in_html();
		echo $this->_get_search_form_html();
	}
	
	private function _get_search_form_html(){
		$top_categories_options_html = '';
		foreach ($this->cats_in_array as $value) {
			$top_categories_options_html .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
		}
		$html = '<div class="span8"><div class="search_and_map_wrapper">
<div id="first_form">
    <h2>Australia Family &amp; Kids Portal</h2><br>
    <form method="post" action="'.get_bloginfo('siteurl').'/search">
        <div class="controls row">
             <input name="where" type="text" class="required span6" value="" id="autocomplete_input_pick_up" placeholder="e.g. City or Postcode" />
        	 <button type="submit" class="btn btn-danger span1">
                    Search
             </button>
		</div>
        <div class="controls row">
                <select name="top_category_id" class="span4" id="top_category_id">
                    <option value="">All Categories</option>
				'.$top_categories_options_html.'
                </select>
                <select name="child_category_id" class="span4" id="child_category_id">
                    <option value="">All Subcategories</option>
                </select>
        </div>
    </form>
</div>
<div id="second_form" class="row" style="display:none;">
	<div id="city_select_scroller" class="span2"></div>					
	<div class="span6">
	<h2>Australia Family &amp; Kids Portal</h2><br>
    <form method="post" action="'.get_bloginfo('siteurl').'/search">
        <div class="controls row">
             <input name="where" type="text" class="required span4" value="" id="autocomplete_input_pick_up2" placeholder="e.g. City or Postcode" />
        	 <button type="submit" class="btn btn-danger span2">
                    Search
             </button>
		</div>
        <div class="controls row">
                <select name="top_category_id" class="span3" id="top_category_id2">
                    <option value="">All Categories</option>
				'.$top_categories_options_html.'
                </select>
                <select name="child_category_id" class="span3" id="child_category_id2">
                    <option value="">All Subcategories</option>
                </select>
        </div>
    </form>
	</div>
</div>
						</div>';
		return $html;
	}
	
	/**
	 * It's bootstrap css compatibility theme, so use the bootstrap css class directly
	 */
	private function _get_search_bar_in_html(){
		return $html_map = '<div class="span4 search_bar_bg" id="mapCont"><img id="areaMap" usemap="#mapAreasAU" src="'.plugins_url('/map_images/map_clear.png', __FILE__).'" alt="" />
<map id="mapAreasAU" name="mapAreasAU">
<area id="area_WA" class="" coords="94,18,94,147,10,171,1,93,5,62,73,17,92,18" shape="poly" title="" alt="Australia Map" data-areaimg="http://www.realestate.com.au//img/search_map/rea/WA.png" href="#">

<area id="area_TAS" class="" coords="181,191,192,230,217,230,216,194" shape="poly" title="My Property Direct Tasmania" alt="My Property Direct Tasmania" data-areaimg="http://www.realestate.com.au/img/search_map/rea/Tas.png" href="#">
<area id="area_QLD" class="" coords="157,90,175,90,175,105,217,105,223,102,225,100,230,102,247,94,199,1,157,1" shape="poly" title="My Property Direct Queensland" alt="My Property Direct Queensland" data-areaimg="/img/search_map/rea/Qld.png" href="#">
<area id="area_NT" class="" coords="95,90,156,90,156,2,95,2" shape="poly" title="My Property Direct Northern Territory" alt="My Property Direct Northern Territory" data-areaimg="http://www.realestate.com.au/img/search_map/rea/NT.png" href="#">
<area id="area_SA" class="" coords="174,200,174,91,95,91,95,144" shape="poly" title="My Property Direct South Australia" alt="My Property Direct South Australia" data-areaimg="/img/search_map/rea/SA.png" href="#">
<area id="area_VIC" class="" coords="175,147,180,147,186,154,190,153,195,156,198,160,207,161,213,163,219,167,226,167,225,186,219,193,188,191,181,191,175,191" shape="poly" title="My Property Direct Victoria" alt="My Property Direct Victoria" data-areaimg="/img/search_map/rea/Vic.png" href="#">
<area id="area_NSW" class="" coords="248,94,231,102,225,100,218,105,175,105,175,146,180,147,186,154,189,153,195,156,198,160,198,141,240,141,250,117" shape="poly" title="My Property Direct New South Wales" alt="My Property Direct New South Wales" data-areaimg="/img/search_map/rea/NSW.png" href="#">
<area id="area_ACT" class="" coords="241,141,198,141,198,160,202,160,208,161,215,164,218,167,228,167,236,154" shape="poly" title="Real estate Australian Capital Territory" alt="My Property Direct Australian Capital Territory" data-areaimg="/img/search_map/rea/ACT.png" href="#">
</map></div>';
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
		$html = '<ul style="display:none;" id="'.$this->top_category_wrapper_id.'">';
		if ($categoris) {
			foreach ($categoris as $value) {
				$html .= '<li><p>'.$value['id'].'</p><p>'.$value['name'].'</p></li>';
			}
		}
		return $html.'</ul>';
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
}

$search_bar = new SearchBar();