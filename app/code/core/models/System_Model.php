<?php
namespace App\Model;

class System_Model
{
	/**
	 * @var mixed
	 */
	protected $block;
	/**
	 * @var mixed
	 */
	protected $db;
	/**
	 * @var mixed
	 */
	protected $config;
	/**
	 * @var mixed
	 */
	public $session;
	// Data accessed by views / controllers
	/**
	 * @var mixed
	 */
	public $data;
	/**
	 * @var mixed
	 */
	public $hash;
	/**
	 * @var mixed
	 */
	public $log;
	/**
	 * @var mixed
	 */
	protected $toolbox;
	/**
	 * @var mixed
	 */
	protected $load;

	/**
	 * @param $db
	 * @param $toolbox
	 * @param $config
	 */
	public function __construct($db, $toolbox, $config)
	{
		$this->db      = $db;
		$this->config  = $config['config'];
		$this->toolbox = $toolbox;
		$this->log     = $config['log'];
		$this->session = self::session();
		//$this->hash         = self::hash();
	}

	/**
	 * @param $string
	 * @return mixed
	 */
	public function encrypt($string)
	{
		# Encrypt using password_hash()
		$hash = new \App\Module\Hash;
		return $hash->encrypt($string);
	}

	/**
	 * @param $string
	 * @param $base
	 * @return mixed
	 */
	public function verify($string, $base)
	{
		# Decrypt hash from encrypt()
		$hash = new \App\Module\Hash;
		return $hash->verify($string, $base);
	}

	/**
	 * @return mixed
	 */
	public function session()
	{
		return $this->toolbox["session"];
	}

	/**
	 * @param $helper
	 * @return mixed
	 */
	public function toolbox($helper)
	{
		# Load a Toolbox helper
		return $this->toolbox["$helper"];
	}

}