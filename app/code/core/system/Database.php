<?php
namespace App\System;
use \PDO as PDO;

class Database extends PDO {

	/**
	 * @var mixed
	 */
	protected $connection_status;
	/**
	 * @var mixed
	 */
	protected $client_version;
	/**
	 * @var mixed
	 */
	protected $server_version;

	/**
	 * @param $c
	 */
	public function __construct($c) {
		if ($c['config']->setting('db_host') != '') {
			parent::__construct("mysql:host=" . $c['config']->setting('db_host') . ";dbname=" . $c['config']->setting('db_name') . "", $c['config']->setting('db_user'), $c['config']->setting('db_pass'));
			PDO::setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			PDO::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}

	/**
	 * @param $c
	 */
	public function sql_info($c) {

		if ($c['config']->setting('db_host') != '') {

			$conn = new PDO("mysql:host=" . $c['config']->setting('db_host') . ";dbname=" . $c['config']->setting('db_name') . "", $c['config']->setting('db_user'), $c['config']->setting('db_pass'));

			$attributes = [
				"CLIENT_VERSION",
				"CONNECTION_STATUS",
				"SERVER_VERSION",
			];

			$data = [];

			foreach ($attributes as $val) {
				$data[] = $conn->getAttribute(constant("PDO::ATTR_$val"));
			}

			return $data;
		}
	}

}
