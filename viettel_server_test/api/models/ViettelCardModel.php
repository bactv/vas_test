<?php

define('SERVER_NAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DB_NAME', 'telco_test');


class ViettelCardModel
{
	protected $_instance;

	public function __construct()
	{
		if ($this->_instance == null) {
			$this->_instance = new PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, USERNAME, PASSWORD);
		}
		return $this->_instance;
	}

	public function setCodeNumber($limit = 1000)
	{
		$arr = [];
		for ($i=0; $i < $limit; $i++) {
			$serial_number = $i . substr(number_format(time() * rand(), 0, '', ''), 0, 9);
			$code_number = $i . substr(number_format(time() * rand(), 0, '', ''), 0, 12);
			$arr_money = array(10, 20, 50, 100, 500);
			$price = $arr_money[array_rand($arr_money, 1)];

			$sql = "INSERT INTO viettel_card (serial_number, code_number, price) VALUES ($serial_number, $code_number, $price)";
			$this->_instance->prepare($sql)->execute();
		}
	}

	public function checkCodeNumber($serial_number, $code_number)
	{
		$sql = "SELECT id, price 
				FROM viettel_card
				WHERE serial_number = :serial_number
				AND code_number = :code_number
				AND status = 1";

		$exe = $this->_instance->prepare($sql);
		$exe->bindParam(':serial_number', $serial_number, PDO::PARAM_INT);
	    $exe->bindParam(':code_number', $code_number, PDO::PARAM_INT);
	    $exe->execute();

	    $result = (array)($exe->fetchAll());

		if (count($result) > 0) {
			$this->disabledCodeNumber($serial_number, $code_number);
			return $result[0];
		} else {
			return null;
		}		

	}

	private function disabledCodeNumber($serial_number, $code_number)
	{
		$sql = "UPDATE viettel_card 
				SET status = 0
				WHERE serial_number = :serial_number
				AND code_number = :code_number";
		$exe = $this->_instance->prepare($sql);
		$exe->bindParam(':serial_number', $serial_number);
	    $exe->bindParam(':code_number', $code_number);
	    return $exe->execute();	
	}
} 