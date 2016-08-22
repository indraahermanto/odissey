<?php
class M_snba extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->load->helper('string');
  }

  function getSnba($ul_name){
  	$getDataA = $this->db->join('od_user_mod as b','on a.id=b.user_id')
						  						->join('od_user_level as c', 'on c.id=b.ul_id')
						  						->where('c.name', 'snba')
						  						->where('a.active', '1')
						  						->get('od_user as a')->result();
  	foreach ($getDataA as $key => $getData) {
  		$getDataB = $this->db->join('od_user_mod as b','on a.id=b.user_id')
						  						->join('od_user_level as c', 'on c.id=b.ul_id')
						  						->where('c.name', $ul_name)
						  						->where('a.email', $getData->email)
						  						->get('od_user as a')->row();
			if(count($getDataB) > 0)
				return $getDataB;
  	}
  }
}