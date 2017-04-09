<?php

require_once(dirname(dirname(__FILE__)) . '/models/ViettelCardModel.php');

class ApiController 
{
	public function api($method_name)
	{
		function action_charge() {
			$request = $_POST;

			if (empty($request['telco_type']) || $request['telco_type'] != 'viettel') {
				echo json_encode(['status' => 1, 'message' => 'Telco is not Viettel']);
				return false;
			}
			if (empty($request['serial_number'])) {
				echo json_encode(['status' => 2, 'message' => 'Serial number invalid']);
				return false;
			}
			if (empty($request['code_number'])) {
				echo json_encode(['status' => 3, 'message' => 'Code invalid']);
				return false;
			}

			$model = new ViettelCardModel();

			$check_code = $model->checkCodeNumber($request['serial_number'], $request['code_number']);
			if (!empty($check_code)) {
				echo json_encode(['status' => 4, 'message' => 'Success', 'money' => $check_code['price']]);
				// return false;
			} else {
				echo json_encode(['status' => 5, 'message' => 'Code number not found']);
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