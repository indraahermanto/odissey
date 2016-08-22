<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_main extends CI_Model {
  function __construct(){
    parent::__construct();
    // $this->load->helper('converter');
  }

	function getRow($table, $field, $primary){
	  $data     = array($field => $primary);
	  $getData = $this->db->get_where($table, $data);
	  return $getData->row();
	}

  function getLastRow($table, $field){
    $getData = $this->db->order_by($field, 'DESC')
                        ->get_where($table);
    return $getData->row(); 
  }

  function getAll($table){
    $getData = $this->db->get($table);
    return $getData->result();
  }

  function getAllWhere($table, $data){
    $getData = $this->db->get_where($table, $data);
    return $getData->result();
  }

  function getShaDoc($table, $sha_number){
    $docs = $this->getAll($table);
    foreach ($docs as $doc) {
      if(sha1($this->config->config['salt'].$doc->number) == $sha_number)
        return $doc;
    }
    return false;
  }

	function getLastDoc($table, $field, $service_id, $doc_code){
		$service = $this->getRow('od_user_level', 'id', $service_id);
    $this->db->order_by($field, 'DESC');
    $getData = $this->db->get($table)->row();

    if(empty($getData)){
      $number = '0001';
    }else{
      $last     = explode('/', $getData->number);
      $lastNo   = strlen($last[0]);
      switch ($last[0]) {
        case $last[0] < 10    : $number = "000".($last[0]+1);break;
        case $last[0] < 100   : $number = '00'.($last[0]+1);break;
        case $last[0] < 1000  : $number = '0'.($last[0]+1);break;
        case $last[0] > 1000  : $number = $last[0]+1;break;
      }
    }
    $nowMonth   = str_replace(' ', '', $this->convnumber->indonesian_date(strtotime('now'), '/M /Y', ''));
    $number  .= "/$doc_code/".strtoupper($service->name.$nowMonth);
    // $_SESSION['doc_no'] = $number;
    return $number;
  }
}