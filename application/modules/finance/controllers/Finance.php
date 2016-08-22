<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Finance extends MY_Controller {
  
  function __construct(){
    parent::__construct();
    // $this->load->helper('toLogin');
    $this->url          = $this->uri->segment_array();
    $this->user         = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
    $this->user_id      = $this->session->userdata('id');
    $this->user_groups  = $this->ion_auth->get_users_groups($this->user_id)->result();
    $this->load->module(array('qbaca', 'reports', 'invoices', 'spb'));
  }

  function index(){
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else if(!$this->ion_auth->in_group('finance')) { // remove this elseif if you want to enable this for non-admins
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      redirect();
    }else {
      $data['adv_menu']       = "";
      $data['adv_menu']      .= $this->main->menuFinance();
      $data['url']            = $this->url;
      $data['left_side']      = implode('/', $this->url);
      $data['user']           = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));

      $data['title']          = 'Odissey : Finance Home';
      $data['page_header']    = 'Finance Dashboard';
      $data['description']    = '';
      $data['content_view']   = 'finance/main.php';
      $data['additionalCSS']  = 'finance/additionalCSS';
      $data['additionalJS']   = 'finance/additionalJS';
      $this->template->call_snba_template($data);
    }
  }

  function reports($action = null){
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else { // remove this elseif if you want to enable this for non-admins
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      if($this->ion_auth->in_group('finance')){
        if($action != ''){
          switch ($action) {
            case 'preview':
              $data = $this->reports->preview($this->url[4]);
              $data['content_view']   = 'reports/preview_v.php';
              $data['page_header']    = 'Preview Berita Acara';
              $data['description']    = '';
              $data['title']          = 'Odissey: Preview Berita Acara';
              break;
          }
          
        }else{
          $data                   = $this->reports->snba_reports();
          $data['page_header']    = 'All Reports';
          $data['description']    = '';
          $data['title']          = 'Odissey: All Reports';
          $data['content_view']   = 'reports/finance/main.php';
        }

        $data['adv_menu']       = "";
        $data['adv_menu']      .= $this->main->menuFinance();
        $data['user']           = $this->user;
        $data['url']            = $this->url;
        $data['left_side']      = implode('/', $this->url);
        $data['additionalCSS']  = 'reports/snba/additionalCSS.php';
        $data['additionalJS']   = 'reports/snba/additionalJS.php';
        $this->template->call_snba_template($data);
      }else redirect('');
    }
  }

  function invoices($action = null){
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else { // remove this elseif if you want to enable this for non-admins
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      if($this->ion_auth->in_group('finance')){
        if($action != ''){
          switch ($action) {
            case 'preview':
              $data = $this->invoices->preview($this->url[4]);
              $data['content_view']   = 'invoices/preview_v.php';
              $data['page_header']    = 'Preview Invoice';
              $data['description']    = '';
              $data['title']          = 'Odissey: Preview Invoice';
              break;
          }
          
        }else{
          $data                   = $this->invoices->snba_invoices();
          $data['page_header']    = 'All Invoices';
          $data['description']    = '';
          $data['title']          = 'Odissey: All Invoices';
          $data['content_view']   = 'invoices/finance/main.php';
        }

        $data['adv_menu']       = "";
        $data['adv_menu']      .= $this->main->menuFinance();
        $data['user']           = $this->user;
        $data['url']            = $this->url;
        $data['left_side']      = implode('/', $this->url);
        $data['additionalCSS']  = 'invoices/snba/additionalCSS.php';
        $data['additionalJS']   = 'invoices/snba/additionalJS.php';
        $this->template->call_snba_template($data);
      }else redirect('');
    }
  }

  function spb($action = null){
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else {
      // remove this elseif if you want to enable this for non-admins
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      if($this->ion_auth->in_group('finance')){
        if($action != ''){
          switch ($action) {
            case 'preview':
              $data = $this->spb->preview($this->url[4]);
              $data['content_view']   = 'spb/preview_v.php';
              $data['page_header']    = 'Preview Surat Perintah Bayar';
              $data['description']    = '';
              $data['title']          = 'Odissey: Preview Surat Perintah Bayar';
              break;

            case 'approve':
              $this->spb->completeSPB();
              break;
          }
          
        }else{
          $data                   = $this->spb->snba_spb();
          $data['page_header']    = 'All Surat Perintah Bayar';
          $data['description']    = '';
          $data['title']          = 'Odissey: All Surat Perintah Bayar';
          $data['content_view']   = 'spb/snba/main.php';
        }

        $data['adv_menu']       = "";
        $data['adv_menu']      .= $this->main->menuFinance();
        $data['user']           = $this->user;
        $data['url']            = $this->url;
        $data['left_side']      = implode('/', $this->url);
        $data['additionalCSS']  = 'spb/snba/additionalCSS.php';
        $data['additionalJS']   = 'spb/snba/additionalJS.php';
        $this->template->call_snba_template($data);
      }else redirect('');
    }
  }
}