<?php
class M_qbaca extends CI_Model {
  function __construct(){
    parent::__construct();
    // $this->load->model('AntiInject');
    $this->load->helper('converter');
  }

  function getDataOrdersLimit($row, $limit, $search){
    // ?f=settle&p=Whqo&date=&key=
    $data['b.partner_status'] = '1';
    $search   = explode('&', $search);
    $searchA  = explode('=', $search[0]);
    
    // status rekon
    if(isset($searchA[1])){
      switch ($searchA[1]) {
        case 'pending': $sRekon='0'; break;
        case 'settle' : $sRekon='1'; break;
        default       : $sRekon='' ; break;
      }
      if($sRekon != '')
        $data['qtrx_stat_rekon'] = $sRekon;
      // else {
      //   $data['qtrx_stat_rekon <='] = 2;
      // }
    }

    // partner id
    $searchB  = explode('=', $search[1]);
    if(isset($searchB[1]) && $searchB[1] != ""){
      $data['a.partner_id'] = $searchB[1];
    }

    // date from - to
    $searchC  = explode('=', $search[2]);
    if(isset($searchC[1]) && $searchC[1] != ""){
      $searchDate   = explode(" - ", $searchC[1]);
      $from         = toDateDB($searchDate[0]);
      $to           = toDateDB($searchDate[1]);
      $data['qtrx_date >= '] = $from;
      $data['qtrx_date <= '] = $to;
    }

    // $searchD = explode('=', $search[3]);
    // if(isset($searchD[1]) && $searchD[1] != ""){
    //   $this->db->like('qtrx_cus_email', $searchD[1]);
    //   $this->db->or_like('qtrx_book_name', $searchD[1]);
    // }

    $this->db->join('od_partner AS b', 'a.partner_id = b.partner_id')->order_by('a.qtrx_date', 'DESC');
    $getData = $this->db->get_where('od_qbaca_trx AS a', $data, $limit, $row);

    return $getData->result();
  }

  function getDataOrdersTotal($search){
    // ?f=settle&p=Whqo&date=&key=
    // echo $search;
    $data['b.partner_status'] = '1';
    $search   = explode('&', $search);
    $searchA  = explode('=', $search[0]);
    
    // status rekon
    if(isset($searchA[1])){
      switch ($searchA[1]) {
        case 'pending': $sRekon='0'; break;
        case 'settle' : $sRekon='1'; break;
        default       : $sRekon='' ; break;
      }
      if($sRekon != '')
        $data['qtrx_stat_rekon'] = $sRekon;
      // else {
      //   $data['qtrx_stat_rekon <='] = 2;
      // }
    }

    // partner id
    $searchB  = explode('=', $search[1]);
    if(isset($searchB[1]) && $searchB[1] != ""){
      $data['a.partner_id'] = $searchB[1];
    }

    // date from - to
    $searchC  = explode('=', $search[2]);
    if(isset($searchC[1]) && $searchC[1] != ""){
      $searchDate   = explode(" - ", $searchC[1]);
      $from         = toDateDB($searchDate[0]);
      $to           = toDateDB($searchDate[1]);
      $data['qtrx_date >= '] = $from;
      $data['qtrx_date <= '] = $to;
    }

    // $searchD = explode('=', $search[3]);
    // if(isset($searchD[1]) && $searchD[1] != ""){
    //   $this->db->like('qtrx_cus_email', $searchD[1]);
    //   $this->db->or_like('qtrx_book_name', $searchD[1]);
    // }

    $this->db->join('od_partner AS b', 'a.partner_id = b.partner_id')->order_by('a.qtrx_date', 'DESC');
    $getData = $this->db->get_where('od_qbaca_trx AS a', $data);

    return $getData->num_rows();
  }

  function updateOrder($qtrx_id, $status){
    $data = array('qtrx_stat_rekon' => $status);

    $this->db->where('qtrx_id', $qtrx_id);
    $this->db->update('od_qbaca_trx', $data);
  }
}