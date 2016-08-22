<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Spb extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->url 		= $this->uri->segment_array();
		$this->email 	= $this->session->userdata('email');
		$this->id 		= $this->session->userdata('identity');
    $this->load->library('notifier');
		$this->load->model(array(
			'main/M_main'
		));
	}

	function snba_spb(){
		$this->load->model(array(
		  'partner/snba/M_partner', 'invoices/snba/M_invoices', 'snba/M_spb'
		));

		$data['key']            = @$this->input->get('key');
    $data['pbank_name']     = @$this->input->get('bank');
    $data['p']              = @$this->input->get('p');
    $data['partners']       = $this->M_partner->getAllPartner();
    if($this->input->get('f') && strtolower($this->input->get('f')) != 'all'){
      $status            		= $this->M_main->getRow('od_spb_stat', 'stat_id', $this->input->get('f'));
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
    $banks              = $this->M_main->getAllWhere('od_partner_bank', array('pbank_stat' => 1));
    foreach ($banks as $key => $bank) {
      $data['banks'][$bank->pbank_name][$key] = $bank;
    }

    $perpage = 20;
    $index = ($this->uri->segment(3, 0)-1)*$perpage;
    if($index === -$perpage) $index = 0;

    $config['suffix']           = "?f=".$data['fw']."&p=".$data['p']."&date=&bank=".$data['pbank_name'];
    // echo $config['total_rows'];
    $config['base_url']         = base_url().'snba/spb/';
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
    $config['total_rows']       = $this->M_spb->getSPBTotal($config['suffix']);
    $this->pagination->initialize($config);
    $data['listStatus']					= $this->M_main->getAll('od_spb_stat');
    $data['docs']       				= $this->M_spb->getSPBLimit($index, $perpage, $config['suffix']);
    $data['total_rows']         = $config['total_rows'];
    // $data['amountOrders']       = $this->M_qbaca->getDataOrdersLimit(0, 0, $config['suffix']);
    // $data['service_id']         = $this->M_main->getRow('od_user_level', 'name', $this->url[2])->id;

		return $data;
	}

	function preview_new($doc){
		$this->load->model(array('invoices/M_invoices', 'snba/M_snba'));

		$doc     = $this->M_main->getShaDoc('od_inv_doc', $doc);
		if(!$doc)
			redirect();
		
		if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('maker')){

			$data['invoice'] = $this->M_invoices->getInvoice($doc->inv_id);
			$periode 					= explode(' - ', $data['invoice']->ba_periode);
			$data['mgr_st']   = $this->M_snba->getSnba('approval');
			// $data['mgr_fn']   = $this->M_->getSnba('maker');
    	$data['periode']	= $this->convnumber->indonesian_date(strtotime($periode[0]), 'd F Y', '')." s.d. "
    											.$this->convnumber->indonesian_date(strtotime($periode[1]), 'd F Y', '');
		}else return show_error('Anda tidak diizinkan masuk ke menu ini.');

    return $data;
	}

	function preview($doc){
		$this->load->model(array('spb/M_spb', 'snba/M_snba'));

		$doc     = $this->M_main->getShaDoc('od_spb_doc', $doc);
		// if(!$doc)
		// 	redirect();
		
		if (!$this->ion_auth->logged_in())
      redirect();
    else{
			$data['invoice'] = $this->M_spb->getSPB($doc->spb_id);
			$periode 					= explode(' - ', $data['invoice']->ba_periode);
			$data['mgr_st']   = $this->M_snba->getSnba('approval');
			// $data['mgr_fn']   = $this->M_->getSnba('maker');
    	$data['periode']	= $this->convnumber->indonesian_date(strtotime($periode[0]), 'd F Y', '')." s.d. "
    											.$this->convnumber->indonesian_date(strtotime($periode[1]), 'd F Y', '');
			$data['url_act']        = "";
			$data['buttProcess']    = "<button type='button' disabled class='btn btn-default btn-flat' data-toggle='modal' data-target='.bs-modal'>";
      $data['buttProcess']   .= ucwords($data['invoice']->stat_name)." &nbsp;";
      $data['buttProcess']   .= "<i class='fa fa-save'></i></button>";
      $data['logs']           = $this->M_main->getAllWhere('od_doc_log', array('dlog_doc_id' => $data['invoice']->spb_id, 'dlog_type' => 'spb'));

      if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('approval') && $doc->spb_status == 'mak'){
        $data['url_act']        = "snba/spb/approve";
        // $data['buttProcess']    = "<button type='button' class='btn btn-danger btn-flat' data-toggle='modal' data-target='.bs-modal-reject'>";
        // $data['buttProcess']   .= "Reject &nbsp;";
        // $data['buttProcess']   .= "<i class='fa fa-times'></i></button> ";
        $data['buttProcess']   	= "<button type='button' class='btn btn-success btn-flat' data-toggle='modal' data-target='.bs-modal'>";
        $data['buttProcess']   .= "Approve &nbsp;";
        $data['buttProcess']   .= "<i class='fa fa-check-square-o'></i></button>";
      }else if($this->ion_auth->in_group('finance') && $this->ion_auth->in_group('approval') && $doc->spb_status == 'sub'){
        $data['url_act']        = "finance/spb/approve";
        // $data['buttProcess']    = "<button type='button' class='btn btn-danger btn-flat' data-toggle='modal' data-target='.bs-modal-reject'>";
        // $data['buttProcess']   .= "Reject &nbsp;";
        // $data['buttProcess']   .= "<i class='fa fa-times'></i></button> ";
        $data['buttProcess']    = "<button type='button' class='btn btn-success btn-flat' data-toggle='modal' data-target='.bs-modal'>";
        $data['buttProcess']   .= "Approve &nbsp;";
        $data['buttProcess']   .= "<i class='fa fa-check-square-o'></i></button>";
      }
		}

    return $data;
	}

  function view_pdf_spb($doc_number){
    $this->load->model(array('spb/M_spb', 'snba/M_snba'));
    $this->load->library('FPDF');
    // define('FPDF_FONTPATH',$this->config->item('fonts_path'));
    $doc              = $this->M_main->getShaDoc('od_spb_doc', $doc_number);
    $data['invoice']  = $this->M_spb->getSPB($doc->spb_id);
    $periode          = explode(' - ', $data['invoice']->ba_periode);
    $data['mgr_st']   = $this->M_snba->getSnba('approval');
    $data['periode']  = $this->convnumber->indonesian_date(strtotime($periode[0]), 'd F Y', '')." s.d. "
                        .$this->convnumber->indonesian_date(strtotime($periode[1]), 'd F Y', '');
    // $query = $this->db->query("SELECT * from class")->result();
    // $data['hasil'] = $query; // Load view "pdf_report" untuk menampilkan hasilnya 
    // $data = "";
    $this->load->view('view_pdf_v', $data);
  }

  function uploadsSPB(){
    $this->load->model(array('spb/M_spb'));
    $data = array();
    $cond         = array('spb_status' => 'app');
    $data['docs']  = $this->M_main->getAllWhere('od_spb_doc', $cond);
    
    return $data;
  }

  function upload_bayar(){
    $this->load->model(array('spb/snba/M_spb'));
    if (!$this->ion_auth->logged_in())
      redirect();
    else{
      if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('maker')){
        $doc      = @$this->input->post("inputSPB");
        $spb      = $this->M_main->getShaDoc('od_spb_doc', $doc);
        if(!$spb)
          redirect();
        
        if (!$this->ion_auth->logged_in())
          redirect();
        else{
          $config['upload_path']    = './uploads/bukti_bayar';
          $config['max_size']       = 2048;
          $config['allowed_types']  = 'gif|jpg|png';
          $config['encrypt_name']   = true;
          $this->load->library('upload', $config);
          $upload = 0;
          if ( !$this->upload->do_upload('inputBayar')){
            $error = array('error' => $this->upload->display_errors());
            // $this->load->view('upload_form', $error);
            print_r($error);
            // show_error("Error: $error. Kesalahan upload, harap hubungi administrator.");
          }else{
            $data = array('upload_data' => $this->upload->data());
            // print_r($data);
            $upload = 1;
          }
          if($upload == 1){
            upDocLog($spb->spb_id, 'spb', 'appSPB'); // update dlog_stat 1 di utk notifikasi email
            // $data['file']     = $data['upload_data']['file_name'];
            $update = $this->M_spb->updateSPB($spb, 'sub', $data['upload_data']['file_name']);
            if($update){
              // $this->M_invoices->updateInvoice($invoice, 'com'); // update report jadi complete
              $mess   = array('note' => 'succSubSPB');
              $this->session->set_userdata($mess);
              redirect('snba/spb/upload');
            }
          }
        }
      }else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
    }
  }

	function makeSPB(){
		$this->load->model(array('invoices/snba/M_invoices', 'snba/M_spb'));
    if (!$this->ion_auth->logged_in())
      redirect();
    else{
      if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('maker')){
        $doc      = @$this->input->post('inputInvoice');
        $invoice  = $this->M_main->getShaDoc('od_inv_doc', $doc);
        if(!$invoice)
          redirect();

        // if(!$invoice)
        //   redirect("snba/spb");

        upDocLog($invoice->inv_id, 'invoice', 'app'); // update dlog_stat 1 di utk notifikasi email
        $create = $this->M_spb->makeSPB($invoice);
        if($create){
          // $this->M_invoices->updateInvoice($invoice, 'com'); // update report jadi complete
          $mess   = array('note' => 'succSPB');
          $this->session->set_userdata($mess);
          redirect('snba/spb');
        }
      }else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
    }
	}

  function approveSPB(){
    $this->load->model(array('invoices/snba/M_invoices', 'snba/M_spb'));
    if (!$this->ion_auth->logged_in())
      redirect();
    else{
      if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('approval')){
        $doc      = @$this->input->post('inputSPB');
        $spb      = $this->M_main->getShaDoc('od_spb_doc', $doc);
        if(!$spb)
          redirect();

        if(!$spb)
          redirect("snba/spb");

        upDocLog($spb->spb_id, 'spb', 'mak'); // update dlog_stat 1 di utk notifikasi email
        $approve = $this->M_spb->updateSPB($spb, 'app');
        if($approve){
          $mess   = array('note' => 'succAppSPB');
          $this->session->set_userdata($mess);
          redirect('snba/spb');
        }
      }else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
    }
  }

  function completeSPB(){
    $this->load->model(array('invoices/snba/M_invoices', 'snba/M_spb'));
    if (!$this->ion_auth->logged_in())
      redirect();
    else{
      if($this->ion_auth->in_group('finance') && $this->ion_auth->in_group('approval')){
        $doc      = @$this->input->post('inputSPB');
        $spb      = $this->M_main->getShaDoc('od_spb_doc', $doc);
        if(!$spb)
          redirect("finance/spb");

        upDocLog($spb->spb_id, 'spb', 'sub'); // update dlog_stat 1 di utk notifikasi email
        $approve = $this->M_spb->updateSPB($spb, 'com');
        if($approve){
          $invoice = $this->M_main->getRow('od_spb_mod', 'spb_id', $spb->spb_id); // update report jadi complete
          $this->M_invoices->updateInvoice($invoice, 'com'); // update report jadi complete
          $mess   = array('note' => 'succComSPB');
          $this->session->set_userdata($mess);
          redirect('finance/spb');
        }
      }else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
    }
  }
}