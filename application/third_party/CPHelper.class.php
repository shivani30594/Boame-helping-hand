<?php

namespace MineSQL;

abstract class CPHelper
{

	protected $endpoint = 'https://www.coinpayments.net/index.php';

	// Can change the style of your payment button
	public function createButton()
	{
		return '<button type="submit" class="btn btn-default">Purchase With CoinPayments</button>';
	}


	public function createProperties($fields)
	{
		$field['cmd']         = '_pay';
		$field['item_name']   = 'Payment';
		$field['custom']	  = '';
		$field['want_shipping'] = '0';


		foreach($field as $key=>$item)
		{
			if(!array_key_exists($key, $fields))
			{
				$fields[$key] = $item;
			}
		}


		return $fields;

	} 


	public function createForm($fields)
	{
		$data = $this->createProperties($fields);
		// echo "<pre>";
		$text = '<form action="'.$this->endpoint.'" method="post">';
		// print_r($fields);
		// die;
		foreach($data as $name => $value) {
			$text .= '<input type="hidden" name="'.$name.'" value="'.$value.'">';
		}
		// $text .= '<input type="hidden" name="cmd" value="_pay">
		// <input type="hidden" name="reset" value="1">
		// <input type="hidden" name="want_shipping" value="0">
		// <input type="hidden" name="merchant" value="10a723ca880ce3216fe57a94faca3404">
		// <input type="hidden" name="currency" value="LTC">
		// <input type="hidden" name="amountf" value="1.00">
		// <input type="hidden" name="item_name" value="Test Item">		
		// <input type="hidden" name="allow_extra" value="1">	
		// <input type="hidden" name="success_url" value="https://www.coinpayments.net/index.php?cmd=acct_home">	
		// <input type="hidden" name="cancel_url" value="https://www.coinpayments.net/merchant-tools">	
		// <input type="image" src="https://www.coinpayments.net/images/pub/buynow-white.png" alt="Buy Now with CoinPayments.net">';

		return $text.$this->createButton().'</form>';

	}






}