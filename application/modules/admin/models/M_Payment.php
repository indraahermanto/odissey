<?php
class M_Payment extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->identity = $this->session->userdata('identity');
    $this->load->model(array (
                  'User_m', 'M_Orders'
                ));
  }

  function payInvoice($username, $invoices, $method, $amount, $amountPaid){
    // print_r($this->input->post());
    $user = $this->M_Orders->getRow('sp_user', 'username', $username);
    if($method != '640'){
      $doc_number = $this->createPayment($amount, $method);
    }
  	
    foreach ($invoices as $invoice) {
      echo $amount." ";
      $inv = $this->M_Orders->getRow('sp_invoice', 'invoice_number', $invoice);
      if($amount >= $inv->rest_amount){
        $paid = $inv->rest_amount;
      }else{
        $paid = $amount;
      }

      $data = array(
                'pay_number'  => $doc_number,   'invoice_number' => $invoice,
                'pmod_amount' => $paid
              );
      if($amount > 0){
        if($this->db->insert('sp_payments_mod', $data))
          logger('addPayMod', implode('; ', $data));
        $this->M_Orders->insOrder($method, $user->id, $paid);

        $rest_amount = $inv->rest_amount - $paid;
        if($rest_amount == 0){
          $dataUpdate['istat_code'] = 'com';
        }
        $dataUpdate['rest_amount'] = $rest_amount;

        $this->M_Orders->updateInvoice($invoice, $dataUpdate);
        unset($dataUpdate);
        $amount -= $paid;
      }
    }
  }

  function createPayment($amount, $method){
  	$lastRow 		= $this->getLastInvoice();
  	$data				= array(
  									'pay_number' 	=> $lastRow, 'pay_amount' => $amount,
  									'tpay_id'			=> $method,  'pay_status' => 1
  								);
  	if($this->db->insert('sp_payments', $data)){
  		logger('succPay', implode('; ', $data));
      // $this->session->set_userdata('notes', '');
      return $lastRow;
  	}else {
      logger('failPay', implode('; ', $data));
      $this->session->set_userdata('notes', 'Something Wrong Payments!');
      redirect('admin/payments');
    }
  }

  function editPayment(){

  }

  function getLastInvoice(){
    $lastDoc 		= $this->User_m->getLastRow('sp_payments', 'pay_id');
    $doc_number = explode('/', $lastDoc->pay_number);

    if(empty($lastDoc)){
      $doc_number = '0001';
    }else{
      $last     = explode('/', $lastDoc->pay_number);
      $lastNo   = strlen($last[0]);
      switch ($last[0]) {
        case $last[0] < 10    : $doc_number = "000".($last[0]+1);break;
        case $last[0] < 100   : $doc_number = '00'.($last[0]+1);break;
        case $last[0] < 1000  : $doc_number = '0'.($last[0]+1);break;
        case $last[0] > 1000  : $doc_number = $last[0]+1;break;
      }
    }
    $format = strtoupper("/PAY/PS/".$this->convnumber->indonesian_date(strtotime('now'),'M /Y',''));
    $doc_number    .= $format;
    return $doc_number;
  }

  function getPayment($field, $primary){
    $data       = array($field => $primary);
    $data['b.pmod_status'] = 1;
    $this->db->join('sp_payments_mod as b ', 'a.pay_number=b.pay_number')
              ->join('sp_invoice as c', 'c.invoice_number=b.invoice_number');
    $getData    = $this->db->get_where('sp_payments as a', $data);
    return $getData->result();
  }

  function updatePmod($field, $primary, $data){
    $this->db->where('invoice_number', $invoice_number);
    if($this->db->update('sp_payments_mod', $data))
      logger('updInv', implode('; ', $data));
  }
}