<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_reports extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->load->model(array(
    		'main/M_main', 'partner/snba/M_partner'
    	));
  }

  function getReport($id){ // double function
    $data = array(
              'a.ba_id' => $id, 'g.dlog_type' => 'report'
            );

    $getData = $this->db->join('od_ba_stat as b', 'a.ba_status=b.stat_id')
                        ->join('od_partner as c', 'a.partner_id=c.partner_id')
                        ->join('od_user_level as d', 'a.ul_id=d.id')
                        ->join('od_partner_mod as e', 'a.partner_id=e.partner_id')
                        ->join('od_user as f', 'e.user_id=f.id')
                        ->join('od_doc_log as g', 'a.ba_id=g.dlog_doc_id')
                        ->get_where('od_ba_doc as a', $data);
    return $getData->row();
  }

  function makeReport($qtrx_id, $partner_id, $service_id, $period, $amount, $amountPKS, $pks_id){
  	$this->load->model('qbaca/snba/M_qbaca');
  	// $table, $field, $service_name, $doc_code
  	$qtrx = explode(',', $qtrx_id);
  	$report_number = $this->M_main->getLastDoc('od_ba_doc', 'ba_id', $service_id, 'BA');
  	$data	= array(
  						'number' 		=> $report_number, 	'partner_id' 	=> $partner_id,
  						'ul_id'			=> $service_id,			'ba_periode' 	=> $period,
  						'ba_amount'	=> $amount,					'ba_amount_pks' => $amountPKS,
              'ba_status'		=> 'mak'
						);
  	if($this->db->insert('od_ba_doc', $data)){
  		logger('makeReport', implode('; ', $data));
  		$report = $this->M_main->getLastRow('od_ba_doc', 'ba_id');
      $this->M_partner->insertPKSMod($report->ba_id, $pks_id);
      docLog($report->ba_id, 'report', 'mak');
  		foreach ($qtrx as $valQ) {
  			if($valQ != ""){
  				$this->addReportMod($valQ, $report->ba_id);
  				$this->M_qbaca->updateOrder($valQ, '1');
  			}
  		}
  		return true;
  	}else{
  		logger('makeReportFail', implode('; ', $data));
  		return show_error('Error: makeReport Fail. <br/>Something Wrong, please contact administrator.');
  	}
  }

  function addReportMod($qtrx_id, $report_id){
  	$data = array('qtrx_id' => $qtrx_id, 'ba_id' => $report_id);
  	if($this->db->insert('od_ba_mod', $data)){
  		logger('addReportMod', implode('; ', $data));
  	}
  }

  function updateReport($report, $act){
    $data   = array('ba_status' => $act);
    $this->db->where('ba_id', $report->ba_id);
    $submit = $this->db->update('od_ba_doc', $data);
    if($submit){
      logger($act.'Report', implode('; ', $data));
      docLog($report->ba_id, 'report', $act);
      return true;
    }else{
      logger($act.'ReportFail', implode('; ', $data));
      return show_error("Error: ".$act." Fail. <br/>Something Wrong, please contact administrator.");
    }
  }

  function getReportLimit($row, $limit, $search){
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
      $data['a.ba_created >='] = date('Y/m/d 00:00:00', strtotime($dateRange[0]));;
      $data['a.ba_created <='] = date('Y/m/d 23:59:59', strtotime($dateRange[1]));;
    }
    if($searchA[1] != "" && $searchA[1] != 'all')
      $data['a.ba_status']  = $searchA[1];
    if($searchB[1] != '')
      $data['a.partner_id'] = $searchB[1];

    $this->db->join('od_ba_stat as b', 'a.ba_status=b.stat_id')
              ->join('od_user_level as c', 'a.ul_id=c.id')
              ->join('od_partner as d', 'a.partner_id=d.partner_id')
              ->order_by('ba_id', 'DESC');
    $getData  = $this->db->get_where('od_ba_doc as a', $data, $limit, $row);
    return $getData->result();
  }

  function getReportTotal($search){
    $len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len)); // ?status=&partner=&date=&key=
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
      $data['a.ba_created >='] = date('Y/m/d 00:00:00', strtotime($dateRange[0]));;
      $data['a.ba_created <='] = date('Y/m/d 23:59:59', strtotime($dateRange[1]));;
    }
    if($searchA[1] != "" && $searchA[1] != 'all')
      $data['a.ba_status']  = $searchA[1];
    if($searchB[1] != '')
      $data['a.partner_id'] = $searchB[1];

    $this->db->join('od_ba_stat as b', 'a.ba_status=b.stat_id')
              ->join('od_user_level as c', 'a.ul_id=c.id')
              ->join('od_partner as d', 'a.partner_id=d.partner_id')
              ->order_by('ba_id', 'DESC');
    $getData  = $this->db->get_where('od_ba_doc as a', $data);
    return $getData->num_rows();
  }
}