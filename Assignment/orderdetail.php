<?php
include_once 'lib/session.php';
Session::checkSession('client');
include_once 'classes/cart.php';
include_once 'classes/orderDetails.php';

$cart = new cart();
$orderDetails = new orderDetails();

$totalQty = $cart->getTotalQtyByUserId();
$result = $orderDetails->getOrderDetails($_GET['orderId']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://use.fontawesome.com/2145adbb48.js"></script>
    <script src="https://kit.fontawesome.com/a42aeb5b72.js" crossorigin="anonymous"></script>
    <title>Order</title>
</head>

<body>
    <nav>
        <label class="logo">STORENOW</label>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="productList.php">Product</a></li>
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user']) { ?>
                <li><a href="logout.php" id="signin">logout</a></li>
            <?php } else { ?>
                <li><a href="register.php" id="signup">Register</a></li>
                <li><a href="login.php" id="signin">Login</a></li>
            <?php } ?>
            <li><a href="order.php" id="order" class="active">Order</a></li>
            <li>
                <a href="checkout.php">
                    <i class="fa fa-shopping-bag"></i>
                    <span class="sumItem">
                        <?= $totalQty['total'] ?>
                    </span>
                </a>
            </li>
        </ul>
    </nav>
    <section class="banner"></section>
    <div class="featuredProducts">
        <h1>Detail Order <?= $_GET['orderId'] ?></h1>
    </div>
    <div class="container-single">
        <table class="order">
            <tr>
                <th>numerical order</th>
                <th>Name Product</th>
                <th>Image</th>
                <th>unit price</th>
                <th>quantity</th>
            </tr>
            <?php $count = 1;
            foreach ($result as $key => $value) { ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $value['productName'] ?></td>
                    <td><img class="image-cart" src="admin/uploads/<?= $value['productImage'] ?>" alt=""></td>
                    <td><?= number_format($value['productPrice'], 0, '', ',') ?>VND</td>
                    <td><?= $value['qty'] ?></td>
                </tr>
            <?php }
            ?>
        </table>

    </div>
    </div>
    <footer>
        <div class="social">
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        </div>
        <ul class="list">
            <li>
                <a href="./">Home</a>
            </li>
            <li>
                <a href="productList.php">Product</a>
            </li>
        </ul>
        <p class="copyright">STORENOW @ 2023</p>
    </footer>
</body>

</html>