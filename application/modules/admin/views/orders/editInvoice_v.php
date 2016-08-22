
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$invoice->invoice_number?></h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-xs-5 col-xs-offset-1">
        <div class="form-group">
          <label>Invoice No</label>
          <input type="text" value="<?=$invoice->invoice_number?>" class="form-control" readonly name="">
        </div>
        <div class="form-group">
          <label>Phone Number</label>
          <input type="text" value="<?=$invoice->number_phone?>" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label>Product</label>
          <input type="text" value="<?=strtoupper($invoice->provider_name)." ".number_format($invoice->product_nom, 0, ',', '.')?>" class="form-control" readonly>
        </div>
      </div>
      <div class="col-xs-5">
        <div class="form-group">
          <label>Username</label>
          <input type="text" value="<?=$invoice->username?>" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label>Fullname</label>
          <input type="text" value="<?=ucwords($invoice->first_name." ".$invoice->last_name)?>" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label>Status</label>
          <input type="text" id="inputStatus" value="<?=ucwords($invoice->istat_name)?>" class="form-control" readonly>
        </div>
      </div>
      <div class="col-xs-12"><hr></div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-sm-offset-1">
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <th class="text-center">No</th>
              <th class="text-center">Payment Number</th>
              <th class="text-center">Amount of pay</th>
              <th class="text-center">Remains</th>
            </thead>
            <tbody>
              <tr>
                <td class="text-center">1</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center"><?=number_format($invoice->product_price, 0, ',', '.')?></td>
              </tr>
              <?php
              $no = 1;
              foreach ($payments as $key => $payment) {
                $no = $key+2;
                if($key == 0)
                  $rest_amount = $invoice->product_price-$payment->pmod_amount;
                else $rest_amount -= $payment->pmod_amount;
              ?>
              <tr>
                <td class="text-center"><?=$no?></td>
                <td class="text-center"><?=$payment->pay_number?></td>
                <td class="text-center text-danger">(<?=number_format($payment->pmod_amount, 0, ',', '.')?>)</td>
                <td class="text-center"><?=number_format($rest_amount, 0, ',', '.')?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <form method="POST" action="<?=base_url().'admin/orders/update'?>">
        <div class="col-sm-4">
          <div class="form-group">
            <label>Price</label>
            <input type="hidden" name="inputInvoiceNo" value="<?=$url[3]?>">
            <input type="text" name="inputPrice" id="inputPrice" required value="<?=$invoice->price?>" class="form-control text-center">
          </div>
          <div class="form-group">
            <label>Cost</label>
            <input type="text" name="inputCost" id="inputCost" required value="<?=$invoice->cost?>" class="form-control text-center">
          </div>
          <div class="form-group">
            <label>Profit</label>
            <input type="text" id="inputProfit" class="form-control text-center" readonly>
          </div>
          <div class="col-sm-6">
            <button type="button" data-toggle="modal" id="butCancel" data-target=".modal-invoice" class="btn btn-danger btn-flat btn-block">Cancel Invoice</button>
          </div>
          <div class="col-sm-6">
            <button class="btn btn-success btn-flat btn-block" id="butSave" disabled>Save</button>
          </div>
        </div>
      </form>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->

<div class="modal fade modal-invoice" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <form method="POST" id="paymentForm" action="<?=base_url().'admin/orders/cancel'?>">
        <div class="modal-body">
          <p>Are you sure to cancel this?</p>
          <input type="hidden" name="inputInvoiceNo" value="<?=$url[3]?>">
        </div>
        <div class="modal-footer form-inline">
          <button class="btn btn-sm btn-danger btn-flat" type="submit">Yes</button>
          <button class="btn btn-sm btn-default btn-flat" type="button" data-dismiss='modal'>No</button>
        </div>
      </form>
    </div>
  </div>
</div>