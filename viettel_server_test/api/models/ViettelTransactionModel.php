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

	
} 