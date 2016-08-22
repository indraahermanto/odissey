<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Notifications extends MY_Controller {
  
  function __construct(){
    parent::__construct();
    // $this->load->helper('toLogin');
    $this->url          = $this->uri->segment_array();
    $this->user         = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
    $this->user_id      = $this->session->userdata('id');
    $this->user_groups  = $this->ion_auth->get_users_groups($this->user_id)->result();
  }

  function index(){
    
  }
}