<?php
/*
  if(isset($message)){
    $notice   = "<div class='alert alert-success'>";
    $notice  .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
    $notice  .= "<span aria-hidden='true'>&times;</span>";
    $notice  .= "</button>".$message."</div>";
    echo $notice;
    unset($_SESSION['notes']);
  } 
?>
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Pulsa</span>
        <span class="info-box-number">Rp. <?=number_format($saldoPulsa, '0', ',','.')?></span>
        <br/>
        <p class="pull-right" data-toggle="modal" data-keyboard="false" data-target=".modal-deposit" style="cursor:pointer">Deposit Yuk!</p>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Bank</span>
        <span class="info-box-number">Rp. <?=number_format($saldoBank, '0', ',','.')?></span>
        <input type="hidden" id="allowBank" value="<?=$saldoBank?>">
        <br/>
        <p class="pull-right" data-toggle="modal" data-keyboard="false" data-target=".modal-tarik" style="cursor:pointer">Tarik Tunai</p>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Cash</span>
        <span class="info-box-number">Rp. <?=number_format($saldoCash, '0', ',','.')?></span>
        <input type="hidden" id="allowCash" value="<?=$saldoCash?>">
        <br/>
        <p class="pull-right" data-toggle="modal" data-keyboard="false" data-target=".modal-setor" style="cursor:pointer">Nabung dulu</p>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Wallet</span>
        <span class="info-box-number">Rp. <?=number_format($saldoWallet, '0', ',','.')?></span>
        <input type="hidden" id="allowWallet" value="<?=$saldoWallet?>">
        <br/>
        <p class="pull-right" data-toggle="modal" data-keyboard="false" data-target=".modal-cair" style="cursor:pointer">Tarik Wallet</p>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
</div><!-- /.row -->

<div class="modal fade modal-deposit" tabindex="-1" role="dialog" aria-labelledby="modalDeposit">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Deposit Yuk!</h4>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class='alert alert-danger alert-dep'>
            Maaf, saldo bank kurang bro!
          </div>
          <div class="form-group">
            <label>Amount</label>
            <input type="text" name="inputAmount" id="amountDep" required class="form-control mask-money text-right">
            <input type="hidden" name="inputType" value="deposit">
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" disabled id="subDep" class="btn btn-sm btn-success btn-flat" name="modal_action" value="Proses">
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade modal-tarik" tabindex="-1" role="dialog" aria-labelledby="modalDeposit">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tarik Tunai</h4>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class='alert alert-danger alert-tarik'>
            Sorry bro, saldo tabungannya kurang!
          </div>
          <div class="form-group">
            <label>Amount</label>
            <input type="text" name="inputAmount" id="amountTarik" required class="form-control mask-money text-right">
            <input type="hidden" name="inputType" value="tarik">
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" disabled id="subTarik" class="btn btn-sm btn-success btn-flat" name="modal_action" value="Proses">
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade modal-setor" tabindex="-1" role="dialog" aria-labelledby="modalDeposit">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nabung dulu</h4>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class='alert alert-danger alert-setor'>
            Sorry, uang cashnya kurang bro!
          </div>
          <div class="form-group">
            <label>Amount</label>
            <input type="text" name="inputAmount" id="amountSetor" required class="form-control mask-money text-right">
            <input type="hidden" name="inputType" value="setor">
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" disabled id="subSetor" class="btn btn-sm btn-success btn-flat" name="modal_action" value="Proses">
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade modal-cair" tabindex="-1" role="dialog" aria-labelledby="modalDeposit">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cairkan Wallet</h4>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class='alert alert-danger alert-cair'>
            Gagal, saldo wallet engga cukup!
          </div>
          <div class="form-group">
            <label>Amount</label>
            <input type="text" name="inputAmount" id="amountCair" required class="form-control mask-money text-right">
            <input type="hidden" name="inputType" value="cair">
          </div>
          <div class="form-group">
            <label>Method</label>
            <select class="form-control" required name="inputMethod">
              <option value="">Select Method</option>
              <option value="620">Bank</option>
              <option value="610">Cash</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" disabled id="subCair" class="btn btn-sm btn-success btn-flat" name="modal_action" value="Proses">
        </div>
      </form>
    </div>
  </div>
</div>*/