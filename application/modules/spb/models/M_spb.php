<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_spb extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->load->model(array(
    		'main/M_main'
    	));
  }

  function getSPB($id){
  	$data = array(
              'a.spb_id' => $id, 'c.status' => 1
            );

    $getData = $this->db->select('*, a.number as spb_number, f.number as inv_number')
                        ->join('od_spb_stat as b', 'a.spb_status=b.stat_id')
                        ->join('od_user_level as c', 'a.ul_id=c.id')
                        ->join('od_partner as d', 'a.partner_id=d.partner_id')
                        ->join('od_spb_mod as e', 'a.spb_id=e.spb_id')
                        ->join('od_inv_doc as f', 'e.inv_id=f.inv_id')
                        ->join('od_partner_bank as g', 'a.partner_id=g.partner_id')
                        ->join('od_partner_mod as h', 'a.partner_id=h.partner_id')
                        ->join('od_user as i', 'h.user_id=i.id')
                        ->join('od_inv_mod as j', 'j.inv_id=j.inv_id')
                        ->join('od_ba_doc as k', 'k.ba_id=k.ba_id')
                        ->order_by('a.spb_id', 'DESC')
                        ->get_where('od_spb_doc as a', $data);
    return $getData->row();
  }
}