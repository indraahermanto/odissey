<?php
class M_qbaca extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->load->model('partner/M_partner');
    // $this->load->helper('string');
    $this->load->helper('converter');
  }

  function getDataOrdersLimit($row, $limit, $search){
    // ?f=settle&date=&key=
    $getMe = $this->M_partner->getMe($this->session->userdata('email'));
    $data['b.partner_status'] = '1';
    $data['a.partner_id']     = $getMe->partner_id;

    $search   = explode('&', $search);
    $searchA  = explode('=', $search[0]);
    $searchC  = explode('=', $search[1]);
    
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
    // $searchB  = explode('=', $search[1]);
    // if(isset($searchB[1]) && $searchB[1] != ""){
    //   $data['a.partner_id'] = $searchB[1];
    // }

    // date from - to
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
    $getMe = $this->M_partner->getMe($this->session->userdata('email'));
    $data['b.partner_status'] = '1';
    $data['a.partner_id']     = $getMe->partner_id;
    
    $search   = explode('&', $search);
    $searchA  = explode('=', $search[0]);
    $searchC  = explode('=', $search[1]);
    
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
    // $searchB  = explode('=', $search[1]);
    // if(isset($searchB[1]) && $searchB[1] != ""){
    //   $data['a.partner_id'] = $searchB[1];
    // }

    // date from - to
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

  function getPeriode($orders_id){
    $dateAw = "";
    $dateAk = "";
    foreach ($orders_id as $order) {
      if($order != ""){
        $db   = $this->db->get_where('od_qbaca_trx', array('qtrx_id' => $order),1,0)->row();
        $date = strtotime($db->qtrx_date);
        if($dateAw == "" && $dateAk == "" ){
          $dateAw = $date; $dateAk = $date;
        }else{
          if($date != "" && $date < $dateAw){
            $dateAw = $date;
          }
          if($date != "" && $date > $dateAk)
            $dateAk = $date;
        }
      }
    }
    return date('Y-m-d', $dateAw)." - ".date('Y-m-d', $dateAk);
  }
}