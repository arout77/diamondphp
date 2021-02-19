<?php
namespace App\Model;

class System_Model {
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
	protected $plugin;
	/**
	 * @var mixed
	 */
	protected $load;

	/**
	 * @param $db
	 * @param $plugin
	 * @param $config
	 */
	public function __construct($db, $plugin, $config) {
		$this->db      = $db;
		$this->config  = $config['config'];
		$this->plugin  = $plugin;
		$this->log     = $config['log'];
		$this->session = self::session();
		//$this->hash         = self::hash();
	}

	/**
	 * @param $string
	 * @return mixed
	 */
	public function encrypt($string) {
		# Encrypt using password_hash()
		$hash = new \App\Plugin\Hash;
		return $hash->encrypt($string);
	}

	/**
	 * @param $string
	 * @param $base
	 * @return mixed
	 */
	public function verify($string, $base) {
		# Decrypt hash from encrypt()
		$hash = new \App\Plugin\Hash;
		return $hash->verify($string, $base);
	}

	/**
	 * @return mixed
	 */
	public function session() {
		return $this->plugin["session"];
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