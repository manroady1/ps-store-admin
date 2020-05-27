<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('zone_name'); ?></th>
			
			<th><?php echo get_msg('country_name'); ?></th>
			
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

	<?php if ( !empty( $zones ) && count( $zones->result()) > 0 ): ?>

		<?php foreach($zones->result() as $zone): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $zone->name;?></td>
				
				<td><?php 

						$conds['zone_id'] = $zone->id;
						$zone_datas = $this->Zone_junction->get_all_by( $conds )->result();
						foreach ($zone_datas as $zone_data) {
							$country_id = $zone_data->country_id;
						}
						$country_id = $zone_data->country_id;

						echo $this->Country->get_one( $country_id )->name; 
					?></td>
				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $zone->id; ?>'>
							<i class='fa fa-pencil-square-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $zone->id;?>">
							<i class='fa fa-trash-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( PUBLISH )): ?>
					
					<td>
						<?php 
						if ( $zone->status == 1): ?>
							<button class="btn btn-sm btn-success unpublish" id='<?php echo $zone->id;?>'>
							<?php echo get_msg('btn_yes'); ?></button>
						<?php else:?>
							<button class="btn btn-sm btn-danger publish" id='<?php echo $zone->id;?>'>
							<?php echo get_msg('btn_no'); ?></button><?php endif;?>
					</td>
				
				<?php endif; ?>

			</tr>

		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

</table>
