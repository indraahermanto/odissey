<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_reports extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->load->model(array(
    		'main/M_main', 'partner/M_partner'
    	));
  }

  function getReport($id){
  	$data = array(
  						'a.ba_id' => $id
  					);

  	$getData = $this->db->join('od_ba_stat as b', 'a.ba_status=b.stat_id')
  											->join('od_partner as c', 'a.partner_id=c.partner_id')
  											->join('od_user_level as d', 'a.ul_id=d.id')
  											->join('od_partner_mod as e', 'a.partner_id=e.partner_id')
  											->join('od_user as f', 'e.user_id=f.id')
  											->get_where('od_ba_doc as a', $data);
  	return $getData->row();
  }

  function getReportTotal($search){
    $len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len)); // ?status=&partner=&date=&key=
    $searchA    = explode('=', strtolower($subSearch[0])); // 
    // $searchB    = explode('=', $subSearch[1]);
    $searchC    = explode('=', $subSearch[1]);
    $getMe      = $this->M_partner->getMe($this->session->userdata('email'));
    $data       = array();
    $data['a.partner_id'] = $getMe->partner_id;
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
    // if($searchB[1] != '')
      // $data['a.partner_id'] = $getMe->partner_id;

    $this->db->join('od_ba_stat as b', 'a.ba_status=b.stat_id')
              ->join('od_user_level as c', 'a.ul_id=c.id')
              ->join('od_partner as d', 'a.partner_id=d.partner_id')
              ->not_like('a.ba_status', 'can')
              ->not_like('a.ba_status', 'mak')
              ->order_by('ba_id', 'DESC');
    $getData  = $this->db->get_where('od_ba_doc as a', $data);
    return $getData->num_rows();
  }

  function getReportLimit($row, $limit, $search){
    $len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len)); // ?status=&partner=&date=&key=
    $searchA    = explode('=', strtolower($subSearch[0])); // 
    // $searchB    = explode('=', $subSearch[1]);
    $searchC    = explode('=', $subSearch[1]);
    $getMe      = $this->M_partner->getMe($this->session->userdata('email'));
    $data       = array();
    $data['a.partner_id'] = $getMe->partner_id;
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
    // if($searchB[1] != '')
    //   $data['a.partner_id'] = $searchB[1];

    $this->db->join('od_ba_stat as b', 'a.ba_status=b.stat_id')
              ->join('od_user_level as c', 'a.ul_id=c.id')
              ->join('od_partner as d', 'a.partner_id=d.partner_id')
              ->not_like('a.ba_status', 'can')
              ->not_like('a.ba_status', 'mak')
              ->order_by('ba_id', 'DESC');
    $getData  = $this->db->get_where('od_ba_doc as a', $data, $limit, $row);
    return $getData->result();
  }
}