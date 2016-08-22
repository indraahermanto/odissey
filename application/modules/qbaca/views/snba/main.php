
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
        <div class="col-md-5 col-md-offset-1">
          <div class="form-group">
            <label>List of Partners:</label>
            <div class="input-group">
              <div class="input-group-btn">
                <input type="hidden" name="f" value="<?=$f?>">
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  <?=ucfirst($f)?>&nbsp;&nbsp;<span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url().'snba/qbaca/transaction?f=all'?>">All</a></li>
                  <li><a href="<?=base_url().'snba/qbaca/transaction?f=settled'?>">Settled</a></li>
                  <li><a href="<?=base_url().'snba/qbaca/transaction?f=pending'?>">Pending</a></li>
                </ul>
              </div><!-- /btn-group -->
              <select class="form-control select2" name="p">
                <option value="">Choose Partner</option>
                <?php
                $select = "";
                foreach ($partners as $partner) {
                  if($partner->partner_id == $p)
                    $select = "selected";
                  echo "<option value='".$partner->partner_id."' $select>".ucwords($partner->partner_name)."</option>";
                }
                ?>
              </select>
            </div><!-- /.input group -->
          </div><!-- /.form group -->
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <label>Date range:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" name="date" value="<?=$date?>" class="form-control pull-right" id="date_range">
            </div><!-- /.input group -->
          </div>
          <div class="form-group">
            <button class="btn btn-default btn-flat btn-sm pull-right">
              Search
            </button>
          </div> 
        </div>
      </form>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->
<div class="box box-solid">
  <div class="box-body">
    <div class="row">
      <div class="col-md-5 col-md-offset-1">
        <?php
        $totalAmountOrders = 0;
        $orders_id = "";
        foreach ($amountOrders as $amountOrder) {
          $orders_id .= $amountOrder->qtrx_id.",";
          $totalAmountOrders += $amountOrder->qtrx_price;
        }
        if($f == 'pending' && $p != "" && $orders_id != "")
          echo '<i>" '.$total_rows." transaksi ditemukan, dengan nilai Rp. ".number_format($totalAmountOrders, 0, ',', '.').'. "</i>';
        ?>
      </div>
      <br/><br/>
      <div class="col-md-12">
        <div class="table-responsive">
          <table id="ordersTable" class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Email Pembaca</th>
                <th>Partner Name</th>
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
              else $no = $index+1;
              $subTotal = 0;
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
                  <td class='text-center'><?=ucwords($transaction->partner_name)?></td>
                  <td style='width:300px'><?=$transaction->qtrx_book_name?></td>
                  <td class='text-right'><?=number_format($transaction->qtrx_price, 0, ',', '.')?></td>
                  <td style='min-width:150px' class='text-center'><?=$transaction->qtrx_date?></td>
                  <td><?=$status?></td>
                  <td><?=ucfirst(strtolower($status_rekon))?></td>
                </tr>
                <?php
                $no++;
                $subTotal += $transaction->qtrx_price;
              }
              if(!count($transactions)){
                echo "<tr><td colspan='8' class='text-center'>No data available</td></tr>";
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="4" class="text-center">Sub Total</th>
                <th><?=number_format($subTotal, 0, ',', '.')?></th>
                <th colspan="3"> </th>
              </tr>
            </tfoot>
          </table>
          <div class="row">
            <div class="col-md-2 pull-right">
              <!-- <div class="input-group-btn"> -->
                <?php if($f == 'pending' && $p != "" && count($transactions) > 0) { ?>
                <form method="POST" action="<?=base_url().'snba/reports/preview/new'?>">
                  <input type="hidden" name="inputPartner" value="<?=$p?>">
                  <input type="hidden" name="inputPeriode" value="<?=$date?>">
                  <input type="hidden" name="inputService" value="<?=$service_id?>">
                  <input type="hidden" name="inputQtrxID" value="<?=$orders_id?>">
                  <input type="hidden" name="inputAmount" value="<?=$totalAmountOrders?>">
                  <?=$buttonProses?>
                </form>
                <?php } ?>
              <!-- </div> -->
            </div>
          </div>
          <?=$this->pagination->create_links();?>
        </div>
      </div>
    </div>
  </div>
</div>