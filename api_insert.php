<?php 
	
include_once('db_connection.php');
include_once('functions.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = false;

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

$json_creat['code'] = 200;
$json_creat['massage'] = 'data inserted';
$json_creat['data'] = $_POST; 

if (empty($name)){
	$json_error['validation'] = 'Name is required';
	$json_error['massage'] = 'Name missing';
	$error = true;
}
elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)){
	$json_error['validation'] = 'Only Allow Letters And Spaces in name value';
}
elseif(empty($slug)){
	$json_error['validation'] = 'Slug is required';
	$json_error['massage'] = 'Slug missing';	
	$error = true;
}
elseif (!preg_match('/^[a-zA-Z\s]+$/', $slug)){
	$json_error['validation'] = 'Only Allow Letters And Spaces';
	$error = true;
}
elseif (empty($sku)){
	$json_error['validation'] = 'Sku is required';
	$json_error['massage'] = 'Slug missing';
	$error = true;
}
elseif (!preg_match('/^[a-zA-Z\s]+$/', $sku)){
	$json_error['validation'] = 'Only Allow Letters And Spaces in sku value';
	$error = true;
}
elseif (empty($moq)){
	$json_error['validation'] = 'MOQ is required';
	$json_error['massage'] = 'moq missing';
	$error = true;
}
elseif (!preg_match('/^[1-9][0-9]{0,15}$/', $moq)){
	$json_error['validation'] = 'Only Allow Number in moq value';
	$error = true;
}
elseif (empty($categories)){
	$json_error['validation'] = 'Categories required';
	$json_error['massage'] = 'Categories categories';
	$error = true;
}
elseif (!preg_match('/^[a-zA-Z\s]+$/', $categories)){
	$json_error['validation'] = 'Only Allow Letters And Spaces in categories value';
	$error = true;
}
elseif (empty($search_keywords)){
	$json_error['validation'] = 'Search keywords is required';
	$json_error['massage'] = 'Search keywords missing';
	$error = true;
}
elseif (!preg_match('/^[a-zA-Z\s]+$/', $search_keywords)){
	$json_error['validation'] = 'Only Allow Letters And Spaces in search keywords value';
	$error = true;
}
elseif (empty($price)){
	$json_error['validation'] = 'Price is required';
	$json_error['massage'] = 'Price missing';
	$error = true;

}
elseif (!preg_match('/^[1-9][0-9]{0,15}$/', $price)){
	$json_error['validation'] = 'Only Allow Number in price value';
	$error = true;

}
elseif (empty($discount_type)){
	$json_error['validation'] = 'Select any one option in discount type value';
	$json_error['massage'] = 'Discount type missing';
	$error = true;
}
elseif (empty($discount_value)){
	$json_error['validation'] = 'Discount value is required';
	$json_error['massage'] = 'Discount value missing';
	$error = true;
}
elseif (!preg_match('/^[1-9][0-9]{0,15}$/', $discount_value)){
	$json_error['validation'] = 'Only Allow Number in discount value';
	$error = true;
}

// =================

if ($error){
	$json_error['code'] = 202;
	echo json_encode($json_error);
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

	$insert_data = insert('product', $p_data);

	if ($insert_data) {
		echo json_encode(array($json_creat));
	}
}

?>