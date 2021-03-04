<?php
// "{Base Price + (Price per page x # pages)*(spiral x Binding} X # of copies }"
include_once('functions.php');

error_reporting(0);

$size = get('size');
$binding = get('binding');
$color = get('color');
$lamination = get('laminat');
$pages = get('pages');
$qty = get('qty');

$total = (($size) + (($binding * $pages)*($color * $pages)) + ($lamination + $qty));


if ($qty <= 49) {
    $discount = ($total - ($total * (0/100)));
    $quanity = "1-49";
    $discount_type = "-";
}
elseif ($qty <= 99) {
    $discount = ($total - ($total * (10/100)));
     $quanity = "50 - 99";
     $discount_type = "10%";
}
elseif ($qty <= 249) {
    $discount = ($total - ($total * (15/100)));
     $quanity = "100 - 249";
     $discount_type = "15%";
}
elseif ($qty <= 499) {
    $discount = ($total - ($total * (20/100)));
     $quanity = "250 - 499";
     $discount_type = "20%";
}
elseif ($qty <= 999) {
    $discount = ($total - ($total * (25/100)));
     $quanity = "50 - 999";
     $discount_type = "25%";
}
elseif ($qty >= 1000) {
    $discount = ($total - ($total * (30/100)));
     $quanity = "1000+";
     $discount_type = "30%";
}else{
    echo "-";
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
        <title>Book Price</title>
    </head>
    <body>
        <div class="container-fluid py-4">
            <form method="post" action="">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-select" name="size">
                            <option selected>Size</option>
                            <option value="1.50" >6x9</option>
                            <option value="1.50">5.5x8.5</option>
                            <option value="1.50">7.5x7.5</option>
                            <option value="1.50">8.5x11</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="binding">
                            <option selected>Binding</option>
                            <option value="2.0">spiral</option>
                            <option value="3.0">perfect</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="color">
                            <option selected>Color</option>
                            <option value="0.032">Black n White Interior / Color Cover</option>
                            <option value="0.040">Full Color Interior / Color Cover</option>
                            <!-- <option value="Cream Color Interior / Color Cover">Cream Color Interior / Color Cover</option> -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="laminat">
                            <option selected>Lamination</option>
                            <option value="0.00">Glossy</option>
                            <option value="0.00">Matt</option>
                        </select>
                    </div>
                </div>
                <div class="row py-4">
                    <div class="col-md-3">
                        <label>Pages</label>
                        <input type="number" class="form-control" value="f" name="pages">
                    </div>
                    <div class="col-md-3">
                        <label>Qty</label>
                        <input type="number" class="form-control" value="" name="qty">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
            </div>
        </form>
    </div>
    <div class="container">
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th scope="col">Quanity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Price Actual</th>
                    <th scope="col">Discount</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_POST['submit'])) { ?>
                   <tr>
                    <td><?php echo $quanity; ?></td>
                    <td><?php echo $total; ?></td>
                    <td><?php echo $discount; ?></td>
                    <td><?php echo $discount_type ?></td>
                </tr>
               <?php } ?>
                
            </tbody>
        </table>
    </div>
    <!--Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    
</body>
</html>