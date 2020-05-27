<div class="container-fluid">
	<div class="row mt-3">
		<?php 
			foreach ($shops->result() as $shop) :
		?>

		<div class="col-md-4" style="padding-top: 30px;">
              <!-- USERS LIST -->
            <div class="box box-danger" style="border: 1px solid #bbb;">
               <div class="card-header" style="border-top: 2px solid red;">
            		<h3 class="box-title" style="padding-top: 5px;">
                 		<i class="fa fa-home"></i>
                 		<a href="<?php echo site_url('admin/dashboard/index/'. $shop->id);?>">
                 			<?php echo $shop->name; ?>
                 		</a>
                 	</h3>
                </div>
                <!-- /.box-header -->
                <div class="img-responsive img-portfolio img-hover"" style="justify-content: center;padding: 10px 10px 20px 10px">
	                <a href="<?php echo site_url('admin/dashboard/index/'. $shop->id);?>">
	                	<?php $default_photo = get_default_photo( $shop->id, 'shop' ); ?>
		                <img alt="image" class="img-responsive img-portfolio img-hover" src="<?php echo img_url( '/'. $default_photo->img_path ); ?>" style="max-height: 100%;max-width: 100%;">				
		            </a>
	            </div>
                <div class="box-body no-padding" style="padding-left: 10px;">
                    <strong><?php echo get_msg('address_label'); ?></strong>
	          	 <p><i class="fa fa-map-marker" style="padding-right: 5px;"></i><?php echo $shop->address; ?></p>
	          	 <strong><?php echo get_msg('lbl_about_shop'); ?></strong>
			         <p> 
		          	 	<?php 
						                    	
	                    	$shopDesc = strip_tags($shop->description);
	                    	
	                    	if (strlen($shopDesc) > 200) {
	                    	
	                    	    $stringCut = substr($shopDesc, 0, 200);
	                
	                    	    $shopDesc = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
	                    	}
	                    	
	                    	echo $shopDesc;
	                    	
	                    ?>
		          	 </p>
	          	 	
	          	 	 <div class="row text-center m-t-20">
						                    
		                <div class="col-md-4">
		                   <i class="ion ion-stats-bars" style="font-size: 20px;"></i>
		                    <p>
		                    	<?php 
				                    $conds['no_publish_filter'] = 1;
				                    echo $this->Category->count_all_by( $conds ) . " "; 
			                    ?>
			                    Categories
		                	</p>
		                </div>
		                <div class="col-md-4">
		                     <i class="ion ion-stats-bars" style="font-size: 20px;"></i>
		                    <p>
		                    	<?php 
				                    $conds['no_publish_filter'] = 1;
				                    echo $this->Subcategory->count_all_by( $conds ) . " "; 
			                    ?>
		                   		Subcategories
		                	</p>
		                </div>
		                <div class="col-md-4">
		                    <i class="ion ion-stats-bars" style="font-size: 20px;"></i>
		                    <p>
		                    	<?php 
				                    $conds['no_publish_filter'] = 1;
				                    echo $this->Product->count_all_by( $conds ) . " "; 
			                    ?>
		                    	Products
		                    </p>
		                </div>
					</div>

                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->

	                <div class="card-footer" style="padding: 10px 10px 10px 80px;">
		                <a href="<?php echo site_url('admin/dashboard/index/'. $shop->id);?>" class="btn btn-primary" style="width: 25%;">Dashboard</a>
		                <a href="<?php echo site_url('admin/shops/edit/'. $shop->id);?>" style="margin-left:10px;width: 25%;" class="btn btn-primary"><?php echo get_msg('btn_edit'); ?></a>
		                <input type="submit" value="<?php echo get_msg('btn_delete')?>" class="btn btn-primary delete-shop" id="<?php echo $shop->id; ?>" style="margin-left: 10px;width: 25%;" data-toggle="modal" data-target="#deleteShop"/>
	                </div>
                <!-- /.box-footer -->
            </div>
              <!--/.box -->
        </div>

        <?php endforeach; ?>

	</div>
</div>

<div class="modal fade"  id="deleteShop">
		
	<div class="modal-dialog">
		
		<div class="modal-content">
		
			<div class="modal-header">
				<h4 class="modal-title"><?php echo get_msg('delete_shop_label')?></h4>

				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>

			</div>

			<div class="modal-body">
				<p><?php echo get_msg('delete_shop_confirm_message')?></p>
				<p>1. Categories</p>
				<p>2. Sub-Categories</p>
				<p>3. Products and Discounts</p>
				<p>4. Products and Collection</p>
				<p>5. News Feeds</p>
				<p>6. Shipping Methods</p>
				<p>7. Watch List</p>
				<p>8. Comments</p>
				<p>9. Contact Us Message</p>
				<p>10. Transactions</p>
				<p>11. Reports</p>
				<p>12. User Shop</p>
				<p>13. Shop Tag</p>
				<p>14. Likes</p>
				<p>15. Favourites</p>
				<p>16. Coupon</p>
			</div>

			<div class="modal-footer">
				<a type="button" class="btn btn-default btn-delete-shop">Yes</a>
				<a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
			</div>

		</div>
	
	</div>			
		
</div>

<script>
	$('.delete-shop').click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		var image = $(this).attr('image');
		var action = '<?php echo site_url('/admin/shops/delete/');?>';
		$('.btn-delete-shop').attr('href', action + id);
	});
</script>