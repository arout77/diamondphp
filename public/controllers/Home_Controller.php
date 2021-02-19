<?php
namespace Web\Controller;
use App\Controller\Base_Controller;

class Home_Controller extends Base_Controller {
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
		return "Home_Controller";
	}

	public function index() {

		//////////////////////////////////////
		// This controller is being overridden
		//////////////////////////////////////
		$mysql = $this->db_info;

		$data = [
			'site_url'     => $this->config->setting('site_url'),
			'controller'   => $this->config->setting('public_path') . 'controllers' . DS . $this->route->controller_class,
			'view'         => VIEWS_PATH . 'home' . DS . 'index.tpl',
			'php_ver'      => PHP_VERSION,
			'software_ver' => $this->config->setting('software_version'),
			'mysql_ver'    => $mysql[2],
		];
		$this->template->assign('data', $data);
		//$this->template->assign('slider', 'sliders/homepage.tpl');
		//$this->template->assign('content', 'home/index.tpl');
		$this->template->display('template/head.tpl');
		$this->template->display('template/body.tpl');
		$this->template->display('home/index.tpl');
		$this->template->display('template/footer.tpl');
	}

	public function test() {
		$per_page = 20;
		$profiles = $this->model('Member')->select(50);
		$limit    = rand(2, 1250);

		$query         = "SELECT * FROM users WHERE hidden = 0";
		$data['pager'] = $this->toolbox('pagination');
		$data['pager']->config($profiles, $per_page);
		// $data['pagination_links'] = $data['pager']->paginate(3);
		$this->template->assign('data', $data);
		$this->template->assign('content', 'index.tpl');

	}

}
