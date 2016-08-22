<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prefix_provider{
	function getProvider($prefix){
		$data = array(
							0 => array("operator_id" => "kVI5","prefix" => "0831"),
							1 => array("operator_id" => "kVI5","prefix" => "0832"),
							2 => array("operator_id" => "kVI5","prefix" => "0833"),
							3 => array("operator_id" => "kVI5","prefix" => "0838"),
							4 => array("operator_id" => "uoyt","prefix" => "0856"),
							5 => array("operator_id" => "uoyt","prefix" => "0857"),
							6 => array("operator_id" => "rehM","prefix" => "0894"),
							7 => array("operator_id" => "rehM","prefix" => "0895"),
							8 => array("operator_id" => "rehM","prefix" => "0896"),
							9 => array("operator_id" => "rehM","prefix" => "0897"),
							10 => array("operator_id" => "rehM","prefix" => "0898"),
							11 => array("operator_id" => "rehM","prefix" => "0899"),
							12 => array("operator_id" => "bMcq","prefix" => "0817"),
							13 => array("operator_id" => "bMcq","prefix" => "0818"),
							14 => array("operator_id" => "bMcq","prefix" => "0819"),
							15 => array("operator_id" => "bMcq","prefix" => "0859"),
							16 => array("operator_id" => "bMcq","prefix" => "0877"),
							17 => array("operator_id" => "bMcq","prefix" => "0878"),
							18 => array("operator_id" => "bMcq","prefix" => "0879"),
							19 => array("operator_id" => "v6CY","prefix" => "0881"),
							20 => array("operator_id" => "v6CY","prefix" => "0882"),
							21 => array("operator_id" => "v6CY","prefix" => "0883"),
							22 => array("operator_id" => "v6CY","prefix" => "0884"),
							23 => array("operator_id" => "v6CY","prefix" => "0885"),
							24 => array("operator_id" => "v6CY","prefix" => "0886"),
							25 => array("operator_id" => "v6CY","prefix" => "0887"),
							26 => array("operator_id" => "v6CY","prefix" => "0888"),
							27 => array("operator_id" => "v6CY","prefix" => "0889"),
							28 => array("operator_id" => "vYHq","prefix" => "0812"),
							29 => array("operator_id" => "vYHq","prefix" => "0813"),
							30 => array("operator_id" => "vYHq","prefix" => "0821"),
							31 => array("operator_id" => "vYHq","prefix" => "0822"),
							32 => array("operator_id" => "vYHq","prefix" => "0823"),
							33 => array("operator_id" => "vYHq","prefix" => "0851"),
							34 => array("operator_id" => "vYHq","prefix" => "0852"),
							35 => array("operator_id" => "vYHq","prefix" => "0853"),
							36 => array("operator_id" => "uoyt","prefix" => "0814"),
							37 => array("operator_id" => "uoyt","prefix" => "0815"),
							38 => array("operator_id" => "uoyt","prefix" => "0816"),
							39 => array("operator_id" => "uoyt","prefix" => "0858"),
							40 => array("operator_id" => "6Cri","prefix" => "9991"),
							41 => array("operator_id" => "6Cri","prefix" => "9992"),
							42 => array("operator_id" => "6Cri","prefix" => "9993"),
							43 => array("operator_id" => "6Cri","prefix" => "9994"),
							44 => array("operator_id" => "Uptd","prefix" => "1400"),
							45 => array("operator_id" => "Uptd","prefix" => "1402"),
							46 => array("operator_id" => "Uptd","prefix" => "1403"),
							47 => array("operator_id" => "Uptd","prefix" => "1404"),
							48 => array("operator_id" => "Uptd","prefix" => "1420"),
							49 => array("operator_id" => "Uptd","prefix" => "1424"),
							50 => array("operator_id" => "Uptd","prefix" => "3200"),
							51 => array("operator_id" => "Uptd","prefix" => "3201"),
							52 => array("operator_id" => "Uptd","prefix" => "3202"),
							53 => array("operator_id" => "Uptd","prefix" => "5650"),
							54 => array("operator_id" => "Uptd","prefix" => "8600")
						);
		foreach ($data as $key => $val) {
			if($val['prefix'] == $prefix)
				return $val['operator_id'];
		}
	}
}