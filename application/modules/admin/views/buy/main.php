<?php
  if(isset($message)){
    $notice   = "<div class='alert alert-info'>";
    $notice  .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
    $notice  .= "<span aria-hidden='true'>&times;</span>";
    $notice  .= "</button>".$message."</div>";
    echo $notice;
    unset($_SESSION['notes']);
  } 
?>
<div class="box box-solid">
  <div class="box-body">
    <form method="POST">
      <div class="row">
        <div class="col-sm-5 col-sm-offset-1">
          <div class="form-group">
            <label>Cust Name</label>
            <?=$inputCustName?>
          </div>
        </div>
        <div class="number"></div>
      </div>
      <div class="row">
        <div class="col-sm-5 col-sm-offset-1">
          <div class="form-group">
            <label>Payment Method</label>
            <select name="inputMethod" id="inputMethod" required class="form-control">
              <option value="">Choose Payment</option>
              <option value="100">Cash</option>
              <option value="200">Bank</option>
              <option value="640">Wallet</option>
              <option value="300">Credit</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-1 col-sm-offset-1">
          <div class="form-group">
            <a class="btn btn-default btn-flat btn-sm" href="<?=base_url()."admin"?>">Back</a>
          </div>
        </div>
        <div class="col-sm-1 col-sm-offset-7">
          <div class="form-group">
            <input type="submit" id="submit" class="btn btn-success btn-flat btn-sm">
          </div>
        </div>
      </div>
    </form>
  </div>
</div>