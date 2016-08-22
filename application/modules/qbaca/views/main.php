<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"></h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <form method="GET">
        <div class="col-md-4 col-md-offset-4">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-btn">
                <input type="hidden" name="f" value="<?=$f?>">
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  <?=ucfirst($f)?>&nbsp;&nbsp;<span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url().'partner/qbaca/transaction?f=all'?>">All</a></li>
                  <li><a href="<?=base_url().'partner/qbaca/transaction?f=settled'?>">Settled</a></li>
                  <li><a href="<?=base_url().'partner/qbaca/transaction?f=pending'?>">Pending</a></li>
                </ul>
              </div><!-- /btn-group -->
              <input type="text" name="date" value="<?=$date?>" class="form-control pull-right" placeholder="Date Range ..." id="date_range">
              <div class="input-group-btn">
                <button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
              </div>
            </div><!-- /.input group -->
          </div><!-- /.form group -->  
        </div>
      </form>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->

<div class="box box-solid">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table id="ordersTable" class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Email Pembaca</th>
                <th>Book Name</th>
                <th>Price</th>
                <th>Date</th>
                <th>Status</th>
                <th>Status Rekon</th>
              </tr>
            </thead>
            <tbody>
              <?php

              if(!isset($url[4]))
                $no = 1;
              else $no = $index+1; $subTotal = 0;
              foreach ($transactions as $transaction) {
                switch ($transaction->qtrx_stat) {
                  case '5': $status = 'Paid'; break;
                  case '1': $status = 'Cancelled'; break;
                  case '8': $status = 'Pending'; break;
                  default: $status = 'Unknown'; break;
                }

                switch ($transaction->qtrx_stat_rekon) {
                  case '1': $status_rekon = 'settle';break;
                  case '0': $status_rekon = 'pending';break;
                }
                ?>
                <tr>
                  <td><?=$no?></td>
                  <td><?=$transaction->qtrx_cus_email?></td>
                  <td style='width:300px'><?=$transaction->qtrx_book_name?></td>
                  <td class='text-right'><?=number_format($transaction->qtrx_price)?></td>
                  <td style='min-width:150px' class='text-center'><?=$transaction->qtrx_date?></td>
                  <td><?=$status?></td>
                  <td><?=ucfirst(strtolower($status_rekon))?></td>
                </tr>
                <?php
                $no++; $subTotal += $transaction->qtrx_price;
              }
              if(!count($transactions)){
                $table = "<tr><td colspan='7' class='text-center'>No data available</td></tr>";
              }
              ?>
            </tbody>
            <tfoot>
              <?php
              $totalAmountOrders = 0;
              foreach ($amountOrders as $amountOrder) {
                $totalAmountOrders += $amountOrder->qtrx_price;
              }
              ?>
              <tr>
                <th class='text-center' colspan='3'>Sub Total</th>
                <th class='text-right'><?=number_format($subTotal)?></th>
              </tr>
              <tr>
                <th class='text-center' colspan='3'>Grand Total</th>
                <th class='text-right'><?=number_format($totalAmountOrders)?></th>
              </tr>
            </tfoot>
          </table>
          <div class="row">
            <div class="col-md-2 col-md-offset-8">
              <?="Result: ".$total_rows." orders."?>
            </div>
          </div>
          <?=$this->pagination->create_links();?>
        </div>
      </div>
    </div>
  </div>
</div>