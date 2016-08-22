<?php
if(isset($_SESSION['note'])){
    $alert    = "";
    $mess     = "";
    switch ($_SESSION['note']) {
      case 'INVFail':
        $alert    = "alert-danger";
        $mess     = "Something Wrong. Please call Administration.";
      break;
      case 'succReport':
        $alert    = "alert-success";
        $mess     = "Report has been created.";
      break;
      case 'subSuccReport':
        $alert    = "alert-success";
        $mess     = "The Report successfully submitted.";
      break;
      case 'appSuccReport':
        $alert    = "alert-success";
        $mess     = "Report has been approved.";
      break;
    }
    $notice   = "<div class='alert ".$alert."'>";
    $notice  .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
    $notice  .= "<span aria-hidden='true'>&times;</span>";
    $notice  .= "</button>".$mess."</div>";
    unset($_SESSION['note']);
    echo $notice;
  }
?>
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
                <input type="hidden" name="f" value="<?=$fw?>">
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  <?=ucwords($f)?>&nbsp;&nbsp;<span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url().'snba/reports/?f=all'?>">All</a></li>
                  <?php
                  foreach ($listStatus as $status) {
                    echo "<li><a href='".base_url()."snba/reports/?f=$status->stat_id'>".ucwords($status->stat_name)."</a></li>";
                  }
                  ?>
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
      <div class="col-md-12">
        <div class="table-responsive">
          <table id="ordersTable" class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Document Number</th>
                <th class="text-center">Partner Name</th>
                <th class="text-center">Period</th>
                <th class="text-center">Service</th>
                <th class="text-center">Amount</th>
                <th class="text-center">Creation Date</th>
                <th class="text-center">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0; $subTotal = 0;
              foreach ($reports as $key => $report) {
                $no = $key+1; $subTotal += $report->ba_amount_pks;
                $created  = $this->convnumber->indonesian_date($report->ba_created, 'd F Y', '');
                $period   = explode(' - ', $report->ba_periode);
                $periode = $this->convnumber->indonesian_date($period[0], 'd F Y', '')." - ".$this->convnumber->indonesian_date($period[1], 'd F Y', '');;
              ?>
              <tr>
                <td class="text-center"><?=number_format($no, 0, ',', '.')?></td>
                <td class="text-center"><?="<a href='".base_url().'snba/reports/preview/'.sha1($this->config->config['salt'].$report->number)."'>$report->number</a>"?></td>
                <td class="text-center"><?=ucwords($report->partner_name)?></td>
                <td class="text-center"><?=$periode?></td>
                <td class="text-center"><?=strtoupper($report->name)?></td>
                <td class="text-right"><?=number_format($report->ba_amount_pks, 0, ',', '.')?></td>
                <td class="text-center"><?=$created?></td>
                <td class="text-center"><?=ucwords($report->stat_name)?></td>
              </tr>
              <?php }
              ?>
            </tbody>
            <tfoot>
              <?php
              if(!count($reports)){
                echo "<tr><td colspan='8' class='text-center'>No data available</td></tr>";
              } else {
              ?>
              <th class='text-center' colspan='5'>Sub Total</th>
              <th class='text-right'><?=number_format($subTotal, 0, ',', '.')?></th>
              <?php } ?>
            </tfoot>
          </table>
          <div class="row">
            <div class="col-md-2 col-md-offset-8">
              <?="Result: ".count($reports)." reports."?>
            </div>
            <div class="col-md-1">
              <!-- <div class="input-group-btn"> -->
                <?php /* if($f == 'pending' && count($transactions) > 0) { ?>
                <form method="POST" action="<?=base_url().'snba/reports/preview/new'?>">
                  <input type="hidden" name="inputPartner" value="<?=$p?>">
                  <input type="hidden" name="inputPeriode" value="<?=$date?>">
                  <input type="hidden" name="inputService" value="<?=$service_id?>">
                  <input type="hidden" name="inputQtrxID" value="<?=$orders_id?>">
                  <input type="hidden" name="inputAmount" value="<?=$totalAmountOrders?>">
                  <?=$buttonProses?>
                </form>
                <?php }*/ ?>
              <!-- </div> -->
            </div>
          </div>
          <?=$this->pagination->create_links();?>
        </div>
      </div>
    </div>
  </div>
</div>