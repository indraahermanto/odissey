<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_partner extends CI_Model {
  function __construct(){
    parent::__construct();
  }

  function getMe($user_email, $service_id=null){
    $data = array('email' => $user_email, 'd.pbank_stat' => 1);

    $this->db->join('od_partner_mod as b', 'a.id=b.user_id')
              ->join('od_partner as c', 'b.partner_id=c.partner_id')
              ->join('od_partner_bank as d', 'c.partner_id=d.partner_id');
    if(isset($service_id)){
      $data['e.ul_id']  = $service_id;
      $data['pks_stat'] = 1;
      $this->db->join('od_pks_doc as e','on b.partner_id=e.partner_id')
                ->join('od_user_level as f', 'f.id=e.ul_id');
    }
  	$getData = $this->db->get_where('od_user as a', $data);
		return $getData->row();
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
}