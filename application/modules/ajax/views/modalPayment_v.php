<form method="POST" action="<?=base_url().'admin/admin/payments/pay'?>">
	<div class="modal-header">
		<h3 class="text-center">Detail</h3>
	</div>
	<div class="modal-body">
		<table class="table table-hover table-bordered table-striped">
	    <thead>
	      <th class="text-center">No</th>
	      <th class="text-center">Date Time</th>
	      <th class="text-center">Product</th>
	      <th class="text-center">Number</th>
	      <th class="text-center">Amount</th>
	      <th class="text-center">Status</th>
	      <th class="text-center">
	      	<input type="button" class="btn btn-link" id="selectAll" value="All">
	    	</th>
	    </thead>
	    <tbody>
	      <?php
	      $jsonDebt = array();
	      $no = 0; $totalAmount = 0;
	      foreach ($orders as $key => $order) {
	      	$no = $key+1;
	    	?>
	    	<tr>
	    		<td><?=$no?></td>
					<td class='text-center'><?=$this->convnumber->indonesian_date(strtotime($order->invoice_date), 'd F <br/> H:i', '');?></td>
					<td class='text-center'><?=strtoupper($order->provider_name)." ".number_format($order->product_nom, 0, ',', '.')?></td>
					<td class='text-center'><?=$order->number_phone?></td>
					<td class='text-right'><?=number_format($order->product_price, 0, ',', '.')?></td>
					<td class='text-center'><?=ucwords($order->istat_name)?></td>
					<td class='text-center'>
						<input  type="hidden" class="invoice_value" value="<?=$order->invoice_number?>">
						<input class="checkbox" type="checkbox" name="invoice_number[]" value="<?=$order->invoice_number?>">
					</td>
	    	</tr>
	      <?php 
	      	$totalAmount += $order->product_price; 
      	} 
      	?>
	    </tbody>
	  </table>
		<?php
		// print_r($orders)
		?>
	</div>
	<div class="modal-footer form-inline">
		<input type="hidden" name="username" value="<?=$user->username?>">
		<input type="text" class="form-control text-right" required readonly id="paymentAmount">
		<select name="InputPay" id="InputPay" required class="form-control">
			<option value="">Select Method</option>
			<option value="100">Cash</option>
			<option value="200">Bank</option>
			<option value="600">Cash</option>
		</select>
		<button class="btn btn-sm btn-success btn-flat" id="payThis" type="submit">Pay This!</button>
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function(){
		$('#payThis').prop('disabled', 'true');

		$('#selectAll').click(function() {
      if($('#selectAll').val() == 'All') {
        $('.checkbox').each(function() {
            this.checked = true;
        })
        $('#selectAll').val('Undo');
        $('#payThis').prop('disabled', false);
        $('#paymentAmount').val(<?=$totalAmount?>);
      }else{
        $('.checkbox').each(function() {
            this.checked = false;
        });
        $('#selectAll').val('All');
        $('#payThis').prop('disabled', true);
        $('#paymentAmount').val('0');
      }
	  });
	})
</script>