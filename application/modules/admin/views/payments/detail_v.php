<div class="row">
  <div class="col-sm-4">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Account Information</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div><!-- /.box-tools -->
      </div><!-- /.box-header -->
      <div class="box-body">
        <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">
          <h3 class="profile-username text-center"><?=$user->first_name." ".$user->last_name?></h3>
          <p class="text-muted text-center"><?=strtoupper($user->ug_name)?></p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Saldo Wallet</b> <a class="pull-right"><?=number_format(0, 0, ',', '.')?></a>
            </li>
            <li class="list-group-item">
              <b>Payable</b> <a class="pull-right"><?=number_format($saldoReceivable, 0, ',', '.')?></a>
            </li>
            <li class="list-group-item">
              <b>Transaction Pending</b> <a class="pull-right"><?=number_format(0, 0, ',', '.')?></a>
            </li>
          </ul>
          <div class="col-sm-6">
            <a href="#" class="btn btn-sm btn-flat btn-success btn-block"><b>Reload Wallet</b></a>
          </div>
          <div class="col-sm-6">
            <button data-toggle="modal" data-target=".modal-payments" class="pay-debt btn btn-sm btn-flat btn-primary btn-block">
              <b>Pay Debt</b>
            </button>
            <input type="hidden" id="inputUserName" value="<?=$user->username?>">
          </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
  <div class="col-sm-8">
    <div class="box box-danger" style="max-height:372px; min-height:372px">
      <div class="box-header with-border">
        <h3 class="box-title">Payment Authorism</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div><!-- /.box-tools -->
      </div><!-- /.box-header -->
      <div class="box-body">
        <table class="table table-hover table-striped">
          <thead>
            <th class="text-center">No</th>
            <th class="text-center">Doc Number</th>
            <th class="text-center">Date Created</th>
            <th class="text-center">Amount</th>
            <th class="text-center">Status</th>
          </thead>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">List of Transaction</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div><!-- /.box-tools -->
      </div><!-- /.box-header -->
      <div class="box-body">
        <div id='tableOrdersUser'>
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
          <?php echo $this->ajax_pagination->create_links(5); ?>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>

<div class="modal fade modal-payments" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form method="POST" id="paymentForm" action="<?=base_url().'admin/admin/payments/pay'?>">
        <div class="modal-header">
          <h3 class="text-center">Detail</h3>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped" id="priceGroup">
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
                $no = 0; $totalAmount = 0;
                foreach ($orders as $key => $order) {
                  $no = $key+1;
                ?>
                <tr>
                  <td><?=$no?></td>
                  <td class='text-center'><?=$this->convnumber->indonesian_date(strtotime($order->invoice_date), 'd F <br/> H:i', '');?></td>
                  <td class='text-center'><?=strtoupper($order->provider_name)." ".number_format($order->product_nom, 0, ',', '.')?></td>
                  <td class='text-center'><?=$order->number_phone?></td>
                  <td class='text-right'><?=number_format($order->rest_amount, 0, ',', '.')?></td>
                  <td class='text-center'><?=ucwords($order->istat_name)?></td>
                  <td class='text-center'>
                    <input class="checkbox" type="checkbox" name="invoice_number[]" id='price<?=$key?>' value="<?=$order->invoice_number?>">
                  </td>
                </tr>
                <?php 
                  $totalAmount += $order->rest_amount; 
                } 
                ?>
              </tbody>
            </table>
          </div>
          <span id="priceGroupTotal"></span>
        </div>
        <div class="modal-footer form-inline">
          <input type="hidden" name="username" value="<?=$user->username?>">
          <input type="hidden" id="totalAmount" value="<?=$totalAmount?>">
          <select name="InputPay" id="InputPay" required class="form-control">
            <option value="">Select Method</option>
            <option value="120">Cash</option>
            <option value="220">Bank</option>
            <!-- <option value="600">Wallet</option> -->
          </select>
          <input type="text" class="form-control text-right" placeholder="Amount of paid" name="InputAmount" id="InputAmount" required>
          <input type="text" class="form-control text-right" name="InputAmountPay" required readonly id="InputAmountPay">
          <button class="btn btn-sm btn-success btn-flat" id="payThis" type="submit">Pay This!</button>
        </div>
      </form>
    </div>
  </div>
</div>