
<div class="col-sm-5 col-sm-offset-1">
	<?=$inputProvider?>
</div>

<div class="product">
	<div class="col-sm-5">
		<?=$inputProduct?>
	</div>
  <div class="col-sm-1"></div>
  <div class="productPrice"></div>
</div>



<script>
  $(document).ready(function(){
    $(".select2").select2();
    $("#inputProvider").change(function(){
    	var provider = $("#inputProvider").val();
    	$(".product").show(500);
    	if(provider != ""){
    		$.ajax({
          url: '<?php echo site_url('ajax/getProduct'); ?>',
          type: 'POST',
          data: "provider="+provider,
          cache: false,
          success: function(msg){
            $(".product").html(msg);
          }
        });
    	}else{
    		$('.product').hide(500);
    	}
    });
    $("#inputProduct").change(function(){
      var product = $("#inputProduct").val();
      $(".productPrice").show(500);
      if(product != ""){
        $.ajax({
          url: '<?php echo site_url('ajax/getPrice'); ?>',
          type: 'POST',
          data: "product="+product,
          cache: false,
          success: function(msg){
            $(".productPrice").html(msg);
          }
        });
      }else{
        $('.productPrice').hide(500);
      }
    });
  });
</script>