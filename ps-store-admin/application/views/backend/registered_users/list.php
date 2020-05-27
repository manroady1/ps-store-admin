<table class="table table-striped table-bordered">

	<tr>
		<th><?php echo get_msg('no')?></th>
		<th><?php echo get_msg('user_name')?></th>
		<th><?php echo get_msg('user_email')?></th>

		<?php if ( $this->ps_auth->has_access( BAN )): ?>
					
			<th><?php echo get_msg('user_ban')?></th>

		<?php endif;?>

		<?php if ( $this->ps_auth->has_access( DEL )): ?>
				
		<th><span class="th-title"><?php echo get_msg('btn_delete')?></span></th>
	
		<?php endif; ?>

	</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $users ) && count( $users->result()) > 0 ): ?>
			
		<?php foreach($users->result() as $user): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $user->user_name;?></td>
				<td><?php echo $user->user_email;?></td>

				<?php if ( $this->ps_auth->has_access( BAN )):?>
						
					<td>
						<?php if ( @$user->is_banned == 0 ): ?>
							
							<button class="btn btn-sm btn-primary-green ban" userid='<?php echo @$user->user_id;?>'>
								<?php echo get_msg( 'user_ban_label' ); ?>
							</button>
						
						<?php else: ?>
							
							<button class="btn btn-sm btn-danger unban" userid='<?php echo @$user->user_id;?>'>
								<?php echo get_msg( 'user_unban' ); ?>
							</button>
						
						<?php endif; ?>

					</td>

				<?php endif;?>

				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo "$user->user_id";?>">
							<i class='fa fa-trash-o'></i>
						</a>
					</td>
				
				<?php endif; ?>

			</tr>
		
		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

</table>