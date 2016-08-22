<?php
	$period 	= explode(' - ', $report->ba_periode);
  $telkom_share = $report->ba_amount*($partner->pks_telkom_share/100);
  $mitra_share  = $report->ba_amount*($partner->pks_mitra_share/100);
  $total        = $report->ba_amount-$telkom_share;

  $dateBody   = "Hari ini <b>".$this->convnumber->indonesian_date(strtotime($report->ba_created), 'l','')."</b> Tanggal <b>";
  $dateBody	 .= $this->convnumber->indonesian_date(strtotime($report->ba_created), 'd','')."</b> Bulan ";
  $dateBody  .= "<b>".$this->convnumber->indonesian_date(strtotime($report->ba_created), 'F','')."</b> Tahun <b>";
 	$dateBody	 .= $this->convnumber->indonesian_date(strtotime($report->ba_created), 'Y','')."</b>,";
  $hasil      = "<b><ol><li>Hasil transaksi ".strtoupper($report->name)." untuk periode "
                .$this->convnumber->indonesian_date(strtotime($period[0]), 'd F Y', '')." sampai "
                .$this->convnumber->indonesian_date(strtotime($period[1]), 'd F Y', '')." sejumlah Rp. ";
  $hasil 		 .= number_format($report->ba_amount, 0, ',', '.').",- ("
  							.$this->convnumber->terbilang($report->ba_amount)." Rupiah) dengan rincian transaksi terlampir dibawah.</li>";
                
  $hasil     .= "<table class='table table-bordered table-stripped'>";
  $hasil     .= "<tr><td class='vert-align text-center' rowspan='2'>Nama Publisher</td>";
  $hasil     .= "<td colspan='2' class='text-center'>Penjualan</td><td colspan='2' class='text-center'>Share</td></tr>";
  $hasil     .= "<tr><td class='text-center' style='max-width:75px'>Total</td><td class='text-center'>Rupiah</td>";
  $hasil     .= "<td class='text-center'>Telkom $partner->pks_telkom_share%</td><td class='text-center'>Mitra $partner->pks_mitra_share%</td></tr>";
  $hasil     .= "<tr><td class='text-center'>".strtoupper($partner->partner_name)."</td>";
  $hasil     .= "<td class='text-center'>".number_format(substr_count($qtrx_id, ','), 0, ',', '.')."</td>";
  $hasil     .= "<td class='text-center'>".number_format($report->ba_amount, 0, ',', '.')."</td>";
  $hasil     .= "<td class='text-center'>".number_format($telkom_share, 0, ',', '.')."</td>";
  $hasil     .= "<td class='text-center'>".number_format($mitra_share, 0, ',', '.')."</td>";
  $hasil     .= "</table>";

  $hasil     .= "<li>".ucwords($report->partner_name)." menerbitkan tagihan kepada Telkom sejumlah Rp. "
  							.number_format($report->ba_amount_pks, 0, ',', '.')
                .",- (".$this->convnumber->terbilang($report->ba_amount_pks)." Rupiah), belum termasuk PPn 10%.</li></ol></b>";
?>
<div class="row">
  <div class="col-sm-12">
    <div class="box box-primary">
      <div class="row">
        <div class="col-xs-12 text-center">
          <h3>BERITA ACARA SETTLEMENT</h3>
          <h4>LAYANAN <?=strtoupper($report->name)?></h4>
          <?="<h5>Antara PT Telekomunikasi Indonesia, Tbk dengan ".ucwords($report->partner_name)."</h5>"?>
          <h5>Nomor: <?=$report->number?></h5>
          <h5>Tanggal: <?=$this->convnumber->indonesian_date(strtotime($report->ba_created), 'd F Y','')?></h5>
        </div>
        <div class="col-xs-10 col-xs-offset-1">
          <hr style="height:3px; background-color: #000">
        </div>
        <div class="col-xs-8 col-xs-offset-2">
          <div class="row text-justify">
            <p>
              <?="Pada Hari ini $dateBody dilaksanakan rekonsiliasi data layanan ".ucwords($report->name)." antara ".''." dengan Telkom dengan hasil sebagai berikut:"?>
            </p>
            <p><?=$hasil?></p>

            <p>
              Demikian Berita Acara ini dibuat untuk digunakan sebagai dasar pembayaran oleh Telkom kepada <?=ucwords($report->partner_name)?> dan apabila dikemudian hari ditemukan kekeliruan dalam perhitungan data ini, maka akan dilakukan perbaikan pada settlement berikutnya.
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
              <p><?=strtoupper($report->partner_name)?></p>
              <br/><br/><br/>
              <u class='text-underline'><?=ucwords($report->first_name." ".$report->last_name)?></u>
              <br/><br/>
            </div>
            <br/><br/>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12"><hr/></div>
        </div>
        <div class="col-xs-12">
          <div class="col-md-1">
            <a href="<?=base_url().$url[1].'/view_pdf/reports/'.$url[4]?>" class="btn btn-default btn-flat">View As PDF</a>
          </div>
          <div class="col-md-4 col-md-offset-6 pull-right">
            <input type="button" class="btn btn-flat btn-default btn-show-order" value="Show Detail Transaction">
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
                <li><?=$this->notifier->report_log($log->dlog_action, $log->dlog_user_id, $this->convnumber->indonesian_date(strtotime($log->dlog_time), 'd F Y H:i:s', ''))?></li>
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
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <!-- <div class="row">
        <div class="col-xs-12">
          <div class="col-xs-10 col-xs-offset-1">
            <table class="table table-bordered">
              <thead>
                <th>a</th>
                <th>a</th>
                <th>a</th>
                <th>a</th>
              </thead>
            </table>
          </div>
        </div>
      </div> -->
    </div>
  </div>
</div>
<div class="modal fade bs-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form method="POST" action="<?=base_url().$url[1].'/reports/'.$url_act?>">
        <div class="modal-body">
          <p class="text-justify">
            Apa Anda <?=$act?> Berita Acara ini atas
            transaksi selama periode 
            <b>
              <?=$this->convnumber->indonesian_date(strtotime($period[0]), 'd F Y', '')
              ." sampai ".$this->convnumber->indonesian_date(strtotime($period[1]), 'd F Y', '')?>
            </b> 
            sejumlah <b>Rp. <?=number_format($report->ba_amount_pks,'0',',','.')?></b> ?
          </p>
          
          <input type="hidden" name="inputReport" value="<?=$url[4]?>">
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