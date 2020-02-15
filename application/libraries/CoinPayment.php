<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/coinpayments.inc.php';

Class CoinPayment
{
	
	// public function get_address($private_key, $public_key, $ipn_url)
	// {
	// 	$cps = new CoinPaymentsAPI();
	// 	$cps->Setup($private_key, $public_key);
	// 	$req = array(
	// 		'amount' => 35,
	// 		'currency1' => 'USD', //USD
	// 		'currency2' => 'BTC', //BTC
	// 		'item_name' => 'Test Item/Order Description',
	// 		'ipn_url' => $ipn_url,

	// 	);
	// 	$result = $cps->CreateTransaction($req);
	// 	return $result;
	// }

	public function get_address($private_key, $public_key, $ipn_url, $amount)
	{
		$cps = new CoinPaymentsAPI();
		$cps->Setup($private_key, $public_key);
		$req = array(
			'amount' => $amount,
			'currency1' => 'USD', //USD
			'currency2' => 'BTC', //BTC
			'item_name' => 'Test Item/Order Description',
			'ipn_url' => $ipn_url,
			//'custom' => $user_id

		);
		$result = $cps->CreateTransaction($req);
		return $result;
	}
}


