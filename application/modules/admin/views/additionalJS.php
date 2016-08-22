
<!-- InputMask -->
<script src="<?=base_url().'assets/plugins/input-mask-miminium/jquery.mask.min.js'?>"></script>

<script type="text/javascript">
  $(function () {
    $('.mask-money').mask('000.000', {reverse: true});
    $('.alert-dep').css('display', 'none');
    $('.alert-tarik').css('display', 'none');
    $('.alert-setor').css('display', 'none');
    $('.alert-cair').css('display', 'none');

    $('.close').click(function(){
    	$('#amountDep').val('');
    	$('#amountSetor').val('');
    	$('#amountTarik').val('');
    	$('#amountCair').val('');
    });

    $('#amountDep').change(function(){
    	var amount 			= $('#amountDep').val().replace('.','');
    	amount 					= parseInt(amount);
    	var allowBank 	= $('#allowBank').val();
    	if(amount > allowBank){
    		$('.alert-dep').show(500);
    		$('#subDep').prop('disabled', true);
    	}else{
    		$('.alert-dep').hide(500);
    		$('#subDep').prop('disabled', false);
    	}
    });

    $('#amountTarik').change(function(){
    	var amount 			= $('#amountTarik').val().replace('.','');
    	amount 					= parseInt(amount);
    	var allowBank 	= $('#allowBank').val();
    	if(amount > allowBank){
    		$('.alert-tarik').show(500);
    		$('#subTarik').prop('disabled', true);
    	}else{
    		$('.alert-tarik').hide(500);
    		$('#subTarik').prop('disabled', false);
    	}
    });

    $('#amountSetor').change(function(){
    	var amount 			= $('#amountSetor').val();
    	amount 					= amount.replace('.','');
    	amount 					= parseInt(amount);
    	var allowCash 	= $('#allowCash').val();
    	if(amount > allowCash){
    		$('.alert-setor').show(500);
    		$('#subSetor').prop('disabled', true);
    	}else{
    		$('.alert-setor').hide(500);
    		$('#subSetor').prop('disabled', false);
    	}
    });

    $('#amountCair').change(function(){
    	var amount 			= $('#amountCair').val();
    	amount 					= amount.replace('.','');
    	amount 					= parseInt(amount);
    	var allowWallet 	= $('#allowWallet').val();
    	if(amount > allowWallet){
    		$('.alert-cair').show(500);
    		$('#subCair').prop('disabled', true);
    	}else{
    		$('.alert-cair').hide(500);
    		$('#subCair').prop('disabled', false);
    	}
    });
  });
</script>