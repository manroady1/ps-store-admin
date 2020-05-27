
<?php
	$attributes = array( 'id' => 'city-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>

	<section class="content animated fadeInRight">
		<div class="col-md-6">
			<div class="card card-info">
		        <div class="card-header">
		            <h3 class="card-title"><?php echo get_msg('city_info')?></h3>
		        </div>

			<form role="form">
        		<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label> <span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('select_country')?>
								</label>

								<?php
									$options=array();
									$options[0]=get_msg('select_country');
									$countries = $this->Country->get_all( );
										foreach($countries->result() as $country) {
											$options[$country->id]=$country->name;
									}

									echo form_dropdown(
										'country_id',
										$options,
										set_value( 'country_id', show_data( @$city->country_id), false ),
										'class="form-control form-control-sm mr-3" id="country_id"'
									);
								?>

							</div>

							<div class="form-group">
								<label> <span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('city_name')?>
								</label>

								<?php echo form_input( array(
									'name' => 'name',
									'value' => set_value( 'name', show_data( @$city->name), false ),
									'class' => 'form-control form-control-sm',
									'placeholder' => get_msg('pls_city_name'),
									'id' => 'name'
								)); ?>

							</div>

							<div class="form-group" style="padding-top: 30px;">
							<div class="form-check">

								<label>
								
									<?php echo form_checkbox( array(
										'name' => 'status',
										'id' => 'status',
										'value' => 'accept',
										'checked' => set_checkbox('status', 1, ( @$city->status == 1 )? true: false ),
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