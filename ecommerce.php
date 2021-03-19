<?php
include_once('db_connection.php');
include_once('functions.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$fetch_query = "SELECT * FROM ecommerce ORDER BY id DESC";
$raw = sql($fetch_query, $db_connection);

$id = get('id');

$where = "id='$id'";
delete('ecommerce', $where, $db_connection);

?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<!-- fontawesome -->
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
		<title>Ecommerce - Data list</title>
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
						<th scope="col">EDIT</th>
						<th scope="col">DELETE</th>
					</tr>
				</thead>
				<tbody>
					<?php
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
						<td>
	                        <a href="details_add.php?id=<?php echo $raws['id'];?>"><button type="submit" name="edit_btn" class="btn btn-info"><i class="fas fa-edit text-gray-dark"></i></button></a>
                        </td>
                        <td>
	                        <a href="ecommerce.php?id=<?php echo $raws['id'];?>"><button type="submit" name="delete_btn" class="btn btn-info"><i class="fas fa-trash text-gray-dark"></i></button></a>
                        </td>

					</tr>

				<?php } ?>

				</tbody>
			</table>
		</div>
		<!-- Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>