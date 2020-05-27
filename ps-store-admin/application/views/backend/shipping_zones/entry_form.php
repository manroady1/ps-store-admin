<?php
	$attributes = array( 'id' => 'shipping-zone-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>

	<section class="content animated fadeInRight">
		<div class="col-md-6">
			<div class="card card-info">
		        <div class="card-header">
		            <h3 class="card-title"><?php echo get_msg('shipping_zone_info')?></h3>
		        </div>

			<form role="form">
        		<div class="card-body">
					<div class="row">
						<div class="col-md-12">

							
							<div class="form-group">

								<label> <span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('shipping_package_name')?>
								</label>

								<?php echo form_input( array(
									'name' => 'name',
									'value' => set_value( 'name', show_data( @$shipping_zone->name), false ),
									'class' => 'form-control form-control-sm',
									'placeholder' => get_msg('pls_shipping_name'),
									'id' => 'name'
								)); ?>

								<input type="hidden" id="existing_zone_id" name="existing_zone_id" value="<?php echo $shipping_zone->zone_id;   ?>">
								
							</div>


							<div class="form-group">
								<label> <span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('select_zone')?>
								</label>
								<?php if(!$shipping_zone){ ?>
								<?php
									$options=array();
									$options[0]=get_msg('select_zone');
									$shp_zone = $this->Shipping_zone->get_all()->result();
									
									foreach ($shp_zone as $shp) {

									  	$result .= "'".$shp->zone_id ."'" .",";
									  
									}
									
									$shi_zone_id = rtrim($result,",");

									$conds['shi_zone_id'] = $shi_zone_id;

									if ($conds['shi_zone_id'] == "") {
										$zones = $this->Zone->get_all();
									} else {
										$zones = $this->Zone->get_all_zone_id($conds);
									}
									
									foreach($zones->result() as $zone) {
											$options[$zone->id]=$zone->name;
									}

									echo form_dropdown(
										'zone_id',
										$options,
										set_value( 'zone_id', show_data( @$shipping_zone->zone_id), false ),
										'class="form-control form-control-sm mr-3" id="zone_id"'
									);
									
								?>
								<?php } else { 
									$options=array();
									$options[0]=get_msg('select_zone');
									$shp_zone = $this->Shipping_zone->get_all()->result();
									
									foreach ($shp_zone as $shp) {

									  	$result .= "'".$shp->zone_id ."'" .",";
									  
									}
									
									$shi_zone_id = rtrim($result,",");

									$conds['shi_zone_id'] = $shi_zone_id;
															
									$zones = $this->Zone->get_all_zone_id($conds)->result();

									foreach ($zones as $zone) {

									  	$result_zone .= "'".$zone->id ."'" .",";
									  
									}

									$result_zone .= "'". $shipping_zone->zone_id ."'" .",";
									
									$result_zone_id = rtrim($result_zone,",");

									$conds['result_zone_id'] = $result_zone_id;
															
									$reszones = $this->Zone->get_all_result_zone_id($conds);

									foreach($reszones->result() as $zone) {
										$options[$zone->id]=$zone->name;
									}

									echo form_dropdown(
										'zone_id',
										$options,
										set_value( 'zone_id', show_data( @$shipping_zone->zone_id), false ),
										'class="form-control form-control-sm mr-3" id="zone_id"'
									);
								} ?>
							</div>

							<div class="form-group" style="padding-top: 30px;">
								<div>
							        <label><input type="radio" name="colorRadio" value="per_order_based_enabled" <?php 
							       		$per_order_based_enabled = $shipping_zone->per_order_based_enabled;
							        if ($per_order_based_enabled == 1) echo "checked"; ?> >
							          <?php echo get_msg('per_order_based'); ?> </label>
							        <label><input type="radio" name="colorRadio" value="per_item_based_enabled" <?php 
							       		$per_item_based_enabled = $shipping_zone->per_item_based_enabled;
							        if ($per_item_based_enabled == 1) echo "checked"; ?> > <?php echo get_msg('per_item_based'); ?> </label>
							        <label><input type="radio" name="colorRadio" value="free_enabled" <?php 
							       		$free_enabled = $shipping_zone->free_enabled;
							        if ($free_enabled == 1) echo "checked"; ?> > <?php echo get_msg('free_shipping'); ?> </label>
							    </div>
							    
							    <?php 
							    	if($shipping_zone->per_order_based_enabled == 1) {
							    		$display = "block";
							    	} else {
							    		$display = "none";
							    	}
							    ?>

							    <div class="per_order_based_enabled box" style="display: <?php echo $display; ?> "> 
							    	<?php echo get_msg('you_selected')?> <b> <?php echo get_msg('per_order_based'); ?> </b> <br> <br>
							    	<?php echo get_msg('cost'); ?> : 
							    	<?php echo form_input( array(
										'name' => 'per_order_based_cost',
										'value' => set_value( 'per_order_based_cost', show_data( @$shipping_zone->per_order_based_cost ), false ),
										'placeholder' => get_msg('per_order_post'),
										'id' => 'per_order_based_cost'
									)); ?>
							    </div>
							    
							    <?php 
							    	if($shipping_zone->per_item_based_enabled == 1) {
							    		$display = "block";
							    	} else {
							    		$display = "none";
							    	}
							    ?>

							    <div class="per_item_based_enabled box" style="display: <?php echo $display; ?> ">
							    	<?php echo get_msg('you_selected')?> <b> <?php echo get_msg('per_item_based'); ?> </b> <br> <br>

							    	<label><input type="checkbox" name="per_item_based_from_product_cost_enable"   <?php 
							       		$per_item_based_from_product_cost_enable = $shipping_zone->per_item_based_from_product_cost_enable;
							        if ($per_item_based_from_product_cost_enable == 1) echo "checked"; ?> /> <?php echo get_msg('take_prd_shipping_cost'); ?></label>

							    	<label>
							    		<!--
							    		<input type="checkbox" name="per_item_based_enabled"  <?php 
							       		$per_item_based_cost = $shipping_zone->per_item_based_cost;
							        	if ($per_item_based_cost != 0 ) echo "checked"; ?> /> -->


							    	<?php echo get_msg('delivery_increment_of_zone'); ?> </label> 
							    	<?php echo form_input( array(
										'name' => 'delivery_increment_of_zone',
										'value' => set_value( 'delivery_increment_of_zone', show_data( @$shipping_zone->delivery_increment_of_zone ), false ),
										'placeholder' => "1",
										'id' => 'delivery_increment_of_zone'
									)); ?>

									 <br>
									 <?php echo get_msg('increment_formula'); ?>
									 <br>
									 <?php echo get_msg('increment_note'); ?>
									 <br>
									 <br>

									<label>
										<!--
										<input type="checkbox" name="per_item_based_enabled"  <?php 
							       		$per_item_based_cost = $shipping_zone->per_item_based_cost;
							        if ($per_item_based_cost != 0 ) echo "checked"; ?> /> -->


							    <?php echo get_msg('based_cost'); ?>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
								</label> 
							    	<?php echo form_input( array(
										'name' => 'per_item_based_cost',
										'value' => set_value( 'per_item_based_cost', show_data( @$shipping_zone->per_item_based_cost ), false ),
										'placeholder' => "0",
										'id' => 'per_item_based_cost'
									)); ?> 



							    	 <br>

									
									


								</div>
							    
								<?php 
							    	if($shipping_zone->free_enabled == 1) {
							    		$display = "block";
							    	} else {
							    		$display = "none";
							    	}
							    ?>

							    <div class="free_enabled box">

							    	<?php echo get_msg('you_selected')?> <b> <?php echo get_msg('free_shipping'); ?> </b> <br> <br>

								</div>
							
							</div>

							
							<div class="form-group" style="padding-top: 30px;">
							<div class="form-check">

								<label>
								
									<?php echo form_checkbox( array(
										'name' => 'status',
										'id' => 'status',
										'value' => 'accept',
										'checked' => set_checkbox('status', 1, ( @$shipping_zone->status == 1 )? true: false ),
										'class' => 'form-check-input'
									));	?>

									<?php echo get_msg( 'status' ); ?>
								</label>
							</div>
						</div>

						</div>

						
					</div>	

				</div>
			
				<div class="card-footer">
			     	<button type="submit" class="btn btn-sm btn-primary">
						<?php echo get_msg('btn_save')?>
					</button>

					<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
						<?php echo get_msg('btn_cancel')?>
					</a>
			    </div>

			</div>
		</div>	

<?php echo form_close(); ?>

</section>

<script type="text/javascript">
	$(".chb").change(function() {
    $(".chb").prop('checked', false);
    $(this).prop('checked', true);
});

	$(".chb").change(function() {
    $(".chb").not(this).prop('checked', false);
});

</script>