<?php

include_once('functions.php');
// error_reporting(0);

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
     
$book_size = array("7.5x7.5"=>"$1.50","8.5x11"=>"$1.50","5.5x8.5"=>"$1.50","4.25x6.87"=>"$1.50","5x8"=>"$2.50","5.06x7.81"=>"$2.50","5.25x8"=>"$2.50","5.83x8.26"=>"$2.50","6.13x9.21"=>"$2.50","6.625x10.25"=>"$2.50","6.69x9.61"=>"$2.50","7.44x9.68"=>"$2.50","7.5x9.25"=>"$2.50","7x10"=>"$2.50","8x10"=>"$2.50","8.25x6"=>"$2.50","8.25x8.25"=>"$2.50","8.25x11"=>"$2.50","8.27x11.69"=>"$2.50","8.5x8.5"=>"$2.50");
    
$binding_type = array("spiral"=>"$0.02","perfect"=>"$0.1");

$lamination_type = array("Glossy"=>"$0.00","Matt"=>"$1.00");

$color_type = array("Black n White Interior / Color Cover"=>"$0.032","Full Color Interior / Color Cover"=>"$0.11","Cream Color Interior / Color Cover"=>"$0.13");

if (isset($_POST['submit'])) {
    
    $size = get('size');
    $binding = get('binding');
    $color = get('color');
    $lamination = get('laminat');
    $pages = get('pages');
    $qty = get('qty');
    
    foreach ($book_size as $bs => $size_price) {
        if ($_POST['size'] == $bs) {
           echo $size_price; 
           echo "<br />";
        }
    }
    foreach ($binding_type as $bt => $binding_price) {
        if ($_POST['binding'] == $bt) {
           echo $binding_price;
           echo "<br />";
        }
    }
    foreach ($color_type as $ct => $color_price) {
        if ($_POST['color'] == $ct) {
           echo $color_price;
           echo "<br />";
        }
    }

    foreach ($lamination_type as $lt => $laminet_price) {
        if ($_POST['laminat'] == $lt) {
           echo $laminet_price;
           echo "<br />";
        }
    }

    $total = (($size_price) + (($binding_price * $qty) * ($color_price * $pages)) + ($laminet_price * $qty));

    echo "Total Of = ". $total;
    die();
    
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
        $quanity = "500 - 999";
        $discount_type = "25%";
    }
    elseif ($qty >= 1000) {
        $discount = ($total - ($total * (30/100)));
        $quanity = "1000+";
        $discount_type = "30%";
    }else{
        echo "-";
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
        <title>Book Price</title>
    </head>
    <body>
        <div class="container-fluid py-4">
            <form method="post" action="">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-select" name="size">
                            <option selected>Size</option>
                            <?php
                                foreach ($book_size as $bs => $size_price) {
                            ?>
                            <option value="<?php echo $bs; ?>"<?= (isset($_POST['size'])&&$_POST['size']==$bs)?'selected':'' ?>><?php echo $bs; ?></option>
                            <?php } ?>
                    </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="binding">
                            <option selected>Binding</option>
                            <?php
                                foreach ($binding_type as $bt => $binding_price) {
                            ?>
                            <option value="<?php echo $bt; ?>" <?= (isset($_POST['binding'])&&$_POST['binding']==$bt)?'selected':'' ?>><?php echo $bt; ?></option>
                        
                             <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="color">
                            <option selected>Color</option>
                            <?php
                               foreach ($color_type as $ct => $color_price) {
                            ?>
                             <option value="<?php echo $ct; ?>" <?= (isset($_POST['color'])&&$_POST['color']==$ct)?'selected':'' ?>><?php echo $ct; ?></option>
                        
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="laminat">
                            <option selected>Lamination</option>
                            <?php
                                foreach ($lamination_type as $lt => $laminet_price) {
                            ?>
                             <option value="<?php echo $lt; ?>" <?= (isset($_POST['laminat'])&&$_POST['laminat']==$lt)?'selected':'' ?>><?php echo $lt; ?></option>
                        
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row py-4">
                    <div class="col-md-3">
                        <label>Pages</label>
                        <input type="number" class="form-control" value="<?php echo $pages ?>" name="pages">
                    </div>
                    <div class="col-md-3">
                        <label>Qty</label>
                        <input type="number" class="form-control" value="<?php echo $qty ?>" name="qty">
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
                    <td><?php echo $discount_type ?></td>+
                </tr>
               <?php } ?>
            </tbody>
        </table>
    </div>
    <!--Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    
</body>
</html>