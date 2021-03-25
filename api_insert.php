<?php 
	
// include_once('db_connection.php');
// include_once('functions.php');
// $error = false;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Header: Access-Control-Allow-Header, Content-Type, Access-Control-Allow-Method, Authorization, X-Requested-With');
$data = json_decode(file_get_contents("php://input"), True);

$api_ary['code'] = 200;
$api_ary['massge'] = 'data inserted';
$api_ary['data'] = $_POST; 

// print_r($_POST);
// die();

$name = $data['name'];
$slug = $data['slug'];
$sku = $data['sku'];
$moq = $data['moq'];
$categories = $data['categories'];
$search_keywords = $data['search_keywords'];
$price = $data['price'];
$discount_type = $data['discount_type'];
$discount_value = $data['discount_value'];

// name Validation ------------------
if (empty($_POST['name'])) {
	$errors['name'] = 'name Is Required *';
	$error = true;
}
else
{
	$name = $_POST['name'];
		if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
		$errors['name'] = 'Only Allow Letters And Spaces';
		$error = true;
	}
}

// slug Validation ------------------
if (empty($_POST['slug'])) {
	$errors['slug'] = 'slug Is Required *';
	$error = true;
}
else
{
	$slug = $_POST['slug'];
	if (!preg_match('/^[a-zA-Z\s]+$/', $slug)) {
		$errors['slug'] = 'Only Allow Letters And Spaces';
		$error = true;
	}
}

// SKU Validation ------------------
if (empty($_POST['sku'])) {
	$errors['sku'] = 'SKU Is Required *';
	$error = true;
}
else
{
	$sku = $_POST['sku'];
	if (!preg_match('/^[a-zA-Z\s]+$/', $sku)) {
		$errors['sku'] = 'Only Allow Letters And Spaces';
		$error = true;
	}
}

// moq Validation ------------------
if (empty($_POST['moq'])) {
	$errors['moq'] = 'moq Is Required *';
	$error = true;
}
else
{
	$moq = $_POST['moq'];
	if (!preg_match('/^[1-9][0-9]{0,15}$/', $moq)) {
		$errors['moq'] = 'Required *';
		$error = true;
	}
}

// categories Validation ------------------
if (empty($_POST['categories'])) {
	$errors['categories'] = 'categories Is Required *';
	$error = true;
}
else
{
	$categories = $_POST['categories'];
	if (!preg_match('/^[a-zA-Z\s]+$/', $categories)) {
		$errors['categories'] = 'Only Allow Letters And Spaces';
		$error = true;
	}
}

// search_keywords Validation ------------------
if (empty($_POST['search_keywords'])) {
	$errors['search_keywords'] = ' Required *';
	$error = true;
}
else
{
	$search_keywords = $_POST['search_keywords'];
	if (!preg_match('/^[a-zA-Z\s]+$/', $search_keywords)) {
		$errors['search_keywords'] = 'Only Allow Letters And Spaces';
		$error = true;
	}
}

// price Validation ------------------
if (empty($_POST['price'])) {
		$errors['price'] = ' Required *';
		$error = true;
	}
else
{
	$price = $_POST['price'];
	if (!preg_match('/^[1-9][0-9]{0,15}$/', $price)) {
		$errors['price'] = 'Only Allow Number value';
		$error = true;
	}
}

// discount_type Validation ------------------
if (empty($_POST['discount_type'])) {
	$errors['discount_type'] = 'Required *';
	$error = true;
}
else
{
	$discount_type = $_POST['discount_type'];
	if (!filter_var($discount_type)) {
		$errors['discount_type'] = 'Only Allow Letters And Spaces';
		$error = true;
	}
}

// discount_value Validation ------------------
if (empty($_POST['discount_value'])) {
	$errors['discount_value'] = 'Required *';
	$error = true;
}
else
{
	$discount_value = $_POST['discount_value'];
	if (!preg_match('/^[1-9][0-9]{0,15}$/', $discount_value)) {
		$errors['discount_value'] = 'Only Allow Number value';
		$error = true;
	}
}

if ($error) {
	$error_msg = "Please Input All Filed !";
}
else
{	
	$p_data = array();
	$p_data['name'] = $name;
	$p_data['slug'] = $slug;
	$p_data['sku'] = $sku;
	$p_data['moq'] = $moq;
	$p_data['categories'] = $categories;
	$p_data['search_keywords'] = $search_keywords;
	$p_data['price'] = $price;
	$p_data['discount_type'] = $discount_type;
	$p_data['discount_value'] = $discount_value;

	$insert_data = insert('ecommerce', $p_data, $db_connection);

	if ($insert_data) {
		echo json_encode(array($api_ary));
	}
	else
	{
		echo json_encode(array('message' => 'data not inserted','status' => 'false'));
	}
}

?>