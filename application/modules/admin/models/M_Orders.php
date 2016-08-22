<?php
class M_Orders extends CI_Model {
  function __construct(){
    parent::__construct();
    $this->load->helper('converter');
    $this->load->model(array(
                        'User_m', 'M_Payment'
                      ));
  }

  function getDataOrdersLimit($row, $limit, $search){
  	$len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len));
    // print_r($subSearch);
    $searchA    = explode('=', $subSearch[0]); // status invoice
    $searchB    = explode('=', $subSearch[1]); // date invoice
    $searchC    = explode('=', $subSearch[2]); // keywords
    $searchD    = explode('=', $subSearch[3]); // userID
    $searchE    = explode('=', $subSearch[4]); // order by $subSearch[5]
    $searchF    = explode('=', $subSearch[5]); // order by $subSearch[5]

    if(isset($searchE[1]) && $searchE[1] != ""){
      switch ($searchE[1]) {
        case 'status': $status = 'c.istat_code'; break;
      }
      if(isset($status))
        $this->db->order_by($status, $searchF[1]);
    }

    $this->db->select('*, c.product_cost as cost, c.product_price as price, c.product_profit as profit')
            ->join('sp_user as b', 'a.user_id=b.id')
            ->join('sp_invoice as c', 'a.order_id = c.order_id')
            ->join('sp_invoice_stat as d', 'c.istat_code = d.istat_code')
            ->join('sp_number as e', 'c.number_id=e.number_id')
            ->join('sp_p_product as f', 'c.product_id=f.product_id')
            ->join('sp_order_type as g', 'a.otype_code=g.otype_code')
            ->join('sp_provider as h', 'h.provider_id=f.provider_id')
            // ->like('istat_name', $sRekon, 'both')
            // ->where('a.otype_code', '400')
            ->order_by('a.order_date', 'DESC');

    if(isset($searchA[1]) && $searchA[1] != "")
      $this->db->where('c.istat_code', substr($searchA[1], 0, 3));

    if(isset($searchB[1]) && $searchB[1] != ""){
      $search   = explode(" - ", $searchB[1]);
      $from     = toDateDB($search[0]);
      if(!isset($search[1]))
        $to     = date('Y-m-d');
      else
        $to     = toDateDB($search[1]);
      
      $data     = array(
        'a.order_date >= '   => $from." 00:00:00",
        'a.order_date <= '   => $to." 23:59:59"
      );
      $this->db->where($data);
    }

    if(isset($searchC[1]) && $searchC[1] != ""){
      $this->db->like('(b.username', $searchC[1], 'both');
      $this->db->or_like('b.email', $searchC[1], 'both');
      $this->db->or_like('b.first_name', $searchC[1], 'both');
      $this->db->or_like('b.last_name', $searchC[1], 'both');
      $this->db->or_like('c.invoice_number', $searchC[1], 'both');
      $this->db->or_where("d.istat_name LIKE '%$searchC[1]%')");
    }

    if(isset($searchD[1]) && $searchD[1] != ""){
      $this->db->where('a.user_id', $searchD[1]);
    }

    $getData  = $this->db->get('sp_order as a', $limit, $row);
    return $getData->result();
  }

  function getCountOrdersTotal($search){
  	$len        = strlen($search);
    $subSearch  = explode('&', substr($search, 1, $len));
    $searchA    = explode('=', $subSearch[0]); // status invoice
    $searchB    = explode('=', $subSearch[1]); // date invoice
    $searchC    = explode('=', $subSearch[2]); // keywords
    $searchD    = explode('=', $subSearch[3]); // userID
    $searchE    = explode('=', $subSearch[4]); // order by $subSearch[5]
    $searchF    = explode('=', $subSearch[5]); // order by $subSearch[5]

    if(isset($searchE[1]) && $searchE[1] != ""){
      switch ($searchE[1]) {
        case 'status': $status = 'istat_code'; break;
      }
      if(isset($status))
        $this->db->order_by($status, $searchF[1]);
    }
    
    $this->db->join('sp_user as b', 'a.user_id=b.id')
            ->join('sp_invoice as c', 'a.order_id = c.order_id')
            ->join('sp_invoice_stat as d', 'c.istat_code = d.istat_code')
            ->join('sp_number as e', 'c.number_id=e.number_id')
            ->join('sp_p_product as f', 'c.product_id=f.product_id')
            ->join('sp_order_type as g', 'a.otype_code=g.otype_code')
            ->join('sp_provider as h', 'h.provider_id=f.provider_id')
            // ->like('istat_name', $sRekon, 'both')
            // ->where('a.otype_code', '400')
            ->order_by('a.order_date', 'DESC');

    if(isset($searchA[1]) && $searchA[1] != "")
      $this->db->where('c.istat_code', substr($searchA[1], 0, 3));

    if(isset($searchB[1]) && $searchB[1] != ""){
      $search   = explode(" - ", $searchB[1]);
      $from     = toDateDB($search[0]);
      if(!isset($search[1]))
        $to     = date('Y-m-d');
      else
        $to     = toDateDB($search[1]);
      
      $data     = array(
        'a.order_date >= '   => $from." 00:00:00",
        'a.order_date <= '   => $to." 23:59:59"
      );
      $this->db->where($data);
    }

    if(isset($searchC[1]) && $searchC[1] != ""){
      $this->db->like('(b.username', $searchC[1], 'both');
      $this->db->or_like('b.email', $searchC[1], 'both');
      $this->db->or_like('b.first_name', $searchC[1], 'both');
      $this->db->or_like('b.last_name', $searchC[1], 'both');
      $this->db->or_like('c.invoice_number', $searchC[1], 'both');
      $this->db->or_where("d.istat_name LIKE '%$searchC[1]%')");
    }

    if(isset($searchD[1]) && $searchD[1] != ""){
      $this->db->where('a.user_id', $searchD[1]);
    }

    $getData  = $this->db->get('sp_order as a');
    return $getData->num_rows();
  }

  function getInvoiceRow($field, $primary){
    $data     = array('a.'.$field => $primary);

    $this->db->select('*, a.product_cost as cost, a.product_price as price, a.product_profit as profit')
            ->join('sp_order as c', 'a.order_id = c.order_id')
            ->join('sp_user as b', 'c.user_id=b.id')
            ->join('sp_invoice_stat as d', 'a.istat_code = d.istat_code')
            ->join('sp_number as e', 'a.number_id=e.number_id')
            ->join('sp_p_product as f', 'a.product_id=f.product_id')
            ->join('sp_order_type as g', 'c.otype_code=g.otype_code')
            ->join('sp_provider as h', 'h.provider_id=f.provider_id')
            // ->like('istat_name', $sRekon, 'both')
            // ->where('a.otype_code', '400')
            ->order_by('a.invoice_date', 'DESC');
    $getData  = $this->db->get_where('sp_invoice as a', $data);
    return $getData->row();
  }

  function getWhereAdmOrders(){
  	$data = array('400', '600', '610', '620', '630', '400', '210', 
									'110', '510', '700', '720', '120', '220', '190', 
									'290', '590', '510');
  	return $data;
  }

  function getAllInvoiceStat(){
    $getData = $this->db->get('sp_invoice_stat');
    return $getData->result();
  }

  function getCustNameByGroup($group_code){
    $data = array('active' => '1', 'ug_code' => $group_code);
    $this->db->order_by('username');
    $getData = $this->db->get_where('sp_user', $data);
    return $getData->result();
  }

  function getAllCustGroup(){
    $this->db->order_by('ug_name');
    $getData = $this->db->get('sp_user_group');
    return $getData->result();
  }

  function selectUserID($username){
    $data = array('username' => $username);
    $getData = $this->db->get_where('sp_user', $data);
    return $getData->row();
  }

  function getAllNumberByUID($username, $provider_id){
    $user = $this->selectUserID($username);
    $data = array('number_status' => '1', 'user_id' => $user->id, 'provider_id' => $provider_id);
    $this->db->order_by('number_id');
    $getData = $this->db->get_where('sp_number', $data);
    return $getData->result();
  }

  function getAllProviderUser($username){
    $user = $this->selectUserID($username);
    $data = array('number_status' => '1', 'user_id' => $user->id);
    $this->db->join('sp_provider as b', 'a.provider_id=b.provider_id')
              ->group_by('a.provider_id')
              ->order_by('a.provider_id');
    $getData = $this->db->get_where('sp_number as a', $data);
    return $getData->result();
  }

  function getAllProvider(){
    $data = array('provider_status' => '1');
    $getData = $this->db->get_where('sp_provider', $data);
    return $getData->result();
  }

  function getProvider($provider_id){
    $data = array('provider_status' => '1', 'provider_id' => $provider_id);
    $getData = $this->db->get_where('sp_provider', $data);
    return $getData->row();
  }

  function getProductByProv($provider_id){
    $data = array('product_status' => '1', 'provider_id' => $provider_id);
    $this->db->order_by('product_nom');
    $getData = $this->db->get_where('sp_p_product', $data);
    return $getData->result();
  }

  function getProductByID($product){
    $data = array('product_status' => '1', 'product_id' => $product);
    $getData = $this->db->get_where('sp_p_product', $data);
    return $getData->row();
  }

  function addOrder($code, $user_id, $amountA, $amountB){
    switch ($code) {
      case '100': // beli pulsa bayar pake cash
        $this->insOrder('400', $user_id, $amountA);
        break;
      case '200': // beli pulsa bayar pake bank
        $this->insOrder('400', $user_id, $amountA);
        break;
      case '300': // beli pulsa hutang
        $this->insOrder('400', $user_id, $amountA);
        break;
      case '640': // beli pulsa bayar pake wallet
        $this->insOrder('400', $user_id, $amountA);
        break;
      case '510': // deposit pulsa via bank
        $this->insOrder('500', $user_id, $amountA);
        break;
    }
    $order_id = $this->insOrder($code, $user_id, $amountB, 'yes');
    return $order_id;
  }

  function insOrder($code, $user_id, $amount, $callback=null){
    $data   = array(
                'otype_code'    => $code,   'user_id'       => $user_id,
                'order_amount'  => $amount, 'order_status'  => 1
              );

    if($this->db->insert('sp_order', $data)){
      $order = $this->User_m->getLastRow('sp_order', 'order_id');
      logger('insOrder', implode('; ', $data));
      if(isset($callback) && $callback == 'yes')
        return $order->order_id;
    }
  }

  function cancelOrder($order_id, $order_date){
    $orders = $this->db->get_where('sp_order', array('order_date' => $order_date))->result();
    $data = array('order_status' => '0');
    foreach ($orders as $order) {
      if($order->order_id != $order_id){
        $this->updateOrder($order->order_id, $data);
      }
    }
    $this->updateOrder($order_id, $data);
    $this->session->set_userdata('notes', 'Success cancel invoice.');
  }

  function editOrder($order_id, $order_date,  $cost, $price){
    $order  = $this->getRow('sp_order', 'order_id', $order_id);
    $orders = $this->db->get_where('sp_order', array('order_date' => $order->order_date))->result();
    foreach ($orders as $order) {
      if($order->order_id != $order_id){
        if($order->otype_code == '400')
          $data['order_amount'] = $cost;
        else $data['order_amount'] = $price; break;
        $this->updateOrder($order->order_id, $data);
      }
    }
    $data['order_amount'] = $price;
    $this->updateOrder($order_id, $data);
    $this->session->set_userdata('notes', 'Invoice has been updated.');
  }

  function updateOrder($order_id, $data){
    $this->db->where('order_id', $order_id);
    if($this->db->update('sp_order', $data))
      logger('updOrder', implode('; ', $data));
  }

  function buyPulsa(){
    $number_id  = @$this->input->post('inputUserNumber');
    $username   = @$this->input->post('inputUserName');
    $method     = @$this->input->post('inputMethod');
    $provider   = @$this->input->post('inputProvider');
    $provider_id = explode('-', $provider);
    $product_id = @$this->input->post('inputProduct');
    $product    = $this->getProductByID($product_id);
    $saldoPulsa = $this->M_Transaction->getSaldo('pulsa');

    if($saldoPulsa < $product->product_cost){
      $this->session->set_userdata('notes', 'Gagal: Saldo Anda tidak cukup');
      return false;
    }

    $gsm        = $this->getProvider($provider_id[0]);
    ($gsm->pg_code == 'gsm') ? $note = "Sedang diproses." : $note = "Diproses: ".$product->product_code.".".$number.".9999";
    $user       = $this->User_m->getUserRow($username);

    if($number_id == 'new'){
      $number     = @$this->input->post('inputNumberN');
      $number_id  = $this->User_m->addNumber($number, $user->id, $provider_id[0]);
    }else{
      $number     = explode('-', $number_id);
      $number_id  = $number[1];
    }

    $order_id   = $this->addOrder($method, $user->id, $product->product_cost, $product->product_price);
    if($method == '300')
      $rest_amount = $product->product_price;
    else $rest_amount = 0;

    $invoice_number = $this->getLastInvoice();
    $data = array(
              'invoice_number'  => $invoice_number,           'order_id'      => $order_id,
              'number_id'       => $number_id,                'product_id'    => $product_id,
              'product_cost'    => $product->product_cost,    'product_price' => $product->product_price,
              'product_profit'  => $product->product_profit,  'rest_amount'   => $rest_amount,
              'invoice_note'    => $note,                     'istat_code'    => 'pen'
            );
    $addInvoice = $this->db->insert('sp_invoice', $data);
    if($addInvoice){
      logger('succBuy', implode('; ', $data));
      $this->session->set_userdata('notes', $note);
    } else {
      logger('succBuy', implode('; ', $data));
      $this->session->set_userdata('notes', 'Gagal: Something Wrong');
    }
  }

  function getLastInvoice(){
    $lastInvoice = $this->User_m->getLastRow('sp_invoice', 'invoice_id');
    $invoice_number = explode('/', $lastInvoice->invoice_number);

    if(empty($lastInvoice)){
      $invoice_number = '0001';
    }else{
      $last     = explode('/', $lastInvoice->invoice_number);
      $lastNo   = strlen($last[0]);
      switch ($last[0]) {
        case $last[0] < 10    : $invoice_number = "000".($last[0]+1);break;
        case $last[0] < 100   : $invoice_number = '00'.($last[0]+1);break;
        case $last[0] < 1000  : $invoice_number = '0'.($last[0]+1);break;
        case $last[0] > 1000  : $invoice_number = $last[0]+1;break;
      }
    }
    $format = strtoupper("/INV/PS/".$this->convnumber->indonesian_date(strtotime('now'),'M /Y',''));
    $invoice_number    .= $format;
    return $invoice_number;
  }

  function updateInvoice($invoice_number, $data){
    $this->db->where('invoice_number', $invoice_number);
    if($this->db->update('sp_invoice', $data))
      logger('updInv', implode('; ', $data));
  }

  function getRow($table, $field, $primary){
    $data     = array($field => $primary);
    $getData = $this->db->get_where($table, $data);
    return $getData->row();
  }

  function getAllClaims(){
    $data['istat_code'] = 'hut';
    $this->db->select('c.first_name, d.ug_name, c.username')->select_sum('rest_amount', 'amount')
              ->join('sp_order as b', 'a.order_id=b.order_id')
              ->join('sp_user as c' , 'b.user_id=c.id')
              ->join('sp_user_group as d', 'c.ug_code=d.ug_code')
              ->group_by('b.user_id')->order_by('c.first_name');
    $getData = $this->db->get_where('sp_invoice as a', $data);
    return $getData->result();
  }
}