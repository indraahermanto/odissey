<?php
class User_m extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->load->helper('converter');
  }

  function checkExistNumber($number){
  	$this->db->join('sp_user b', 'a.user_id=b.id');
  	$getData = $this->db->get_where('sp_number as a', array('a.number_phone' => $number));
  	return $getData->row();
  }

  function getUserRow($prefix){ // like M_Orders->selectUserID
    if(is_numeric($prefix)){

    }else{
    	$data = array('username' => $prefix);
    }
    $getData = $this->db->get_where('sp_user', $data);
    return $getData->row();
  }

  function getUserInformation($username){
    $data = array('username' => $username);
    $this->db->join('sp_user_group as b', 'a.ug_code=b.ug_code')
              ->join('sp_number as c', 'a.id=c.user_id')
              ->join('sp_user_mod as d', 'd.user_id=a.id')
              ->join('sp_user_level as e', 'd.ul_id=e.id');
    $getData = $this->db->get_where('sp_user as a', $data);
    return $getData->row();
  }

  function addNumber($number, $user_id, $provider_id){
  	
  	$data = array(
  						'number_phone' 	=> $number, 	'provider_id'		=> $provider_id,
  						'user_id'				=> $user_id,	'number_status' => 1
  					);
  	if($this->db->insert('sp_number', $data)){
  		$getLast = $this->getLastRow('sp_number', 'number_id');
  		logger('addNum', implode('; ', $data));
  		return $getLast->number_id;
  	}else return false;
  }

  function getLastRow($table, $primary){
  	$this->db->order_by($primary,'desc');
  	$getData = $this->db->get($table);
  	return $getData->row();
  }
}