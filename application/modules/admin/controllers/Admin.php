<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->url = $this->uri->segment_array();
		$this->load->model(array(
				'partner/snba/M_partner', 'main/M_main', 'M_Payment'
			));
		$this->load->modules(array(
				'partner'
			));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		// $this->lang->load('auth');
	}

	// redirect if needed, otherwise display the user list
	function index(){
		if (!$this->ion_auth->logged_in()){
			// redirect them to the login page
			redirect('main/login', 'refresh');
		} elseif (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else {
			$data['message'] = $this->session->userdata('notes');
			
			$data['adv_menu']       = "";
      $data['adv_menu']      .= $this->main->menuAdmin();
      $data['url']            = $this->url;
      $data['left_side']      = implode('/', $this->url);
      $data['user']           = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));

			$data['page_header']    = 'Dashboard';
      $data['description']    = '';
      $data['title']          = 'Odissey: Home';
      $data['url']            = $this->url;
      $data['left_side']      = implode('/', $this->url);
      $data['content_view']   = 'admin/main.php';
      $data['additionalCSS']  = 'admin/additionalCSS.php';
      $data['additionalJS']   = 'admin/additionalJS.php';
      // $data['saldoBank']			= $this->M_Transaction->getSaldo('bank');
      // $data['saldoCash']			= $this->M_Transaction->getSaldo('cash');
      // $data['saldoPulsa']			= $this->M_Transaction->getSaldo('pulsa');
      // $data['saldoWallet']		= $this->M_Transaction->getSaldo('wallet');

      $this->template->call_admin_template($data);
      
		}
	}

	function users($action = null){
		if (!$this->ion_auth->logged_in()){
			// redirect them to the login page
			redirect('users/login', 'refresh');
		} elseif (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else {

			//list the users
			$data['users'] = $this->ion_auth->users()->result();
			foreach ($data['users'] as $k => $user){
				$data['users'][$k]->roles = $this->ion_auth->get_users_roles($user->id)->result();
				$data['users'][$k]->services = $this->ion_auth->get_users_services($user->id)->result();
			}

			$data['page_header']    = lang('index_heading');
      $data['description']    = lang('index_subheading');
      $data['title']          = 'Odissey: Users';
      $data['url']            = $this->url;
      $data['left_side']      = implode('/', $this->url);
			$data['content_view']   = 'admin/users/main.php';
			// set the flash data error message if there is one
			$data['adv_menu']       			= $this->main->menuAdmin();
			$data['user']           			= $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			isset($this->url[4]) ? $id = $this->url[4] : $id = "";
			switch (preg_replace("/[^0-9a-zA-Z]/", '', strtolower($action))) {
				case 'new':
					// $this->load->model(array(''));
					$data 									= $this->create_user();
					$data['page_header']    = lang('create_user_heading');
		      $data['description']    = lang('create_user_subheading');
		      $data['title']          = 'Odissey: Home';
		      $data['url']            = $this->url;
		      $data['left_side']      = implode('/', $this->url);
					$data['content_view']   = 'admin/users/create_user.php';
					break;

				case 'edituser':
					$data 									= $this->edit_user($id);
					$data['page_header']    = lang('edit_user_heading');
		      $data['description']    = lang('edit_user_subheading');
		      $data['title']          = 'Odissey: Home';
		      $data['url']            = $this->url;
		      $data['left_side']      = implode('/', $this->url);
					$data['content_view']   = 'admin/users/edit_user.php';
					break;

				case 'changepassword':
					$data 									= $this->change_password();
					$data['page_header']    = lang('change_password_heading');
		      $data['description']    = '';
		      $data['title']          = 'Odissey: Home';
		      $data['url']            = $this->url;
		      $data['left_side']      = implode('/', $this->url);
					$data['content_view']   = 'admin/users/change_password.php';
					break;
			}

			$data['additionalCSS']  = 'admin/users/additionalCSS.php';
      $data['additionalJS']   = 'admin/users/additionalJS.php';

      $this->template->call_admin_template($data);
		}
	}

	function partners($action=null){
		$data										= $this->partner->admin_partner();
		$data['page_header']    = "Partners";
    $data['description']    = "";
    $data['title']          = 'Odissey: Partners';
		$data['content_view']   = 'admin/partners/main.php';

		if($action != null){
			switch (preg_replace("/[^0-9a-zA-Z]/", '', strtolower($action))) {
				case 'new':
					$data['page_header']    = "New Partner";
			    $data['description']    = "";
			    $data['title']          = 'Odissey: New Partner';
					$data['content_view']   = 'admin/partners/new_v.php';
					break;

				case 'edit':
					$data['page_header']    = "Edit Partner";
			    $data['description']    = "";
			    $data['title']          = 'Odissey: Edit Partner';
					$data['content_view']   = 'admin/partners/edit_v.php';
					break;
			}
		}

		$data['url']            = $this->url;
	  $data['left_side']      = implode('/', $this->url);
		$data['adv_menu']       = $this->main->menuAdmin();
		$data['user']           = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
		$data['additionalCSS']  = 'admin/partners/additionalCSS.php';
    $data['additionalJS']   = 'admin/partners/additionalJS.php';

    $this->template->call_admin_template($data);
	}

	// change password
	function change_password(){
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in()){
			redirect('main/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false){
			// display the form
			// set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$data['new_password'] = array(
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'pattern' => '^.{'.$data['min_password_length'].'}.*$',
			);
			$data['new_password_confirm'] = array(
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'pattern' => '^.{'.$data['min_password_length'].'}.*$',
			);
			$data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			return $data;
			// render
			// $this->_render_page('auth/change_password', $data);
		} else {
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change){
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('main/change_password', 'refresh');
			}
		}
	}

	// create a new user
	function create_user(){
    $data['title'] = $this->lang->line('create_user_heading');
    $data['adv_menu']       			= $this->main->menuAdmin();
		$data['user']           			= $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));

    if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()){
        redirect('member', 'refresh');
    }

    $tables = $this->config->item('tables','ion_auth');
    $identity_column = $this->config->item('identity','ion_auth');
    $data['identity_column'] = $identity_column;

    // validate form input
    $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
    $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
    if($identity_column!=='email'){
      $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
      $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
    } else {
      $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
    }
    $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
    // $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
    $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
    $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

    if ($this->form_validation->run() == true){
      $email    = strtolower($this->input->post('email'));
      $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
      $password = $this->input->post('password');

      $additional_data = array(
          'first_name' => $this->input->post('first_name'),
          'last_name'  => $this->input->post('last_name'),
          // 'company'    => $this->input->post('company'),
          // 'phone'      => $this->input->post('phone'),
      );
    }
    if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data)){
      // check to see if we are creating the user
      // redirect them back to the admin page
      $this->session->set_flashdata('message', $this->ion_auth->messages());
      redirect("auth", 'refresh');
    } else {
      // display the create user form
      // set the flash data error message if there is one
      $data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

      $data['first_name'] = array(
          'name'  => 'first_name',
          'id'    => 'first_name',
          'class'	=> 'form-control',
          'type'  => 'text',
          'value' => $this->form_validation->set_value('first_name'),
      );
      $data['last_name'] = array(
          'name'  => 'last_name',
          'id'    => 'last_name',
          'class'	=> 'form-control',
          'type'  => 'text',
          'value' => $this->form_validation->set_value('last_name'),
      );
      $data['identity'] = array(
          'name'  => 'identity',
          'id'    => 'identity',
          'class'	=> 'form-control',
          'type'  => 'text',
          'value' => $this->form_validation->set_value('identity'),
      );
      $data['email'] = array(
          'name'  => 'email',
          'id'    => 'email',
          'class'	=> 'form-control',
          'type'  => 'text',
          'value' => $this->form_validation->set_value('email'),
      );
      // $data['company'] = array(
      //     'name'  => 'company',
      //     'id'    => 'company',
      //     'type'  => 'text',
      //     'value' => $this->form_validation->set_value('company'),
      // );
      $data['phone'] = array(
          'name'  => 'phone',
          'id'    => 'phone',
          'class'	=> 'form-control',
          'type'  => 'text',
          'value' => $this->form_validation->set_value('phone'),
      );
      $data['password'] = array(
          'name'  => 'password',
          'id'    => 'password',
          'class'	=> 'form-control',
          'type'  => 'password',
          'value' => $this->form_validation->set_value('password'),
      );
      $data['password_confirm'] = array(
          'name'  => 'password_confirm',
          'id'    => 'password_confirm',
          'class'	=> 'form-control',
          'type'  => 'password',
          'value' => $this->form_validation->set_value('password_confirm'),
      );
      return $data;
      // $this->_render_page('auth/create_user', $data);
    }
  }

	// edit a user
	function edit_user($id){
		$data['title'] = $this->lang->line('edit_user_heading');

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))){
			redirect('member', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		// $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		// $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

		if (isset($_POST) && !empty($_POST)){
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')){
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password')){
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE){
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					// 'company'    => $this->input->post('company'),
					// 'phone'      => $this->input->post('phone'),
				);

				// update the password if it was posted
				if ($this->input->post('password')){
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin()){
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}
					}
				}

				// check to see if we are updating the user
		   	if($this->ion_auth->update($user->id, $data)){
		    	// redirect them back to the admin page if admin, or to the base url if non admin
			    $this->session->set_flashdata('message', $this->ion_auth->messages() );
			    if ($this->ion_auth->is_admin()){
						redirect('admin/member', 'refresh');
					} else {
						redirect('/', 'refresh');
					}
		    } else {
		    	// redirect them back to the admin page if admin, or to the base url if non admin
			    $this->session->set_flashdata('message', $this->ion_auth->errors() );
			    if ($this->ion_auth->is_admin()){
						redirect('admin/member', 'refresh');
					} else {
						redirect('/', 'refresh');
					}
		    }
			}
		}

		// display the edit user form
		$data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$data['user'] = $user;
		$data['groups'] = $groups;
		$data['currentGroups'] = $currentGroups;

		$data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		// $data['company'] = array(
		// 	'name'  => 'company',
		// 	'id'    => 'company',
		// 	'type'  => 'text',
		// 	'value' => $this->form_validation->set_value('company', $user->company),
		// );
		// $data['phone'] = array(
		// 	'name'  => 'phone',
		// 	'id'    => 'phone',
		// 	'type'  => 'text',
		// 	'value' => $this->form_validation->set_value('phone', $user->phone),
		// );
		$data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'class' => 'form-control',
			'type' => 'password'
		);
		$data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'class' => 'form-control',
			'type' => 'password'
		);

		return $data;
		// $this->_render_page('auth/edit_user', $data);
	}

	// create a new group
	function create_group(){
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()){
			redirect('member', 'refresh');
		}
		$data['title'] 					= $this->lang->line('create_group_title');
		$data['adv_menu']       = $this->main->menuAdmin();
		$data['user']           = $this->M_main->getRow('od_user', 'email', $this->session->userdata('email'));
		$data['left_side']      = implode('/', $this->url);
		$data['title']          = 'Odissey : Settlement Home';
    $data['page_header']    = 'Settlement Dashboard';
    $data['description']    = '';
      

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

		if ($this->form_validation->run() == TRUE){
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id){
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("admin/member", 'refresh');
			}
		} else {
			// display the create group form
			// set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			$this->_render_page('auth/create_group', $data);
		}
	}

	// edit a group
	function edit_group($id){
		// bail if no group id given
		if(!$id || empty($id)){
			redirect('member', 'refresh');
		}

		$data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()){
			redirect('member', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST)){
			if ($this->form_validation->run() === TRUE){
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update){
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("admin/member", 'refresh');
			}
		}

		// set the flash data error message if there is one
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		);
		$data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$this->_render_page('auth/edit_group', $data);
	}


	function _get_csrf_nonce(){
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce(){
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function transaction(){
		if (!$this->ion_auth->logged_in()){
			// redirect them to the login page
			redirect('main/login', 'refresh');
		} elseif (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
			// redirect them to the home page because they must be an administrator to view this
			redirect('member', 'refresh');
		} else {
			$data['page_header']    = 'All Transaction';
      $data['description']    = '';
      $data['title']          = 'Odissey: All Transaction';
      $data['url']            = $this->url;
      $data['left_side']      = implode('/', $this->url);
      $data['content_view']   = 'admin/transaction/main.php';
      $data['additionalCSS']  = 'admin/transaction/additionalCSS.php';
      $data['additionalJS']   = 'admin/transaction/additionalJS.php';

      $perpage = 20;
	    $index = ($this->uri->segment(3, 0)-1)*$perpage;
	    if($index === -$perpage) $index = 0;

	    $data['date']           		= @$this->input->get('date');
	    $data['stat']           		= @$this->input->get('stat');
	    $data['key']           			= @$this->input->get('key');
	    $config['suffix']           = "?stat=".$data['stat']."&date=".$data['date']."&key=".$data['key'];
	    $config['total_rows']       = $this->M_Transaction->getCountTrxTotal($config['suffix']);
	    $config['base_url']         = base_url().'admin/transaction/';
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
	    $data['tableTrx']        = $this->createTableTrx($index, $perpage, $config['suffix']);
	    $data['totalAmountTrx']  = $this->M_Transaction->getTotalAmountTrx($config['suffix']);
	    $data['buttMakReport']      = "";

      $this->template->call_admin_template($data);
		}
	}

	// Function input admin/transaction page
  function createTableTrx($index, $perpage, $search){
    
    $transactions = $this->M_Transaction->getDataTrxLimit($index, $perpage, $search);
    
    $table = "";$total=0;
    if($index == "")
      $no = 1;
    else $no = $index+1;
    foreach ($transactions as $transaction) {
      
      $table .= "<tr>";
      $table .= "<td>".$no."</td>";
      $table .= "<td>".$transaction->order_id."</td>";
      $table .= "<td>".ucwords($transaction->first_name." ".$transaction->last_name)."</td>";
      $table .= "<td>".ucfirst($transaction->otype_name)."</td>";
      $table .= "<td class='text-right'>".number_format($transaction->order_amount)."</td>";
      $table .= "<td>".$transaction->order_date."</td>";
      // $table .= "<td style='width:300px'>".$order->order_date."</td>";
      // $table .= "<td class='text-right'>".number_format($order->product_cost)."</td>";
      // $table .= "<td class='text-right'>".number_format($order->product_price)."</td>";
      // $table .= "<td class='text-right'>".number_format($order->product_profit)."</td>";
      // // $table .= "<td style='min-width:150px' class='text-center'>".$order->order_date."</td>";
      // // $table .= "<td class='text-center'>".$status."</td>";
      // $table .= "<td class='text-center'>".ucfirst(strtolower($order->istat_name))."</td>";
      $table .= "</tr>";
      // $total += $order->qtrx_price;
      $no++;
    }
    // $table .= "<tr>";
    // $table .= "<th colspan='3' class='text-center'>Sub Total</th>";
    // $table .= "<th class='text-right'>".number_format($total)."</th>";
    //$table .= "</tr></tfoot>";

    if(!count($transactions)){
      $table = "<tr><td colspan='7' class='text-center'>No data available</td></tr>";
    }
    return $table;
  }

	function orders($invoice_id=null){
		if (!$this->ion_auth->logged_in()){
			// redirect them to the login page
			redirect('main/login', 'refresh');
		} elseif (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
			// redirect them to the home page because they must be an administrator to view this
			redirect('member', 'refresh');
		} else {
			if(isset($invoice_id) && strlen($invoice_id) > 4){
				switch ($invoice_id) {
					case 'cancel':
						$invoice_number = @$this->input->post('inputInvoiceNo');
						if($invoice_number == "")
							redirect('admin/orders');
						$this->cancelInvoice($invoice_number);
						break;
					case 'update':
						$invoice_number = @$this->input->post('inputInvoiceNo');
						$cost = @$this->input->post('inputCost');
						$price = @$this->input->post('inputPrice');
						if($invoice_number == "" | !is_numeric($cost) | !is_numeric($price))
							return show_error('Price & cost must a number!');
						$data = $this->updateInvoice($invoice_number, $cost, $price);
						break;
				}

				$len = strlen($invoice_id);
				switch ($len) {
					case '5' : $id = substr($invoice_id, 0, 1); break;
					case '6' : $id = substr($invoice_id, 0, 2); break;
					case '7' : $id = substr($invoice_id, 0, 3); break;
					case '8' : $id = substr($invoice_id, 0, 4); break;
					case '9' : $id = substr($invoice_id, 0, 5); break;
					case '10': $id = substr($invoice_id, 0, 6); break;
				}
				$invoice = $this->M_Orders->getInvoiceRow('invoice_id', $id);
				if(sizeof($invoice) == 0 || substr($invoice->invoice_number, 0, 4) != substr($invoice_id, -4))
					return show_error('You must be an administrator to view this page.');
				$data['payments']				= $this->M_Payment->getPayment('c.invoice_number', $invoice->invoice_number);
				$data['page_header']    = 'Invoice';
	      $data['description']    = '';
	      $data['invoice']				= $invoice;
	      $data['title']          = 'Odissey: Invoice '.$invoice->invoice_number;
	      $data['content_view']   = 'admin/orders/editInvoice_v.php';
			}else{
				$data = $this->allOrder();
			}
			$data['message'] 				= $this->session->userdata('notes');
      $data['url']            = $this->url;
      $data['left_side']      = implode('/', $this->url);
      $data['additionalCSS']  = 'admin/orders/additionalCSS.php';
      $data['additionalJS']   = 'admin/orders/additionalJS.php';
			
      $this->template->call_admin_template($data);
		}
	}

	// cancel Invoice
	function cancelInvoice($invoice_key){
		$len = strlen($invoice_key);
		switch ($len) {
			case '5' : $id = substr($invoice_key, 0, 1); break;
			case '6' : $id = substr($invoice_key, 0, 2); break;
			case '7' : $id = substr($invoice_key, 0, 3); break;
			case '8' : $id = substr($invoice_key, 0, 4); break;
			case '9' : $id = substr($invoice_key, 0, 5); break;
			case '10': $id = substr($invoice_key, 0, 6); break;
		}
		$invoice = $this->M_Orders->getInvoiceRow('invoice_id', $id);
		// echo $invoice_key." ".substr($invoice->invoice_number, 0, 4)." = ".substr($invoice_key, -4)." ".sizeof($invoice);
		if(sizeof($invoice) == 0 || substr($invoice->invoice_number, 0, 4) != substr($invoice_key, -4))
			return show_error('Somthing Wrong!');
		$dataCancel = array('istat_code' => 'can'); // cancel
		$this->M_Orders->updateInvoice($invoice->invoice_number, $dataCancel);
		$this->M_Orders->cancelOrder($invoice->order_id, $invoice->order_date);
		sleep(2);
		redirect('admin/orders');
	}

	// update Invoice
	function updateInvoice($invoice_key, $cost, $price){
		$len = strlen($invoice_key);
		switch ($len) {
			case '5' : $id = substr($invoice_key, 0, 1); break;
			case '6' : $id = substr($invoice_key, 0, 2); break;
			case '7' : $id = substr($invoice_key, 0, 3); break;
			case '8' : $id = substr($invoice_key, 0, 4); break;
			case '9' : $id = substr($invoice_key, 0, 5); break;
			case '10': $id = substr($invoice_key, 0, 6); break;
		}
		$invoice = $this->M_Orders->getInvoiceRow('invoice_id', $id);
		echo $invoice_key." ".substr($invoice->invoice_number, 0, 4)." = ".substr($invoice_key, -4)." ".sizeof($invoice);
		if(sizeof($invoice) == 0 || substr($invoice->invoice_number, 0, 4) != substr($invoice_key, -4))
			return show_error('Somthing Wrong!');
		$profit 		= $price - $cost;
		$dataUpdate = array(
										'product_cost' => $cost, 		'product_price' => $price,
										'product_profit' => $profit
									); // update
		$this->M_Orders->updateInvoice($invoice->invoice_number, $dataUpdate);
		$this->M_Orders->editOrder($invoice->order_id, $invoice->order_date, $cost, $price);
		// $this->M_Payment->updatePayment();
		// $this->M_Orders->cancelOrder($invoice->order_id, $invoice->order_date);
		sleep(2);
		redirect('admin/orders');
	}

	// Index all order or All invoice
	function allOrder(){
		$data['page_header']    = 'All Orders';
    $data['description']    = '';
    $data['title']          = 'Odissey: All Orders';
    $data['content_view']   = 'admin/orders/main.php';

    $perpage = 20;
    $index = ($this->uri->segment(3, 0)-1)*$perpage;
    if($index === -$perpage) $index = 0;

    $data['date']           		= @$this->input->get('date');
    $data['key']           			= @$this->input->get('key');
    $data['stat']           		= @$this->input->get('stat');
    if($data['stat'] == 'all') $data['stat'] = "";
    $config['suffix']           = "?stat=".$data['stat']."&date=".$data['date']."&key=".$data['key']."&user=&sort=&by=";
    $config['total_rows']       = $this->M_Orders->getCountOrdersTotal($config['suffix']);
    $config['base_url']         = base_url().'admin/orders/';
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
    $data['tableOrders']        = $this->createTableOrders($index, $perpage, $config['suffix']);
    $data['listStat']      			= $this->dropdownInvoiceStat();
    return $data;
	}

	// Function input qbaca/orders page
  function createTableOrders($index, $perpage, $search){
    
    $orders = $this->M_Orders->getDataOrdersLimit($index, $perpage, $search);
    
    $table = ""; $totalPrice=0; $totalCost=0; $totalProfit=0;
    if($index == "")
      $no = 1;
    else $no = $index+1;
    foreach ($orders as $order) {
    	$id = $order->invoice_id.substr($order->invoice_number, 0, 4);
      
      $table .= "<tr>";
      $table .= "<td>".$no."</td>";
      $table .= "<td>".$this->convnumber->indonesian_date(strtotime($order->invoice_date), 'd F <br/> H:i', '')."</td>";
      $table .= "<td><a href='".base_url()."admin/orders/$id'>".$order->invoice_number."</a></td>";
      $table .= "<td>".ucwords($order->first_name." ".$order->last_name)."</td>";
      $table .= "<td>".$order->number_phone."</td>";
      $table .= "<td>".$order->product_code."</td>";
      $table .= "<td class='text-right'>".number_format($order->cost)."</td>";
      $table .= "<td class='text-right'>".number_format($order->price)."</td>";
      $table .= "<td class='text-right'>".number_format($order->rest_amount)."</td>";
      $table .= "<td class='text-center'>".ucfirst(strtolower($order->istat_name))."</td>";
      $table .= "</tr>";
      $totalPrice += $order->product_price;
      $totalCost += $order->product_cost;
      $no++;
    }
    $table .= "<tr>";
    $table .= "<th colspan='5' class='text-center'>Sub Total</th>";
    $table .= "<th class='text-right'>".number_format($totalCost)."</th>";
    $table .= "<th class='text-right'>".number_format($totalPrice)."</th>";
    $table .= "</tr></tfoot>";

    if(!count($orders)){
      $table = "<tr><td colspan='7' class='text-center'>No data available</td></tr>";
    }
    // print_r($orders);
    return $table;
  }

  function dropdownInvoiceStat(){
  	$list = "<ul class='dropdown-menu'>";
  	$list .= "<li><a href=".base_url()."admin/orders/?stat=all>All</a></li>";
  	$stats = $this->M_Orders->getAllInvoiceStat();
  	foreach ($stats as $stat) {
  		$list .= "<li><a href='".base_url()."admin/orders/?stat=".$stat->istat_name."'>".ucwords($stat->istat_name)."</a></li>";
  	}
  	$list .= "</ul>";
  	return $list;
  }

  function order_pulsa(){
  	if (!$this->ion_auth->logged_in()){
			// redirect them to the login page
			redirect('main/login', 'refresh');
		} elseif (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
			// redirect them to the home page because they must be an administrator to view this
			redirect('member', 'refresh');
		} else {
			//validate form input
			$this->form_validation->set_rules('inputUserName','Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('inputUserNumber','Number', 'trim|required|xss_clean');
			$this->form_validation->set_rules('inputProvider','Provider', 'trim|required|xss_clean');
			$this->form_validation->set_rules('inputProduct','Product', 'trim|required|xss_clean');
			$this->form_validation->set_rules('inputMethod','Payment Method', 'trim|required|xss_clean');
			
			$data['message'] = $this->session->userdata('notes');
			if ($this->form_validation->run() == true){
				$buy = $this->M_Orders->buyPulsa();
				redirect('admin/order_pulsa', 'refresh');
				// $this->session->set_flashdata('message', $this->ion_auth->messages());
			} else {
				$data['page_header']    = '[Admin] Buy Pulsa';
	      $data['description']    = '';
	      $data['title']          = 'Odissey: [Admin] Buy Pulsa';
	      $data['url']            = $this->url;
	      $data['left_side']      = implode('/', $this->url);
	      $data['content_view']   = 'admin/buy/main.php';
	      $data['additionalCSS']  = 'admin/buy/additionalCSS.php';
	      $data['additionalJS']   = 'admin/buy/additionalJS.php';
	      $data['inputCustName']	= $this->inputCustName();
	      $this->template->call_admin_template($data);
			}
  	}
	}

	function inputCustName(){
		$listName 	= "<select id='inputUserName' name='inputUserName' required class='select2 form-control' width='100%'>";
		$listName  .= "<option value=''>Choose Customer</option>";
		$groups 		= $this->M_Orders->getAllCustGroup();
		foreach ($groups as $group) {
			$listName  .= "<optgroup label='".ucwords($group->ug_name)."'>";
			$users 			= $this->M_Orders->getCustNameByGroup($group->ug_code);
			foreach ($users as $user) {
				$listName 	.= "<option value='".$user->username."'>".ucwords($user->first_name." ".$user->last_name)."</option>";
			}
			$listName .= "</optgroup>";
		}
		$listName .= "</select>";
		return $listName;
	}

	function payments($action=null){
		if (!$this->ion_auth->logged_in()){
			// redirect them to the login page
			redirect('main/login', 'refresh');
		} elseif (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
			// redirect them to the home page because they must be an administrator to view this
			redirect('member', 'refresh');
		} else {
			$this->load->library('ajax/Ajax_pagination');
			if(isset($this->url[5]))
				$this->paymentDetailA();
			else {
				switch ($action) {
					case 'detail'	: $data = $this->admPaymentDetail(); break;
					case 'pay'		: $data = $this->paymentsPay(); break;
					default:
						$data['page_header']    = 'Payments';
			      $data['description']    = '';
			      $data['title']          = 'Odissey: Payments';
			      $data['url']            = $this->url;
			      $data['left_side']      = implode('/', $this->url);
			      $data['content_view']   = 'admin/payments/main.php';
			      $data['tableClaims']		= $this->tableClaims();
						break;
				}
				$data['additionalCSS']  = 'admin/payments/additionalCSS.php';
	      $data['additionalJS']   = 'admin/payments/additionalJS.php';
	      $this->template->call_admin_template($data);
			}
		}
	}

	function tableClaims(){
		$table 		= "<tbody>";
		$claims 		= $this->M_Orders->getAllClaims();
		foreach ($claims as $key => $claim) {
			$no 		= $key+1;
			$table .= "<tr>";
			$table .= "<td class='text-center'>$no</td>";
			$table .= "<td class='text-center'><a href='".base_url()."admin/payments/detail/$claim->username"."'>";
			$table .= "$claim->first_name</a></td>";
			$table .= "<td class='text-center'>".strtoupper($claim->ug_name)."</td>";
			$table .= "<td class='text-right'>".number_format($claim->amount, 0, ',', '.')."</td>";
			$table .= "</tr>";
		}
		$table 	 .= "</tbody>";
		return $table;
	}

	function admPaymentDetail(){
		$data['page_header']    		= 'Payments';
    $data['description']    		= '';
    $data['title']          		= 'Odissey: Payments';
    $data['url']            		= $this->url;
    $data['left_side']      		= implode('/', $this->url);
    $data['content_view']   		= 'admin/payments/detail_v.php';
    $data['user'] 							= $this->User_m->getUserInformation($this->url[4]);
    $suffix											= "?stat=&date=&key=&user=".$data['user']->user_id."&sort=&by=";
    $suffix_b										= "?stat=hut&date=&key=&user=".$data['user']->user_id."&sort=&by=";
		$data['orders'] 						= $this->M_Orders->getDataOrdersLimit(0, 0, $suffix_b);
		// $data['totalAmount']				= $this->totalAmount($data['orders']);
    $perPage 										= 10;
    $data['paymentDetail']			= $this->paymentDetail(0, $perPage, $suffix);
    $data['saldoWallet']				= $this->M_Transaction->getSaldo('userWallet', $data['user']->user_id);
    $data['saldoReceivable']		= $this->M_Transaction->getSaldo('userReceivable', $data['user']->user_id);

    //pagination configuration
    $config['num_links']        = 2;
    $config['display_pages']    = TRUE;
    $config['use_page_numbers'] = TRUE;
    $config['next_link']        = false;
    $config['prev_link']        = false;
    //$config['suffix']         =  $this->model_trx->search_trx_url();
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
    $config['target']      			= '#tableOrdersUser';
    $config['base_url']    			= base_url().'admin/payments/detail/'.$this->url[4];
    $config['total_rows']  			= $this->M_Orders->getCountOrdersTotal($suffix);
    $config['per_page']    			= $perPage;
    $this->ajax_pagination->initialize($config);
    return $data;
	}

	// admin/payments/detail
	function accInformation($username){
		$user = $this->User_m->getUserInformation($username);
		// print_r($user);
	}

	function paymentDetail($index, $perPage, $suffix){
		// $config['suffix']           = "?stat=".$data['stat']."&date=".$data['date']."&key=".$data['key'];
		$orders = $this->M_Orders->getDataOrdersLimit($index, $perPage, $suffix);
		$table 	= "";
		$totalAmount = 0;
		foreach ($orders as $key => $order) {
			if($index == 0)
				$no 		= $key+1;
			else $no 		= $key+$index+1;
			$table .= "<tr>";
			$table .= "<td class='text-center'>$no</td>";
			$table .= "<td class='text-center'>$order->invoice_date</td>";
			$table .= "<td class='text-center'>".strtoupper($order->provider_name)." ".number_format($order->product_nom, 0, ',', '.')."</td>";
			$table .= "<td class='text-center'>$order->number_phone</td>";
			$table .= "<td class='text-right'>".number_format($order->product_price, 0, ',', '.')."</td>";
			$table .= "<td class='text-center'>".ucwords($order->istat_name)."</td>";
			$table .= "</tr>";
			$totalAmount += $order->product_price;
		}
		// print_r($orders);

		$table 	.= "<tr>";
		$table 	.= "<th class='text-center' colspan='4'>Total</th>";
		$table 	.= "<th class='text-right'>".number_format($totalAmount, 0, ',', '.')."</th>";
		$table 	.= "<th></th>";
		$table 	.= "</tr>";
		return $table;
	}

	// admin/payments/detail/userAjax
	function paymentDetailA(){
    $page = $this->input->post('page');
    if(!$page){
        $index = 0;
    }else{
        $index = $page;
    }
    
    $data['left_side']      		= implode('/', $this->url);
    $data['user'] 							= $this->User_m->getUserInformation($this->url[4]);
    $suffix											= "?stat=&date=&key=&user=".$data['user']->user_id."&sort=&by=";
    $config['per_page']    			= 10;
    $config['uri_segment'] 			= 5;
    $data['paymentDetail']			= $this->paymentDetail($index, $config['per_page'], $suffix);
    //pagination configuration
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
    $config['target']      			= '#tableOrdersUser';
    $config['base_url']    			= base_url().'admin/payments/detail/'.$this->url[4];
    $config['total_rows']  			= $this->M_Orders->getCountOrdersTotal($suffix);
    $this->ajax_pagination->initialize($config);
    $this->load->view('admin/payments/tableOrdersUser', $data, false);
    // echo $data['paymentDetail'];
  }

  // admin/payments/pay
  function paymentsPay(){
  	$data['page_header']    = 'Payment Debt';
    $data['description']    = '';
    $data['title']          = 'Odissey: Payment Debt';
    $data['url']            = $this->url;
    $data['left_side']      = implode('/', $this->url);
    $data['content_view']   = 'admin/payments/pay_v.php';
    $data['additionalCSS']  = 'admin/payments/additionalCSS.php';
    $data['additionalJS']   = 'admin/payments/additionalJS.php';
    $username = @$this->input->post('username');
    $invoices = @$this->input->post('invoice_number');
    $method 	= @$this->input->post('InputPay');
    $amount 	= @$this->input->post('InputAmount');
    $amountPaid 	= @$this->input->post('InputAmountPay');
    if(sizeof($invoices) == 0)
    	echo 'kosong';
    else $pay = $this->M_Payment->payInvoice($username, $invoices, $method, $amount, $amountPaid);
  	return $data;
  }

  // function totalAmount($orders){
  // 	$totalAmount = 0;
  // 	foreach ($orders as $key => $order) {
  // 		$totalAmount += $order->product_price;
  // 	}
  // 	return $totalAmount;
  // }
}