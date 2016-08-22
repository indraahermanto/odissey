<?php
class M_P_Products extends CI_Model {
  function __construct(){
    parent::__construct();
  }

  function getProductRow($id){
  	$data = array('product_id', $id);
  	$getData = $this->db->get_where('sp_p_product', $data);
  	return $getData->row();
  }
}