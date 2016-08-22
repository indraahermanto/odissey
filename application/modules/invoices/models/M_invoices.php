<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_invoices extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->load->model(array(
    		'main/M_main', 'partner/M_partner'
    	));
    $this->partner 	= $this->M_partner->getMe($this->session->userdata('email'));
  }

  function makeInvoice($ba_id, $service_id, $amount, $file, $rekening){
  	$number = $this->M_main->getLastDoc('od_inv_doc', 'inv_id', $service_id, 'INV');

  	$moveFP = 1;
    if($file != ""){
      $move     = str_replace(base_url(), '', $file);
      $file     = explode('/', str_replace(".pdf", "", $move));
      $newPath  = 'uploads/faktur-pajak-invoice/';
      $newName  = sha1($this->config->item('salt').$file[2]).'.pdf';
      if(copy($move, $newPath.$newName)){
        unlink($move);
        $moveFP = 1;
      }
    }else $moveFP = 0;
    
  	$data	= array(
  						'number' 			=> $number, 				'partner_id' 	=> $this->partner->partner_id,
  						'ul_id'				=> $service_id,			'inv_amount'	=> $amount,
  						'pbank_id' 		=> $rekening,				'inv_file'		=> $newName,
  						'inv_status'	=> 'mak'
						);
  	if($this->db->insert('od_inv_doc', $data)){
  		logger('makeInvoice', implode('; ', $data));
  		$invoice = $this->M_main->getLastRow('od_inv_doc', 'inv_id');
      docLog($invoice->inv_id, 'invoice', 'mak');
      $this->addInvoiceMod($ba_id, $invoice->inv_id);
  		return true;
  	}else{
  		logger('mak', implode('; ', $data));
  		return show_error('Error: makeInvoice Fail. <br/>Something Wrong, please contact administrator.');
  	}
  }

  function addInvoiceMod($ba_id, $inv_id){
  	$data 	= array('ba_id' => $ba_id, 'inv_id' => $inv_id);
  	$input 	= $this->db->insert('od_inv_mod', $data);
  	logger('addInvMod', implode('; ', $data));
  	return true;
  }

  function getInvoiceLimit($row, $limit, $search){
    $len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len)); // ?status=&partner=&date=&key=
    $searchA    = explode('=', strtolower($subSearch[0])); // 
    // $searchB    = explode('=', $subSearch[1]);
    $searchC    = explode('=', $subSearch[1]);
    $data       = array();
    $data['a.partner_id'] = $this->partner->partner_id;
    // if(isset($subSearch[2])){
    //   // echo $subSearch[2];
    //   $searchC  = explode('=', strtolower($subSearch[2]));
    //   $data['ba_type'] = $searchC[1];
    // }
    //echo $searchA[1];
    if($searchC[1] != ""){
      // $data['ba_periode'] = $searchB[1];
      $dateRange = explode(' - ', $searchC[1]);
      $data['a.inv_created >='] = date('Y/m/d 00:00:00', strtotime($dateRange[0]));;
      $data['a.inv_created <='] = date('Y/m/d 23:59:59', strtotime($dateRange[1]));;
    }
    if($searchA[1] != "" && $searchA[1] != 'all')
      $data['a.inv_status']  = $searchA[1];
    // if($searchB[1] != '')
    //   $data['a.partner_id'] = $searchB[1];

    $this->db->select('*, a.number as inv_number, f.number as ba_number')
              ->join('od_inv_stat as b', 'a.inv_status=b.stat_id')
              ->join('od_user_level as c', 'a.ul_id=c.id')
              ->join('od_partner as d', 'a.partner_id=d.partner_id')
              ->join('od_inv_mod as e', 'a.inv_id=e.inv_id')
              ->join('od_ba_doc as f', 'e.ba_id=f.ba_id')
              ->order_by('a.inv_id', 'DESC');
    $getData  = $this->db->get_where('od_inv_doc as a', $data, $limit, $row);
    return $getData->result();
  }

  function getInvoice($id){
    $data = array(
              'a.inv_id' => $id, 'c.status' => 1
            );

    $getData = $this->db->select('*, a.number as inv_number, f.number as ba_number')
                        ->join('od_inv_stat as b', 'a.inv_status=b.stat_id')
                        ->join('od_user_level as c', 'a.ul_id=c.id')
                        ->join('od_partner as d', 'a.partner_id=d.partner_id')
                        ->join('od_inv_mod as e', 'a.inv_id=e.inv_id')
                        ->join('od_ba_doc as f', 'e.ba_id=f.ba_id')
                        ->join('od_partner_bank as g', 'a.partner_id=g.partner_id')
                        ->join('od_partner_mod as h', 'a.partner_id=h.partner_id')
                        ->join('od_user as i', 'h.user_id=i.id')
                        ->order_by('a.inv_id', 'DESC')
                        ->get_where('od_inv_doc as a', $data);
    return $getData->row();
  }

  function updateInvoice($invoice, $act, $file){
    $moveFP = 1;
    if($file != ""){
      $move     = str_replace(base_url(), '', $file);
      $file     = explode('/', str_replace(".pdf", "", $move));
      $newPath  = 'uploads/faktur-pajak-invoice/';
      $newName  = sha1($this->config->item('salt').$file[2]).'.pdf';
      if(copy($move, $newPath.$newName)){
        // rename('uploads/faktur-pajak-invoice/', newname);
        unlink($move);
        $moveFP = 1;
      }
    }else $moveFP = 0;

    $data   = array('inv_status' => $act, 'inv_file' => $newName);
    $this->db->where('inv_id', $invoice->inv_id);

    $submit = $this->db->update('od_inv_doc', $data);
    if($submit){
      logger($act.'Invoice', implode('; ', $data));
      docLog($invoice->inv_id, 'invoice', $act);
      return true;
    }else{
      logger($act.'InvoiceFail', implode('; ', $data));
      return show_error("Error: ".$act."Invoice Fail. <br/>Something Wrong, please contact administrator.");
    }
  }
}