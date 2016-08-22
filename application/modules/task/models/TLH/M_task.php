<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_task extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->load->model(array(
        'main/M_main'
      ));
    $this->email  = $this->session->userdata('email');
    $this->user   = $this->M_main->getRow('od_user', 'email', $this->email);
  }

  function makeTask($data){
    // $data = array('user_id' => $this->user->username, 'task_content' => $content);
    if($this->db->insert('od_task_doc', $data)){
      logger($data['task_status'].'Task', implode('; ', $data));
      $task = $this->M_main->getLastRow('od_task_doc', 'task_id');
      docLog($task->task_id, 'task', $data['task_status']);
      // $this->addSPBMod($invoice->inv_id, $task->task_id);
      return true;
    }else{
      logger('makeTaskFail', implode('; ', $data));
      return show_error('Error: makeTask Fail. <br/>Something Wrong, please contact administrator.');
    }
  }

  function saveTask($data, $id){
    // $update = $this->db->update('od_spb_doc', $data);
    $this->db->where('task_id', $id);
    $update = $this->db->update('od_task_doc', $data);
    if($update){
      logger($data['task_status'].'task', implode('; ', $data));
      docLog($id, 'task', $data['task_status'], implode(';', $data));
      return true;
    }else{
      logger($data['task_status'].'taskFail', implode('; ', $data));
      return show_error("Error: ".$data['task_status']."Task Fail. <br/>Something Wrong, please contact administrator.");
    }
  }

  function getTaskLimit($row, $limit, $search){
    $len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len)); // ?fw=&key=&date=&user=
    $searchA    = explode('=', strtolower($subSearch[0])); //
    $searchB    = explode('=', $subSearch[1]);
    $searchC    = explode('=', $subSearch[2]);
    $searchD    = explode('=', $subSearch[3]);
    $data = array();
    // if(isset($subSearch[2])){
    //   // echo $subSearch[2];
    //   $searchC  = explode('=', strtolower($subSearch[2]));
    //   $data['ba_type'] = $searchC[1];
    // }
    //echo $searchA[1];
    if($searchC[1] != ""){
      // $data['ba_periode'] = $searchB[1];
      $dateRange = explode(' - ', $searchC[1]);
      $data['a.task_date >='] = date('Y/m/d 00:00:00', strtotime($dateRange[0]));;
      $data['a.task_date <='] = date('Y/m/d 23:59:59', strtotime($dateRange[1]));;
    }
    if($searchA[1] != "" && $searchA[1] != 'all')
      $data['a.task_status']  = $searchA[1];
    if($searchD[1] != "")
      $data['b.username']  = $searchD[1];

    // if($searchA[1] != '')
    //   $data['a.user_id'] = $searchA[1];

    $this->db->join('od_user as b', 'a.user_id=b.username')
              ->join('od_task_stat as c', 'a.task_status=c.stat_id')
              ->order_by('task_date', 'DESC');
    $getData  = $this->db->get_where('od_task_doc as a', $data, $limit, $row);
    // $getData  = $this->db->get_where('od_ba_doc as a', $data, $limit, $row);
    return $getData->result();
  }

  function getTaskTotal($search){
    $len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len)); // ?fw=&key=&date=&user=
    $searchA    = explode('=', strtolower($subSearch[0])); //
    $searchB    = explode('=', $subSearch[1]);
    $searchC    = explode('=', $subSearch[2]);
    $searchD    = explode('=', $subSearch[3]);
    $data = array();
    // if(isset($subSearch[2])){
    //   // echo $subSearch[2];
    //   $searchC  = explode('=', strtolower($subSearch[2]));
    //   $data['ba_type'] = $searchC[1];
    // }
    //echo $searchA[1];
    if($searchC[1] != ""){
      // $data['ba_periode'] = $searchB[1];
      $dateRange = explode(' - ', $searchC[1]);
      $data['a.task_date >='] = date('Y/m/d 00:00:00', strtotime($dateRange[0]));;
      $data['a.task_date <='] = date('Y/m/d 23:59:59', strtotime($dateRange[1]));;
    }
    if($searchA[1] != "" && $searchA[1] != 'all')
      $data['a.task_status']  = $searchA[1];
    if($searchD[1] != "")
      $data['b.username']  = $searchD[1];

    $this->db->join('od_user as b', 'a.user_id=b.username')
              ->join('od_task_stat as c', 'a.task_status=c.stat_id')
              ->order_by('task_date', 'DESC');
    $getData  = $this->db->get_where('od_task_doc as a', $data);
    return $getData->num_rows();
  }

  function getTask($task_id){
    // task id use sha1
    $tasks    = $this->M_main->getAll('od_task_doc');
    foreach ($tasks as $task) {
      if(sha1($this->config->item('salt').$task->task_id) == $task_id){
        $task_id = $task->task_id;
      }
    }
    $data = $this->M_main->getRow('od_task_doc', 'task_id', $task_id);
    return $data;
  }
}