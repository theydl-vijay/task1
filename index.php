<?php
// "{Base Price + (Price per page x # pages) + Lamentation + Binding} X # of copies }"
include_once('functions.php');
// include_once('db_connection.php');

$size = get('size');
$binding = get('binding');
$color = get('color');
$lamination = get('laminat');
$pages = get('pages');
$qty = get('qty')


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
                            <option value="6x9">6x9</option>
                            <option value="5.5x8.5">5.5x8.5</option>
                            <option value="7.5x7.5">7.5x7.5</option>
                            <option value="8.5x11">8.5x11</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="binding">
                            <option selected>Binding</option>
                            <option value="spiral">spiral</option>
                            <option value="perfect">perfect</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="color">
                            <option selected>Color</option>
                            <option value="Black n White Interior / Color Cover">Black n White Interior / Color Cover</option>
                            <option value="Full Color Interior / Color CoverFull Color Interior / Color Cover">Full Color Interior / Color Cover</option>
                            <option value="Cream Color Interior / Color Cover">Cream Color Interior / Color Cover</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="laminat">
                            <option selected>Lamination</option>
                            <option value="Glossy">Glossy</option>
                            <option value="Matt">Matt</option>
                        </select>
                    </div>
                </div>
                <div class="row py-4">
                    <div class="col-md-3">
                        <label>Pages</label>
                        <input type="number" class="form-control" value="" name="pages">
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
                    <th scope="col">size</th>
                    <th scope="col">binding</th>
                    <th scope="col">color</th>
                    <th scope="col">laminat</th>
                    <th scope="col">pages</th>
                    <th scope="col">qty</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_POST['submit'])) { ?>
                   <tr>
                    <td><?php echo $size; ?></td>
                    <td><?php echo $binding; ?></td>
                    <td><?php echo $color; ?></td>
                    <td><?php echo $laminat; ?></td>
                    <td><?php echo $pages; ?></td>
                    <td><?php echo $qty; ?></td>
                </tr>
               <?php } ?>
                
            </tbody>
        </table>
    </div>
    <!--Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    
</body>
</html>