<?php
  $dateBody   = "Hari ini <b>".$this->convnumber->now('l','')."</b> Tanggal <b>".$this->convnumber->now('d','')."</b> Bulan ";
  $dateBody  .= "<b>".$this->convnumber->now('F','')."</b> Tahun <b>".$this->convnumber->now('Y','')."</b>,";
  $hasil      = "<b><ol><li>Hasil transaksi ".strtoupper("")." untuk periode ".""." sampai ".""." sejumlah Rp. "
                .number_format(0, 0, ',', '.').",- (".$this->convnumber->terbilang(0)." Rupiah) dengan rincian transaksi terlampir dibawah.</li>";
  $hasil     .= "<li>".ucwords("")." menerbitkan tagihan kepada Telkom sejumlah Rp. ".number_format(0, 0, ',', '.')
                .",- (".$this->convnumber->terbilang(0)." Rupiah), belum termasuk PPn 10%.<br/>"
                ."<u>Sesuai dengan Dokumen Perjanjian Kerja Sama No. </u></li></ol></b>";
?>
<div class="row">
  <div class="col-sm-12">
    <div class="box box-primary">
      <div class="row">
        <div class="col-xs-12 text-center">
          <h3>SURAT PERINTAH BAYAR</h3>
          <h4>LAYANAN <?=strtoupper($invoice->name)?></h4>
          <?="<h5>Antara PT Telekomunikasi Indonesia, Tbk dengan ".ucwords($invoice->partner_name)."</h5>"?>
          <h5>Nomor: .................................</h5>
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
          <div class="col-md-2 col-md-offset-9 pull-right">
            <form method="POST" action="<?=base_url().'snba/spb/maker'?>">
              <input type="hidden" name="inputInvoice" value="<?=$url[5]?>">
              <button class="btn btn-success btn-flat" data-toggle="modal" data-target=".bs-modal">
                Create &nbsp;
                <i class="fa fa-check-square-o"></i>
              </button>
            </form>
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

<?php /*
<div class="modal fade bs-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form method="POST" action="<?=base_url().'snba/reports/maker'?>">
        <div class="modal-body">
          <p class="text-justify">
            Apa Anda yakin untuk membuat Berita Acara atas <b><?=''?></b>
            transaksi selama periode <b><?=''?></b> sejumlah <b>Rp. <?=number_format($amountPKS,'0',',','.')?></b> ?
          </p>
          <input type="hidden" name="inputQtrxID" value="<?=$qtrx_id?>">
          <input type="hidden" name="inputPID" value="<?=$partner->partner_id?>">
          <input type="hidden" name="inputService" value="<?=$partner->ul_id?>">
          <input type="hidden" name="inputPeriode" value="<?=$period?>">
          <input type="hidden" name="inputPKS" value="<?=$partner->pks_id?>">
          <input type="hidden" name="inputAmount" value="<?=$amount?>">
          <input type="hidden" name="inputAmountPKS" value="<?=$amountPKS?>">
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
</div> */?>