<!-- Select2 -->
<script src="<?=base_url().'assets/plugins/select2/select2.full.min.js'?>"></script>

<script>
  $(document).ready(function(){
    $(".select2").select2();
    $("#inputUserName").change(function(){
    	var name = $("#inputUserName").val();
    	$(".number").show(500);
    	if(name != ""){
    		$.ajax({
          url: '<?php echo site_url('ajax/getNumber'); ?>',
          type: 'POST',
          data: "userID="+name,
          cache: false,
          success: function(msg){
            $(".number").html(msg);
          }
        });
    	}else{
    		$(".number").hide(500);
    	}
    });
  });
</script>