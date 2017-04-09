<?php

class SyncCommand 
{
	public function run_sync()
	{
		echo "Hello World";
	}
}

// position [0] is the script's file name
array_shift($argv);
$className = array_shift($argv);
$funcName = array_shift($argv);

call_user_func(array($className, $funcName));