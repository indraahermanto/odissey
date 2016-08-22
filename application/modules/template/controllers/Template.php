<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Template extends MY_Controller {
  
  function __construct(){
    parent::__construct();
    $this->login = $this->session->userdata('logged_in');
  }
  
  function call_nologin_template($data=null){
    //to call nologin template view
    $this->load->view('nologin_template_v', $data);
  }

  function call_login_template($data=null){
    //to call nologin template view
    $this->load->view('login_template_v', $data);
  }

  function call_admin_template($data=null){
    //to call admin template view
    $this->load->view('admin_template_v', $data);
  }

  function call_partner_template($data=null){
    //to call admin template view
    $this->load->view('partner_template_v', $data);
  }

  function call_snba_template($data=null){
    //to call admin template view
    $this->load->view('snba_template_v', $data);
  }

  function call_telkom_template($data=null){
    //to call admin template view
    $this->load->view('user_template_v', $data);
  }
}