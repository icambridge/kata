<?php
require_once './LiarLiar.php';
if (isset($argv[1])) {
	// I know they say it will always be run with the proper
	// input, but I don't trust them.
	try {
		$liarLiar = new LiarLiar($argv[1]);
		echo $liarLiar->getRequiredOutput();
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}