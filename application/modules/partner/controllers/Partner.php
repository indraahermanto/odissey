<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->url          = $this->uri->segment_array();
		$this->user         = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
    $this->user_id      = $this->session->userdata('id');
    $this->user_groups  = $this->ion_auth->get_users_groups($this->user_id)->result();
    $this->load->module(array('reports', 'invoices'));
	}

	// redirect if needed, otherwise display the user list
	// function index(){
	// 	if (!$this->ion_auth->logged_in()){
	// 		// redirect them to the login page
	// 		redirect('member/login', 'refresh');
	// 	} else {
	// 		if($this->ion_auth->is_admin()){
 //        $data['adv_menu'] ="<li><a href='".base_url()."admin'><i class='fa fa-user-secret'></i> <span>Admin Page</span></a></li>";
 //      }else $data['adv_menu'] = "";

	// 		$data['page_header']    = 'Orders';
 //      $data['description']    = '';
 //      $data['title']          = 'MantoSys: Home';
 //      $data['url']            = $this->url;
 //      $data['left_side']      = implode('/', $this->url);
 //      $data['content_view']   = 'partner/main.php';
 //      $data['additionalCSS']  = 'partner/additionalCSS.php';
 //      $data['additionalJS']   = 'partner/additionalJS.php';
 //      $this->template->call_partner_template($data);
	// 	}
	// }

  function admin_partner(){
    // $this->load->module('partner');
    $this->load->model(array(
      'snba/M_partner'
    ));

    // ?status=active&partner=Whqo&service=&key=
    // $data['key']            = @$this->input->get('key');
    $data['partner']           = @$this->input->get('partner');
    // $data['p']              = @$this->input->get('p');
    // $data['partners']       = $this->M_partner->getAllPartner();
    if($this->input->get('status'))
      $data['status']            = $this->input->get('status');
    else $data['status']         = '';
    
    $perpage = 20;
    $data['index'] = ($this->uri->segment(3, 0)-1)*$perpage;
    if($data['index'] === -$perpage) $data['index'] = 0;

    $config['base_url']         = base_url().$this->url[1].'/partners';
    $config['suffix']           = "?status=".$data['status']."&partner=".$data['partner']."&service=";
    $config['total_rows']       = $this->M_partner->getPartnersTotal($config['suffix']);
    // echo $config['total_rows'];
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
    $data['partners']           = $this->M_partner->getPartnersLimit($data['index'], $perpage, $config['suffix']);
    // $data['service_id']         = $this->M_main->getRow('od_user_level', 'name', $this->url[2])->id;
    
    // if($data['date'] != "" && $data['f'] != "" && $this->ion_auth->in_group('maker'))
    //     $data['buttonProses']   = '<input type="submit" value="Proses" class="btn btn-success btn-flat btn-sm">';
    // else $data['buttonProses']  = "";
    return $data;
  }

	function qbaca($id = null){
    // access_page('snba');
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    }else if($this->ion_auth->in_group('qbaca')){
      $this->load->module(array('qbaca'));
      $data                   = $this->qbaca->partner_qbaca();
      $data['adv_menu']       = "";
      $data['adv_menu']      .= $this->main->menuPartner();
      $data['user']           = $this->user;
      $data['url']            = $this->url;
      $data['left_side']      = implode('/', $this->url);
      $data['page_header']    = 'Transaction Qbaca';
      $data['description']    = '';
      $data['title']          = 'Odissey: All Transaction Qbaca';
      $data['content_view']   = 'qbaca/main.php';
      $data['additionalCSS']  = 'qbaca/additionalCSS.php';
      $data['additionalJS']   = 'qbaca/additionalJS.php';
      $this->template->call_partner_template($data);
    }else{
      // remove this elseif if you want to enable this for non-partner
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      redirect();
    }
  }

  function reports($action = null){
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else { // remove this elseif if you want to enable this for non-admins
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      if($this->ion_auth->in_group('partner')){
        if($action != ''){
          switch ($action) {
            case 'preview':
              if(isset($this->url[4]) && $this->url[4] == 'new'){
                // $data = $this->reports->preview_new();
                // $data['content_view']   = 'reports/snba/preview_new_v.php';
                redirect($this->url[1]."/reports");
              }else {
                $data = $this->reports->preview($this->url[4]);
                $data['content_view']   = 'reports/preview_v.php';
              }

              $data['page_header']    = 'Preview Berita Acara';
              $data['description']    = '';
              $data['title']          = 'Odissey: Preview Berita Acara';
              break;

            case 'approve':
              $this->reports->approveReport();
              break;
          }
          
        }else{
          $data                   = $this->reports->partner_reports();
          $data['page_header']    = 'All Reports';
          $data['description']    = '';
          $data['title']          = 'Odissey: All Reports';
          $data['content_view']   = 'reports/main.php';
        }

        $data['adv_menu']       = "";
        $data['adv_menu']      .= $this->main->menuPartner();
        $data['user']           = $this->user;
        $data['url']            = $this->url;
        $data['left_side']      = implode('/', $this->url);
        $data['additionalCSS']  = 'reports/additionalCSS.php';
        $data['additionalJS']   = 'reports/additionalJS.php';
        $this->template->call_partner_template($data);
      }else redirect('');
    }
  }

  function invoices($action = null){
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else { // remove this elseif if you want to enable this for non-admins
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      if($this->ion_auth->in_group('partner')){
        if($action != ''){
          switch ($action) {
            case 'preview':
              if(isset($this->url[4]) && $this->url[4] == 'new'){
                $data = $this->invoices->preview_new();
                $data['content_view']   = 'invoices/preview_new_v.php';
                // redirect($this->url[1]."/invoices");
              }else {
                $data = $this->invoices->preview($this->url[4]);
                $data['content_view']   = 'invoices/preview_v.php';
              }
              $data['page_header']    = 'Preview Invoice';
              $data['description']    = '';
              $data['title']          = 'Odissey: Preview Invoice';
              break;

            case 'new':
              $data = $this->invoices->newInvoice();
              $data['content_view']   = 'invoices/new.php';
              $data['page_header']    = 'New Invoice';
              $data['description']    = '';
              $data['title']          = 'Odissey: New Invoice';
              break;
              
            case 'maker':
              $this->invoices->makeInvoice();
              break;

            case 'change_file':
              $this->invoices->uploadFP();
              break;
          }
          
        }else{
          $data                   = $this->invoices->partner_invoices();
          $data['page_header']    = 'All Invoices';
          $data['description']    = '';
          $data['title']          = 'Odissey: All Invoices';
          $data['content_view']   = 'invoices/main.php';
        }

        $data['adv_menu']       = "";
        $data['adv_menu']      .= $this->main->menuPartner();
        $data['user']           = $this->user;
        $data['url']            = $this->url;
        $data['left_side']      = implode('/', $this->url);
        $data['additionalCSS']  = 'invoices/additionalCSS.php';
        $data['additionalJS']   = 'invoices/additionalJS.php';
        $this->template->call_partner_template($data);
      }else redirect('');
    }
  }
}