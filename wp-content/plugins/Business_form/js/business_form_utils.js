jQuery(document).ready(function() {
					if(jQuery("#top_category_id").length>0){
						jQuery("#top_category_id").change(function(){
							var top_category_id = jQuery(this).val();
							var options = '<option value="">All Subcategories</option>'+jQuery("#child_categories"+top_category_id).html();
							jQuery("#child_category_id").html('').html(options);
						});
					}
					
});