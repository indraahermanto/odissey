<?php
if(isset($_SESSION['note'])){
  echo $_SESSION['note'];
  unset($_SESSION['note']);
}
?>

<div class="box box-primary" style="min-height: 440px">
  <div class="box-header with-border">
    <h3 class="box-title"></h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <form method="POST" enctype="multipart/form-data" action="<?=base_url()."snba/spb/upload_bayar"?>">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
              <label>List Report</label>
              <select class="select2 form-control" id="inputSPB" name="inputSPB">
                <option value="">Choose Report</option>
                <?php
                foreach ($docs as $doc) {
                  echo "<option value='".sha1($this->config->item('salt').($doc->number))."'>$doc->number - $doc->spb_amount</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Bukti Bayar</label>
              <input id="inputBayar" name="inputBayar" required type="file" class="file-loading">
            </div>
            <div class="form-group">
              <label>Amount of SPB</label>
              <input type="text" readonly class="form-control" id="amountSPB" value="0">
            </div>
            
            <input type="submit" disabled id="sub" class="btn btn-default btn-flat pull-right" value="Submit">
          </div>
        </div>
      </form>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->