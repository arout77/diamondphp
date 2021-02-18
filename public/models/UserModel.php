<?php

class UserModel extends App\Model\System_Model {

	/**
	 * @param Integer $uid
	 * @return mixed
	 */
	public function select_user_by_id(int $uid): PDOStatement{

		//$limit1 = (int) $this->toolbox('sanitize')->xss($limit * 10);
		$query = "SELECT * FROM users WHERE user_id = ?";
		$sql   = $this->db->prepare($query);
		$sql->execute([$uid]);

		return $sql;
	}

	/**
	 * @return mixed
	 */
	public function select_all_users(): PDOStatement{

		$query = "SELECT * FROM users";
		$sql   = $this->db->prepare($query);
		$sql->execute();

		return $sql;
	}

	/**
	 * @param $amount
	 * @return mixed
	 */
	public function select_random_users($amount = 100) {
		$query = "SELECT * FROM users ORDER BY RAND() LIMIT $amount";
		$sql   = $this->db->prepare($query);
		$sql->execute();

		return $sql;
	}
}