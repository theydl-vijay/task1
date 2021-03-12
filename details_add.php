<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = false;

$error_msg = $insert_data = $name = $slug = $sku = $moq =  $categories =  $search_keywords =  $price =  $discount_type =  $discount_value =  '';

$errors = array('name' => '', 'slug' => '', 'sku' => '', 'moq' => '', 'categories' => '', 'search_keywords' => '', 'price' => '', 'discount_type' => '', 'discount_value' => '',);

include_once('db_connection.php');
include_once('functions.php');

if(isset($_POST['submit']))
{
	$name = get('name');
	$slug = get('slug');
	$sku = get('sku');
	$moq = get('moq');
	$categories = get('categories');
	$search_keywords = get('search_keywords');
	$price = get('price');
	$discount_type = get('discount_type');
	$discount_value = get('discount_value');

	$insert = array();
	$insert['name'] = $name;
	$insert['slug'] = $slug;
	$insert['sku'] = $sku;
	$insert['moq'] = $moq;
	$insert['categories'] = $categories;
	$insert['search_keywords'] = $search_keywords;
	$insert['price'] = $price;
	$insert['discount_type'] = $discount_type;
	$insert['discount_value'] = $discount_value;

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

	if ($error) {
		$error_msg = "Please Input All Filed !";
	}
	else
	{
		$insert_data = insert('ecommerce', $insert, $db_connection);
	}

	if ($insert_data) {
		header("location:ecommerce.php");
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
		<?php
			if ($error_msg) {
				echo "<div class='alert alert-danger text-dark text-center alert-dismissible fade show' role='alert'>
				  <strong> $error_msg </strong>
				  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
				</div>";
			};
		?>
		
		<div class="container text-capitalize">
			<h2 class="text-center py-4">Add New Product Details Here </h2>
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label class="form-label">Name <span class="text-danger">*</span></label>
							<input name="name" value="<?php echo $name ?>" type="text" class="form-control" required >
							<div class="text-danger"><?php echo $errors['name']; ?></div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label class="form-label">Slug <span class="text-danger">*</span></label>
							<input name="slug" value="<?php echo $slug ?>" type="text" class="form-control" required >
							<div class="text-danger"><?php echo $errors['slug']; ?></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label class="form-label">SKU <span class="text-danger">*</span></label>
							<input name="sku" value="<?php echo $sku ?>" type="text" class="form-control" required >
							<div class="text-danger"><?php echo $errors['sku']; ?></div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label class="form-label">MOQ <span class="text-danger">*</span></label>
							<input name="moq" value="<?php echo $moq ?>" type="number" class="form-control" required >
							<div class="text-danger"><?php echo $errors['moq']; ?></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-4 col-12">
						<div class="mb-3">
							<label class="form-label">Categories <span class="text-danger">*</span></label>
							<input name="categories" value="<?php echo $categories ?>" type="text" class="form-control" required >
							<div class="text-danger"><?php echo $errors['categories']; ?></div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-12">
						<div class="mb-3">
							<label class="form-label">Search keywords <span class="text-danger">*</span></label>
							<input name="search_keywords" value="<?php echo $search_keywords ?>" type="text" class="form-control" required >
							<div class="text-danger"><?php echo $errors['search_keywords']; ?></div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-12">
						<div class="mb-3">
							<label class="form-label">Price <span class="text-danger">*</span></label>
							<input name="price" value="<?php echo $price ?>" type="number" class="form-control" required >
							<div class="text-danger"><?php echo $errors['price']; ?></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12">
						<label  class="form-label">Discount Type <span class="text-danger">*</span></label>
						<select name="discount_type" value="<?php echo $discount_type ?>" class="form-select"required>
							<option selected disabled >Select Option...</option>
							<?php
								$select_opt = array("Fixed","Discount");
							
                                foreach ($select_opt as $option) {
                            ?>
                            <option value="<?php echo $option; ?>"<?= (isset($_POST['discount_type'])&&$_POST['discount_type']==$option)?'selected':'' ?>><?php echo $option; ?></option>

                        	<?php } ?>

							
							<!-- <option value="Fixed">Fixed</option>
							<option value="Discount">Discount</option> -->
						</select>
						<div class="text-danger"><?php echo $errors['discount_type']; ?></div>
					</div>
					<div class="col-lg-6 col-md-6 col-12">
						<div class="mb-3">
							<label class="form-label">Discount value <span class="text-danger">*</span></label>
							<input name="discount_value" value="<?php echo $discount_value ?>" type="number" class="form-control" required >
							<div class="text-danger"><?php echo $errors['discount_value']; ?></div>
						</div>
					</div>
				</div>
				<button type="submit" name="submit" class="btn btn-danger">Save Here</button>
			</form>
			
		</div>
		<!-- Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>