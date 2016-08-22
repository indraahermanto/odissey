<?php
  $dateBody   = "Hari ini <b>".$this->convnumber->now('l','')."</b> Tanggal <b>".$this->convnumber->now('d','')."</b> Bulan ";
  $dateBody  .= "<b>".$this->convnumber->now('F','')."</b> Tahun <b>".$this->convnumber->now('Y','')."</b>,";
  $telkom_share = $amount*($partner->pks_telkom_share/100);
  $mitra_share  = $amount*($partner->pks_mitra_share/100);
  $total        = $amount-$telkom_share;
  $hasil      = "<b><ol><li>Hasil transaksi ".strtoupper($partner->name)." untuk periode ".$dateFrom." sampai ".$dateTo." sejumlah Rp. "
                .number_format($amount, 0, ',', '.').",- (".$this->convnumber->terbilang($amount)." Rupiah) dengan rincian transaksi terlampir dibawah.</li>";
  $hasil     .= "<table class='table table-bordered table-stripped'>";
  $hasil     .= "<tr><td class='vert-align text-center' rowspan='2'>Nama Publisher</td>";
  $hasil     .= "<td colspan='2' class='text-center'>Penjualan</td><td colspan='2' class='text-center'>Share</td></tr>";
  $hasil     .= "<tr><td class='text-center' style='max-width:75px'>Total Penjualan</td><td class='text-center'>Rupiah</td>";
  $hasil     .= "<td class='text-center'>Telkom $partner->pks_telkom_share%</td><td class='text-center'>Mitra $partner->pks_mitra_share%</td></tr>";
  $hasil     .= "<tr><td class='text-center'>".strtoupper($partner->partner_name)."</td>";
  $hasil     .= "<td class='text-center'>".number_format(substr_count($qtrx_id, ','), 0, ',', '.')."</td>";
  $hasil     .= "<td class='text-center'>".number_format($amount, 0, ',', '.')."</td>";
  $hasil     .= "<td class='text-center'>".number_format($telkom_share, 0, ',', '.')."</td>";
  $hasil     .= "<td class='text-center'>".number_format($mitra_share, 0, ',', '.')."</td>";
  $hasil     .= "</table>";
  $hasil     .= "<li>".ucwords($partner->partner_name)." menerbitkan tagihan kepada Telkom sejumlah Rp. ".number_format($amountPKS, 0, ',', '.')
                .",- (".$this->convnumber->terbilang($amountPKS)."  Rupiah), belum termasuk PPn 10%.<br/>"
                ."<u>Sesuai dengan Dokumen Perjanjian Kerja Sama No. $partner->pks_number</u></li></ol></b>";
