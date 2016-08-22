<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->url = $this->uri->segment_array();
	}

	// redirect if needed, otherwise display the user list
	function index(){
		if (!$this->ion_auth->logged_in()){
			// redirect them to the login page
			redirect('member/login', 'refresh');
		} else {
			if($this->ion_auth->is_admin()){
        $data['adm_menu'] ="<li><a href='".base_url()."admin'><i class='fa fa-user-secret'></i> <span>Admin Page</span></a></li>";
      }else $data['adm_menu'] = "";

			$data['page_header']    = 'Orders';
      $data['description']    = '';
      $data['title']          = 'MantoSys: Home';
      $data['url']            = $this->url;
      $data['left_side']      = implode('/', $this->url);
      $data['content_view']   = 'orders/main.php';
      $data['additionalCSS']  = 'orders/additionalCSS.php';
      $data['additionalJS']   = 'orders/additionalJS.php';
      $this->template->call_user_template($data);
		}
	}
}