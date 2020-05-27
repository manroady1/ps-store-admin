<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
	
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('rating_product_name'); ?></th>
			<th><?php echo get_msg('rating_user_name'); ?></th>
			<th><?php echo get_msg('rating_title'); ?></th>
			<th><?php echo get_msg('rating_value'); ?></th>
			<th><?php echo get_msg('date'); ?></th>
		</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $ratings ) && count( $ratings->result()) > 0 ): ?>

		<?php foreach($ratings->result() as $rating): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $this->Product->get_one($rating->product_id)->name ?></td>
				<td><?php echo $this->User->get_one($rating->user_id)->user_name?></td>
				<td><?php echo $rating->title; ?></td>
				<td><?php echo $rating->rating; ?></td>
				<td><?php echo $rating->added_date; ?></td>
			</tr>
		<?php endforeach; ?>

		<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>
</table>
</div>
