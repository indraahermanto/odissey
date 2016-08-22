<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notifier{
	function report_log($action, $user_id, $time){
		$log 	= "";
		$CI 	= & get_instance();
		$user	= $CI->db->get_where('od_user', array('id' => $user_id))->row();
		$fullname = ucwords(strtolower($user->first_name." ".$user->last_name));
		switch ($action) {
			case 'mak': $log .= 'melakukan <b>pembuatan</b> Berita Acara';break;
			case 'sub': $log .= '<b>mensubmit</b> Berita Acara';break;
			case 'app': $log .= '<b>menyetujui</b> Berita Acara';break;
			case 'com': $log .= '<b>membuat invoice</b> untuk Berita Acara ini';break;
		}
		return $fullname." ".$log." pada ".$time;
	}

	function invoice_log($action, $user_id, $time){
		$log 	= "";
		$CI 	= & get_instance();
		$user	= $CI->db->get_where('od_user', array('id' => $user_id))->row();
		$fullname = ucwords(strtolower($user->first_name." ".$user->last_name));
		switch ($action) {
			case 'mak': $log .= 'melakukan <b>pembuatan</b>';break;
			case 'sub': $log .= '<b>mensubmit</b>';break;
			case 'app': $log .= '<b>menyetujui</b>';break;
			case 'rej': $log .= '<b>menolak</b>';break;
			case 'rev': $log .= '<b>merevisi</b>';break;
			case 'com': $log .= '<b>membayar</b>';break;
		}
		return $fullname." ".$log." Invoice ini pada ".$time;
	}

	function spb_log($action, $user_id, $time){
		$log 	= "";
		$CI 	= & get_instance();
		$user	= $CI->db->get_where('od_user', array('id' => $user_id))->row();
		$fullname = ucwords(strtolower($user->first_name." ".$user->last_name));
		switch ($action) {
			case 'mak': $log .= 'melakukan <b>pembuatan</b> Surat Perintah Bayar';break;
			case 'sub': $log .= 'melakukan <b>maker</b> di ibanking';break;
			case 'app': $log .= '<b>menyetujui</b> Surat Perintah Bayar';break;
			case 'com': $log .= 'melakukan <b>lunas bayar</b> Surat Perintah Bayar';break;
		}
		return $fullname." ".$log." pada ".$time;
	}
}