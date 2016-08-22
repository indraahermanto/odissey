<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	function __construct(){
		parent::__construct();
    $this->url = $this->uri->segment_array();
    $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

    $this->lang->load('auth');
    // $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

    // $this->lang->load('auth');
	}

	function index(){
    if (!$this->ion_auth->logged_in()){
      $data['page_header'] = '';
      $data['description'] = '';
      $data['title'] = 'Welcome to Odissey';
      // $this->template->call_nologin_template($data);
      redirect('main/login');

    } else { // remove this elseif if you want to enable this for non-admins
      // redirect them to the home page because they must be an administrator to view this
      // return show_error('You must be an administrator to view this page.');
      if($this->ion_auth->is_admin()){
        redirect('admin');
        // echo "<pre>";
        // $data['user']           = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
        // $user_groups = $this->ion_auth->get_users_groups($data['user']->id)->result();
        // print_r($user_groups);
        // $data['adv_menu']       = "";
        // $data['url']            = $this->url;
        // $select                 = "";
        // $data['left_side']      = implode('/', $this->url);
        // $data['adv_menu']    .= "<li><a href='".base_url()."admin'><i class='fa fa-user-secret'></i> <span>Admin Page</span></a></li>";
      } else if($this->ion_auth->in_group('snba')){
        redirect('snba');
        // default partner
        // $data['adv_menu']       = "";
        // $data['adv_menu']      .= $this->menuQbaca();
        // $data['url']            = $this->url;
        // $data['left_side']      = implode('/', $this->url);
        // $data['user']           = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
        // $data['page_header']    = 'Dashboard';
        // $data['description']    = '';
        // $data['title']          = 'MantoSys: Home';
        // $data['content_view']   = 'main/main.php';
        // $data['additionalCSS']  = 'main/additionalCSS.php';
        // $data['additionalJS']   = 'main/additionalJS.php';
        // $this->template->call_partner_template($data);
      }else if($this->ion_auth->in_group('finance')){
        redirect('finance');
      }else{
        
        // default partner
        $data['adv_menu']       = "";
        $data['adv_menu']       = $this->menuPartner();
        $data['user']           = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
        $data['page_header']    = 'Dashboard';
        $data['description']    = '';
        $data['title']          = 'Odissey: Home';
        $data['url']            = $this->url;
        $data['left_side']      = implode('/', $this->url);
        $data['content_view']   = 'main/main.php';
        $data['additionalCSS']  = 'main/additionalCSS.php';
        $data['additionalJS']   = 'main/additionalJS.php';
        $this->template->call_partner_template($data);
      }
    }
  }

  // log the user in
  function login(){
    $data['title'] = $this->lang->line('login_heading');

    //validate form input
    $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
    $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

    if ($this->form_validation->run() == true){
      // check to see if the user is logging in
      // check for "remember me"
      $remember = (bool) $this->input->post('remember');

      if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)){
        //if the login is successful
        //redirect them back to the home page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('/', 'refresh');
      } else {
        // if the login was un-successful
        // redirect them back to the login page
        $this->session->set_flashdata('message', $this->ion_auth->errors());
        redirect('main/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
      }
    } else {
      // the user is not logging in so display the login page
      // set the flash data error message if there is one
      $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      $data['identity'] = array('name' => 'identity',
        'id'    => 'identity',
        'type'  => 'text',
        'value' => $this->form_validation->set_value('identity'),
      );
      $data['password'] = array('name' => 'password',
        'id'   => 'password',
        'type' => 'password',
      );
      $data['content_view'] = 'main/auth/login';
      $this->template->call_login_template($data);
      // $this->_render_page('auth/login', $data);
    }
  }

  // log the user out
  function logout(){
    $data['title'] = "Logout";

    // log the user out
    $logout = $this->ion_auth->logout();

    // redirect them to the login page
    $this->session->set_flashdata('message', $this->ion_auth->messages());
    redirect('main/login', 'refresh');
  }

  function mainMenu(){
    $url = implode('/', $this->url);
    $menu = "";
    if(!isset($this->url[1]))
      $this->url[1] = "partner";
    substr_count($url, $this->url[1].'/reports') > 0 ? $select = 'active' : $select = "";
      $menu .= "<li class='".$select."'><a href='".base_url().$this->url[1]."/reports/'><i class='fa fa-bookmark'></i> <span>Reports</span></a></li>";
    substr_count($url, $this->url[1].'/invoices') > 0 ? $select = 'active' : $select = "";
      $menu .= "<li class='".$select."'><a href='".base_url().$this->url[1]."/invoices/'><i class='fa fa-credit-card'></i> <span>Invoices</span></a></li>";
    return $menu;
  }

  function menuLayanan($all=null){
    $url = implode('/', $this->url);
    $select = ""; $menu = "";
    if(!isset($this->url[1]))
      $this->url[1] = "partner";

    if($this->ion_auth->in_group('qbaca') || $all == 'all'){
      substr_count($url, 'qbaca') > 0 ? $select = 'active' : $select = "";
        $menu .= "<li class='".$select."'><a href='".base_url().$this->url[1]
              ."/qbaca/transaction'><i class='fa fa-book'></i> <span>Qbaca</span></a></li>";
    }

    return $menu;
  }

  function menuBayar(){
    $url    = implode('/', $this->url);
    $menu   = "";
    substr_count($url, $this->url[1].'/spb') > 0 ? $select = 'active' : $select = "";
      $menu .= "<li class='".$select."'><a href='".base_url().$this->url[1]."/spb/'><i class='fa fa-archive'></i> <span>SPB</span></a></li>";
    return $menu;
  }

  function menuAdmin(){
    $url    = implode('/', $this->url);
    $menu   = "";
    substr_count($url, 'users') > 0 ? $select = 'active' : $select = "";
      $menu .= "<li class='".$select."'><a href='".base_url().$this->url[1]
            ."/users'><i class='fa fa-user'></i> <span>Users</span></a></li>";
    substr_count($url, 'partners') > 0 ? $select = 'active' : $select = "";
      $menu .= "<li class='".$select."'><a href='".base_url().$this->url[1]
            ."/partners'><i class='fa fa-group'></i> <span>Partners</span></a></li>";
    $menu  .= $this->menuLayanan('all');
    $menu  .= $this->mainMenu();
    $menu  .= $this->menuBayar();
    return $menu;
  }

  function menuPartner(){
    $menu     = "";
    $menu    .= $this->menuLayanan();
    $menu    .= $this->mainMenu();
    return $menu;
  }

  function menuSnba(){
    $url    = implode('/', $this->url);
    $menu = "";
    $menu  .= $this->menuLayanan('all');
    $menu  .= $this->mainMenu();
    $menu  .= $this->menuBayar();
    //  fa-tasks
    substr_count($url, $this->url[1].'/task') > 0 ? $select = 'active' : $select = "";
      $menu .= "<li class='".$select."'><a href='".base_url().$this->url[1]."/task/'><i class='fa fa-tasks'></i> <span>Log Aktivitas</span></a></li>";
    return $menu;
  }

  function menuFinance(){
    $menu = "";
    // $menu  .= $this->menuLayanan('all');
    $menu  .= $this->mainMenu();
    $menu  .= $this->menuBayar();
    return $menu;
  }
}