<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('shipping_name'); ?></th>
			<th><?php echo get_msg('shipping_price'); ?></th>
			<th><?php echo get_msg('shipping_days'); ?></th>
			
			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_edit')?></span></th>
			
			<?php endif; ?>
			
			<?php if ( $this->ps_auth->has_access( DEL )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_delete')?></span></th>
			
			<?php endif; ?>
			
			<?php if ( $this->ps_auth->has_access( PUBLISH )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_publish')?></span></th>
			
			<?php endif; ?>

		</tr>
		
	
	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $shippings ) && count( $shippings->result()) > 0 ): ?>

		<?php foreach($shippings->result() as $shipping): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $shipping->name;?></td>
				<td><?php echo $shipping->price; ?></td>
				<td><?php echo $shipping->days ?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $shipping->id; ?>'>
							<i class='fa fa-pencil-square-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#shippingmodal" id="<?php echo "$shipping->id";?>">
							<i class='fa fa-trash-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( PUBLISH )): ?>
					
					<td>
						<?php if ( @$shipping->is_published == 1): ?>
							<button class="btn btn-sm btn-success unpublish" id='<?php echo $shipping->id;?>'>
							<?php echo get_msg('btn_yes'); ?></button>
						<?php else:?>
							<button class="btn btn-sm btn-danger publish" id='<?php echo $shipping->id;?>'>
							<?php echo get_msg('btn_no'); ?></button><?php endif;?>
					</td>
				
				<?php endif; ?>

			</tr>

		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

</table>
</div>

