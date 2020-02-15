<?php
namespace MineSQL;


require dirname(__FILE__).'/CPHelper.class.php';

class coinPayments extends CPHelper 
{

	private $secretKey;
	private $merchantId;
	private $isHttpAuth;
	public $paymentErrors;


	public function setMerchantId($merchant)
	{
		$this->merchantId = $merchant;
	}

	public function setSecretKey($secretKey)
	{
		$this->secretKey = $secretKey;
	}


	function createPayment($productName, $currency, $price, $custom, $callbackUrl, $successUrl = '', $cancelUrl = '')
	{
		$fields = array(
				  'merchant' => $this->merchantId,
				  'item_name' => $productName,
				  'currency' => $currency,
				  'amountf' => $price, 
				  'ipn_url' => $callbackUrl,
				  'success_url' => $successUrl,
				  'cancel_url' => $cancelUrl,
				  'custom'  => $custom
				  );


		return $this->createForm($fields);
	}



	function ValidatePayment($cost, $currency)
	{
		if(!isset($_POST['ipn_mode']))
		{
			$this->paymentError[] = 'ipn mode not set.';

			return "step1".false;

		}

		if($this->isHttpAuth || $_POST['ipn_mode'] != 'hmac') {
			
			//Verify that the http authentication checks out with the users supplied information 
			// 
			if($_SERVER['PHP_AUTH_USER']==$this->merchantId && $_SERVER['PHP_AUTH_PW']==$this->secretKey)
			{
				// Failsafe to prevent malformed requests to throw an error
				if(empty($_POST['merchant']))
				{

					$this->paymentError[] = 'POST data does not contain a merchant ID.';

					return "step2".false;

					
				}

				if($this->checkFields()) {
					$this->paymentError[] =  'IPN OK';
					return "step3".true;
				}

			}

			$this->paymentError[] = 'Request does not autheticate (wrong merchant ID + secret Key combo)';

			return "step4".false;

		}

		return $this->validatePaymentHMAC();

	}


	private function validatePaymentHMAC()
	{
		if(!empty($_SERVER['HTTP_HMAC'])) {

			$hmac = hash_hmac("sha512", file_get_contents('php://input'), $this->secretKey);

			if($hmac == $_SERVER['HTTP_HMAC']) {

				if($this->checkFields()) {

					$this->paymentError[] = 'IPN OK';
					return "step5".true;

				}
			}

			$this->paymentError[] = 'HMAC hashes do not match';

			return "step6".false;
		}

		$this->paymentError[] = 'Does not contain a HMAC request';

		return "step7".false;
	}


	private function checkFields($currency, $cost)
	{
		// Ensure the paid out merchant is the same as the application
		if($_POST['merchant'] == $this->merchantId) {

			//ensure that the same currency was used (form tampering)
			if(strtoupper($_POST['currency1']) == strtoupper($currency)) {

				// ensure the price was paid
				if(floatval($_POST['amount1']) >= floatval($cost)) {

					// check and make sure coinpayments confirmed the payment
					if(intval($_POST['status']) >= 100 || intval($_POST['status']) == 2) {

						return "step8".true;

					}

					if(intval($_POST['status']) == -2) {

						$this->paymentError[] = 'The payment has been chargedback through paypal.';

						return "step9".false;

					}

					$this->paymentError[] = 'The payment most likely has not been completed yet.';

					return "step10".false;

				}

				$this->paymentError[] = 'The amount paid does not match the original payment.';

			}

			$this->paymentError[] = 'The currency requested and currency paid differ, suspected form tampering.';

			return "step11".false;
		}

		$this->paymentError[] = 'Merchant ID does not match.';

		return "step12".false;
	}


	public function getErrors()
	{
		return (empty($this->paymentErrors)) ? $this->paymentErrors : 'No errors are there';
	}

}