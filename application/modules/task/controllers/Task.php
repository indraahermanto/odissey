<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Task extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->url 		= $this->uri->segment_array();
		$this->email 	= $this->session->userdata('email');
		$this->id 		= $this->session->userdata('identity');
		$this->user   = $this->M_main->getRow('od_user', 'email', $this->email);
		$this->load->library('notifier');
		$this->load->model(array(
			'main/M_main'
		));
	}

	function tlh_task(){
		$data = array();
		$this->load->model('TLH/M_task');
		$data['date']		= @$this->input->get('date');
		$data['key']   = @$this->input->get('key');
		if($this->input->get('f') && strtolower($this->input->get('f')) != 'all'){
      $status            		= $this->M_main->getRow('od_task_stat', 'stat_id', $this->input->get('f'));
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

		$config['suffix'] 					= "?f=".$data['fw']."&key=".$data['key']."&date=".$data['date']."&user=".$this->user->username;
		$config['base_url']         = base_url().'snba/task/';
		$config['per_page']         = $perpage;
		$config['num_links']        = 2;
		$config['display_pages']    = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['next_link']        = false;
		$config['prev_link']        = false;
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
		$config['total_rows']       = $this->M_task->getTaskTotal($config['suffix']);
		$this->pagination->initialize($config);
		$data['tasks']            	= $this->M_task->getTaskLimit($index, $perpage, $config['suffix']);
		$data['total_rows']         = $config['total_rows'];
		$data['listStatus']					= $this->M_main->getAll('od_task_stat');

		return $data;
	}

	function telkom_task(){
		$data = array();
		$this->load->model('M_task');
		$data['date']		= @$this->input->get('date');
		$data['key']   = @$this->input->get('key');
		if($this->input->get('f') && strtolower($this->input->get('f')) != 'all'){
      $status            		= $this->M_main->getRow('od_task_stat', 'stat_id', $this->input->get('f'));
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

		$config['suffix'] 					= "?f=".$data['fw']."&key=".$data['key']."&date=".$data['date']."&user=";
		$config['base_url']         = base_url().'snba/task/';
		$config['per_page']         = $perpage;
		$config['num_links']        = 2;
		$config['display_pages']    = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['next_link']        = false;
		$config['prev_link']        = false;
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
		$config['total_rows']       = $this->M_task->getTaskTotal($config['suffix']);
		$this->pagination->initialize($config);
		$data['tasks']            	= $this->M_task->getTaskLimit($index, $perpage, $config['suffix']);
		$data['total_rows']         = $config['total_rows'];
		$data['listStatus']					= $this->M_main->getAll('od_task_stat');
		if($this->ion_auth->in_group('maker')){
			$data['buttNew']						=	"<a href='".base_url()."snba/task/new' class='btn btn-flat btn-sm btn-primary'>Aktivitas Baru</a>";
		}else $data['buttNew'] = "";

		return $data;
	}

	function new_task(){
		$this->load->model('TLH/M_task');
		$data['date_now'] = $this->convnumber->indonesian_date(strtotime(date('now')),'l, d F  Y', '');
		$data['status']		= $this->M_main->getAll('od_task_stat');
		return $data;
	}

	function preview_task($doc_number){
		$this->load->model('TLH/M_task');
		// echo $doc_number;
		// $data['task']	        = $this->M_main->getShaDoc('od_task_doc', $doc_number);
		$data['task']     = $this->M_task->getTask($doc_number);
		$data['status']		= $this->M_main->getAll('od_task_stat');
		$data['logs']     = $this->M_main->getAllWhere('od_doc_log', array('dlog_doc_id' => $data['task']->task_id));
		$data['reviewer'] = "";
		$data['reviewer_date'] = "";
		
		if($this->ion_auth->in_group('snba')){
			$data['reviewUser'] = 0;
			$data['buttReview'] = '';
      if($this->ion_auth->in_group('telkom')){
      	// $data['noteReview'] = '<textarea style="height:75px;max-height:110px;max-width:272px" name="noteReview" class="form-control"></textarea>
      	if($data['task']->task_rev_stat != 1){
      		// $data['noteReview'] = '<textarea style="height:75px;max-height:110px;max-width:272px" name="noteReview" class="form-control">'.$data['task']->task_review.'</textarea>';
      		if($data['logs'][0]->dlog_user_id != $this->user->id){
      			$data['reviewUser'] = 1;
      			$data['buttReview'] = '<input type="submit" style="max-width:272px" class="form-control btn btn-flat btn-primary">';
      		}else {
      			$data['reviewUser'] = 0;
      			$data['buttReview'] = "";
      		}
      	}
      }
      if($data['task']->task_rev_stat == 1){
      	$reviewer 	= $this->M_main->getRow('od_user', 'id', $data['logs'][1]->dlog_user_id);
    		$data['reviewer'] 		= "(".ucwords($reviewer->first_name." ".$reviewer->last_name).")";
    		$data['review_date'] 	= $this->convnumber->indonesian_date(strtotime($data['logs'][1]->dlog_time), 'd F Y H:i', '');
      }
    }
		// print_r($data['task']);
    // if(!$doc)
    //   redirect($this->url[1]."/task");
    // else if(!isset($this->url[4])) redirect();
    // $data['task']         = $this->M_main->getRow('od_task_doc', 'task_id', $doc->task_id);
    // $this->M_main->get_row($doc->task_id);
		return $data;
	}

	function createTask(){
		$this->load->model('TLH/M_task');
		if (!$this->ion_auth->logged_in())
			redirect();
		else{
			if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('maker')){
				$content      = @$this->input->post('inputDetActivity');
				$status      	= @$this->input->post('inputStatus');
				$activity     = @$this->input->post('inputActivity');
				$date      		= @date('Y-m-d', strtotime($this->input->post('inputDate')));
				
				// upDocLog($invoice->inv_id, 'invoice', 'app'); // update dlog_stat 1 di utk notifikasi email
				$data = array(
									'task_content' 	=> $content,	'task_activity'	=> $activity, 
									'task_date'			=> $date,			'task_status'		=> $status,
									'user_id' 			=> $this->user->username
								);
				// print_r($data);
				$create = $this->M_task->makeTask($data);
				if($create){
					// $this->M_invoices->updateInvoice($invoice, 'com'); // update report jadi complete
					$mess   = array('note' => 'succTask');
					$this->session->set_userdata($mess);
					redirect('snba/task');
				}
			}else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
		}
	}

	function saveTask(){
		$this->load->model('TLH/M_task');
		if (!$this->ion_auth->logged_in())
			redirect();
		else{
			if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('maker')){
				$task_id      = @$this->input->post('taskID');
				$status      	= @$this->input->post('inputStatus');
				$activity     = @$this->input->post('inputActivity');
				$content     	= @$this->input->post('inputDetActivity');
				
				// upDocLog($invoice->inv_id, 'invoice', 'app'); // update dlog_stat 1 di utk notifikasi email
				$data = array(
									'task_content' 	=> $content,	'task_activity'	=> $activity, 
									'task_status'		=> $status
								);
				$task     = $this->M_task->getTask($task_id);
				// echo $task->task_id;
				// print_r($data);
				if($task != 'cls'){
					$save = $this->M_task->saveTask($data, $task->task_id);
					if($save){
						// $this->M_invoices->updateInvoice($invoice, 'com'); // update report jadi complete
						$mess   = array('note' => 'succSaveTask');
						$this->session->set_userdata($mess);
						redirect('snba/task');
					}
				}else redirect('snba/task');
			}else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
		}
	}

	function reviewTask($task_id){
		$this->load->model('M_task');
		if (!$this->ion_auth->logged_in())
			redirect();
		else{
			if($this->ion_auth->in_group('snba') && $this->ion_auth->in_group('telkom')){
				$noteReview  	= @$this->input->post('noteReview');
				$task     		= $this->M_task->getTask($task_id);
				if(count($task) < 1)
					redirect('snba/task');
				$data 	= array('task_review' => $noteReview, 'task_rev_stat' => 1);
				$review = $this->M_task->saveReview($task, $data);
				if($review){
					// $this->M_invoices->updateInvoice($invoice, 'com'); // update report jadi complete
					$mess   = array('note' => 'succSaveReview');
					$this->session->set_userdata($mess);
					redirect('snba/task');
				}
			}else show_error("Maaf, Anda tidak diperkenankan mengakses halaman ini. Terima kasih");
		}
	}
}