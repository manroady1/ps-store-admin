<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#zone-form').validate({
			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$zone->id; ?>"
				},
				
				country_id: {
		       		indexCheck : ""
		      	},
		      	
		      	"city_id[]": "required"
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_zone_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_zone_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_zone_exist' ) ;?>."
				},

				country_id:{
			       indexCheck: "<?php echo $this->lang->line('f_item_country_required'); ?>"
			    },
				
				"city_id[]": "<?php echo $this->lang->line('f_item_city_required'); ?>"
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

	function runAfterJQ() {


		$('#country_id').on('change', function() {

				var value = $('option:selected', this).text().replace(/Value\s/, '');

				var countryId = $(this).val();
				 
				$.ajax({
					url: '<?php echo $module_site_url . '/get_all_cities/';?>' + countryId,
					method: 'GET',
					dataType: 'JSON',
					success:function(data){
						$('#city_id').html("");
						$.each(data, function(i, obj){
						    $('#city_id').append('<option value="'+ obj.id +'">' + obj.name+ '</option>');
						});
						$('#name').val($('#name').val() + " ").blur();
						$('#city_id').trigger('change');
					}
				});
			});

			$('[data-toggle="tooltip"]').tooltip();
	}	
		

</script>

