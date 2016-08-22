<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_invoices extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->model(array(
				'main/M_main', 'partner/snba/M_partner'
			));
	}

	function getInvoiceLimit($row, $limit, $search){
		$len        = strlen($search);
		$subSearch  = explode('&', substr($search, 1, $len));  // ?status=&partner=&date=&key=
		$searchA    = explode('=', strtolower($subSearch[0])); // 
		$searchB    = explode('=', $subSearch[1]);
		$searchC    = explode('=', $subSearch[2]);
		$data 			= array();
		// if(isset($subSearch[2])){
		//   // echo $subSearch[2];
		//   $searchC  = explode('=', strtolower($subSearch[2]));
		//   $data['ba_type'] = $searchC[1];
		// }
		//echo $searchA[1];
		if($searchC[1] != ""){
			// $data['ba_periode'] = $searchB[1];
			$dateRange = explode(' - ', $searchC[1]);
			$data['a.inv_created >='] = date('Y/m/d 00:00:00', strtotime($dateRange[0]));;
			$data['a.inv_created <='] = date('Y/m/d 23:59:59', strtotime($dateRange[1]));;
		}
		if($searchA[1] != "" && $searchA[1] != 'all')
			$data['a.inv_status']  = $searchA[1];
		if($searchB[1] != '')
			$data['a.partner_id'] = $searchB[1];

		$this->db->select('*, a.number as inv_number, f.number as ba_number')
							->join('od_inv_stat as b', 'a.inv_status=b.stat_id')
							->join('od_user_level as c', 'a.ul_id=c.id')
							->join('od_partner as d', 'a.partner_id=d.partner_id')
							->join('od_inv_mod as e', 'a.inv_id=e.inv_id')
							->join('od_ba_doc as f', 'e.ba_id=f.ba_id')
							->order_by('a.inv_id', 'DESC');
		$getData  = $this->db->get_where('od_inv_doc as a', $data, $limit, $row);
		return $getData->result();
	}

	function getInvoiceTotal($search){
		$len        = strlen($search);
		$subSearch  = explode('&', substr($search, 1, $len));  // ?status=&partner=&date=&key=
		$searchA    = explode('=', strtolower($subSearch[0])); // 
		$searchB    = explode('=', $subSearch[1]);
		$searchC    = explode('=', $subSearch[2]);
		$data 			= array();
		// if(isset($subSearch[2])){
		//   // echo $subSearch[2];
		//   $searchC  = explode('=', strtolower($subSearch[2]));
		//   $data['ba_type'] = $searchC[1];
		// }
		//echo $searchA[1];
		if($searchC[1] != ""){
			// $data['ba_periode'] = $searchB[1];
			$dateRange = explode(' - ', $searchC[1]);
			$data['a.inv_created >='] = date('Y/m/d 00:00:00', strtotime($dateRange[0]));;
			$data['a.inv_created <='] = date('Y/m/d 23:59:59', strtotime($dateRange[1]));;
		}
		if($searchA[1] != "" && $searchA[1] != 'all')
			$data['a.inv_status']  = $searchA[1];
		if($searchB[1] != '')
			$data['a.partner_id'] = $searchB[1];

		$this->db->select('*, a.number as inv_number, f.number as ba_number')
							->join('od_inv_stat as b', 'a.inv_status=b.stat_id')
							->join('od_user_level as c', 'a.ul_id=c.id')
							->join('od_partner as d', 'a.partner_id=d.partner_id')
							->join('od_inv_mod as e', 'a.inv_id=e.inv_id')
							->join('od_ba_doc as f', 'e.ba_id=f.ba_id')
							->order_by('a.inv_id', 'DESC');
		$getData  = $this->db->get_where('od_inv_doc as a', $data);
		return $getData->num_rows();
	}

	function updateInvoice($invoice, $act, $reason=null){
		$data   = array('inv_status' => $act);
		$this->db->where('inv_id', $invoice->inv_id);
		$submit = $this->db->update('od_inv_doc', $data);
		if($submit){
			logger($act.'Invoice', implode('; ', $data));
			if(isset($reason))
				docLog($invoice->inv_id, 'invoice', $act, $reason);
			else
				docLog($invoice->inv_id, 'invoice', $act);
			return true;
		}else{
			logger($act.'InvoiceFail', implode('; ', $data));
			return show_error("Error: ".$act."Invoice Fail. <br/>Something Wrong, please contact administrator.");
		}
	}
}