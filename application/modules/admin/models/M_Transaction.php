<?php
class M_Transaction extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->identity = $this->session->userdata('identity');
  }

  function getDataTrxLimit($row, $limit, $search){
  	$len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len));
    $searchA    = explode('=', $subSearch[0]);
    $searchB    = explode('=', $subSearch[1]);

    switch ($searchA[1]) {
      case 'pending': $sRekon='0'; break;
      case 'settle' : $sRekon='1'; break;
      default       : $sRekon='' ; break;
    }
    if($searchB[1] != ""){
      $search   = explode(" - ", $searchB[1]);
      $from     = toDateDB($search[0]);
      $to       = toDateDB($search[1]);
      $data     = array(
        'a.order_date >= '   => $from,
        'a.order_date <= '   => $to
      );
    }

    // $this->db->join('sp_invoice as b', 'a.order_id = b.order_id')
    // 				->join('sp_invoice_stat as c', 'b.istat_code = c.istat_code')
    // 				->join('sp_user as d', 'a.user_id=d.id')
    // 				->join('sp_number as e', 'b.number_id=e.number_id')
    // 				->like('istat_name', $sRekon, 'both')
    $data = $this->getWhereAdmTrx();
		$this->db->join('sp_user as b', 'a.user_id=b.id')
							->join('sp_order_type as c','a.otype_code=c.otype_code')
							->where_in('a.otype_code', $data)
							->order_by('order_date', 'DESC');
    $getData  = $this->db->get('sp_order as a', $limit, $row);
    return $getData->result();
  }

  function getCountTrxTotal($search){
  	$len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len));
    $searchA    = explode('=', $subSearch[0]);
    $searchB    = explode('=', $subSearch[1]);

    switch ($searchA[1]) {
      case 'pending': $sRekon='0'; break;
      case 'settle' : $sRekon='1'; break;
      default       : $sRekon='' ; break;
    }
    if($searchB[1] != ""){
      $search   = explode(" - ", $searchB[1]);
      $from     = toDateDB($search[0]);
      $to       = toDateDB($search[1]);
      $data     = array(
        'a.order_date >= '   => $from,
        'a.order_date <= '   => $to
      );
    }

    
    // $this->db->join('sp_invoice as b', 'a.order_id = b.order_id')
    // 				->join('sp_invoice_stat as c', 'b.istat_code = c.istat_code')
    // 				->join('sp_user as d', 'a.user_id=d.id')
    // 				->join('sp_number as e', 'b.number_id=e.number_id')
    // 				->like('istat_name', $sRekon, 'both')
    // 				->order_by('order_date', 'DESC');
    $data = $this->getWhereAdmTrx();
    $this->db->where_in('otype_code',$data)->order_by('order_date', 'DESC');
    $getData  = $this->db->get('sp_order as a');
    return $getData->num_rows();
  }

  function getWhereAdmTrx(){
  	$data = array('400', '600', '610', '620', '630', '400', '210', 
									'110', '510', '700', '720', '120', '220', '190', 
									'290', '590', '510');
  	return $data;
  }

  function getTotalAmountTrx(){

  }

  function getSaldo($code, $user_id=null){
    switch ($code) {
      case 'bank':
        $codePlus   = array('200', '210', '220', '290');
        $codeMin    = array('110', '510', '620', '720');
        $saldo      = $this->getAllSaldo($codePlus)->amount - $this->getAllSaldo($codeMin)->amount;
        break;
      case 'cash':
        $codePlus   = array('100', '110', '120', '190');
        $codeMin    = array('210', '610', '700');
        $saldo      = $this->getAllSaldo($codePlus)->amount - $this->getAllSaldo($codeMin)->amount;
        break;
      case 'pulsa':
        $codePlus   = array('500', '590');
        $codeMin    = array('400');
        $saldo      = $this->getAllSaldo($codePlus)->amount - $this->getAllSaldo($codeMin)->amount;
        break;
      case 'wallet':
        $codePlus   = array('600');
        $codeMin    = array('610', '620', '630', '640');
        $saldo      = $this->getAllSaldo($codePlus)->amount - $this->getAllSaldo($codeMin)->amount;
        break;
      case 'uwallet':
        $codePlus   = array('630', '640');
        $saldo      = $this->getAllSaldo($codePlus)->amount;
        break;
      case 'userWallet':
        $codePlus   = array('630', '640');
        $saldo      = $this->getAllSaldo($codePlus, $user_id)->amount;
        break;
      case 'receivable':
        $codePlus   = array('300');
        $codeMin    = array('120', '220', '630');
        $saldo      = $this->getAllSaldo($codePlus)->amount - $this->getAllSaldo($codeMin)->amount;
        break;
      case 'userReceivable':
        $codePlus   = array('300');
        $codeMin    = array('120', '220', '630');
        $saldo      = $this->getAllSaldo($codePlus, $user_id)->amount - $this->getAllSaldo($codeMin, $user_id)->amount;
        break;
      case 'profit':
        $codePlus   = array('100', '200', '300', '500', '640');
        $codeMin    = array('400', '510', '610', '620', '700', '710', '720', '730');
        $saldo      = $this->getAllSaldo($codePlus)->amount - $this->getAllSaldo($codeMin)->amount;
        break;
      case 'modal':
        $codePlus   = array('190', '290', '590', '710', '730');
        $saldo      = $this->getAllSaldo($codePlus)->amount;
        break;
    }
    return $saldo;
  }

  function getAllSaldo($code, $user_id=null){
    $data = array('order_status' => 1);
    if(isset($user_id))
      $data['user_id'] = $user_id;
    $this->db->select_sum('order_amount', 'amount')->where_in('otype_code', $code);
    $getData = $this->db->get_where('sp_order', $data);
    return $getData->row();
  }

  function manageSaldo(){
    $this->load->model('admin/M_Orders');
    $this->load->model('admin/User_m');
    
    $type   = @$this->input->post('inputType');
    $amount = @str_replace('.', '', $this->input->post('inputAmount'));
    $user   = $this->User_m->getUserRow($this->identity);

    switch ($type) {
      case 'deposit':
        $saldoBank    = $this->getSaldo('bank');
        if($saldoBank < $amount){
          $this->session->set_userdata('notes', 'Gagal: Saldo bank tidak cukup');
          logger('failDep', 'Gagal: Saldo bank tidak cukup');
          return false;
        }else{
          $order_id   = $this->M_Orders->addOrder('510', $user->id, $amount, $amount);
          $this->session->set_userdata('notes', 'Sukses: Deposit berhasil');
          logger('succDep', $order_id);
        }
        break;
      case 'tarik':
        $saldoBank    = $this->getSaldo('bank');
        if($saldoBank < $amount){
          $this->session->set_userdata('notes', 'Gagal: Saldo bank tidak cukup');
          logger('failTar', 'Gagal: Saldo bank tidak cukup');
          return false;
        }else{
          $order_id   = $this->M_Orders->addOrder('110', $user->id, $amount, $amount);
          $this->session->set_userdata('notes', 'Sukses: Tarik tunai berhasil');
          logger('succTar', $order_id);
        }
        break;
      case 'setor':
        $saldoCash    = $this->getSaldo('cash');
        if($saldoCash < $amount){
          $this->session->set_userdata('notes', 'Gagal: Saldo cash tidak cukup');
          logger('failSet', 'Gagal: Saldo cash tidak cukup');
          return false;
        }else{
          $order_id   = $this->M_Orders->addOrder('210', $user->id, $amount, $amount);
          $this->session->set_userdata('notes', 'Sukses: Setoran berhasil');
          logger('succSet', $order_id);
        }
        break;
      case 'cair':
        $saldoWallet  = $this->getSaldo('wallet');
        $method       = @$this->input->post('inputMethod');
        if($saldoWallet < $amount){
          $this->session->set_userdata('notes', 'Gagal: Saldo wallet tidak cukup');
          logger('failWal', 'Gagal: Saldo wallet tidak cukup');
          return false;
        }else{
          if($method == '610')
            $code = '610';
          else $code = '620';

          $order_id = $this->M_Orders->addOrder($code, $user->id, $amount, $amount);
          $this->session->set_userdata('notes', 'Sukses: Tarik wallet berhasil');
          logger('succWal', $order_id);
        }
        break;
    }
  }
}