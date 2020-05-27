
<?php
	$attributes = array( 'id' => 'zone-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>

	<section class="content animated fadeInRight">
		<div class="col-md-6">
			<div class="card card-info">
		        <div class="card-header">
		            <h3 class="card-title"><?php echo get_msg('zone_info')?></h3>
		        </div>

			<form role="form">
        		<div class="card-body">
					<div class="row">
						<div class="col-md-12">

							<div class="form-group">

								<label> <span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('zone_name')?>
								</label>

								<?php echo form_input( array(
									'name' => 'name',
									'value' => set_value( 'name', show_data( @$zone->name), false ),
									'class' => 'form-control form-control-sm',
									'placeholder' => get_msg('pls_zone_name'),
									'id' => 'name'
								)); ?>

							</div>

							<div class="form-group">
								<label> <span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('select_country')?>
								</label>

								<?php
									if(isset($zone)){
										$options=array();
										$options[0]=get_msg('select_country');

										$countries = $this->Country->get_all( );
											foreach($countries->result() as $country) {
												$options[$country->id]=$country->name;
										}
										$country_id = $zone_data->country_id;

										$conds['zone_id'] = $zone->id;
											$zone_datas = $this->Zone_junction->get_all_by( $conds )->result();
											foreach ($zone_datas as $zone_data) {
												$country_id = $zone_data->country_id;
											}
											$conds['country_id'] = $country_id;

										echo form_dropdown(
											'country_id',
											$options,
											set_value( 'country_id', show_data( @$country_id ), false ),
											'class="form-control form-control-sm mr-3" id="country_id"'
										);

									} else {
										$options=array();
										$options[-1]=get_msg('select_country');
										$countries = $this->Country->get_all( );
											foreach($countries->result() as $country) {
												$options[$country->id]=$country->name;
										}
										$country_id = $zone_data->country_id;

										echo form_dropdown(
											'country_id',
											$options,
											set_value( 'country_id', show_data( @$country_id ), false ),
											'class="form-control form-control-sm mr-3" id="country_id"'
										);

									}
									
								?>

							</div>

							<div class="form-group">
								<label> <span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('select_city')?>
								</label>

								<?php 
								if(isset($zone)) {
										$options=array();
										$options[0]=get_msg('select_city');
										$conds['zone_id'] = $zone->id;
										$zone_datas = $this->Zone_junction->get_all_by( $conds )->result();
										//print_r($zone_datas);die;
										foreach ($zone_datas as $zone_data) {
											$country_id = $zone_data->country_id;
											$city_id = $zone_data->city_id;
											

										} ?>
										<select  multiple name="city_id[]" id="city_id" class="form-control" size="10" >
										
										
											<?php
												$conds['country_id'] = $country_id;

												//get all cities from zone_junctions table

												$cities = $this->City->get_all_by($conds);
												foreach($cities->result() as $city) {
													$cond_city_check['city_id'] = $city->id;
													$zone_id_from_junction = $this->Zone_junction->get_one_by( $cond_city_check )->zone_id;

													if($zone_id_from_junction == "") {
														$city_not_inside_zone[] = $city->id;
													}
												}

												


												$cities = $this->City->get_all_by($conds);
												foreach($cities->result() as $city) {
													
													$cond_zone_jun['zone_id'] = $zone->id;
													$cond_zone_jun['city_id'] = $city->id;

													$jun_id = $this->Zone_junction->get_one_by( $cond_zone_jun )->id;

													if($jun_id != "") {

															echo "<option value='".$city->id."'";

															$cond_zone['country_id'] = $country_id;
															$cond_zone['city_id']    = $city->id;
															$cond_zone['zone_id'] = $zone->id;

															$zone_city_id = $this->Zone_junction->get_one_by( $cond_zone )->city_id;


															if($zone_city_id == $city->id) 
															{
																echo " selected ";
															} 
																	
															echo ">".$city->name."</option>";


													} else {

														for($i=0; $i<count($city_not_inside_zone); $i ++) {
															if($city_not_inside_zone[$i] == $city->id) {
															 	echo "<option value='".$city->id."'";
																echo ">".$city->name."</option>";
															}
														}

													} 
												} 

											?>
										</select>

									<?php } else {
										$conds['country_id'] = $selected_country_id;
										$options=array();
										$options[0]=get_msg('select_city');

										echo form_multiselect(
											'city_id[]',
											$options,
											set_value( 'city_id', show_data( @$city_id ), false ),
											'class="form-control form-control-sm mr-3" id="city_id" size="10"'
										);
									} 

								?>

							</div>

							
							<div class="form-group" style="padding-top: 30px;">
							<div class="form-check">

								<label>
								
									<?php echo form_checkbox( array(
										'name' => 'status',
										'id' => 'status',
										'value' => 'accept',
										'checked' => set_checkbox('status', 1, ( @$zone->status == 1 )? true: false ),
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
