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
