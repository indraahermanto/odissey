<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('noToDate')){
  function toDateDB($date) {
    $date  = preg_replace("/[^0-9\/]/", "",$date);
    //echo $date;
    $b = date_create($date);
    return date_format($b, 'Y-m-d'); // sample 2016-11-20
  }
}