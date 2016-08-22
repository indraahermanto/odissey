<div class="box box-primary" style="min-height: 440px">
  <div class="box-header with-border">
    <h3 class="box-title"></h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <form method="POST" enctype="multipart/form-data" action="<?=base_url().'partner/invoices/preview/new'?>">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
              <label>List Report</label>
              <select class="select2 form-control" id="inputReport" name="inputReport">
                <option value="">Choose Report</option>
                <?php
                foreach ($reports as $report) {
                  $period = explode(" - ", $report->ba_periode);
                  echo "<option value='".sha1($this->config->item('salt').($report->number))."'>$report->number - "
                        .$this->convnumber->indonesian_date(strtotime($period[0]), 'd F Y', '')." s.d. "
                        .$this->convnumber->indonesian_date(strtotime($period[1]), 'd F Y', '')
                        ." - ".number_format($report->ba_amount, 0, ',', '.')."</option>";
                }
                ?>
              </select>
            </div>
            <?php
            if($partner->partner_tax_stat == 1){ ?>
            <div class="form-group">
              <label class="control-label">Upload Faktur Pajak</label>
              <input id="inputFP" name="inputFP" type="file" class="file-loading">
              <small>*max size 10Mb</small>
            </div>
            <?php } ?>

            <div class="form-group">
              <label>Transfer to</label>
              <input type="text" readonly class="form-control" value="<?=$partner->pbank_rekening." - ".strtoupper($partner->pbank_an)." (".ucwords($partner->pbank_name).")"?>">
              <input type="hidden" value="<?=$partner->pbank_id?>">
            </div>
            <div class="form-group">
              <label>Amount of Berita Acara</label>
              <input type="text" readonly class="form-control" id="amountReport" value="0">
            </div>
            
            <!-- <label> Do you have a document refference ?</label>
            <div class="form-group form-animate-checkbox">
              <input type="checkbox" class="checkbox"  id="doc_reff" value="yes" name="doc_reff">
              <label>&nbsp;&nbsp; Yes, I have</label>
            </div> -->
            <input type="submit" disabled id="sub" class="btn btn-default btn-flat pull-right" value="Submit">
          </div>
        </div>
      </form>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->