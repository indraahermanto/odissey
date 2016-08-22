<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->url = $this->uri->segment_array();
    $this->load->library('notifier');
	}

	// redirect if needed, otherwise display the user list
	// function index(){
	// 	if (!$this->ion_auth->logged_in()){
	// 		// redirect them to the login page
	// 		redirect('member/login', 'refresh');
	// 	} else {
	// 		if($this->ion_auth->is_admin()){
 //        $data['adm_menu'] ="<li><a href='".base_url()."admin'><i class='fa fa-user-secret'></i> <span>Admin Page</span></a></li>";
 //      }else $data['adm_menu'] = "";

	// 		$data['page_header']    = 'Reports';
 //      $data['description']    = '';
 //      $data['title']          = 'MantoSys: Home';
 //      $data['url']            = $this->url;
 //      $data['left_side']      = implode('/', $this->url);
 //      $data['content_view']   = 'orders/main.php';
 //      $data['additionalCSS']  = 'orders/additionalCSS.php';
 //      $data['additionalJS']   = 'orders/additionalJS.php';
 //      $this->template->call_user_template($data);
	// 	}
	// }

  function partner_reports(){
    $this->load->model(array(
      'partner/M_partner', 'M_reports', 'main/M_main'
    ));

    // $data['key']            = @$this->input->get('key');
    $data['date']           = @$this->input->get('date');
    $data['p']              = @$this->input->get('p');
    // $data['partners']       = $this->M_partner->getAllPartner();
    if($this->input->get('f') && strtolower($this->input->get('f')) != 'all'){
      $status               = $this->M_main->getRow('od_ba_stat', 'stat_id', $this->input->get('f'));
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
    $config['base_url']         = base_url().'partner/reports/';
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
    $config['total_rows']       = $this->M_reports->getReportTotal($config['suffix']);
    $this->pagination->initialize($config);
    $data['listStatus']         = $this->M_main->getAll('od_ba_stat');
    $data['reports']            = $this->M_reports->getReportLimit($index, $perpage, $config['suffix']);
    $data['total_rows']         = $config['total_rows'];
    // $data['amountOrders']       = $this->M_qbaca->getDataOrdersLimit(0, 0, $config['suffix']);
    // $data['service_id']         = $this->M_main->getRow('od_user_level', 'name', $this->url[2])->id;

    return $data;
  }

	function snba_reports(){
    
    $this->load->model(array(
      'partner/snba/M_partner', 'snba/M_reports', 'main/M_main'
    ));

    $data['key']            = @$this->input->get('key');
    $data['date']           = @$this->input->get('date');
    $data['p']              = @$this->input->get('p');
    $data['partners']       = $this->M_partner->getAllPartner();
    if($this->input->get('f') && strtolower($this->input->get('f')) != 'all'){
      $status            		= $this->M_main->getRow('od_ba_stat', 'stat_id', $this->input->get('f'));
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
    $config['base_url']         = base_url().'snba/reports/';
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
    $config['total_rows']       = $this->M_reports->getReportTotal($config['suffix']);
    $this->pagination->initialize($config);
    $data['listStatus']					= $this->M_main->getAll('od_ba_stat');
    $data['reports']       			= $this->M_reports->getReportLimit($index, $perpage, $config['suffix']);
    $data['total_rows']         = $config['total_rows'];
    // $data['amountOrders']       = $this->M_qbaca->getDataOrdersLimit(0, 0, $config['suffix']);
    // $data['service_id']         = $this->M_main->getRow('od_user_level', 'name', $this->url[2])->id;

    return $data;
	}

	function preview_new(){
		$this->load->model(array('partner/snba/M_partner', 'qbaca/M_qbaca', 'snba/M_snba'));
		$data['qtrx_id']		= @$this->input->post('inputQtrxID');
		$data['period'] 		= @$this->input->post('inputPeriode');
		$service_id 				= @$this->input->post('inputService');
		$data['amount']     = @$this->input->post('inputAmount');
		$partner_id					= @$this->input->post('inputPartner');
    // echo $periodee;

		if(!count($data['qtrx_id']))
			redirect('snba/qbaca/transaction');

		if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('maker')){
			// $data['period']		= $this->M_qbaca->getPeriode(explode(',', $data['qtrx_id']));

      // $data['period']   = $periodee;
			$datePeriod				= explode(' - ', $data['period']);
			// echo strtotime($datePeriod[0]);
			$data['mgr_st']		=	$this->M_snba->getSnba('maker');
			// print_r($data['mgr_st']);
			// $data['pn_app']		=	$this->M_partner->getPartnerRow($partner_id);
			// print_r($data['pn_app']);
			$data['dateFrom'] = $this->convnumber->indonesian_date(strtotime($datePeriod[0]),'d F  Y', '');
			$data['dateTo'] 	= $this->convnumber->indonesian_date(strtotime($datePeriod[1]),'d F  Y', '');
			$data['partner'] 	= $this->M_partner->getPartnerRow($partner_id, $service_id);
      $data['amountPKS']= $data['amount']*($data['partner']->pks_mitra_share/100);
			// print_r($data);
      $service          = $this->M_main->getRow('od_user_level', 'id', $service_id);
      $qtrx_id          = explode(',', $data['qtrx_id']);
      $data['orders']   = array(); // $this->M_main->getAllWhere($service->table_trx, array('qtrx_id' => ''));
      foreach ($qtrx_id as $trx_id) {
        $orders = $this->M_main->getAllWhere($service->table_trx, array('qtrx_id' => $trx_id));
        array_push($data['orders'], $orders);
      }
      // print_r($data['orders']);

      if(!$data['partner'])
        show_error("PKS untuk partner ini belum ada / tidak aktif.");
      else
			 return $data;
		}else return show_error('Anda tidak diizinkan masuk ke menu ini.');
	}
	
	function preview($doc_number){
    $this->load->model(array('partner/snba/M_partner', 'M_reports', 'main/M_main', 'snba/M_snba'));
    // $data['report'] = $this->M_reports->
    if (!$this->ion_auth->logged_in())
      redirect();
    else{
      $data['url_act']  = ""; $data['act'] = "menyetujui";
      $doc              = $this->M_main->getShaDoc('od_ba_doc', $doc_number);
      if(!$doc)
        redirect($this->url[1]."/reports");
      else if(!isset($this->url[4])) redirect();
      $data['report']         = $this->M_reports->getReport($doc->ba_id);
      $data['partner']        = $this->M_partner->getPartnerRow($data['report']->partner_id, $data['report']->ul_id);
      $qtrx_id                = $this->M_main->getAllWhere('od_ba_mod', array('ba_id' => $data['report']->ba_id));
      $service                = $this->M_main->getRow('od_user_level', 'id', $data['partner']->ul_id);

      $data['orders']         = array(); // $this->M_main->getAllWhere($service->table_trx, array('qtrx_id' => ''));
      $data['qtrx_id']        = "";
      foreach ($qtrx_id as $trx) {
        $data['qtrx_id'] .= $trx->qtrx_id.",";
        $orders = $this->M_main->getAllWhere($service->table_trx, array('qtrx_id' => $trx->qtrx_id));
        array_push($data['orders'], $orders);
      }
      
      $data['mgr_st']         = $this->M_snba->getSnba('approval');
      $data['logs']           = $this->M_main->getAllWhere('od_doc_log', array('dlog_doc_id' => $data['report']->ba_id));
      $data['buttProcess']    = "<button type='button' disabled class='btn btn-default btn-flat' data-toggle='modal' data-target='.bs-modal'>";
      $data['buttProcess']   .= ucwords($data['report']->stat_name)." &nbsp;";
      $data['buttProcess']   .= "<i class='fa fa-save'></i></button>";

      if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('approval') && $doc->ba_status == 'mak'){
        $data['url_act']        = "submit";
        $data['buttProcess']    = "<button type='button' class='btn btn-success btn-flat' data-toggle='modal' data-target='.bs-modal'>";
        $data['buttProcess']   .= "Approve &nbsp;";
        $data['buttProcess']   .= "<i class='fa fa-check-square-o'></i></button>";
      }else if($this->ion_auth->in_group('partner') && $this->ion_auth->in_group('maker') && $doc->ba_status == 'sub'){
        $data['url_act']        = "approve";
        $data['buttProcess']    = "<button type='button' class='btn btn-success btn-flat' data-toggle='modal' data-target='.bs-modal'>";
        $data['buttProcess']   .= "Approve &nbsp;";
        $data['buttProcess']   .= "<i class='fa fa-check-square-o'></i></button>";
      }

      return $data;
    }
	}

  function view_pdf_report($doc_number){
    $this->load->model(array('partner/snba/M_partner', 'M_reports', 'main/M_main', 'snba/M_snba'));
    $this->load->library('FPDF');
    // define('FPDF_FONTPATH',$this->config->item('fonts_path'));
    $doc              = $this->M_main->getShaDoc('od_ba_doc', $doc_number);
    $data['report']   = $this->M_reports->getReport($doc->ba_id);
    $data['partner']  = $this->M_partner->getPartnerRow($data['report']->partner_id, $data['report']->ul_id);
    $qtrx_id          = $this->M_main->getAllWhere('od_ba_mod', array('ba_id' => $data['report']->ba_id));
    $service          = $this->M_main->getRow('od_user_level', 'id', $data['partner']->ul_id);

    $data['orders']         = array(); // $this->M_main->getAllWhere($service->table_trx, array('qtrx_id' => ''));
    $data['qtrx_id']        = "";
    foreach ($qtrx_id as $trx) {
      $data['qtrx_id'] .= $trx->qtrx_id.",";
      $orders = $this->M_main->getAllWhere($service->table_trx, array('qtrx_id' => $trx->qtrx_id));
      array_push($data['orders'], $orders);
    }

    $data['mgr_st']   = $this->M_snba->getSnba('approval');
    // $query = $this->db->query("SELECT * from class")->result();
    // $data['hasil'] = $query; // Load view "pdf_report" untuk menampilkan hasilnya 
    // $data = "";
    $this->load->view('view_pdf_v', $data);
  }

	function makeReport(){
		$this->load->model('snba/M_reports');

		$qtrx_id 		= @$this->input->post('inputQtrxID');
		$partner_id = @$this->input->post('inputPID');
		$service_id = @$this->input->post('inputService');
		$period 		= @$this->input->post('inputPeriode');
		$amount 		= @$this->input->post('inputAmount');
    $amountPKS  = @$this->input->post('inputAmountPKS');
    $pks        = @$this->input->post('inputPKS');

    if (!$this->ion_auth->logged_in())
      redirect();
    else{
  		if($qtrx_id == "")
  			redirect('snba/reports');
      if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('maker')){
        $create = $this->M_reports->makeReport($qtrx_id, $partner_id, $service_id, $period, $amount, $amountPKS, $pks);
        if($create){
          $mess   = array('note' => 'succReport');
          $this->session->set_userdata($mess);
          redirect('snba/reports');
        }
      }else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
    }
	}

  // approval report by snba
  function submitReport(){
    $this->load->model(array('snba/M_reports', 'main/M_main'));
    if (!$this->ion_auth->logged_in())
      redirect();
    else{
      if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('approval')){
        $doc_number       = @$this->input->post('inputReport');
        $doc              = $this->M_main->getShaDoc('od_ba_doc', $doc_number);

        if(!$doc)
          redirect($this->url[1]."/reports");
        $report = $this->M_reports->getReport($doc->ba_id);
        $submit = $this->M_reports->updateReport($report, 'sub');

        upDocLog($report->ba_id, 'report', 'mak'); // update dlog_stat 1 di utk notifikasi email
        if($submit){
          $mess   = array('note' => 'subSuccReport');
          $this->session->set_userdata($mess);
          redirect('snba/reports');
        }
      }else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
    }
  }

  function approveReport(){
    $this->load->model(array('snba/M_reports', 'main/M_main'));
    if (!$this->ion_auth->logged_in())
      redirect();
    else{
      if($this->ion_auth->in_group('partner')){
        $doc_number       = @$this->input->post('inputReport');
        $doc              = $this->M_main->getShaDoc('od_ba_doc', $doc_number);
        if(!$doc)
          redirect($this->url[1]."/reports");
        $report = $this->M_reports->getReport($doc->ba_id);
        $submit = $this->M_reports->updateReport($report, 'app');

        upDocLog($report->ba_id, 'report', 'sub'); // update dlog_stat 1 di utk notifikasi email
        if($submit){
          $mess   = array('note' => 'appSuccReport');
          $this->session->set_userdata($mess);
          redirect('partner/reports');
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