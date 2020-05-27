<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#city-form').validate({
			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$city->id; ?>"
				},
				country_id: {
		       		indexCheck : ""
		      	}
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_city_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_city_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_city_exist' ) ;?>."
				},
				country_id:{
			       indexCheck: "<?php echo $this->lang->line('f_item_country_required'); ?>"
			    }
			}
		});
		
		jQuery.validator.addMethod("indexCheck",function( value, element ) {
			
			   if(value == 0) {
			    	return false;
			   } else {
			    	return true;
			   };

			   
		});

		// custom validation
		jQuery.validator.addMethod("blankCheck",function( value, element ) {
			
			   if(value == "") {
			    	return false;
			   } else {
			   		
			    	return true;
			   };
		})

	}

	<?php endif; ?>

</script>

