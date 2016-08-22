<?php
if(isset($_SESSION['note'])){
    $alert    = "";
    $mess     = "";
    switch ($_SESSION['note']) {
      case 'INVFail':
        $alert    = "alert-danger";
        $mess     = "Something Wrong. Please call Administration.";
      break;
      case 'succInvoice':
        $alert    = "alert-success";
        $mess     = "Success make a Invoice.";
      break;
      case 'creSucceed':
        $alert    = "alert-success";
        $mess     = "Invoice has been created.";
      break;
      case 'subSucceed':
        $alert    = "alert-success";
        $mess     = "The doc successfully submitted.";
      break;
      case 'succSubSPB':
        $alert    = "alert-success";
        $mess     = "Bukti Bayar has been uploaded.";
      break;
      case 'appSucceed':
        $alert    = "alert-success";
        $mess     = "Invoices has been approved.";
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
                  <li><a href="<?=base_url().$url[1].'/spb/?f=all'?>">All</a></li>
                  <?php
                  foreach ($listStatus as $status) {
                    echo "<li><a href='".base_url().$url[1]."/spb/?f=$status->stat_id'>".ucwords($status->stat_name)."</a></li>";
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
            <label>Bank Account</label>
            <select class="form-control select2" name="bank">
              <option value="">Choose Bank</option>
              <?php
              $select = "";
              foreach ($banks as $key => $bank) {
                if($key == $pbank_name)
                  $select = "selected";
                else $select = "";
                echo "<option value='".$key."' $select>".strtoupper($key)."</option>";
                // if($bank->pbank_name == $pbank_name)
                //   $select = "selected";
                // echo "<option value='".$bank->pbank_name."' $select>".ucwords($bank->pbank_name)."</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-default btn-flat btn-sm pull-right">
              Search
            </button>
            <a href="<?=base_url().$url[1]."/spb/upload"?>" class="btn btn-primary btn-flat btn-sm pull-right">
              Upload Bukti Bayar
            </a>
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
        <?php // echo $_GET['f']." s ".$pbank_name ?>
        <div class="table-responsive">
          <table id="ordersTable" class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Invoice Number</th>
                <th class="text-center">Partner Name</th>
                <th class="text-center">Service</th>
                <th class="text-center">Period</th>
                <th class="text-center">Amount</th>
                <th class="text-center">Date</th>
                <th class="text-center">Status</th>
                <?php if($pbank_name != "" && $fw == 'app'){ ?>
                  <th class="text-center">Select All</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <form action="<?=base_url()."download/batch/$pbank_name"?>" method="POST" id="uploadForm">
              <?php
              
              $no = 0; $subTotal = 0;
              foreach ($docs as $key => $doc) {
                $no = $key+1; $subTotal += $doc->spb_amount;
                $created  = $this->convnumber->indonesian_date($doc->spb_created, 'd F Y', '');
                $period   = explode(' - ', " - ");
                $periode = $this->convnumber->indonesian_date($period[0], 'd F Y', '')." - ".$this->convnumber->indonesian_date($period[1], 'd F Y', '');;
              ?>
              <tr>
                <td class="text-center"><?=number_format($no, 0, ',', '.')?></td>
                <td class="text-center">
                  <?="<a href='".base_url().$url[1].'/spb/preview/'.sha1($this->config->config['salt'].$doc->spb_number)
                  ."'>$doc->spb_number</a>"?>
                </td>
                <td class="text-center"><?=ucwords($doc->partner_name)?></td>
                <td class="text-center"><?=strtoupper($doc->name)?></td>
                <td class="text-center"><?=$periode?></td>
                <td class="text-right"><?=number_format($doc->spb_amount, 0, ',', '.')?></td>
                <td class="text-center"><?=$created?></td>
                <td class="text-center"><?=ucwords($doc->stat_name)?></td>
                <?php if($pbank_name != "" && $fw == 'app'){ ?>
                <td class="text-center">
                  <input type="checkbox" name="inputSPB[]" value="<?=sha1($this->config->config['salt'].$doc->spb_number)?>">
                </td>
                <?php } ?>
              </tr>
              <?php } 
              ?>
              </form>
            </tbody>
            <tfoot>
              <?php
              if(!count($docs)){
                echo "<tr><td colspan='8' class='text-center'>No data available</td></tr>";
              } else {
              ?>
              <th class='text-center' colspan='5'>Sub Total</th>
              <th class='text-right'><?=number_format($subTotal, 0, ',', '.')?></th>
              <?php }
              ?>
            </tfoot>
          </table>

          <div class="row">
            <div class="col-md-2 col-md-offset-8">
              <?="Result: ".count($docs)." docs."?>
            </div>
            <div class="col-md-1">
              <?php if($pbank_name != "" && $fw == 'app'){ ?>
              <a href="#download" onclick="document.getElementById('uploadForm').submit();" class="btn btn-default btn-flat btn-sm">
                Download Batch
              </a>
              <?php } ?>
            </div>
          </div>
          <?=$this->pagination->create_links();?>
        </div>
      </div>
    </div>
  </div>
</div>