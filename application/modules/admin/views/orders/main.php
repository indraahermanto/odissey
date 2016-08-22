<?php
if(isset($message)){
    $notice   = "<div class='alert alert-success'>";
    $notice  .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
    $notice  .= "<span aria-hidden='true'>&times;</span>";
    $notice  .= "</button>".$message."</div>";
    echo $notice;
    unset($_SESSION['notes']);
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
      <form method="GET">
        <div class="row">
          <div class="col-md-5 col-md-offset-1">
            <input type="text" name="date" class="form-control pull-right" value="<?=$date?>" placeholder="Date Range ..." id="date_range">
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-btn">
                  <input type="hidden" name="stat" value="<?=$stat?>">
                  <?php if($stat == "") $stat = "all"; ?>
                  <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                    <?=ucfirst($stat)?>&nbsp;&nbsp;<span class="fa fa-caret-down"></span>
                  </button>
                  <?=$listStat?>
                </div><!-- /btn-group -->
                <input type="text" name="key" class="form-control pull-right" value="<?=$key?>"" placeholder="Keyword ...">
              </div><!-- /.input group -->
            </div><!-- /.form group -->  
          </div>
        </div>
        <div class="row">
          <div class="col-xs-3 col-md-2 col-xs-offset-8 col-md-offset-9">
            <div class="form-group">
              <button style="max-width:120px" class="btn btn-primary btn-flat form-control">Search&nbsp;&nbsp;&nbsp;<i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </form>
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
                <th class="text-center">Date</th>
                <th class="text-center">Invoice Number</th>
                <th class="text-center">Cust. Name</th>
                <th class="text-center">Number</th>
                <th class="text-center">Product Code</th>
                <th class="text-center">Cost</th>
                <th class="text-center">Price</th>
                <th class="text-center">Rest Amount</th>
                <th class="text-center">Status</th>
              </tr>
            </thead>
            <tbody>
              <?=$tableOrders?>
            </tbody>
          </table>
          <?=$this->pagination->create_links();?>
        </div>
      </div>
    </div>
  </div>
</div>