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
<div class="table-responsive animated fadeInRight" style="padding: 50px 30px 10px 30px;">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('shop_name'); ?></th>
			<th><?php echo get_msg('address_label'); ?></th>
			
			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_edit')?></span></th>
			
			<?php endif; ?>
			
			<?php if ( $this->ps_auth->has_access( PUBLISH )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_publish')?></span></th>
			
			<?php endif; ?>

		</tr>
		
	
	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $shops ) && count( $shops->result()) > 0 ): ?>

		<?php foreach($shops->result() as $shop): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $shop->name;?></td>
				<td><?php echo $shop->address;?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $shop->id; ?>'>
							<i class='fa fa-pencil-square-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( PUBLISH )): ?>
					
					<td>
						<?php if ( @$shop->status == 1): ?>
							<button class="btn btn-sm btn-success unpublish" id='<?php echo $shop->id;?>'>
							Yes</button>
						<?php else:?>
							<button class="btn btn-sm btn-danger publish" id='<?php echo $shop->id;?>'>
							No</button><?php endif;?>
					</td>
				
				<?php endif; ?>

			</tr>

		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

</table>
</div>

<script>

		// Publish Trigger
		$(document).delegate('.publish','click',function(){
			
			// get button and id
			var btn = $(this);
			var id = $(this).attr('id');

			// Ajax Call to publish
			$.ajax({
				url: "<?php echo $module_site_url .'/ajx_publish/'; ?>" + id,
				method: 'GET',
				success: function( msg ) {
					if ( msg == true ){
						btn.addClass('unpublish').addClass('btn-success')
							.removeClass('publish').removeClass('btn-danger')
							.html('Yes');
					} else {
						alert( "<?php echo get_msg( 'err_sy888' ); ?>" );
					}
				}
			});
		});

		// Unpublish Trigger
		$(document).delegate('.unpublish','click',function(){

			// get button and id
			var btn = $(this);
			var id = $(this).attr('id');

			// Ajax call to unpublish
			$.ajax({
				url: "<?php echo $module_site_url .'/ajx_unpublish/'; ?>" + id,
				method: 'GET',
				success: function( msg ){
					if ( msg == true )
						btn.addClass('publish').addClass('btn-danger')
							.removeClass('unpublish').removeClass('btn-success')
							.html('No');
					else
						alert( "<?php echo get_msg( 'err_sy4444s' ); ?>" );
				}
			});
		});

</script>