<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->url = $this->uri->segment_array();
		$this->load->model(array(
				'main/M_main'
			));
	}

	function getAmountReport(){
		$doc_number = @$this->input->post('doc_number');
		if($doc_number != ""){
			$doc = $this->M_main->getShaDoc('od_ba_doc', $doc_number);
			// $report = $this->M_main->getRow('od_ba_doc', 'ba_id', $doc->ba_id);

			echo number_format($doc->ba_amount_pks, 0, ',', '.');
		}
	}

	function getAmountSPB(){
		$doc_number = @$this->input->post('doc_number');
		if($doc_number == "")
			redirect();
		$doc = $this->M_main->getShaDoc('od_spb_doc', $doc_number);
		// $inv = $this->M_main->getRow('od_inv_doc', 'inv_id', $doc->ba_id);
		echo number_format($doc->spb_amount, 0, ',', '.');
	}
}