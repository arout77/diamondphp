<?php
namespace App\Controller;
/*
 * File:    /app/code/core/system/base_controller.php
 * Purpose: Base class from which all controllers extend
 */

class Base_Controller {
	/**
	 * @var mixed
	 */
	protected $action;
	/**
	 * @var mixed
	 */
	public $cache;
	/**
	 * @var mixed
	 */
	public $config;
	/**
	 * @var mixed
	 */
	private $controller;
	/**
	 * @var mixed
	 */
	private $controller_class;
	/**
	 * @var mixed
	 */
	private $controller_filename;
	/**
	 * @var mixed
	 */
	protected $core;
	/**
	 * @var mixed
	 */
	protected $cron;
	/**
	 * @var mixed
	 */
	protected $data;
	/**
	 * @var mixed
	 */
	protected $db;
	/**
	 * @var mixed
	 */
	protected $db_info;
	/**
	 * @var mixed
	 */
	protected $dispatcher;
	/**
	 * @var mixed
	 */
	public $load;
	/**
	 * @var mixed
	 */
	public $log;
	/**
	 * @var mixed
	 */
	protected $model;
	/**
	 * @var mixed
	 */
	protected $param;
	/**
	 * @var mixed
	 */
	protected $route;
	/**
	 * @var mixed
	 */
	public $session;
	/**
	 * @var mixed
	 */
	public $template;
	/**
	 * @var mixed
	 */
	public $plugin;
	/**
	 * @var mixed
	 */
	public $view;

	/**
	 * @param $app
	 */
	public function __construct($app) {
		$this->config = $app['config'];
		$this->core   = $app;
		// $this->cron       = $app['cron'];
		$this->db = $app['database'];
		$this->db_info = $app['database_info'];
		// $this->dispatcher = $app['dispatcher'];
		// $this->event      = $app['event'];
		$this->load     = $app['load'];
		$this->log      = $app['log'];
		$this->model    = $app['system_model'];
		$this->route    = $app['router'];
		$this->session  = $app['session'];
		$this->template = $app['template'];
		$this->plugin  = $app['toolbox'];
	}

	/**
	 * @param $_web_class
	 * @param $_override_class
	 * @return mixed
	 */
	public function initOverrideController($_web_class, $_override_class) {
		
		# Define child controller extending this class
		$this->controller = $this->route->controller;
		# The class name contained inside child controller
		$this->controller_class = $this->controller . '_Controller';
		# File name of child controller
		$this->controller_filename = ucwords($this->controller_class) . '.php';
		# Action being requested from child controller
		$this->action = $this->route->action;
		$action       = trim(strtolower($this->route->action));
		# URL parameters
		$this->param = $this->route->param;
		if (class_exists($_override_class)) {
			# File was found and has proper file permissions
			require_once PUBLIC_OVERRIDE_PATH . 'controllers/' . $this->controller_filename;

			if (class_exists($_override_class)) {
				# File found and class exists, so instantiate controller class
				$__instantiate_class = new $_override_class($this->core);

				if (!is_subclass_of($__instantiate_class, $_web_class))
				{
					echo $_override_class . ' DOES NOT EXTEND ' . $_web_class;
				}

				if (method_exists($__instantiate_class, $action)) {
					# Class method exists
					$__instantiate_class->$action();
				} else {
					# Valid controller, but invalid action
					$this->template->assign('controller_path', PUBLIC_OVERRIDE_PATH . 'controllers/' . $this->controller_filename);
					$this->template->assign('content', 'error/action.tpl');
				}
			} else {
				# Controller file exists, but class name
				# is not formatted / spelled properly
				$this->template->assign('content', 'error/controller-bad-classname.tpl');
			}
		} else {
			if (!is_readable($this->config->setting('controllers_path') . $this->controller_filename)) {
				# Controller file does not exist, or
				# does not have read permissions
				if ($this->config->setting('debug_mode') === 'OFF') {
					return $this->redirect('error/_404');
				} else {
					$controller = new \Web\Controller\Error_Controller($this->core);
					$controller->controller();
				}
			}
		}
	}

