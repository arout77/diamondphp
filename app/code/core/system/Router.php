<?php
namespace App\System;

/**
 * File: /app/code/core/system/Router.php
 * Purpose: retrieve $_GET['request'] and break it down into segments. Each
 * segment is used to create an MVC routing system
 */

class Router
{

	/**
	 * @var mixed
	 */
	public $controller;
	/**
	 * @var mixed
	 */
	public $controller_class;
	/**
	 * @var mixed
	 */
	private $default_controller;
	/**
	 * @var mixed
	 */
	public $action;
	/**
	 * @var mixed
	 */
	public $param;
	/**
	 * @var mixed
	 */
	public $param1;
	/**
	 * @var mixed
	 */
	public $param2;
	/**
	 * @var mixed
	 */
	public $param3;
	/**
	 * @var mixed
	 */
	public $param4;
	/**
	 * @var mixed
	 */
	public $param5;
	/**
	 * @var mixed
	 */
	public $param6;
	/**
	 * @var mixed
	 */
	public $param7;
	/**
	 * @var mixed
	 */
	public $param8;
	/**
	 * @var mixed
	 */
	public $param9;
	/**
	 * @var mixed
	 */
	public $param10;
	/**
	 * @var mixed
	 */
	private $config;
	# A numerically indexed array of the URL segments (controller, action, parameters)
	# Access each URL segment by index key; i.e.
	# Controller would be $this->route->request[0], action would be $this->route->request[1],
	# parameters would be $this->route->request[2], $this->route->request[3], etc.
	# Breadcrumb helper relies on this
	/**
	 * @var mixed
	 */
	public $request;
	// Files
	/**
	 * @var mixed
	 */
	public $controller_dir;
	/**
	 * @var mixed
	 */
	public $view_dir;
	// Pagination
	/**
	 * @var mixed
	 */
	public $page;

	/**
	 * @param $default_controller
	 * @param $config
	 */
	public function __construct($default_controller = 'Home', $config)
	{

		$this->default_controller = $default_controller;
		$this->config             = $config;

		if (isset($_GET['page']))
		{
			$this->page = (int) $_GET['page'];
		}

		self::build();
	}

	public function build()
	{

		if (isset($_GET['request']) && !empty($_GET['request']))
		{
			// Get the requested URL, and break it up into segments
			$_request      = explode('/', $_GET['request'] . '/');
			$this->request = $_request;

			/**
			 * At this point, we have the $_GET['request'] stored in an array
			 *
			 * Example URL and usage:
			 *
			 * index.php?request=controller/action/param1/param2/param3
			 *
			 * $_request would have the following values:
			 *
			 * 	    controller
			 *  	action
			 *  	param1
			 *  	param2
			 *  	param3
			 *
			 * @$_request
			 *
			 */

			// Set the controller to the first segment from $_request
			// Otherwise default to the WelcomeController
			$_controller = array_slice($_request, 0, 1);

			if (isset($_controller) && !empty($_controller) && $_controller != '')
			{
				$_controller = implode("/", $_controller);
				// Trim whitespace, sanitize profusely and set controller name
				$this->controller = trim(htmlentities(ucwords(strip_tags($_controller))));
			}
			else
			// No controller specified. Set to Home Controller
			{
				$this->controller = 'Home';
			}

			$this->controller_class = $this->controller . '_Controller';

			// Set the action to the second segment from $_request
			// Otherwise set to the default action index()
			$_action = array_slice($_request, 1, 1);

			foreach ($_action as $_a)
			{
				if (!empty($_a) && isset($_a) && $_a != '')
				{
					$this->action = trim(htmlentities(strtolower(strip_tags($_a))));
				}
				else
				{
					$this->action = 'index';
				}
			}

			$_params[]  = array_slice($_request, 2);
			$num_params = count($_params[0]);

			for ($i = 0; $i < $num_params; $i++)
			{
				// Params are numerically indexed start with 0. Add 1
				// to each to assign correct param #
				$paramOffset = $i + 1;

				if (!empty($_params[0][$i]) && $_params[0][$i] != '')
				{
					$nParam = "param".$paramOffset;
					$this->{$nParam} = $_params[0][$i];
				}
			}

		}
		else if (!isset($_GET['request']) || empty($_GET['request']) || !isset($_controller))
		{
			// Fallback to default controller (set in Config.php)
			$this->controller       = $this->config->setting('default_controller');
			$this->controller_class = $this->controller . '_Controller';
			$this->controller_dir   = CONTROLLERS_PATH;
			$this->action           = 'index';
			$this->request          = $this->controller;
		}
	}
}
