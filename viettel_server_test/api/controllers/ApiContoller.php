<?php

require_once(dirname(dirname(__FILE__)) . '/models/ViettelCardModel.php');

class ApiController 
{
	public function api($method_name)
	{
		function action_charge() {
			$request = $_POST;

			if (empty($request['telco_type']) || $request['telco_type'] != 'viettel') {
				echo json_encode(['code' => 206]);
				return false;
			}
			if (empty($request['serial_number'])) {
				echo json_encode(['code' => 204]);
				return false;
			}
			if (empty($request['code_number'])) {
				echo json_encode(['code' => 204]);
				return false;
			}

			$model = new ViettelCardModel();

			$check_code = $model->checkCodeNumber($request['serial_number'], $request['code_number']);
			if (!empty($check_code)) {
				echo json_encode(['code' => 200, 'money' => $check_code['price']]);
				// return false;
			} else {
				echo json_encode(['code' => 404]);
				// return false;
			}
		}

		function run_card_number_test() {
			$model = new ViettelCardModel();
			$model->setCodeNumber();
		}

		function test() {
			$arr = array(10, 20, 50, 100, 500);
			var_dump($arr[array_rand($arr, 1)]);
		}

		if (function_exists($method_name)) {    
			call_user_func($method_name);
      	} else{
          echo 'method not exists';
      	}
	}
}

$arr = explode('/', $_SERVER['REQUEST_URI']);
$action = $arr[count($arr) - 1];

$obj = new ApiController();
$obj->api($action);