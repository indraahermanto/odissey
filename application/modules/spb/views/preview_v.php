
<div class="row">
  <div class="col-sm-12">
    <div class="box box-primary">
      <div class="row">
        <div class="col-xs-12 text-center">
          <h3>SURAT PERINTAH BAYAR</h3>
          <h4>LAYANAN <?=strtoupper($invoice->name)?></h4>
          <?="<h5>Antara PT Telekomunikasi Indonesia, Tbk dengan ".ucwords($invoice->partner_name)."</h5>"?>
          <h5>Nomor: <?=$invoice->spb_number?></h5>
          <h5>Tanggal: <?=$this->convnumber->now('d F Y','')?></h5>
        </div>
        <div class="col-xs-10 col-xs-offset-1">
          <hr style="height:3px; background-color: #000">
        </div>
        <div class="col-xs-8 col-xs-offset-2">
          <div class="row text-justify">
            <p>
              <?="Kepada Manager Finance harap dibayarkan uang sejumlah Rp.".number_format($invoice->inv_amount, 0, ',', '.')." ("
                  .$this->convnumber->terbilang($invoice->inv_amount)." Rupiah) sebagai tindak lanjut rekonsiliasi atas transaksi "
                  .strtoupper($invoice->name)." terhadap invoice dibawah ini:"?>
            </p>
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped">
                <thead>
                  <th class="text-center">No</th>
                  <th class="text-center">Nomor Invoice</th>
                  <th class="text-center">Nilai Transaksi</th>
                  <th class="text-center">Periode</th>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">1</td>
                    <td class="text-center"><?=$invoice->inv_number?></td>
                    <td class="text-right"><?=number_format($invoice->inv_amount, 0, ',', '.')?></td>
                    <td class="text-center"><?=$periode?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p>Dibebankan kepada:<br/>
              <div style="margin-left:20px">
                <b><i>
                  <?="Bank ".ucwords($invoice->pbank_name)."<br/>".strtoupper($invoice->pbank_rekening)." - A/N ".strtoupper($invoice->pbank_an)?>
                </i></b>
              </div>
            </p>
            <p>
              Demikian Surat Perintah Bayar ini dibuat untuk digunakan sebagai dasar pembayaran oleh Telkom kepada <?=ucwords($invoice->partner_name)?> dan apabila dikemudian hari ditemukan kekeliruan dalam perhitungan data ini, maka akan dilakukan perbaikan pada settlement berikutnya.
            </p>
          </div>
          <br/><br/><br/><br/><br/>

          <div class="row">
            <div class='col-xs-6 text-center'>
              <br/>
              <b>
                <p>
                  Lunas Bayar<br/>
                  <?=ucwords("Mgr. Finance Service DSC")?>
                </p>
                <br/><br/><br/>
                <u class='text-underline'><?=ucwords("Suahmadi")?></u>
                <p><?="NIK. 651234"?></p>
              </b>
            </div>

            <div class='col-xs-6 text-center'>
              <b>
                <p>
                  <?="Jakarta, ".$this->convnumber->indonesian_date(strtotime('now'), 'd F Y', '')?><br/>
                  <?=ucwords("Kuasa Rekonsiliasi & Settlement")?><br/>
                  <?=ucwords("Mgr. Settlement & Business Analyst")?>
                </p>
                <br/><br/><br/>
                <u class='text-underline'><?=ucwords($mgr_st->first_name." ".$mgr_st->last_name)?></u>
                <p><?="NIK. ".$mgr_st->username?></p>
              </b>
            </div>
            <br/><br/>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12"><hr/></div>
        </div>
        <div class="col-xs-12">
          <?php
          // print_r($invoice);
          if($invoice->spb_status != 'mak' && $invoice->spb_status != 'app'){
            ?>
            <div class="col-md-1 col-md-offset-1">
              <div id="">
                <a href="<?=base_url()."uploads/bukti_bayar/".$invoice->spb_file?>" class="btn btn-default btn-flat" title="<?="Bukti Bayar ".$invoice->spb_number?>"  data-gallery>
                  Lihat Bukti Bayar
                </a>
              </div>
              <!-- <button class="btn btn-default btn-flat" data-toggle="modal" data-target="#attachment">
                Lihat Bukti Bayar
              </button> -->
            </div>
          <?php } ?>
          <div class="col-md-1">
            <a href="<?=base_url().$url[1].'/view_pdf/spb/'.$url[4]?>" class="btn btn-default btn-flat">View As PDF</a>
          </div>
          <div class="col-md-2 col-md-offset-6 pull-right">
            <?=$buttProcess?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12"><hr/></div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="col-xs-10 col-xs-offset-1">
            <h3>Document History:</h3>
            <ol>
              <?php foreach ($logs as $log) { ?>
                <?php
                  echo "<li>".$this->notifier->spb_log($log->dlog_action, $log->dlog_user_id, $this->convnumber->indonesian_date(strtotime($log->dlog_time), 'd F Y H:i:s', ''))."</li>";
                ?>
              <?php } ?>
            </ol>
            <br/><br/>
            <h4>[DISCLAIMER]</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12"><hr/></div>
        </div>
      </div>
      <div class="row tableTrxReport">
        <div class="col-xs-12">
          <div class="col-xs-10 col-xs-offset-1">
            <?=''?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form method="POST" action="<?=base_url().$url_act?>">
        <div class="modal-body">
          <p class="text-justify">
            Apa Anda yakin untuk membuat Berita Acara atas <b><?=''?></b>
            transaksi selama periode <b><?=$periode?></b> sejumlah <b>Rp. <?=number_format($invoice->spb_amount,'0',',','.')?></b> ?
          </p>
          <input type="hidden" name="inputSPB" value="<?=$url[4]?>">
        </div>
        <div class="modal-footer">
          <div class="input-group-btn">
            <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cancel</button>
            <button class="btn btn-flat btn-primary" data-toggle="modal">
              <i class="fa fa-check"></i> Yes
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="attachment" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="input-group-btn">
          <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <div class="modal-body">
        <img src="<?=base_url()."uploads/bukti_bayar/".$invoice->spb_file?>" class="img-responsive">
      </div>
    </div>
  </div>
</div>

<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" borderless-checkbox="true" data-use-bootstrap-modal="false">
<!-- <div id="blueimp-gallery" class="blueimp-gallery" data-use-bootstrap-modal="false"> -->
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <a class="close">×</a>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title"></h3>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
            </div>
        </div>
    </div>
</div>