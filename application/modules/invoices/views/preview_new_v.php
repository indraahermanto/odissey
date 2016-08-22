<?php

$telkom_share = $report->ba_amount*($partner->pks_telkom_share/100);
$mitra_share  = $report->ba_amount*($partner->pks_mitra_share/100);
$total        = $report->ba_amount-$telkom_share;
?>
<div class="box box-primary" style="min-height: 440px">
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
    	<h3>INVOICE</h3>
    	<br/><br/>
    	<div class='row'>
        <div class='col-xs-1'>Nomor</div>
        <div class='col-xs-1'><p class='pull-right'>:</p></div>
        <div class='col-xs-8 col-md-5'><p>.......</p></div>
      </div>

      <?php
      /*<div class='row'>
        <div class='col-xs-1'>No BA</div>
        <div class='col-xs-1'><p class='pull-right'>:</p></div>
        <div class='col-xs-8 col-md-5'><p style='word-wrap: break-word;'><?=$report->number?></p></div>
      </div>
      */
      ?>

      <div class='row'>
        <div class='col-xs-1'>Perihal</div>
        <div class='col-xs-1'><p class='pull-right'>:</p></div>
        <div class='col-xs-8 col-md-5'>
          <p style='word-wrap: break-word;'><?="Penagihan profit sharing layanan <b>".strtoupper($service)."</b> periode <b>$periode</b>"?></p>
        </div>
      </div>
    </div>
  </div><br/><br/>
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
    	<p>Kepada: </p>
    	<p>PT Telekomunikasi Indonesia</p>
    	<p>di Jakarta</p>
    </div>
  </div><br/>
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <p>Berdasarkan Berita Acara No <?="<b>".$report->number."</b>"?> kami sampaikan tagihan 
      utk layanan <?="<b>".strtoupper($service)."</b>"?> periode <?="<b>".$periode."</b> :"?> </p>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-8 col-xs-offset-2">
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <th class="text-center">No.</th>
            <th class="text-center">Report No.</th>
            <th class="text-center">Service</th>
            <th class="text-center">Amount</th>
          </thead>
          <tbody>
            <tr>
              <td class="text-center"><?=number_format(1, 0, ',', '.')?></td>
              <td class="text-center"><?=$report->number?></td>
              <td class="text-center"><?=strtoupper($service)?></td>
              <td class="text-right"><?=number_format($report->ba_amount_pks, 2, ',', '.')?></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th class="text-center" colspan="3">Sub Total</th>
              <th class="text-right"><?=number_format($report->ba_amount_pks, 2, ',', '.')?></th>
            </tr>
            <?php
            $total = $report->ba_amount_pks;
            if($report->partner_tax_stat){
              $ppn    = $total*(10/100);
              $total += $ppn;
            ?>
            <tr>
              <th class="text-center" colspan="3">PPN: 10% X Sub Total</th>
              <th class="text-right"><?=number_format($ppn, 2, ',', '.')?></th>
            </tr>
            <?php } ?>
            <tr>
              <th class="text-center" colspan="3">Total yang harus dibayarkan</th>
              <th class="text-right"><?=number_format($total, 2, ',', '.')?></th>
            </tr>
            <tr>
              <th class="text-center">Terbilang</th>
              <th class="text-center" colspan="3"><?=$this->convnumber->terbilang($total)." Rupiah."?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div><br/>
  <div class="row">
    <div class="col-xs-6 col-sm-5 col-xs-offset-1">
    	<p>Catatan:</p>
      <p class='text-justify'> Pembayaran dapat ditransfer melalui <b>BANK <?=strtoupper($partner->pbank_name)?>
      </b> No Rekening: <b><?=$partner->pbank_rekening." A.N. ".strtoupper($partner->pbank_an)?></b></p>
    </div>
  </div><br/><br/><br/>
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
    	<div class='col-xs-6 text-center'></div>

      <div class='col-xs-6 text-center'>
        <p><?=ucwords($partner->partner_city).", ".$this->convnumber->indonesian_date(strtotime('now'), 'd F Y', '')?><br/>
        <?=ucwords($partner->partner_name)?></p>
        <br/><br/><br/>
        <u class='text-underline'><?=ucwords($partner->first_name." ".$partner->last_name)?></u>
        <p>Direktur</p>
      </div>
    </div>
  </div><br/><br/><br/><br/>
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
    	<p class='text-center'><?=$partner->partner_address." ".ucwords($partner->partner_city)." Telp. ".$partner->partner_office_phone?></p>
    </div>
  </div><br/>

  <div class="row">
    <div class="col-xs-12"><hr/></div>
  </div>
  <div class="col-xs-12">
    <div class="col-md-2">
      <a target="_blank" href="<?=$file?>">Preview Faktur Pajak</a>
    </div>
    <div class="col-md-4 col-md-offset-5 pull-right">
      <input type="button" class="btn btn-flat btn-default btn-show-order" value="Show Detail Transaction">
      <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target=".bs-modal">
        Process &nbsp;
        <i class="fa fa-check-square-o"></i>
      </button>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12"><hr/></div>
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
              <th colspan="3" class="text-center">Subtotal</th>
              <th class="text-right"><?=number_format($subtotal, 0, ',' ,'.')?></th>
            </tr>
            <tr>
              <th colspan="3" class="text-center">Share Telkom, <?=$partner->pks_telkom_share."%"?></th>
              <th class="text-right"><?=number_format($telkom_share, 0, ',' ,'.')?></th>
            </tr>
            <?php
              if($report->partner_tax_stat){
                $ppn = ($total/1.1)*(10/100);
                $subtotalB = $subtotal-$telkom_share;
            ?>
            <tr>
              <th colspan="3" class="text-center">Total Sebelum Pajak</th>
              <th class="text-right"><?=number_format($subtotalB, 0, ',' ,'.')?></th>
            </tr>  
            <tr>
              <th colspan="3" class="text-center">10% PPn</th>
              <th class="text-right"><?=number_format($ppn, 0, ',' ,'.')?></th>
            </tr>  
            <?php } ?>
            <tr>
              <th colspan="3" class="text-center">Grand Total</th>
              <th class="text-right"><?=number_format($total, 0, ',' ,'.')?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form method="POST" action="<?=base_url().'partner/invoices/maker'?>">
        <input type="hidden" name="inputFileFP" value="<?=$file?>">
        <input type="hidden" name="inputService" value="<?=$report->ul_id?>">
        <input type="hidden" name="inputAmount" value="<?=$total?>">
        <input type='hidden' name='inputRek' value="<?=$partner->pbank_id?>">
        <input type="hidden" name="inputReport" value="<?=sha1($this->config->item('salt').$report->number)?>">
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
              <p class="text-justify">
                Dengan ini saya yakin dan setuju untuk membuat Invoice ini.
              </p>
            </div>
          </div>
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