	/**
	 * @param $_web_class
	 * @param $_override_class
	 */
	public function initPublicController($_web_class, $_override_class) {
		# Define child controller extending this class
		$this->controller = $this->route->controller;
		# The class name contained inside child controller
		$this->controller_class = $this->controller . '_Controller';
		# File name of child controller
		$this->controller_filename = ucwords($this->controller_class) . '.php';
		# Action being requested from child controller
		$this->action = $this->route->action;
		$action       = trim(strtolower($this->route->action));
		# URL parameters
		$this->param = $this->route->param;
		
		if (class_exists($_web_class)) {
			# File was found and has proper file permissions
			require_once $this->config->setting('controllers_path') . $this->controller_filename;

			if (class_exists($_web_class)) {
				# File found and class exists, so instantiate controller class
				$__instantiate_class = new $_web_class($this->core);

				// if (!is_subclass_of($__instantiate_class, $_web_class))
				// {
				// 	echo $_override_class . ' DOES NOT EXTEND ' . $_web_class;
				// }

				if (method_exists($__instantiate_class, $action)) {
					# Class method exists
					$__instantiate_class->$action();
				} else {
					# Valid controller, but invalid action
					$this->template->assign('controller_path', $this->config->setting('controllers_path') . 'controllers/' . $this->controller_filename);
					$this->template->assign('content', 'error/action.tpl');
				}
			} else {
				# Controller file exists, but class name
				# is not formatted / spelled properly
				$this->template->assign('content', 'error/controller-bad-classname.tpl');
			}
		} else {
			if (!is_readable($this->config->setting('controllers_path') . $this->controller_filename)) {
				# Controller file does not exist, or
				# does not have read permissions
				if ($this->config->setting('debug_mode') === 'OFF') {
					return $this->redirect('error/_404');
				} else {
					$controller = new \Web\Controller\Error_Controller($this->core);
					$controller->controller();
				}
			}
		}

	}

	/**
	 * @return mixed
	 */
	public final function parse() {
		# Define child controller extending this class
		$this->controller = $this->route->controller;
		# The class name contained inside child controller
		$this->controller_class = $this->controller . '_Controller';
		# File name of child controller
		$this->controller_filename = ucwords($this->controller_class) . '.php';
		# Action being requested from child controller
		$this->action = $this->route->action;
		$action       = trim(strtolower($this->route->action));
		# URL parameters
		$this->param = $this->route->param;
		# Pass controller information to view files; used for debugger
		$this->template->assign('controller', $this->controller);
		$this->template->assign('controller_class', $this->controller_class);
		$this->template->assign('controller_filename', $this->controller_filename);
		$this->template->assign('action', $action);

		# Admin, Public and Override classes
		$_admin_class    = $this->controller_class;
		$_web_class      = "\Web\Controller\\" . $this->controller_class;
		$_override_class = "\App\ControllerOverride\\" . $this->controller_class;
		
		# First search for requested controller file in override directory
		if (is_readable(PUBLIC_OVERRIDE_PATH . 'controllers/' . $this->controller_filename)) {
			return self::initOverrideController($_web_class, $_override_class);
		}

		if (is_readable($this->config->setting('controllers_path') . $this->controller_filename)) {
			return self::initPublicController($_web_class, $_override_class);
		}

		# Controller file does not exist, or
		# does not have read permissions
		if ($this->config->setting('debug_mode') === 'OFF') {
			$this->redirect('error/_404');
		} else {
			$this->template->display('error/controller.tpl');
		}

		# Check if the admin controller is being requested
		// if ($this->controller == $this->config->setting('admin_controller') && is_readable(CORE_PATH . 'controllers/' . $this->controller_filename) && $this->controller_filename)
		// {
		// 	# File was found and has proper file permissions
		// 	require_once CORE_PATH . 'controllers/' . $this->controller_filename;

		// 	if (class_exists($_admin_class))
		// 	{
		// 		# File found and class exists, so instantiate controller class
		// 		$__instantiate_class = new $this->controller_class($this->core);

		// 		if (method_exists($__instantiate_class, $action))
		// 		{
		// 			# Class method exists
		// 			$__instantiate_class->$action();
		// 		}
		// 		else
		// 		{
		// 			# Valid controller, but invalid action
		// 			$this->template->assign('controller_path', CORE_PATH . 'controllers/' . $this->controller_filename);
		// 			$this->template->assign('content', 'error/action.tpl');
		// 		}
		// 	}
		// 	else
		// 	{
		// 		# Controller file exists, but class name
		// 		# is not formatted / spelled properly
		// 		$this->template->assign('content', 'error/controller-bad-classname.tpl');
		// 	}
		// }
	}

	/**
	 * @param $model
	 * @return mixed
	 */
	public function model($model) {
		return $this->load->model("$model");
	}

	/**
	 * @param $url
	 */
	public function redirect($url) {
		if ($url === 'http_referer') {
			return header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit;
		}
		return header('Location: ' . SITE_URL . $url);
	}

	/**
	 * @return mixed
	 */
	public function session() {
		return $this->plugin('session');
	}

	/**
	 * @param $helper
	 * @return mixed
	 */
	public function plugin($helper) {
		# Load a plugin helper
		return $this->plugin["$helper"];
	}

}
