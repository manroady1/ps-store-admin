<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#shipping-zone-form').validate({
			rules:{
				
				zone_id: {
		       		indexCheck : ""
		      	}
			},
			messages:{
				
				zone_id:{
			       indexCheck: "<?php echo $this->lang->line('f_item_zone_required'); ?>"
			    }
			}
		});
		
		jQuery.validator.addMethod("indexCheck",function( value, element ) {
			
			   if(value == 0) {
			    	return false;
			   } else {
			    	return true;
			   };

			   
		});

		

	}

	<?php endif; ?>

</script>

<style type="text/css">
    
    .box{
        color: #000;
        padding: 20px;
        display: none;
        margin-top: 20px;
    }
    
    .red{ background: #ff0000; }
    .green{ background: #228B22; }
    .blue{ background: #0000ff; }
    .per_order_based_enabled { background: #e2e0e0; }
    .per_item_based_enabled { background: #e2e0e0; }
    .free_enabled { background: #e2e0e0; }


    label{ margin-right: 15px; }

</style>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide();
        $(targetBox).show();
    });
});


$('input[name="delivery_increment_of_zone"]').keyup(function(e)
                                {
  if (/[^\d.-]/g.test(this.value))
  {
    // Filter non-digits from input value.
    this.value = this.value.replace(/[^\d.-]/g, '');
  }

});

$('input[name="per_item_based_cost"]').keyup(function(e)
                                {
  if (/[^\d.-]/g.test(this.value))
  {
    // Filter non-digits from input value.
    this.value = this.value.replace(/[^\d.-]/g, '');
  }
  
});

$('input[name="per_order_based_cost"]').keyup(function(e)
                                {
  if (/[^\d.-]/g.test(this.value))
  {
    // Filter non-digits from input value.
    this.value = this.value.replace(/[^\d.-]/g, '');
  }
  
});

</script>	

