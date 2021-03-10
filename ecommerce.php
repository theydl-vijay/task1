<?php
include_once('db_connection.php');
// include_once('functions.php');

$fetch_query = "SELECT * FROM ecommerce ORDER BY id DESC";
$query_run = mysqli_query($db_connection,$fetch_query);

?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<title>Ecommerce</title>
	</head>
	<body>
		
		<div class="container-fluid">
			<h2 class="text-center py-4"> Product List </h2>
			<a href="details_add.php"><button type="button" class="btn btn-primary my-4">Add New Product</button></a>
			<table class="table table-striped table-hover">
				<thead>
					<tr class="text-capitalize">
						<th scope="col">id</th>
						<th scope="col">name</th>
						<th scope="col">slug</th>
						<th scope="col">SKU</th>
						<th scope="col">MOQ</th>
						<th scope="col">categories</th>
						<th scope="col">search key words</th>
						<th scope="col">price</th>
						<th scope="col">discount type</th>
						<th scope="col">discount value</th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					while($raw = mysqli_fetch_array($query_run))
					{	
						$id = $raw['id'];
						$name = $raw['name'];
						$slug = $raw['slug'];
						$sku = $raw['sku'];
						$moq = $raw['moq'];
						$categories = $raw['categories'];
						$search_keywords = $raw['search_keywords'];
						$price = $raw['price'];
						$discount_type = $raw['discount_type'];
						$discount_value = $raw['discount_value'];
					?>
					
					<tr>
						<td><?php echo $id; ?></td>
						<td><?php echo $name; ?></td>
						<td><?php echo $slug; ?></td>
						<td><?php echo $sku; ?></td>
						<td><?php echo $moq; ?></td>
						<td><?php echo $categories; ?></td>
						<td><?php echo $search_keywords; ?></td>
						<td><?php echo $price; ?></td>
						<td><?php echo $discount_type; ?></td>
						<td><?php echo $discount_value; ?></td>
					</tr>

				<?php } ?>

				</tbody>
			</table>
		</div>
		<!-- Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>