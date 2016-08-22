<script type="text/javascript">
	$(document).ready(function(){

		var price = parseFloat($('#inputPrice').val());
		var cost 	= parseFloat($('#inputCost').val());
		var profit;
		profit = price-cost;
		if(profit > 0)
			$('#inputProfit').val(profit);
		
		$('#inputPrice').prop('readonly', true);
		if($('#inputStatus').val() == 'Cancelled'){
			$('#butCancel').prop('disabled', true);
			$('#inputCost').prop('readonly', true);
		}

		// $('#inputPrice').change(function(){
		// 	var price = $('#inputPrice').val();
		// 	var cost 	= $('#inputCost').val();
		// 	var profit;
		// 	profit = price-cost;
		// 	if(profit > 0 && price != 0){
		// 		$('#inputProfit').val(profit);
		// 		$('#butSave').prop('disabled', false);
		// 	}else $('#butSave').prop('disabled', true);
		// });

		$('#inputCost').change(function(){
			var price = $('#inputPrice').val();
			var cost 	= $('#inputCost').val();
			var profit;
			profit = price-cost;
			if(profit > 0 && cost != 0){
				$('#inputProfit').val(profit);
				$('#butSave').prop('disabled', false);
			}else $('#butSave').prop('disabled', true);
		});
	});
</script>