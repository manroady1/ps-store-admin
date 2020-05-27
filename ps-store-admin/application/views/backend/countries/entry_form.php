<?php
	$attributes = array( 'id' => 'country-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	
<section class="content animated fadeInRight">
	<div class="col-md-6">
		<div class="card card-info">
		    <div class="card-header">
		        <h3 class="card-title"><?php echo get_msg('country_info')?></h3>
		    </div>
	        <!-- /.card-header -->
			<form role="form">      
	        <div class="card-body">
	            <div class="row">
	             	<div class="col-md-12">
	            		<div class="form-group">
	                   		<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('country_name')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('name_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'name',
								'value' => set_value( 'name', show_data( @$country->name ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'country_name' ),
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
										'checked' => set_checkbox('status', 1, ( @$country->status == 1 )? true: false ),
										'class' => 'form-check-input'
									));	?>

									<?php echo get_msg( 'status' ); ?>
								</label>
							</div>
						</div>
	              	</div>

	              	
	            </div>
	            <!-- /.row -->
	        </div>
	        <!-- /.card-body -->

			<div class="card-footer">
	            <button type="submit" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_save')?>
				</button>

				<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_cancel')?>
				</a>
	        </div>
	       
	    </div>
	    <!-- card info -->
    </div>
</section>
				

	
	

<?php echo form_close(); ?>