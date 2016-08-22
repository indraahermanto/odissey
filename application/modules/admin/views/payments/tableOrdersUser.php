<div class="table-responsive">
  <table class="table table-hover table-bordered table-striped">
    <thead>
      <th class="text-center">No</th>
      <th class="text-center">Date Time</th>
      <th class="text-center">Product</th>
      <th class="text-center">Number</th>
      <th class="text-center">Amount</th>
      <th class="text-center">Status</th>
    </thead>
    <tbody>
      <?=$paymentDetail?>
    </tbody>
  </table>
</div>
<?php echo $this->ajax_pagination->create_links(); ?>