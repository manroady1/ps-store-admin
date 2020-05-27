<?php
	$attributes = array( 'id' => 'api-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  	<a class="navbar-brand" href="#">
  		<!-- Brand Logo -->
	    <img src="<?php echo img_url( "shopping-cart.png" ); ?>" class="img-circle img-sm" alt="User Image">
  	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	</button>

  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	    	<li class="nav-item" style="margin-left: 10px;">
	        	<a class="btn btn-block btn-outline-primary" href="<?php echo site_url('admin/shops/');?>"> 
		  			<span class='fa fa-exchange'></span> <?php echo get_msg('back_shop_list'); ?>
		  		</a>
	      	</li>
	      	<li class="nav-item" style="margin-left: 10px;">
	        	<a class="btn btn-block btn-outline-primary" href='<?php echo $module_site_url .'/shopadd';?>'> 
					&#10148; <?php echo get_msg('btn_create_new_shop'); ?>
				</a>
	      	</li>
	      	<li class="nav-item active" style="margin-left: 10px;">
		        <a class="btn btn-block btn-outline-primary" href='<?php echo $module_site_url .'/shoplist';?>'> 
					&#10148; <?php echo get_msg('btn_shop_list'); ?>
				</a>
		    </li>
	      	<li class="nav-item" style="margin-left: 10px;">
	        	<a class="btn btn-block btn-outline-primary" href="<?php echo site_url('/admin/notis');?>"> 
			  		&#10148; <?php echo get_msg('btn_push_notification'); ?>
				</a>
	      	</li>
	      	<li class="nav-item" style="margin-left: 10px;">
	        	<a class="btn btn-block btn-outline-primary" href="<?php echo $module_site_url .'/exports';?>"> 
		  			&#10148;<?php echo get_msg('btn_export_database'); ?>
		  		</a>
	      	</li>
	      	<li class="nav-item" style="margin-left: 10px;">
		        <a class="btn btn-block btn-outline-primary" href="<?php echo site_url('/admin/system_users');?>"> 
				  	&#10148;<?php echo get_msg('btn_system_user'); ?>
				</a>
		    </li>
	      	<li class="nav-item dropdown" style="margin-left: 10px;">
	        	<a class="btn btn-block btn-outline-primary dropdown-toggle" data-toggle="dropdown" href="#">
	        		<span class='fa fa-gear'></span> &nbsp; <?php echo get_msg('setting_label'); ?>
	        	</a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	        	<a class="dropdown-item" href="<?php echo site_url('admin/apis');?>"> 
		  					&#10148;<?php echo get_msg('api_info'); ?>
		  		</a>
	          	<div class="dropdown-divider"></div>
	          	<a class="dropdown-item" href="<?php echo site_url('/admin/abouts');?>"> 
					  		&#10148; <?php echo get_msg('btn_about_app'); ?>
				</a>
	        </div>
	      </li>
	    </ul>
	   	<ul class="navbar-nav ml-auto">

	       <li class="user user-menu">
	            <a href="<?php echo site_url ( $be_url . '/profile');?>" class="d-block">
			        <?php $logged_in_user = $this->ps_auth->get_user_info(); ?>
			        <img src="<?php echo img_url( 'thumbnail/'. $logged_in_user->user_profile_photo ); ?>" class="user-image" alt="User Image">
			        <span class="hidden-xs" style="color: black; font-weight: bold;"><?php echo $logged_in_user->user_name;?></span>
	            </a>
	      	</li>

	      	<li class="messages-menu open" style="padding-left: 30px;">
		        <a href="<?php echo site_url('logout');?>" aria-expanded="true">
		        	<i class="fa fa-sign-out" style="font-size: 1.5em; color: #000;"></i>
		        </a>
	      	</li>

	    </ul>
  	</div>
</nav>
<div class="container-fluid">
	<div class="col-12"  style="padding: 30px 20px 20px 20px;">
		<div class="card earning-widget">
	        <div class="card-header" style="border-top: 2px solid red;">
				<h5><?php echo get_msg('api_info')?></h5>
			</div>
			<!-- /.card-header -->
	        <div class="card-body">

				<table class="table table-striped table-bordered mt-3">

					<?php $count = $this->uri->segment(4) or $count = 0; ?>

					<?php if ( !empty( $apis ) && count( $apis->result()) > 0 ): ?>

						<?php foreach ( $apis->result() as $api ): ?>
							<?php if ( $api->type == "list") { ?>
								<tr>
									<td><?php echo ++$count;?></td>
									<td><?php echo $api->api_name;?></td>
									<td><?php echo get_msg( 'api_order_by' ); ?></td>
									
									<td>
									<?php 
										$options = $api_constants[$api->api_constant];

										echo form_dropdown(
											'order_by_field[]',
											$options,
											set_value( 'order_by_field[]', @$api->order_by_field ),
											'class="form-control form-control-sm" id="order_by_field"'
										);
									?>
									</td>

									<td>
									<?php 
										$options = array( 'asc' => 'Ascending', 'desc' => 'Descending');

										echo form_dropdown(
											'order_by_type[]',
											$options,
											set_value( 'order_by_type[]', @$api->order_by_type ),
											'class="form-control form-control-sm" id="order_by_type"'
										);
									?>
									</td>

								</tr>

							<?php } else { ?>

								<tr>
									<td><?php echo ++$count;?></td>
									<td colspan="2"><?php echo $api->api_name;?></td>
									<td colspan="2">
										<?php 
												$options = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10');

												echo form_dropdown(
													'count[]',
													$options,
													set_value( 'count[]', @$api->count ),
													'class="form-control form-control-sm" id="count"'
												);
										?>
									</td>
								</tr>

							<?php } ?>

							<input type="hidden" name="api_id[]" value="<?php echo $api->api_id; ?>"/>

						<?php endforeach; ?>

					<?php else: ?>
							
						<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

					<?php endif; ?>

				</table>	
			</div>
			<div class="card-footer">
				<button type="submit" name="save" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_save')?>
				</button>
			</div>
		</div>
	</div>
</div>
	

<?php echo form_close(); ?>
