<!-- Select2 -->
<link rel="stylesheet" href="<?=base_url().'assets/plugins/select2/select2.min.css'?>">

<div class="col-sm-5">
	<?=$inputProduct?>
</div>
<div class="col-sm-1"></div>

<div class="productPrice"></div>

<!-- Select2 -->
<script src="<?=base_url().'assets/plugins/select2/select2.full.min.js'?>"></script>

<script>
  $(document).ready(function(){
    $(".select2").select2();
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