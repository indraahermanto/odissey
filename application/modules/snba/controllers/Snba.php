<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Snba extends MY_Controller {
  
  function __construct(){
    parent::__construct();
    // $this->load->helper('toLogin');
    $this->url          = $this->uri->segment_array();
    $this->user         = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
    $this->user_id      = $this->session->userdata('id');
    $this->user_groups  = $this->ion_auth->get_users_groups($this->user_id)->result();
    $this->load->module(array('qbaca', 'reports', 'invoices', 'spb', 'task', 'notifications'));
  }

  function index(){
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else if(!$this->ion_auth->in_group('snba')) { // remove this elseif if you want to enable this for non-admins
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      redirect();
    }else {
      $data['adv_menu']       = $this->main->menuSnba();
      $data['url']            = $this->url;
      $data['left_side']      = implode('/', $this->url);
      $data['user']           = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));

      $data['title']          = 'Odissey : Settlement Home';
      $data['page_header']    = 'Settlement Dashboard';
      $data['description']    = '';
      $data['content_view']   = 'snba/main.php';
      $data['additionalCSS']  = 'snba/additionalCSS';
      $data['additionalJS']   = 'snba/additionalJS';
      $this->template->call_snba_template($data);
    }
  }

  function qbaca($id = null){
    // access_page('snba');
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else { // remove this elseif if you want to enable this for non-admins
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      if($this->ion_auth->in_group('snba')){
        $data = $this->qbaca->snba_qbaca();
        $data['adv_menu']       = "";
        $data['adv_menu']      .= $this->main->menuSnba();
        $data['user']           = $this->user;
        $data['url']            = $this->url;
        $data['left_side']      = implode('/', $this->url);
        $data['page_header']    = 'Transaction Qbaca';
        $data['description']    = '';
        $data['title']          = 'Odissey: All Transaction Qbaca';
        $data['content_view']   = 'qbaca/snba/main.php';
        $data['additionalCSS']  = 'qbaca/snba/additionalCSS.php';
        $data['additionalJS']   = 'qbaca/snba/additionalJS.php';
        $this->template->call_snba_template($data);
      }else redirect('');
    }
  }

  function reports($action = null){
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else { // remove this elseif if you want to enable this for non-admins
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      if($this->ion_auth->in_group('snba')){
        if($action != ''){
          switch ($action) {
            case 'preview':
              if(isset($this->url[4]) && $this->url[4] == 'new'){
                $data = $this->reports->preview_new();
                $data['content_view']   = 'reports/snba/preview_new_v.php';
              }else {
                $data = $this->reports->preview($this->url[4]);
                $data['content_view']   = 'reports/preview_v.php';
              }

              $data['page_header']    = 'Preview Berita Acara';
              $data['description']    = '';
              $data['title']          = 'Odissey: Preview Berita Acara';
              break;

            case 'maker':
              $this->reports->makeReport();
              break;

            case 'submit':
              $this->reports->submitReport();
              break;
          }
          
        }else{
          $data                   = $this->reports->snba_reports();
          $data['page_header']    = 'All Reports';
          $data['description']    = '';
          $data['title']          = 'Odissey: All Reports';
          $data['content_view']   = 'reports/snba/main.php';
        }

        $data['adv_menu']       = "";
        $data['adv_menu']      .= $this->main->menuSnba();
        $data['user']           = $this->user;
        $data['url']            = $this->url;
        $data['left_side']      = implode('/', $this->url);
        $data['additionalCSS']  = 'reports/snba/additionalCSS.php';
        $data['additionalJS']   = 'reports/snba/additionalJS.php';
        $this->template->call_snba_template($data);
      }else redirect('');
    }
    
    // // access_page('snba');
    // if($id != null){
    //   $url = $this->url; $ba_number="";
    //   if(isset($url[4]))
    //     $ba_number = $url[4];
    //   if(isset($url[3]))
    //     $action = $url[3];
    //   // echo 'a '.$action." b ".$ba_number;
    //   switch ($action) {
    //     case 'preview':
    //       if(isset($ba_number) && $ba_number!= "")
    //         $data = $this->reports->preview($ba_number);
    //       else $data = $this->reports->previewNew();
    //     break;
    //     case 'submit'   : $this->reports->submitBA();break;
    //     // case 'approve'  : $this->reports->approveBA();break;
    //     case 'maker'    : $this->reports->makeNew();break;
    //   }
    //   $this->template->call_snba_template($data);
    // }else{
    //   $data = $this->reports->main();
    //   $this->template->call_snba_template($data);
    // }
  }

  function invoices($action = null){
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else { // remove this elseif if you want to enable this for non-admins
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      if($this->ion_auth->in_group('snba')){
        if($action != ''){
          switch ($action) {
            case 'preview':
              $data = $this->invoices->preview($this->url[4]);
              $data['content_view']   = 'invoices/preview_v.php';
              $data['page_header']    = 'Preview Invoice';
              $data['description']    = '';
              $data['title']          = 'Odissey: Preview Invoice';
              break;

            case 'approve':
              $this->invoices->approveInvoice();
              break;

            case 'reject':
              $this->invoices->rejectInvoice();
              break;
          }
          
        }else{
          $data                   = $this->invoices->snba_invoices();
          $data['page_header']    = 'All Invoices';
          $data['description']    = '';
          $data['title']          = 'Odissey: All Invoices';
          $data['content_view']   = 'invoices/snba/main.php';
        }

        $data['adv_menu']       = "";
        $data['adv_menu']      .= $this->main->menuSnba();
        $data['user']           = $this->user;
        $data['url']            = $this->url;
        $data['left_side']      = implode('/', $this->url);
        $data['additionalCSS']  = 'invoices/snba/additionalCSS.php';
        $data['additionalJS']   = 'invoices/snba/additionalJS.php';
        $this->template->call_snba_template($data);
      }else redirect('');
    }
  }

  function view_pdf($document = null){
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else {
      if($this->ion_auth->in_group('snba')){
        if($document != ''){
          switch ($document) {
            case 'reports':
              $this->reports->view_pdf_report($this->url[4]);
              break;

            case 'spb':
              $this->spb->view_pdf_spb($this->url[4]);
              break;
          }
          
        }else redirect('');
      }else redirect('');
    }
  }

  function task($action = null){
    // $reviewUser = 0;
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else {
      if($this->ion_auth->in_group('snba')){
        if($this->ion_auth->in_group('telkom')){
          // untuk viewer telkom organik
          // $reviewUser = 1;
          if($action != ''){
            switch ($action) {
              case 'preview':
                $data                   = $this->task->preview_task($this->url[4]);
                $data['page_header']    = "Lihat Aktivitas";
                $data['description']    = '';
                $data['title']          = 'Odissey: Lihat Aktivitas';
                $data['content_view']   = 'task/preview.php';
                break;
              case 'new':
                $data                   = $this->task->new_task();
                $data['page_header']    = "Aktivitas saya hari ini?";
                $data['description']    = '';
                $data['title']          = 'Odissey: Aktivitas Baru';
                $data['content_view']   = 'task/TLH/new.php';
                break;
              case 'create':
                $this->task->createTask();
                break;
              case 'review':
                $this->task->reviewTask($this->url[4]);
                break;
              default:
                redirect('snba/task');
                break;
            }
            // return show_error("Anda tidak diijinkan mengakses link ini.");
          }else{
            $data                   = $this->task->telkom_task();
            $data['page_header']    = 'Log Aktivitas';
            $data['description']    = '';
            $data['title']          = 'Odissey: Log Aktivitas';
            $data['content_view']   = 'task/main.php';
          }
        }else{
          // untuk TLH
          if($action != ''){
            switch ($action) {
              case 'new':
                $data                   = $this->task->new_task();
                $data['page_header']    = "Aktivitas saya hari ini?";
                $data['description']    = '';
                $data['title']          = 'Odissey: Aktivitas Baru';
                $data['content_view']   = 'task/TLH/new.php';
                break;
              case 'preview':
                $data                   = $this->task->preview_task($this->url[4]);
                $data['page_header']    = "Lihat Aktivitas";
                $data['description']    = '';
                $data['title']          = 'Odissey: Lihat Aktivitas';
                $data['content_view']   = 'task/preview.php';
                break;
              // case 'edit':
              //   $data                   = $this->task->preview_task($this->url[4]);
              //   $data['page_header']    = "Aktivitas Saya";
              //   $data['description']    = '';
              //   $data['title']          = 'Odissey: Aktivitas Saya';
              //   $data['content_view']   = 'task/TLH/edit.php';
              //   break;
              case 'save':
                $this->task->saveTask();
                break;
              // case 'discard':
              //   $_SESSION['note'] = "disTask";
              //   redirect('snba/task');
              //   break;
              case 'create':
                $this->task->createTask();
                break;
            }
          }else{
            $data                   = $this->task->tlh_task();
            $data['page_header']    = 'Log Aktivitas';
            $data['description']    = '';
            $data['title']          = 'Odissey: Log Aktivitas';
            $data['content_view']   = 'task/TLH/main.php';
          }
        }
        // if($reviewUser)      = 
        $data['adv_menu']       = "";
        $data['adv_menu']      .= $this->main->menuSnba();
        $data['user']           = $this->user;
        $data['url']            = $this->url;
        $data['left_side']      = implode('/', $this->url);
        $data['additionalCSS']  = 'task/TLH/additionalCSS.php';
        $data['additionalJS']   = 'task/TLH/additionalJS.php';
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
      if($this->ion_auth->in_group('snba')){
        if($action != ''){
          switch ($action) {
            case 'preview':
              if(isset($this->url[4]) && $this->url[4] == 'new'){
                $data = $this->spb->preview_new($this->url[5]);
                $data['content_view']   = 'spb/snba/preview_new_v.php';
              }else {
                $data = $this->spb->preview($this->url[4]);
                $data['content_view']   = 'spb/preview_v.php';
              }

              $data['page_header']    = 'Preview Surat Perintah Bayar';
              $data['description']    = '';
              $data['title']          = 'Odissey: Preview Surat Perintah Bayar';
              break;

            case 'maker':
              $this->spb->makeSPB();
              break;

            case 'approve':
              $this->spb->approveSPB();
              break;

            case 'upload':
              $data = $this->spb->uploadsSPB();
              $data['content_view']   = 'spb/snba/upload_v.php';
              $data['page_header']    = 'Upload Bukti Bayar';
              $data['description']    = '';
              $data['title']          = 'Odissey: Upload Bukti Bayar';
              break;

            case 'upload_bayar':
              $this->spb->upload_bayar();
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
        $data['adv_menu']      .= $this->main->menuSnba();
        $data['user']           = $this->user;
        $data['url']            = $this->url;
        $data['left_side']      = implode('/', $this->url);
        $data['additionalCSS']  = 'spb/snba/additionalCSS.php';
        $data['additionalJS']   = 'spb/snba/additionalJS.php';
        $this->template->call_snba_template($data);
      }else redirect('');
    }
  }

  function notifications($action = null){
    // $reviewUser = 0;
    if (!$this->ion_auth->logged_in()){
      redirect('main/login');
    } else {
      $data['page_header']    = 'All Surat Perintah Bayar';
      $data['description']    = '';
      $data['title']          = 'Odissey: All Surat Perintah Bayar';
      $data['content_view']   = 'notifications/main.php';
      $data['adv_menu']       = "";
      $data['adv_menu']      .= $this->main->menuSnba();
      $data['user']           = $this->user;
      $data['url']            = $this->url;
      $data['left_side']      = implode('/', $this->url);
      $data['additionalCSS']  = 'notifications/additionalCSS.php';
      $data['additionalJS']   = 'notifications/additionalJS.php';
      $this->template->call_snba_template($data);
    }
  }
}