<script>

	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {
		
		$('#shipping-form').validate({
			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$shipping->id; ?>"
					
				}
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_shipping_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_shipping_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_shipping_exist' ) ;?>."
				}
			}

		});

		// custom validation
		jQuery.validator.addMethod("blankCheck",function( value, element ) {
			
			   if(value == "") {
			    	return false;
			   } else {
			    	return true;
			   }
		})
	}
	
	<?php endif; ?>

		$('.delete-img').click(function(e){
			e.preventDefault();

			// get id and image
			var id = $(this).attr('id');

			// do action
			var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$shipping->id; ?>';
			console.log( action );
			$('.btn-delete-image').attr('href', action);
			
		});

	
</script>

<?php 
	$this->load->view( $template_path .'/components/icon_upload_modal', $data );

	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 
?>