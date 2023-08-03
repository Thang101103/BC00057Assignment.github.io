<?php
include_once 'lib/session.php';
Session::checkSession('client');
include 'classes/order.php';
include_once 'classes/cart.php';

$cart = new cart();
$totalQty = $cart->getTotalQtyByUserId();

$order = new order();
$result = $order->getOrderByUser();

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
                <li><a href="logout.php" id="signin">Logout</a></li>
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
        <h1>Order</h1>
    </div>
    <div class="container-single">
        <?php if ($result) { ?>
            <table class="order">
                <tr>
                    <th>numerical order</th>
                    <th>code orders</th>
                    <th>booking date</th>
                    <th>delivery date</th>
                    <th>status</th>
                    <th>operation</th>
                </tr>
                <?php $count = 1;
                foreach ($result as $key => $value) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $value['id'] ?></td>
                        <td><?= $value['createdDate'] ?></td>
                        <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Estimated 3 days after the order has been processed" ?> <?=  ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                        <?php
                        if ($value['status'] == 'Delivering') { ?>
                            <td>
                                <a href="complete_order.php?orderId=<?= $value['id'] ?>">Delivering (Click to confirm receipt)</a>
                            </td>
                            <td>
                                <a href="orderdetail.php?orderId=<?= $value['id'] ?>">Detail</a>
                            </td>
                        <?php } else { ?>
                            <td>
                                <?= $value['status'] ?>
                            </td>
                            <td>
                                <a href="orderdetail.php?orderId=<?= $value['id'] ?>">Detail</a>
                            </td>
                        <?php }
                        ?>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <h3>Orders are currently empty</h3>
        <?php } ?>


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
                <a href="./">Hoem</a>
            </li>
            <li>
                <a href="productList.php">Product</a>
            </li>
        </ul>
        <p class="copyright">STORENOW @ 2023</p>
    </footer>
</body>

</html>