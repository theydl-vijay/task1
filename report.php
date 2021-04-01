<?php
include_once('db_connection.php');
include_once('functions.php');

$week_query = "SELECT WEEK(audit_created_date) as month, count(id) as entery FROM ecommerce GROUP by WEEK(audit_created_date)";
$raw = sql($week_query, $db_connection);

// $month_query = "SELECT MONTHNAME(audit_created_date) as month, count(id) as entery FROM ecommerce GROUP by MONTH(audit_created_date)";
// $raw = sql($month_query, $db_connection);

// $quarter_query = "SELECT QUARTER(audit_created_date) as month, count(id) as entery FROM ecommerce GROUP by QUARTER(audit_created_date)";
// $raw = sql($quarter_query, $db_connection);

// $year_query = "SELECT YEAR(audit_created_date) as month, count(id) as entery FROM ecommerce GROUP by YEAR(audit_created_date)";
// $raw = sql($year_query, $db_connection);

$report_opt = array("Week","Month","Quarter","Year");

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
		<div class="container">
			<h3 class="text-center py-4">Monthely Report</h3>
			<div>
			<form>
				<select class="form-select w-25" name="select_option">
					<option selected disabled > Select Report Option </option>
					<?php
						foreach ($report_opt as $report) {
					?>
					<option value="<?php echo $report; ?>" <?= (isset($_POST['select_option'])&&$_POST['select_option']==$report)?'selected':'' ?>><?php echo $report; ?></option>
				<?php } ?>
				</select>
				<button type="button" name="submit" class="btn btn-primary my-2">Submit</button>
			</form>

			<table class="table table-striped table-hover my-4">
				<thead>
					<tr class="text-capitalize">
						<th scope="col">week</th>
						<th scope="col">total entery</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					foreach ($raw as $raws) {
						$month = $raws['month'];
						$entery = $raws['entery'];
					?>
					<tr>
						<td><?php echo $month; ?></td>
						<td><?php echo $entery; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
	<!-- Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	<script type="text/javascript" src="jquery-3.6.0.min.js"></script>
</html>