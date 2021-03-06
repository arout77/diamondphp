<?php
namespace App\Plugin;
use App\System\Plugins as Plugin_Core;
use \angelleye\PayPal\rest\checkout_orders\CheckoutOrdersAPI;

require_once VENDOR_PATH . 'angelleye/paypal-php-library/autoload.php';
require_once VENDOR_PATH . 'angelleye/paypal-php-library/samples/config/config.php';

class Paypal extends Plugin_Core {

	/**
	 * @var mixed
	 */
	private $config;

	/**
	 * @param $app
	 */
	public function __construct($app) {
		$this->config = $app['config'];
	}

	public function AuthorizeOrder() {

		$configArray = [
			'Sandbox'      => $sandbox,
			'ClientID'     => $rest_client_id,
			'ClientSecret' => $rest_client_secret,
			'LogResults'   => $log_results,
			'LogPath'      => $log_path,
			'LogLevel'     => $log_level,
		];

		/**
		 * Authorizes payment for an order.
		 */
		$PayPal = new CheckoutOrdersAPI($configArray);

		if (isset($_GET['success']) && $_GET['success'] == 'true') {

			/**
			 * You can make this call only if you specified intent=AUTHORIZE in the create order call.
			 * get order id after the payment approval from PayPal,
			 * but if you know Order id then you can directly use $order_id function to AUTHORIZE the order.
			 */

			$order_id = isset($_GET['token']) ? $_GET['token'] : ''; // Required. The ID of the order for which to authorize.

			$response = $PayPal->AuthorizeOrder($order_id);

			echo "<pre>";
			print_r($response);
			exit;

		} else {
			echo "User Cancelled the Approval";
			exit;
		}
	}

}