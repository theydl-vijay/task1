<?php 
	
include_once('db_connection.php');
include_once('functions.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$name = get('name');
$slug = get('slug');
$sku = get('sku');
$moq = get('moq');
$categories = get('categories');
$search_keywords = get('search_keywords');
$price = get('price');
$discount_type = get('discount_type');
$discount_value = get('discount_value');

header('Content-type:application/json');

$data = json_decode(file_get_contents("php://input"), True);

$api_ary['code'] = 200;
$api_ary['massge'] = 'data inserted';
$api_ary['data'] = $_POST; 

$error = '';

if (empty($name)){
	$error = 'Name is required';
}
elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)){
	$error = 'Only Allow Letters And Spaces in name value';
}
elseif(empty($slug)){
	$error = 'Slug is required';	
}
elseif (!preg_match('/^[a-zA-Z\s]+$/', $slug)){
	$error = 'Only Allow Letters And Spaces';
}
elseif (empty($sku)){
	$error = 'Sku is required';
}
elseif (!preg_match('/^[a-zA-Z\s]+$/', $sku)){
	$error = 'Only Allow Letters And Spaces in sku value';
}
elseif (empty($moq)){
	$error = 'MOQ is required';
}
elseif (!preg_match('/^[1-9][0-9]{0,15}$/', $moq)){
	$error = 'Only Allow Number in moq value';
}
elseif (empty($categories)){
	$error = 'Categories id required';
}
elseif (!preg_match('/^[a-zA-Z\s]+$/', $categories)){
	$error = 'Only Allow Letters And Spaces in categories value';
}
elseif (empty($search_keywords)){
	$error = 'Search keywords is required';
}
elseif (!preg_match('/^[a-zA-Z\s]+$/', $search_keywords)){
	$error = 'Only Allow Letters And Spaces in search keywords value';
}
elseif (empty($price)){
	$error = 'Price is required';
}
elseif (!preg_match('/^[1-9][0-9]{0,15}$/', $price)){
	$error = 'Only Allow Number in price value';
}
elseif (empty($discount_type)){
	$error = 'Select any one option in discount type value';
}
elseif (empty($discount_value)){
	$error = 'Discount value is required';
}
elseif (!preg_match('/^[1-9][0-9]{0,15}$/', $discount_value)){
	$error = 'Only Allow Number in discount value';
}

if ($error){
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