?>
<div class="row">
  <div class="col-sm-12">
    <div class="box box-primary">
      <div class="row">
        <div class="col-xs-12 text-center">
          <h3>BERITA ACARA SETTLEMENT</h3>
          <h4>LAYANAN <?=strtoupper($partner->name)?></h4>
          <?="<h5>Antara PT Telekomunikasi Indonesia, Tbk dengan ".ucwords($partner->partner_name)."</h5>"?>
          <h5>Nomor: .................................</h5>
          <h5>Tanggal: <?=$this->convnumber->now('d F Y','')?></h5>
        </div>
        <div class="col-xs-10 col-xs-offset-1">
          <hr style="height:3px; background-color: #000">
        </div>
        <div class="col-xs-8 col-xs-offset-2">
          <div class="row text-justify">
            <p>
              <?="Pada Hari ini $dateBody dilaksanakan rekonsiliasi data layanan ".ucwords($partner->name)." antara ".''." dengan Telkom dengan hasil sebagai berikut:"?>
            </p>
            <p><?=$hasil?></p>

            <p>
              Demikian Berita Acara ini dibuat untuk digunakan sebagai dasar pembayaran oleh Telkom kepada <?=ucwords($partner->partner_name)?> dan apabila dikemudian hari ditemukan kekeliruan dalam perhitungan data ini, maka akan dilakukan perbaikan pada settlement berikutnya.
            </p>
          </div>
          <br/><br/><br/><br/><br/>
          <div class="row">
            <div class='col-xs-6 text-center'>
              <p>PT TELEKOMUNIKASI INDONESIA</p>
              <br/><br/><br/>
              <u class='text-underline'><?=ucwords($mgr_st->first_name." ".$mgr_st->last_name)?></u>
              <p><?=ucwords("Mgr. Settlement & Business Analyst")?></p>
            </div>

            <div class='col-xs-6 text-center'>
              <p><?=strtoupper($partner->partner_name)?></p>
              <br/><br/><br/>
              <u class='text-underline'><?=strtoupper($partner->first_name." ".$partner->last_name)?></u>
            </div>
            <br/><br/>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12"><hr/></div>
        </div>
        <div class="col-xs-12">
          <div class="col-md-4 col-md-offset-7 pull-right">
            <input type="button" class="btn btn-flat btn-default btn-show-order" value="Show Detail Transaction">
            <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target=".bs-modal">
              Create &nbsp;
              <i class="fa fa-check-square-o"></i>
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12"><hr/></div>
        </div>
      </div>
      <!-- <div class="row">
        <div class="col-xs-12">
          <div class="col-xs-10 col-xs-offset-1">
            [Document History]
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12"><hr/></div>
        </div>
      </div> -->
      
      <!-- Tabel transaksi -->
      <div class="row tableTrxReport">
        <div class="col-xs-12">
          <div class="col-xs-10 col-xs-offset-1">
            List of Transaction: <br/>
            <table class='table table-bordered table-stripped'>
              <thead>
                <th class='text-center'>No.</th>
                <th class='text-center'>Order ID</th>
                <th class='text-center'>Book Name</th>
                <th class='text-center'>Amount</th>
              </thead>
              <tbody>
                <?php 
                $subtotal = 0;
                foreach ($orders as $key_o => $order) { 
                  if(isset($order[0])){
                ?>
                  <tr>
                    <td class="text-center"><?=$key_o+1?></td>
                    <td class="text-center"><?=$order[0]->qtrx_oid?></td>
                    <td><?=$order[0]->qtrx_book_name?></td>
                    <td class="text-right"><?=number_format($order[0]->qtrx_price, 0, ',' ,'.')?></td>
                  </tr>  
                <?php 
                    $subtotal += $order[0]->qtrx_price;
                    }
                  }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3" class="text-center">Total Amount</th>
                  <th class="text-right"><?=number_format($subtotal, 0, ',' ,'.')?></th>
                </tr>
                <tr>
                  <th colspan="3" class="text-center">Share Telkom, <?=$partner->pks_telkom_share."%"?></th>
                  <th class="text-right"><?=number_format($telkom_share, 0, ',' ,'.')?></th>
                </tr>
                <tr>
                  <th colspan="3" class="text-center">Share Mitra, <?=$partner->pks_mitra_share."%"?></th>
                  <th class="text-right"><?=number_format($total, 0, ',' ,'.')?></th>
                </tr>
                <?php /*
                <tr>
                  <th colspan="3" class="text-center">Subtotal</th>
                  <th class="text-right"><?=number_format($subtotal, 0, ',' ,'.')?></th>
                </tr>
                <tr>
                  <th colspan="3" class="text-center">Share Telkom, <?=$partner->pks_telkom_share."%"?></th>
                  <th class="text-right"><?=number_format($telkom_share, 0, ',' ,'.')?></th>
                </tr>
                <tr>
                  <th colspan="3" class="text-center">Grand Total</th>
                  <th class="text-right"><?=number_format($total, 0, ',' ,'.')?></th>
                </tr>*/ ?>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form method="POST" action="<?=base_url().'snba/reports/maker'?>">
        <div class="modal-body">
          <p class="text-justify">
            Apa Anda yakin untuk membuat Berita Acara atas <b><?=''?></b>
            transaksi selama periode <b><?=$dateFrom." sampai ".$dateTo?></b> sejumlah <b>Rp. <?=number_format($amountPKS,'0',',','.')?></b> ?
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
            <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">No</button>
            <button class="btn btn-flat btn-primary" data-toggle="modal">
              <i class="fa fa-check"></i> Yes
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>