<?php

include_once('db_connection.php');
include_once('functions.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['term'])) {

	$search = get('term');

	$query = "SELECT * FROM product WHERE name LIKE '%{$search}%' LIMIT 10";
	($result = sql($query));

	$response = array();
	foreach ($result as $data) {
		$response[] = array(
			"lable"=>$data['id'],
			"value"=>$data['name'],
		);
	}
	
	echo json_encode($response);
}

?>