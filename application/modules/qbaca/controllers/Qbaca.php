<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Qbaca extends MY_Controller {

	function __construct(){
		parent::__construct();
        $this->url = $this->uri->segment_array();
	}

	// function transaction(){
		// if (!$this->ion_auth->logged_in()){
  //     $data['page_header'] = '';
  //     $data['description'] = '';
  //     $data['title'] = 'Welcome to Odissey';
  //     $this->template->call_nologin_template($data);
  //   } else { // remove this elseif if you want to enable this for non-admins
  //     if($this->ion_auth->in_group('qbaca')){
		//     $data = $this->partner_qbaca();
		//     $data['adv_menu'] = "";
		//     $data['url']            = $this->url;
		//     $data['left_side']      = implode('/', $this->url);
		// 		if(substr_count($data['left_side'], 'qbaca') > 0) $select = 'active';
		//     $data['adv_menu']    .= "<li class='".$select."'><a href='".base_url()."qbaca/transaction'><i class='fa fa-book'></i> <span>Qbaca</span></a></li>";
		//     $data['user']           = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
		//     $data['page_header']    = 'Transaction Qbaca';
		//     $data['description']    = '';
		//     $data['title']          = 'Odissey: All Transaction Qbaca';
		//     $data['content_view']   = 'qbaca/main.php';
		//     $data['additionalCSS']  = 'qbaca/additionalCSS.php';
		//     $data['additionalJS']   = 'qbaca/additionalJS.php';
	 //      $this->template->call_partner_template($data);
  //     } else if($this->ion_auth->in_group('snba')){
  //     	$data = $this->snba_qbaca();
		//     $data['adv_menu'] = "";
		//     $data['url']            = $this->url;
		//     $data['left_side']      = implode('/', $this->url);
		// 		if(substr_count($data['left_side'], 'qbaca') > 0) $select = 'active';
		//     $data['adv_menu']    .= "<li class='".$select."'><a href='".base_url()."qbaca/transaction'><i class='fa fa-book'></i> <span>Qbaca</span></a></li>";
		//     $data['user']           = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
		//     $data['page_header']    = 'Transaction Qbaca';
		//     $data['description']    = '';
		//     $data['title']          = 'Odissey: All Transaction Qbaca';
		//     $data['content_view']   = 'qbaca/main.php';
		//     $data['additionalCSS']  = 'qbaca/additionalCSS.php';
		//     $data['additionalJS']   = 'qbaca/additionalJS.php';
	 //      $this->template->call_snba_template($data);
  //     }
  //   }
	// }

	function partner_qbaca(){
        // $this->load->module('partner');
        $this->load->model(array(
          'M_qbaca', 'partner/M_partner'
        ));

        // $data['key']            = @$this->input->get('key');
        $data['date']           = @$this->input->get('date');
        // $data['p']              = @$this->input->get('p');
        // $data['partners']       = $this->M_partner->getAllPartner();
        if($this->input->get('f'))
          $data['f']            = $this->input->get('f');
        else $data['f']         = 'all';
        
        $perpage = 20;
        $data['index'] = ($this->uri->segment(4, 0)-1)*$perpage;
        if($data['index'] === -$perpage) $data['index'] = 0;

        $config['suffix']           = "?f=".$data['f']."&date=".$data['date'];
        $config['total_rows']       = $this->M_qbaca->getDataOrdersTotal($config['suffix']);
        // echo $config['total_rows'];
        $config['base_url']         = base_url().'partner/qbaca/transaction/';
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
        $this->pagination->initialize($config);
        $data['total_rows']         = $config['total_rows'];
        $data['transactions']       = $this->M_qbaca->getDataOrdersLimit($data['index'], $perpage, $config['suffix']);
        $data['amountOrders']       = $this->M_qbaca->getDataOrdersLimit(0, 0, $config['suffix']);
        // $data['service_id']         = $this->M_main->getRow('od_user_level', 'name', $this->url[2])->id;
        
        // if($data['date'] != "" && $data['f'] != "" && $this->ion_auth->in_group('maker'))
        //     $data['buttonProses']   = '<input type="submit" value="Proses" class="btn btn-success btn-flat btn-sm">';
        // else $data['buttonProses']  = "";
        return $data;
	}

  function snba_qbaca(){
    // $this->load->module('partner');
    $this->load->model(array(
      'snba/M_qbaca', 'partner/snba/M_partner'
    ));

    $data['key']            = @$this->input->get('key');
    $data['date']           = @$this->input->get('date');
    $data['p']              = @$this->input->get('p');
    $data['partners']       = $this->M_partner->getAllPartner();
    if($this->input->get('f'))
      $data['f']            = $this->input->get('f');
    else $data['f']         = 'all';
    
    $perpage = 20;
    $data['index'] = ($this->uri->segment(4, 0)-1)*$perpage;
    if($data['index'] === -$perpage) $data['index'] = 0;

    $config['base_url']         = base_url().'snba/qbaca';
    $config['suffix']           = "?f=".$data['f']."&p=".$data['p']."&date=".$data['date']."&key=".$data['key'];
    $config['total_rows']       = $this->M_qbaca->getDataOrdersTotal($config['suffix']);
    // echo $config['total_rows'];
    $config['base_url']         = base_url().'snba/qbaca/transaction/';
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
    $this->pagination->initialize($config);
    $data['total_rows']         = $config['total_rows'];
    $data['transactions']       = $this->M_qbaca->getDataOrdersLimit($data['index'], $perpage, $config['suffix']);
    $data['amountOrders']       = $this->M_qbaca->getDataOrdersLimit(0, 0, $config['suffix']);
    $data['service_id']         = $this->M_main->getRow('od_user_level', 'name', $this->url[2])->id;
    
    if($data['date'] != "" && $data['p'] != "" && $data['f'] != "" && $this->ion_auth->in_group('maker'))
        $data['buttonProses']   = '<input type="submit" value="Preview BA" class="btn btn-success btn-flat btn-sm">';
    else $data['buttonProses']  = "";
    return $data;
  }
}