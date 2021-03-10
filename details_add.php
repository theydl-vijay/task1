<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$name = $slug = $sku = $moq =  $categories =  $search_keywords =  $price =  $discount_type =  $discount_value =  '';
$errors = array('name' => '', 'slug' => '', 'sku' => '', 'moq' => '', 'categories' => '', 'search_keywords' => '', 'price' => '', 'discount_type' => '', 'discount_value' => '',);


include_once('db_connection.php');
// include_once('functions.php');


if(isset($_POST['submit']))
{
	$name = $_POST['name'];
	$slug = $_POST['slug'];
	$sku = $_POST['sku'];
	$moq = $_POST['moq'];
	$categories = $_POST['categories'];
	$search_keywords = $_POST['search_keywords'];
	$price = $_POST['price'];
	$discount_type = $_POST['discount_type'];
	$discount_value = $_POST['discount_value'];

	$insert_query = "INSERT INTO ecommerce (name, slug, sku, moq, categories, search_keywords, price, discount_type, discount_value)
		VALUES('$name','$slug','$sku','$moq','$categories','$search_keywords','$price','$discount_type','$discount_value')";

	$query_run = mysqli_query($db_connection,$insert_query);

// name Validation ------------------

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (empty($_POST['name'])) {
			$errors['name'] = 'Name Is Required *';
		}
		else
		{
		    $name = $_POST['name'];
		    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
		      $errors['name'] = 'Only Allow Letters And Spaces';
		    }
		}

// slug Validation ------------------

		if (empty($_POST['slug'])) {
			$errors['slug'] = 'slug Is Required *';
		}
		else
		{
		    $slug = $_POST['slug'];
		    if (!preg_match('/^[a-zA-Z\s]+$/', $slug)) {
		      $errors['slug'] = 'Only Allow Letters And Spaces';
		    }
		}

// SKU Validation ------------------

		if (empty($_POST['sku'])) {
			$errors['sku'] = 'SKU Is Required *';
		}
		else
		{
		    $sku = $_POST['sku'];
		    if (!preg_match('/^[a-zA-Z\s]+$/', $sku)) {
		      $errors['sku'] = 'Only Allow Letters And Spaces';
		    }
		}

// moq Validation ------------------

		if (empty($_POST['moq'])) {
			$errors['moq'] = 'moq Is Required *';
		}
		else
		{
		    $moq = $_POST['moq'];
		    if (!preg_match('/^[0-9]{10}+$/', $moq)) {
		      $errors['moq'] = 'Required *';
		    }
		}

// categories Validation ------------------

		if (empty($_POST['categories'])) {
			$errors['categories'] = 'categories Is Required *';
		}
		else
		{
		    $categories = $_POST['categories'];
		    if (!preg_match('/^[a-zA-Z\s]+$/', $categories)) {
		      $errors['categories'] = 'Only Allow Letters And Spaces';
		    }
		}


// search_keywords Validation ------------------

	if (empty($_POST['search_keywords'])) {
			$errors['search_keywords'] = ' Required *';
		}
		else
		{
		    $search_keywords = $_POST['search_keywords'];
		    if (!preg_match('/^[a-zA-Z\s]+$/', $search_keywords)) {
		      $errors['search_keywords'] = 'Only Allow Letters And Spaces';
		    }
		}

// price Validation ------------------

	if (empty($_POST['price'])) {
			$errors['price'] = ' Required *';
		}
		else
		{
		    $price = $_POST['price'];
		    if (!preg_match('/^[0-9]{10}+$/', $price)) {
		      $errors['price'] = 'Only Allow Number value';
		    }
		}

// discount_type Validation ------------------

		if (empty($_POST['discount_type'])) {
			$errors['discount_type'] = 'Select Any One Option *';
		}
		

// discount_value Validation ------------------

		if (empty($_POST['discount_value'])) {
			$errors['discount_value'] = 'Required *';
		}
	}
}
?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<title>Ecommerce - Details Add</title>
	</head>
	<body>
		
		<div class="container text-capitalize">
			<h2 class="text-center py-4">Add New Product Details Here </h2>
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label class="form-label">Name</label>
							<input name="name" type="text" class="form-control" required >
							<div class="text-danger"><?php echo $errors['name']; ?></div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label class="form-label">Slug</label>
							<input name="slug" type="text" class="form-control" required >
							<div class="text-danger"><?php echo $errors['slug']; ?></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label class="form-label">SKU</label>
							<input name="sku" type="text" class="form-control" required >
							<div class="text-danger"><?php echo $errors['sku']; ?></div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label class="form-label">MOQ</label>
							<input name="moq" type="number" class="form-control" required >
							<div class="text-danger"><?php echo $errors['moq']; ?></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-4 col-12">
						<div class="mb-3">
							<label class="form-label">Categories</label>
							<input name="categories" type="text" class="form-control" required >
							<div class="text-danger"><?php echo $errors['categories']; ?></div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-12">
						<div class="mb-3">
							<label class="form-label">Search keywords</label>
							<input name="search_keywords" type="text" class="form-control" required >
							<div class="text-danger"><?php echo $errors['search_keywords']; ?></div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-12">
						<div class="mb-3">
							<label class="form-label">Price</label>
							<input name="price" type="number" class="form-control" required >
							<div class="text-danger"><?php echo $errors['price']; ?></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12">
						<label  class="form-label">Discount Type</label>
					    <select name="discount_type" class="form-select" required  >
					      <option selected disabled value="">Choose...	</option>
					      <option>Fixed</option>
					      <option>Discount</option>
					      <div class="text-danger"><?php echo $errors['discount_type']; ?></div>
					    </select>
					</div>
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label class="form-label">Discount value</label>
							<input name="discount_value" type="number" class="form-control" required >
							<div class="text-danger"><?php echo $errors['discount_value']; ?></div>
						</div>
					</div>
				</div>
				<a href="ecommerce.php"><button type="submit" name="submit" class="btn btn-danger">Save Here</button></a>
			</form>
			
		</div>
		<!-- Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>