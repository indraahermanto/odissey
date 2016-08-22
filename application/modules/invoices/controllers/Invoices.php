<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->url 		= $this->uri->segment_array();
		$this->email 	= $this->session->userdata('email');
		$this->load->library('notifier');
		$this->load->model(array(
				'main/M_main'
			));
	}

	function partner_invoices(){
		$this->load->model(array(
			'partner/M_partner', 'M_invoices'
		));

		// $data['key']         = @$this->input->get('key');
		$data['date']           = @$this->input->get('date');
		$data['p']              = @$this->input->get('p');
		// $data['partners']       = $this->M_partner->getAllPartner();
		if($this->input->get('f') && strtolower($this->input->get('f')) != 'all'){
			$status               = $this->M_main->getRow('od_inv_stat', 'stat_id', $this->input->get('f'));
			if(!$status){
				$data['f']          = 'all';
				$data['fw']         = 'all';
			}else{
				$data['f']          = $status->stat_name;
				$data['fw']         = $this->input->get('f');
			}
		}else {
			$data['f']        = 'all';
			$data['fw']       = 'all';
		}

		$perpage = 20;
		$index = ($this->uri->segment(3, 0)-1)*$perpage;
		if($index === -$perpage) $index = 0;

		$config['suffix']           = "?f=".$data['fw']."&date=".$data['date'];
		// echo $config['total_rows'];
		$config['base_url']         = base_url().'partner/invoices/';
		$config['per_page']         = $perpage;
		$config['num_links']        = 2;
		$config['display_pages']    = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['next_link']        = false;
		$config['prev_link']        = false;
		//$config['suffix']           =  $this->model_trx->search_trx_url();
		$config['full_tag_open']    = "<div class='col-md-12'><div class='col-md-12 text-center'>".
																	"<nav><ul class='pagination pagination-sm'>";
		$config['full_tag_close']   = "</ul></nav></div></div>";

		$config['first_tag_open']   = "<li class='page-item'>";
		$config['first_link']       = "<span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span>";
		$config['first_tag_close']  = "</li>";

		$config['last_tag_open']    = "<li class='page-item'>";
		$config['last_link']        = "<span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span>";
		$config['last_tag_close']   = "</li>";

		$config['num_tag_open']     = "<li class='page-item'>";
		$config['num_tag_close']    = "</li>";
		$config['cur_tag_open']     = "<li class='page-item active'><a>";
		$config['cur_tag_close']    = "</a></li>";
		$config['total_rows']       = "";
		$this->pagination->initialize($config);
		$data['listStatus']         = $this->M_main->getAll('od_inv_stat');
		$data['invoices']           = $this->M_invoices->getInvoiceLimit($index, $perpage, $config['suffix']);;
		$data['total_rows']         = $config['total_rows'];
		// $data['amountOrders']       = $this->M_qbaca->getDataOrdersLimit(0, 0, $config['suffix']);
		// $data['service_id']         = $this->M_main->getRow('od_user_level', 'name', $this->url[2])->id;

		return $data;
	}

	function snba_invoices(){
		$this->load->model(array(
			'partner/snba/M_partner', 'snba/M_invoices'
		));

		$data['key']            = @$this->input->get('key');
		$data['date']           = @$this->input->get('date');
		$data['p']              = @$this->input->get('p');
		$data['partners']       = $this->M_partner->getAllPartner();
		if($this->input->get('f') && strtolower($this->input->get('f')) != 'all'){
			$status            		= $this->M_main->getRow('od_inv_stat', 'stat_id', $this->input->get('f'));
			if(!$status){
				$data['f']					= 'all';
				$data['fw']					= 'all';
			}else{
				$data['f']					= $status->stat_name;
				$data['fw']					= $this->input->get('f');
			}
		}else {
			$data['f']				= 'all';
			$data['fw']       = 'all';
		}

		$perpage = 20;
		$index = ($this->uri->segment(3, 0)-1)*$perpage;
		if($index === -$perpage) $index = 0;

		$config['suffix']           = "?f=".$data['fw']."&p=".$data['p']."&date=".$data['date']."&key=".$data['key'];
		// echo $config['total_rows'];
		$config['base_url']         = base_url().'snba/invoices/';
		$config['per_page']         = $perpage;
		$config['num_links']        = 2;
		$config['display_pages']    = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['next_link']        = false;
		$config['prev_link']        = false;
		//$config['suffix']           =  $this->model_trx->search_trx_url();
		$config['full_tag_open']    = "<div class='col-md-12'><div class='col-md-12 text-center'>".
																	"<nav><ul class='pagination pagination-sm'>";
		$config['full_tag_close']   = "</ul></nav></div></div>";

		$config['first_tag_open']   = "<li class='page-item'>";
		$config['first_link']       = "<span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span>";
		$config['first_tag_close']  = "</li>";

		$config['last_tag_open']    = "<li class='page-item'>";
		$config['last_link']        = "<span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span>";
		$config['last_tag_close']   = "</li>";

		$config['num_tag_open']     = "<li class='page-item'>";
		$config['num_tag_close']    = "</li>";
		$config['cur_tag_open']     = "<li class='page-item active'><a>";
		$config['cur_tag_close']    = "</a></li>";
		$config['total_rows']       = $this->M_invoices->getInvoiceTotal($config['suffix']);
		$this->pagination->initialize($config);
		$data['listStatus']         = $this->M_main->getAll('od_inv_stat');
		$data['invoices']           = $this->M_invoices->getInvoiceLimit($index, $perpage, $config['suffix']);;
		$data['total_rows']         = $config['total_rows'];
		// $data['amountOrders']       = $this->M_qbaca->getDataOrdersLimit(0, 0, $config['suffix']);
		// $data['service_id']         = $this->M_main->getRow('od_user_level', 'name', $this->url[2])->id;

		return $data;
	}

	function newInvoice(){
		$this->load->model(array('partner/M_partner'));
		$data = array();
		$condReport				= array('ba_status' => 'app');
		$data['partner'] 	= $this->M_partner->getMe($this->email);
		$data['reports'] 	= $this->M_main->getAllWhere('od_ba_doc', $condReport);
		if(!$data['partner']){
			show_error("Pastikan rekening tujuan telah diatur.");
		}
		return $data;
	}

	function preview_new(){
		$this->load->model(array('M_invoices', 'reports/M_reports'));
		$config['upload_path']    = './uploads/temp';
		$config['allowed_types']  = 'pdf';
		$config['max_size']       = 100240;
		$config['max_width']      = 1024;
		$config['max_height']     = 768;
		$config['encrypt_name']   = true;
		$this->load->library('upload', $config);

		if ( !$this->upload->do_upload('inputFP')){
			$error = array('error' => $this->upload->display_errors());
			// $this->load->view('upload_form', $error);
			show_error("Error: $error. Kesalahan upload, harap hubungi administrator.");
		}else{
			$data = array('upload_data' => $this->upload->data());
			// print_r($data);
			$upload = 1;
		}

		$doc_number				= $this->input->post('inputReport');
		$doc              = $this->M_main->getShaDoc('od_ba_doc', $doc_number);
		if(!$doc)
			redirect($this->url[1]."/reports");

		$data['report']		= $this->M_reports->getReport($doc->ba_id);
		$data['file']			= base_url().'uploads/temp/'.$data['upload_data']['file_name'];
		$service 					= explode('/', $data['report']->number);
		$data['service']	= strtolower($service[2]);

		// $data['partner']     = $this->M_partner->getPartnerRow($data['report']->partner_id, $data['report']->ul_id);

		// $service_id					= $this->M_main->getRow('od_user_level', 'name', $data['report']->ul_id)
		// $data['partner']			= $this->M_partner->getPartnerRow();
		$data['partner'] 				= $this->M_partner->getMe($this->email, $data['report']->ul_id);
		$qtrx_id                = $this->M_main->getAllWhere('od_ba_mod', array('ba_id' => $data['report']->ba_id));
		$service                = $this->M_main->getRow('od_user_level', 'id', $data['report']->ul_id);

		$data['orders']         = array(); // $this->M_main->getAllWhere($service->table_trx, array('qtrx_id' => ''));
		$data['qtrx_id']        = "";
		foreach ($qtrx_id as $trx) {
			$data['qtrx_id'] .= $trx->qtrx_id.",";
			$orders = $this->M_main->getAllWhere($service->table_trx, array('qtrx_id' => $trx->qtrx_id));
			array_push($data['orders'], $orders);
		}

		$periode 					= explode(' - ', $data['report']->ba_periode);
		$data['periode']	= $this->convnumber->indonesian_date(strtotime($periode[0]), 'd F Y', '')." sampai "
												.$this->convnumber->indonesian_date(strtotime($periode[1]), 'd F Y', '');
		// switch (strtolower($about)) {
		//   case 'qbaca': $data['tableTrxReport'] = $this->tableTrxQbaca($this->partner_id, $this->input->post('InputDocNumber')); break;
		// }
		return $data;
	}

	function preview($doc_number){
		$data = array();
		$this->load->model(array('M_invoices', 'main/M_main', 'snba/M_snba'));
		// $data['report'] = $this->M_reports->
		if (!$this->ion_auth->logged_in())
			redirect();
		else{
			$data['url_act'] 	= ""; $data['act'] = "menyetujui";
			$doc              = $this->M_main->getShaDoc('od_inv_doc', $doc_number);
			if(!$doc)
				redirect($this->url[1]."/invoices");
			else if(!isset($this->url[4])) redirect();
			$data['invoice']         = $this->M_invoices->getInvoice($doc->inv_id);
			// $data['mgr_st']         = $this->M_snba->getSnba('maker');
			$periode 					= explode(' - ', $data['invoice']->ba_periode);

			$data['partner']        = $this->M_partner->getPartnerRow($data['invoice']->partner_id, $data['invoice']->ul_id);
			$qtrx_id                = $this->M_main->getAllWhere('od_ba_mod', array('ba_id' => $data['invoice']->ba_id));
			$service                = $this->M_main->getRow('od_user_level', 'id', $data['partner']->ul_id);

			$data['orders']         = array(); // $this->M_main->getAllWhere($service->table_trx, array('qtrx_id' => ''));
			$data['qtrx_id']        = "";
			foreach ($qtrx_id as $trx) {
				$data['qtrx_id'] .= $trx->qtrx_id.",";
				$orders = $this->M_main->getAllWhere($service->table_trx, array('qtrx_id' => $trx->qtrx_id));
				array_push($data['orders'], $orders);
			}


			$data['periode']	= $this->convnumber->indonesian_date(strtotime($periode[0]), 'd F Y', '')." sampai "
													.$this->convnumber->indonesian_date(strtotime($periode[1]), 'd F Y', '');
			$data['logs']           = $this->M_main->getAllWhere('od_doc_log', array('dlog_doc_id' => $data['invoice']->inv_id, 'dlog_type' => 'invoice'));
			$data['buttProcess']    = "<button type='button' disabled class='btn btn-default btn-flat' data-toggle='modal' data-target='.bs-modal'>";
			$data['buttProcess']   .= ucwords($data['invoice']->stat_name)." &nbsp;";
			$data['buttProcess']   .= "<i class='fa fa-save'></i></button>";

			if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('maker') && ($doc->inv_status == 'mak' | $doc->inv_status == 'rev')){
				$data['url_act']        = "approve"; 
				$data['buttProcess']    = "<button type='button' class='btn btn-danger btn-flat' data-toggle='modal' data-target='.bs-modal-reject'>";
				$data['buttProcess']   .= "Reject &nbsp;";
				$data['buttProcess']   .= "<i class='fa fa-times'></i></button> ";
				$data['buttProcess']   .= "<button type='button' class='btn btn-success btn-flat' data-toggle='modal' data-target='.bs-modal-upload'>";
				$data['buttProcess']   .= "Approve &nbsp;";
				$data['buttProcess']   .= "<i class='fa fa-check-square-o'></i></button>";
			}else if($this->ion_auth->in_group('partner') && $doc->inv_status == 'rej'){
				$data['url_act']        = "change_file"; 
				$data['buttProcess']   .= "<button type='button' class='btn btn-success btn-flat' data-toggle='modal' data-target='.bs-modal'>";
				$data['buttProcess']   .= "Change &nbsp;";
				$data['buttProcess']   .= "<i class='fa fa-check-square-o'></i></button>";
			}
		}
		return $data;
	}

	function approveInvoice(){
		$this->load->model(array('snba/M_invoices', 'reports/snba/M_reports'));
		if (!$this->ion_auth->logged_in())
		  redirect();
		else{
		  if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('maker')){
		  	$doc_number	= @$this->input->post('inputInvoice');
				$invoice     = $this->M_main->getShaDoc('od_inv_doc', $doc_number);
				if(!$invoice)
					redirect("snba/invoices");

				upDocLog($invoice->inv_id, 'invoice', 'mak'); // update dlog_stat 1 di utk notifikasi email
				$create = $this->M_invoices->updateInvoice($invoice, 'app');
				if($create){
					// $this->M_reports->updateReport($report, 'com'); // update report jadi complete
					$mess 	= array('note' => 'succAppInvoice');
					$this->session->set_userdata($mess);
					redirect("snba/spb/preview/new/$doc_number");
				}
		  }else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
		}
	}

	function rejectInvoice(){
		$this->load->model(array('snba/M_invoices', 'reports/snba/M_reports'));
		if (!$this->ion_auth->logged_in())
		  redirect();
		else{
		  if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('maker')){
		  	$doc_number	= @$this->input->post('inputInvoice');
				$reason			= @$this->input->post('inpNote');
				$invoice     = $this->M_main->getShaDoc('od_inv_doc', $doc_number);
				if(!$invoice)
					redirect("snba/invoices");

				upDocLog($invoice->inv_id, 'invoice', 'mak'); // update dlog_stat 1 di utk notifikasi email
				$create = $this->M_invoices->updateInvoice($invoice, 'rej', $reason);
				if($create){
					// $this->M_reports->updateReport($report, 'com'); // update report jadi complete
					$mess 	= array('note' => 'succRejInvoice');
					$this->session->set_userdata($mess);
					redirect("snba/invoices/");
				}
		  }else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
		}
	}

	function makeInvoice(){
		$this->load->model(array('M_invoices', 'reports/snba/M_reports'));

		$file 		= @$this->input->post('inputFileFP');
		$service 	= @$this->input->post('inputService');
		$amount 	= @$this->input->post('inputAmount');
		$rekening 	= @$this->input->post('inputRek');
		$doc_number	= @$this->input->post('inputReport');

		if (!$this->ion_auth->logged_in())
		  redirect();
		else{
		  if($this->ion_auth->in_group('partner')){
		  	$report     = $this->M_main->getShaDoc('od_ba_doc', $doc_number);
				if(!$report)
					redirect("partner/invoices");

				upDocLog($report->ba_id, 'report', 'app'); // update dlog_stat 1 di utk notifikasi email
				$create = $this->M_invoices->makeInvoice($report->ba_id, $service, $amount, $file, $rekening);
				if($create){
					$this->M_reports->updateReport($report, 'com'); // update report jadi complete
					$mess 	= array('note' => 'succInvoice');
					$this->session->set_userdata($mess);
					redirect('partner/invoices');
				}
		  }else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
		}
	}

	function uploadFP(){
		$this->load->model(array('M_invoices', 'reports/snba/M_reports'));

		if (!$this->ion_auth->logged_in())
		  redirect();
		else{
		  if($this->ion_auth->in_group('partner')){
		  	$doc_number	= @$this->input->post('inputInvoice');
				$invoice     = $this->M_main->getShaDoc('od_inv_doc', $doc_number);
				if(!$invoice)
					redirect("partner/invoices");

				$config['upload_path']    = './uploads/temp';
				$config['allowed_types']  = 'pdf';
				$config['max_size']       = 100240;
				$config['max_width']      = 1024;
				$config['max_height']     = 768;
				$config['encrypt_name']   = true;
				$this->load->library('upload', $config);

				if ( !$this->upload->do_upload('inputFP')){
					$error = array('error' => $this->upload->display_errors());
					// $this->load->view('upload_form', $error);
					print_r($error);
					// show_error("Error: $error. Kesalahan upload, harap hubungi administrator.");
				}else{
					$data = array('upload_data' => $this->upload->data());
					// print_r($data);
					$upload = 1;
				}
		// print_r($data);
				$file		= base_url().'uploads/temp/'.$data['upload_data']['file_name'];
				// echo $file;
				upDocLog($invoice->inv_id, 'invoice', 'rej'); // update dlog_stat 1 di utk notifikasi email
				$create = $this->M_invoices->updateInvoice($invoice, 'rev', $file);
				if($create){
					// $this->M_reports->updateReport($report, 'com'); // update report jadi complete
					$mess 	= array('note' => 'succRevInvoice');
					$this->session->set_userdata($mess);
					// echo $file;
					redirect("partner/invoices/preview/$doc_number");
				}
		  }else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
		}
	}
}

// if (!$this->ion_auth->logged_in())
//   redirect();
// else{
//   if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('approval')){

//   }else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
// }