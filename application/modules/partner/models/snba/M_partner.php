<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_partner extends CI_Model {
  function __construct(){
    parent::__construct();
    // $this->load->helper('converter');
  }

  function getAllPartner($id=null, $active=null){
  	$data = array('partner_status' => 1);
  	if(isset($id) && $id != "")
  		$data['partner_id'] = $id;

  	$getData = $this->db->get_where('od_partner', $data);
  	return $getData->result();
  }

  function getPartnersLimit($row, $limit, $search){
    // ?status=active&partner=Whqo&service=&key=
    // $data['b.partner_status'] = '1';
    $search   = explode('&', $search);
    $searchA  = explode('=', $search[0]);
    $data     = array();
    
    // $data['e.status'] = 1;
    // status rekon
    if(isset($searchA[1])){
      switch ($searchA[1]) {
        case 'active' : $status='1'; break;
        case 'not active' : $status='1'; break;
        default       : $status='' ; break;
      }
      if($status != '')
        $data['a.partner_status'] = $status;
    }

    // partner id
    $searchB  = explode('=', $search[1]);
    if(isset($searchB[1]) && $searchB[1] != ""){
      $data['a.partner_id'] = $searchB[1];
    }

    // // service
    // $searchC  = explode('=', $search[2]);
    // if(isset($searchC[1]) && $searchC[1] != ""){
    //   $data['e.name'] = $searchC[1];
    // }

    // $searchD = explode('=', $search[3]);
    // if(isset($searchD[1]) && $searchD[1] != ""){
    //   $this->db->like('qtrx_cus_email', $searchD[1]);
    //   $this->db->or_like('qtrx_book_name', $searchD[1]);
    // }

    // $this->db->join('od_partner_mod AS b', 'a.partner_id = b.partner_id')
    //           ->join('od_user AS c', 'b.user_id = c.id')
    //           ->join('od_user_mod AS d', 'c.id = d.user_id')
    //           ->join('od_user_level AS e', 'd.ul_id = e.id')
    //           ->order_by('a.partner_id', 'ASC');
    $getData = $this->db->get_where('od_partner AS a', $data, $limit, $row);

    return $getData->result();
  }

  function getPartnersTotal($search){
    // ?status=active&partner=Whqo&service=&key=
    // $data['b.partner_status'] = '1';
    $search   = explode('&', $search);
    $searchA  = explode('=', $search[0]);
    $data     = array();
    
    // $data['e.status'] = 1;
    // status rekon
    if(isset($searchA[1])){
      switch ($searchA[1]) {
        case 'active' : $status='1'; break;
        case 'not active' : $status='1'; break;
        default       : $status='' ; break;
      }
      if($status != '')
        $data['a.partner_status'] = $status;
    }

    // partner id
    $searchB  = explode('=', $search[1]);
    if(isset($searchB[1]) && $searchB[1] != ""){
      $data['a.partner_id'] = $searchB[1];
    }

    // // service
    // $searchC  = explode('=', $search[2]);
    // if(isset($searchC[1]) && $searchC[1] != ""){
    //   $data['e.name'] = $searchC[1];
    // }

    // $searchD = explode('=', $search[3]);
    // if(isset($searchD[1]) && $searchD[1] != ""){
    //   $this->db->like('qtrx_cus_email', $searchD[1]);
    //   $this->db->or_like('qtrx_book_name', $searchD[1]);
    // }

    // $this->db->join('od_partner_mod AS b', 'a.partner_id = b.partner_id')
    //           ->join('od_user AS c', 'b.user_id = c.id')
    //           ->join('od_user_mod AS d', 'c.id = d.user_id')
    //           ->join('od_user_level AS e', 'd.ul_id = e.id')
    //           ->order_by('a.partner_id', 'ASC');
    $getData = $this->db->get_where('od_partner AS a', $data);

    return $getData->num_rows();
  }

  function getPartnerRow($id, $service_id=null){
    $data = array(
              'a.partner_status' => 1, 'a.partner_id'     => $id,
              'e.active'     => 1
            );
    // if(isset($id) && $id != "")
    //   $data['partner_id'] = $id;
    // $this->db->join('od_partner_bank as b','on a.partner_id=b.partner_id');
    if(isset($service_id)){
      $data['b.ul_id']  = $service_id;
      $data['pks_stat'] = 1;
      $this->db->join('od_pks_doc as b','on a.partner_id=b.partner_id')
                ->join('od_user_level as c', 'c.id=b.ul_id');
    }
    $getData = $this->db->join('od_partner_mod as d', 'a.partner_id=d.partner_id')
                        ->join('od_user as e', 'd.user_id=e.id')
                        ->get_where('od_partner as a', $data);
    return $getData->row();
  }

  // insert pks mod of report
  function insertPKSMod($ba_id, $pks_id){
    $data     = array(
                  'ba_id'         => $ba_id, 'pks_id' => $pks_id,
                  'pks_mod_stat'  => 1
                );
    $getData  = $this->db->insert('od_pks_mod', $data);
    logger('insertPKSMod', implode('; ', $data));
    return true;
  }
}