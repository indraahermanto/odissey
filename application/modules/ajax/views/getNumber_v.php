<!-- Select2 -->
<link rel="stylesheet" href="<?=base_url().'assets/plugins/select2/select2.min.css'?>">

<div class="col-sm-5">
	<?php
		echo $listNumber
	?>
</div>
<div class="col-sm-1"></div>
<div class="provider"></div>

<!-- Select2 -->
<script src="<?=base_url().'assets/plugins/select2/select2.full.min.js'?>"></script>

<script>
  $(document).ready(function(){
    $(".select2").select2();
    $("#inputUserNumber").change(function(){
    	var number = $("#inputUserNumber").val();
    	$(".provider").show(500);
    	if(number != ""){
    		$.ajax({
          url: '<?php echo site_url('ajax/getProvider'); ?>',
          type: 'POST',
          data: "number="+number,
          cache: false,
          success: function(msg){
            $(".provider").html(msg);
            if(number == 'new')
              $('#submit').prop('disabled', true);
            else $('#submit').prop('disabled', false);
          }
        });
    	}else{
    		$('.provider').hide(500);
    	}
    });
  });
</script>