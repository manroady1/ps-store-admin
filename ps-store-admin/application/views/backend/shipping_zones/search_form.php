<div class='row my-3'>
	<div class='col-6'>
	<?php
		$attributes = array('class' => 'form-inline');
		echo form_open( $module_site_url .'/search', $attributes);
	?>
		
		<div class="form-group" style="padding-top: 3px;">

			<?php
				$options=array();
				$options[0]=get_msg('select_zone');
				
				$zones = $this->Zone->get_all( );
				foreach($zones->result() as $zone) {
					
						$options[$zone->id]=$zone->name;
				}
				
				echo form_dropdown(
					'zone_id',
					$options,
					set_value( 'zone_id', show_data( $zone_id ), false ),
					'class="form-control form-control-sm mr-3" id="zone_id"'
				);
			?> 
				

		</div>

	  	<div class="form-group" style="padding-right: 2px;">
		  	<button type="submit" class="btn btn-sm btn-primary">
		  		<?php echo get_msg( 'btn_search' )?>
		  	</button>
	  	</div>

	  	<div class="form-group">
		  	<a href='<?php echo $module_site_url; ?>' class='btn btn-sm btn-primary'>
				<?php echo get_msg( 'btn_reset' )?>
			</a>
	  	</div>

	<?php echo form_close(); ?>

	</div>	

	<div class='col-6'>
		<a href='<?php echo $module_site_url .'/add';?>' class='btn btn-sm btn-primary pull-right'>
			<span class='fa fa-plus'></span> 
			<?php echo get_msg( 'shipping_zone_add' )?>
		</a>
	</div>

</div>




