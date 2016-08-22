<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->url 		= $this->uri->segment_array();
		$this->email 	= $this->session->userdata('email');
		$this->id 		= $this->session->userdata('identity');
		$this->load->model(array(
			'main/M_main', 'M_download', 'spb/M_spb'
		));
		$this->load->helper('download');
	}

	function batch($bank=null){
		if($bank == 'mandiri'){
			$mcm 	= "0700006092006";
			$docs 	= $this->input->post('inputSPB');
			$data 	= "";
			// print_r($docs);
			$data = array();
			$count = 0; $total = 0;
			$partner_temp = "";
			foreach ($docs as $doc) {
				$spb    = $this->M_main->getShaDoc('od_spb_doc', $doc);
				$abc 	= $this->M_spb->getSPB($spb->spb_id);
				$total += $abc->spb_amount;
				

				// $data[$abc->partner_id] = $abc;
				$data[$abc->partner_id][$count] = $abc;
				// if($partner_temp != $abc->partner_id){
				// 	// array_push($data[$abc->partner_id], $abc);
				// 	$data[$abc->partner_id][$count] = $abc;
				// }
				// $partner_temp = $abc->partner_id;
				$count++;
				// array_push($data[$abc->partner_id], $abc);
				// echo $data;
				// print_r($data);
				// echo "<br/>";
				// echo implode(",", $abc);
				// $data 	.= implode(",", $abc);
				// array_push($data, $abc);
			}
			$content = "P;".date('Ymd').";$mcm;$count;$total;\r\n";
			// print_r($data);
			foreach ($data as $key => $val) {
				$amount = 0;
				foreach ($val as $key_b => $val_b) {
					// print_r($val_b);
					// echo $val_b->pbank_rekening;
					$amount += $val_b->spb_amount;
				}
				$content .= "$val_b->pbank_rekening;$val_b->pbank_an;$val_b->partner_address ".ucwords(strtolower($val_b->partner_city)).";;;IDR;$amount;;;IBU;;;;;;;Y;$val_b->email;;;;;;;;;;;;;;;;;;;;;;;;\r\n";
				// echo "$val->pbank_rekening;$val->pbank_an;$val->partner_address ".ucwords(strtolower($val->partner_city)).";;;IDR;$val->spb_amount;;;IBU;;;;;;;Y;$val->email;;;;;;;;;;;;;;;;;;;;;;;;<br/>";
			}

			// print_r($data);

			force_download('mandiri_batch_'.date('Ymd').'.txt', $content);
		}else {
			force_download('error.txt', 'error: download error!');
		}
	}
}