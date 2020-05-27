<?php
$attributes = array('id' => 'backend-form','enctype' => 'multipart/form-data');
echo form_open( '', $attributes);
?>
<section class="content animated fadeInRight">
	<div class="card card-info">
		<div class="card-header">
	        <h3 class="card-title"><?php echo get_msg('backend_config_info_lable')?></h3>
	    </div>


		<div class="card-body">
	        <div class="row">
	          	<div class="col-md-6">
	          		<div class="form-group">
						<label><?php echo get_msg('sender_name_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('sender_name_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'sender_name',
								'id' => 'sender_name',
								'class' => 'form-control',
								'placeholder' => get_msg('sender_name_label'),
								'value' => set_value( 'sender_name', show_data( @$backend->sender_name ), false )
							));
						?>
					</div>

					<div class="form-group">
						<label><?php echo get_msg('receive_email_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('receive_email_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'email',
								'name' => 'receive_email',
								'id' => 'receive_email',
								'class' => 'form-control',
								'placeholder' => get_msg('receive_email_label'),
								'value' => set_value( 'receive_email', show_data( @$backend->receive_email ), false )
							));
						?>
					</div>

	          	</div>

	          	<div class="col-md-6">
	          		<div class="form-group">
						<label><?php echo get_msg('sender_email_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('receive_email_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'email',
								'name' => 'sender_email',
								'id' => 'sender_email',
								'class' => 'form-control',
								'placeholder' => get_msg('sender_email_label'),
								'value' => set_value( 'sender_email', show_data( @$backend->sender_email ), false )
							));
						?>
					</div>

					<div class="form-group">
						<label><?php echo get_msg('fcm_api_key_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('fcm_api_key_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'fcm_api_key',
								'id' => 'fcm_api_key',
								'class' => 'form-control',
								'placeholder' => get_msg('fcm_api_key_label'),
								'value' => set_value( 'fcm_api_key', show_data( @$backend->fcm_api_key ), false )
							));
						?>
					</div>
	          	</div>

	          	<legend class="ml-3"><?php echo get_msg('smtp_section')?></legend>
		        <hr width="100%">
		        <div class="col-md-6">
	          		<div class="form-group">
	          			<label><?php echo get_msg('smtp_host_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('fcm_api_key_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'smtp_host',
								'id' => 'smtp_host',
								'class' => 'form-control',
								'placeholder' => get_msg('smtp_host_placeholder'),
								'value' => set_value( 'smtp_host', show_data( @$backend->smtp_host ), false )
							));
						?>
	          		</div>

	          		<div class="form-group">
	          			<label><?php echo get_msg('smtp_port_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('smtp_port_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'smtp_port',
								'id' => 'smtp_port',
								'class' => 'form-control',
								'placeholder' => get_msg('smtp_port_label'),
								'value' => set_value( 'smtp_port', show_data( @$backend->smtp_port ), false )
							));
						?>
	          		</div>

	          		<div class="form-group" style="padding-top: 30px;">
						<div class="form-check">

							<label class="form-check-label">
							
								<?php echo form_checkbox( array(
									'name' => 'smtp_enable',
									'id' => 'smtp_enable',
									'value' => 'accept',
									'checked' => set_checkbox('smtp_enable', 1, ( @$backend->smtp_enable == 1 )? true: false ),
									'class' => 'form-check-input'
								));	?>
								<label><?php echo get_msg( 'smtp_enable' ); ?></label>
							</label>
						</div>
					</div>
	          	</div>

	          	<div class="col-md-6">
	          		<div class="form-group">
	          			<label><?php echo get_msg('smtp_user_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('smtp_user_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'smtp_user',
								'id' => 'smtp_user',
								'class' => 'form-control',
								'placeholder' => get_msg('smtp_user_label'),
								'value' => set_value( 'smtp_user', show_data( @$backend->smtp_user ), false )
							));
						?>
	          		</div>

	          		<div class="form-group">
	          			<label><?php echo get_msg('smtp_pass_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('smtp_pass_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'password',
								'name' => 'smtp_pass',
								'id' => 'smtp_pass',
								'class' => 'form-control',
								'placeholder' => get_msg('smtp_pass_label'),
								'value' => set_value( 'smtp_pass', show_data( @$backend->smtp_pass ), false )
							));
						?>
	          		</div>
	          	</div>

	          	<legend class="ml-3"><?php echo get_msg('img_section')?></legend>
	            <div class="col-md-6">
	            	 <?php if ( !isset( $backend )): ?>

						<div class="form-group">
						
							<label>
								<?php echo get_msg('backend_logo')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<br/>

							<input class="btn btn-sm" type="file" name="icon" id="icon">
						</div>

						<?php else: ?>

						<label>
							<?php echo get_msg('backend_logo')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label> 
						
						<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadlogo">
							<?php echo get_msg('btn_replace_photo')?>
						</div>
						
						<hr/>
					
						<?php
							$conds = array( 'img_type' => 'backend-logo', 'img_parent_id' => $backend->id );
							$images = $this->Image->get_all_by( $conds )->result();
						?>
							
						<?php if ( count($images) > 0 ): ?>
							
							<div class="row">

							<?php $i = 0; foreach ( $images as $img ) :?>

								<?php if ($i>0 && $i%3==0): ?>
										
								</div><div class='row'>
								
								<?php endif; ?>
									
								<div class="col-md-4" style="height:100">

									<div class="thumbnail">

										<img src="<?php echo $this->ps_image->upload_thumbnail_url . $img->img_path; ?>">

										<br/>
										
										<p class="text-center">
											
											<a data-toggle="modal" data-target="#deletePhoto" class="delete-img" id="<?php echo $img->img_id; ?>"   
												image="<?php echo $img->img_path; ?>">
												<?php echo get_msg('remove_label'); ?>
											</a>
										</p>

									</div>

								</div>

							<?php $i++; endforeach; ?>

							</div>
						
						<?php endif; ?>

					<?php endif; ?>	
					<!-- End nav icon -->
	            </div>

	            <div class="col-md-6">
	            	 <?php if ( !isset( $backend )): ?>

						<div class="form-group">
						
							<label>
								<?php echo get_msg('backend_fav_icon')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<br/>

							<input class="btn btn-sm" type="file" name="fav" id="fav">
						</div>

						<?php else: ?>

						<label>
							<?php echo get_msg('backend_fav_icon')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label> 
						
						<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadFav">
							<?php echo get_msg('btn_replace_photo')?>
						</div>
						
						<hr/>
					
						<?php
							$conds = array( 'img_type' => 'fav-icon', 'img_parent_id' => $backend->id );
							$images = $this->Image->get_all_by( $conds )->result();
						?>
							
						<?php if ( count($images) > 0 ): ?>
							
							<div class="row">

							<?php $i = 0; foreach ( $images as $img ) :?>

								<?php if ($i>0 && $i%3==0): ?>
										
								</div><div class='row'>
								
								<?php endif; ?>
									
								<div class="col-md-4" style="height:100">

									<div class="thumbnail">

										<img src="<?php echo $this->ps_image->upload_url . $img->img_path; ?>">

										<br/>
										
										<p class="text-center">
											
											<a data-toggle="modal" data-target="#deletePhoto" class="delete-img" id="<?php echo $img->img_id; ?>"   
												image="<?php echo $img->img_path; ?>">
												<?php echo get_msg('remove_label'); ?>
											</a>
										</p>

									</div>

								</div>

							<?php $i++; endforeach; ?>

							</div>
						
						<?php endif; ?>

					<?php endif; ?>	
					<!-- End fav icon -->

					<?php if ( !isset( $backend )): ?>

						<div class="form-group">
							<label><?php echo get_msg('backend_login_img')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<br/>

							<input class="btn btn-sm" type="file" name="images1">
						</div>

						<?php else: ?>
						
						<label><?php echo get_msg('backend_login_img')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label> 
						
						<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadImage">
							<?php echo get_msg('btn_replace_photo')?>
						</div>
						
						<hr/>
						
		                <?php
							$conds = array( 'img_type' => 'login-image', 'img_parent_id' => $backend->id );
							$images = $this->Image->get_all_by( $conds )->result();
						?>
							
						<?php if ( count($images) > 0 ): ?>
							
							<div class="row">

							<?php $i = 0; foreach ( $images as $img ) :?>

								<?php if ($i>0 && $i%3==0): ?>
										
								</div><div class='row'>
								
								<?php endif; ?>
									
								<div class="col-md-4" style="height:100">

									<div class="thumbnail">

										<img src="<?php echo $this->ps_image->upload_thumbnail_url . $img->img_path; ?>">

										<br/>

									</div>

								</div>

							<?php $i++; endforeach; ?>

							</div>
						
						<?php endif; ?>

					<?php endif; ?>	
					<!-- login image -->
	            </div>
	            <!-- End Icon -->
	        </div>
	        <!-- /.card-body -->
	        <div class="card-footer">
				<button type="submit" name="save" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_save')?>
				</button>

				<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_cancel')?>
				</a>
			</div>
			<!-- /.card footer-->
	    </div>
	</div>
    <!-- /.card info-->
</section>
<?php echo form_close(); ?>