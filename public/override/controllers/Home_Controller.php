<?php
namespace App\ControllerOverride;
use \Web\Controller\Home_Controller as Home;

class Home_Controller extends Home {
	/**
	 * [__construct description]
	 * @param [object] $app [Instance of Pimple]
	 *
	 * Often, an individual controller will need a constructor.
	 * Below is an example of creating the __construct() for a
	 * given controller.
	 * The $app variable must be passed to the construct method,
	 * and again to the parent::__construct() method call
	 */
	public function __construct($app) {
		parent::__construct($app);
	}

	public function __toString() {
		return "Home_Controller_Override";
	}

	public function index() {

		// $headers = [
		// 	'Transfer-Encoding: chunked',
		// 	'Content-Encoding: none',
		// 	'Content-Type: text/csv; charset=UTF-8',
		// 	'Content-Description: File Transfer',
		// 	'Content-Disposition: attachment; filename=".env"',
		// ];
		// $this->set_headers($headers);
		$mysql     = $this->db_info;
		$mysql_ver = $mysql[2];

		$data = [
			'site_url'     => $this->config->setting('site_url'),
			'controller'   => $this->config->setting('public_path') . 'controllers' . DS . $this->route->controller_class,
			'view'         => VIEWS_PATH . 'home' . DS . 'index.tpl',
			'php_ver'      => PHP_VERSION,
			'software_ver' => $this->config->setting('software_version'),
			'mysql_ver'    => $mysql_ver ?? 'Enter your database connection settings in the .env file',
		];
		$this->template->assign('title', 'DiamondPHP Framework for PHP 8');
		$this->template->assign('data', $data);
		$this->template->display('template/head.tpl');
		$this->template->display('template/body.tpl');
		$this->template->display('home/index.tpl');
		$this->template->display('template/footer.tpl');
/*
$to = 'andrew_rout@yahoo.com';
$to_name = 'Andrew Rout';
$from = 'arout@diamondphp.org';
$from_name = 'Admin';
$subject = 'Testing PHPMailer';
$message = '<h1>Yo Muddafucka</h1>Respond to this email if you got it.';

$mail = $this->plugin('email');
$mail->__construct(
host: 'smtp.gmail.com',
user: 'flynismo@gmail.com',
pass: 'nkdiefgggevjbebt',
port: 587,
smtp: true,
smtp_auth: true,
html: true,
debug: 0,
secure: true,
);

// $mail->addCC('cc@example.com');
// $mail->addBCC('cc@example.com');
// $mail->addAttachment('/var/tmp/file.tar.gz');

if( $mail->send($to, $to_name, $from, $from_name, $subject, $message) !== false ) {
$this->template->assign('mailstatus', 'Mail sent successfully');
} else {
$this->template->assign('mailstatus', 'There was a problem sending the email');
}
 */
	}

	public function checkout() {
		$this->template->assign('cc', 'Visa');
		$this->template->assign('ccnum', 4032036749380406);
		$this->template->assign('expires', '01/2026');
		$this->template->assign('cvv', 459);

		$this->template->display('template/head.tpl');
		$this->template->display('template/body.tpl');
		$this->template->display('home/checkout.tpl');
		$this->template->display('template/footer.tpl');
	}

	public function userData() {

		$query = $this->model('User');
		$users = $query->select_random_users(100);

		$this->template->assign('users', $users);
		$this->template->display('template/head.tpl');
		$this->template->display('template/body.tpl');
		$this->template->display('home/userdata.tpl');
		$this->template->display('template/footer.tpl');
	}

}
