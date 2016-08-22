<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_spb extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->load->model(array(
    		'main/M_main', 'partner/snba/M_partner'
    	));
  }

  function getSPBLimit($row, $limit, $search){
    $len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len));  // ?status=&partner=&date=&key=
    $searchA    = explode('=', strtolower($subSearch[0])); // 
    $searchB    = explode('=', $subSearch[1]);
    $searchC    = explode('=', $subSearch[2]);
    $searchD    = explode('=', $subSearch[3]);
    $data       = array();
    // if(isset($subSearch[2])){
    //   // echo $subSearch[2];
    //   $searchC  = explode('=', strtolower($subSearch[2]));
    //   $data['ba_type'] = $searchC[1];
    // }
    //echo $searchA[1];
    if($searchC[1] != ""){
      // $data['ba_periode'] = $searchB[1];
      $dateRange = explode(' - ', $searchC[1]);
      $data['a.spb_created >='] = date('Y/m/d 00:00:00', strtotime($dateRange[0]));;
      $data['a.spb_created <='] = date('Y/m/d 23:59:59', strtotime($dateRange[1]));;
    }
    if($searchD[1] != "" && $searchA[1] == 'app')
      $data['g.pbank_name'] = $searchD[1];
    if($searchA[1] != "" && $searchA[1] != 'all')
      $data['a.spb_status']  = $searchA[1];
    if($searchB[1] != '')
      $data['a.partner_id'] = $searchB[1];

    $this->db->select('*, a.number as spb_number, f.number as inv_number')
              ->join('od_spb_stat as b', 'a.spb_status=b.stat_id')
              ->join('od_user_level as c', 'a.ul_id=c.id')
              ->join('od_partner as d', 'a.partner_id=d.partner_id')
              ->join('od_spb_mod as e', 'a.spb_id=e.spb_id')
              ->join('od_inv_doc as f', 'e.inv_id=f.inv_id')
              ->join('od_partner_bank as g', 'f.pbank_id=g.pbank_id')
              ->order_by('a.spb_id', 'DESC');
    $getData  = $this->db->get_where('od_spb_doc as a', $data, $limit, $row);
    return $getData->result();
  }

  function getSPBTotal($search){
  	$len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len));  // ?status=&partner=&date=&key=
    $searchA    = explode('=', strtolower($subSearch[0])); // 
    $searchB    = explode('=', $subSearch[1]);
    $searchC    = explode('=', $subSearch[2]);
    $data = array();
    // if(isset($subSearch[2])){
    //   // echo $subSearch[2];
    //   $searchC  = explode('=', strtolower($subSearch[2]));
    //   $data['ba_type'] = $searchC[1];
    // }
    //echo $searchA[1];
    if($searchC[1] != ""){
      // $data['ba_periode'] = $searchB[1];
      $dateRange = explode(' - ', $searchC[1]);
      $data['a.spb_created >='] = date('Y/m/d 00:00:00', strtotime($dateRange[0]));;
      $data['a.spb_created <='] = date('Y/m/d 23:59:59', strtotime($dateRange[1]));;
    }
    if($searchA[1] != "" && $searchA[1] != 'all')
      $data['a.spb_status']  = $searchA[1];
    if($searchB[1] != '')
      $data['a.partner_id'] = $searchB[1];

    $this->db->join('od_spb_stat as b', 'a.spb_status=b.stat_id')
              ->join('od_user_level as c', 'a.ul_id=c.id')
              ->join('od_partner as d', 'a.partner_id=d.partner_id')
              ->order_by('spb_id', 'DESC');
    $getData  = $this->db->get_where('od_spb_doc as a', $data);
    return $getData->num_rows();
  }

  function makeSPB($invoice){
  	$number = $this->M_main->getLastDoc('od_spb_doc', 'spb_id', $invoice->ul_id, 'SPB');

  	$data	= array(
  						'number' 			=> $number, 				'partner_id' 	=> $invoice->partner_id,
  						'ul_id'				=> $invoice->ul_id,	'spb_amount'	=> $invoice->inv_amount,
  						'spb_status'	=> 'mak'
						);
  	if($this->db->insert('od_spb_doc', $data)){
  		logger('makeSPB', implode('; ', $data));
  		$spb = $this->M_main->getLastRow('od_spb_doc', 'spb_id');
      docLog($spb->spb_id, 'spb', 'mak');
      $this->addSPBMod($invoice->inv_id, $spb->spb_id);
  		return true;
  	}else{
  		logger('makeInvoiceFail', implode('; ', $data));
  		return show_error('Error: makeInvoice Fail. <br/>Something Wrong, please contact administrator.');
  	}
  }

  function addSPBMod($inv_id, $spb_id){
  	$data = array('inv_id' => $inv_id, 'spb_id' => $spb_id);
  	$this->db->insert('od_spb_mod', $data);
  	return true;
  }

  function updateSPB($spb, $act, $file=null){
    $data   = array('spb_status' => $act);
    if($file != null){
      $data['spb_file'] = $file;
    }
    $this->db->where('spb_id', $spb->spb_id);
    $update = $this->db->update('od_spb_doc', $data);
    if($update){
      logger($act.'SPB', implode('; ', $data));
      docLog($spb->spb_id, 'spb', $act);
      return true;
    }else{
      logger($act.'SPBFail', implode('; ', $data));
      return show_error("Error: ".$act."SPB Fail. <br/>Something Wrong, please contact administrator.");
    }
  }
}