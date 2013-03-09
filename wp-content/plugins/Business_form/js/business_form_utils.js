jQuery(document).ready(function() {
					if(jQuery("#inputmain_category").length>0){
						jQuery("#inputmain_category").change(function(){
							var top_category_id = jQuery(this).val();
							var options = '<option value="">All Subcategories</option>'+jQuery("#child_categories"+top_category_id).html();
							jQuery("#inputchild_category").html('').html(options);
						});
					}
					
});