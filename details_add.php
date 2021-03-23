<?php

include_once('db_connection.php');
include_once('functions.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = false;

$error_msg = '';
$insert_data = '';
$name = '';
$slug = '';
$sku = '';
$moq = '';
$categories = '';
$search_keywords = '';
$price = '';
$discount_type = '';
$discount_value = '';

$errors = array('name' => '', 'slug' => '', 'sku' => '', 'moq' => '', 'categories' => '', 'search_keywords' => '', 'price' => '', 'discount_type' => '', 'discount_value' => '');

$id = get('id');

// $name = get('name');
// $slug = get('slug');
// $sku = get('sku');
// $moq = get('moq');
// $categories = get('categories');
// $search_keywords = get('search_keywords');
// $price = get('price');
// $discount_type = get('discount_type');
// $discount_value = get('discount_value');

if ($id) {

	$fetch_data = "SELECT * FROM ecommerce WHERE id='$id'";
	$raw = sql($fetch_data, $db_connection);

	foreach ($raw as $raws) {
		$id = $raws['id'];
		$name = $raws['name'];
		$slug = $raws['slug'];
		$sku = $raws['sku'];
		$moq = $raws['moq'];
		$categories = $raws['categories'];
		$search_keywords = $raws['search_keywords'];
		$price = $raws['price'];
		$discount_type = $raws['discount_type'];
		$discount_value = $raws['discount_value'];
	}
}

if (isset($_POST['submit'])) 
{
	include_once('api_insert.php');
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

		<style>
			.error{
				color: #FF0000;
			}
		</style>

	</head>
	<body>
		<?php
			if ($error_msg) {
				echo "<div class='alert alert-danger text-dark text-center alert-dismissible fade show' role='alert'>
				  <strong> $error_msg </strong>
				  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
				</div>";
			};
		?>
		
		<div class="container py-5">
			<h2 class="text-center pb-4">Add New Product Details Here </h2>
			<form method="POST" id="product_form">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label for="name" class="form-label">Name <span class="text-danger">*</span></label>
							<input name="name" id="name" value="<?php echo $name ?>" type="text" class="form-control"  >
							<div class="text-danger"><?php echo $errors['name']; ?></div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">

							<?php
								if ($id) {
									echo"<label for='slug' class='form-label'>Slug <span class='text-danger'>*</span></label>
										<input name='slug' value='$slug' type='text' class='form-control'  >";
								}
								else
								{
									echo"<label for='slug' class='form-label'>Slug <span class='text-danger'>*</span></label>
										<input name='slug' id='slug' value='$slug' type='text' class='form-control'  >";	
								}
							 ?>
							<div class="text-danger"><?php echo $errors['slug']; ?></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label for="" class="form-label">SKU <span class="text-danger">*</span></label>
							<input name="sku" id="sku" value="<?php echo $sku ?>" type="text" class="form-control"  >
							<div class="text-danger"><?php echo $errors['sku']; ?></div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label for="moq" class="form-label">MOQ <span class="text-danger">*</span></label>
							<input name="moq" id="moq" value="<?php echo $moq ?>" type="number" class="form-control"  >
							<div class="text-danger"><?php echo $errors['moq']; ?></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-4 col-12">
						<div class="mb-3">
							<label for="categories" class="form-label">Categories <span class="text-danger">*</span></label>
							<input name="categories" id="categories" value="<?php echo $categories ?>" type="text" class="form-control"  >
							<div class="text-danger"><?php echo $errors['categories']; ?></div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-12">
						<div class="mb-3">
							<label for="search_keywords" class="form-label">Search keywords <span class="text-danger">*</span></label>
							<input name="search_keywords" value="<?php echo $search_keywords ?>" type="text" class="form-control"  >
							<div class="text-danger"><?php echo $errors['search_keywords']; ?></div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-12">
						<div class="mb-3">
							<label for="price" class="form-label">Price <span class="text-danger">*</span></label>
							<input name="price" id="price" value="<?php echo $price ?>" type="number" class="form-control"  >
							<div class="text-danger"><?php echo $errors['price']; ?></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12 mb-3">
						<label for="discount_type" class="form-label">Discount Type <span class="text-danger">*</span></label>
						<select name="discount_type" id="discount_type" value="<?php echo $discount_type ?>" class="form-select">
							<option selected disabled >Select Option...</option>
							<?php
								$select_opt = array("Fixed","Discount");
                                foreach ($select_opt as $option) {
                            ?>
                            <option value="<?php echo $option; ?>" <?= ($discount_type==$option)? 'selected' : '' ?> <?=(isset($_POST['discount_type'])&&$_POST['discount_type']==$option)?'selected':'' ?>><?php echo $option; ?></option>
                        	<?php } ?>
						</select>
						<div class="text-danger"><?php echo $errors['discount_type']; ?></div>
					</div>
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label for="discount_value" class="form-label">Discount value <span class="text-danger">*</span></label>
							<input name="discount_value" id="discount_value" value="<?php echo $discount_value ?>" type="number" class="form-control"  >
							<div class="text-danger"><?php echo $errors['discount_value']; ?></div>
						</div>
					</div>
				</div>
				<button type='submit' id="submit" name='submit' class='btn btn-danger'>Save Here</button>
			</form>
			
		</div>
		<!-- Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
		<script type="text/javascript" src="jquery-3.6.0.min.js"></script>
		<script type="text/javascript" src="jquery.validate.js"></script>
		<script type="text/javascript" src="myjquery.js"></script>
	</body>
</html>