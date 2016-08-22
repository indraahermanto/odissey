<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('logger')){
  function logger($action, $param) {
		$CI       = & get_instance();  //get instance, access the CI superobject
		$id       = $CI->session->userdata('identity');
		if($id == null)
			$id = "";
		$sess_id  = $CI->input->ip_address();
		$url      = base_url().implode('/', $CI->uri->segment_array());
		$data = array(
			'ip_address'  => $sess_id,
			'user_name'   => $id,
			'log_url'     => $url,
			'log_action'  => $action,
			'log_message' => $id." ".$action."\r\n{".$param."}"
		);

		$CI->db->insert('od_log_activity', $data);
		return true;
  }

  function docLog($doc_id, $type, $action, $reason=null){
		$CI       = & get_instance();  //get instance, access the CI superobject
		$email    = $CI->session->userdata('email');

		$user     = $CI->db->get_where('od_user', array('email' => $email))->row();

		$data = array(
			'dlog_doc_id' 	=> $doc_id, 	'dlog_type'   => $type,
			'dlog_action'   => $action, 'dlog_user_id'  => $user->id,
			'dlog_status'   => 0
		);
		if(isset($reason))
			$data['dlog_note'] = $reason;

		$CI->db->insert('od_doc_log', $data);
		return true;
  }

  function upDocLog($doc_id, $type, $action){
		$CI       = & get_instance();  //get instance, access the CI superobject
		$email    = $CI->session->userdata('email');
		$user     = $CI->db->get_where('od_user', array('email' => $email))->row();

		$data       = array('dlog_status' => 1);
		$data_where = array(
			'dlog_doc_id' => $doc_id, 'dlog_type' => $type,
			'dlog_action' => $action
		);
		$CI->db->where($data_where);
		$CI->db->update('od_doc_log', $data);
		// $CI->db->insert('od_doc_log', $data);
		return true;
  }
}