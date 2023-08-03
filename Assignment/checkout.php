<?php
include_once 'lib/session.php';
Session::checkSession('client');
include_once 'classes/cart.php';
include_once 'classes/user.php';

$cart = new cart();
$list = $cart->get();
$totalPrice = $cart->getTotalPriceByUserId();
$totalQty = $cart->getTotalQtyByUserId();

$user = new user();
$userInfo = $user->get();
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
    <title>Checkout</title>
</head>

<body>
    <nav>
        <label class="logo" id="logo">STORENOW</label>
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
            <li><a href="order.php" id="order">Order</a></li>
            <li>
                <a href="checkout.php" class="active">
                    <i class="fa fa-shopping-bag"></i>
                    <span class="sumItem" id="totalQtyHeader">
                        <?= $totalQty['total'] ?>
                    </span>
                </a>
            </li>
        </ul>
    </nav>
    <section class="banner"></section>
    <div class="featuredProducts">
        <h1>Cart</h1>
    </div>
    <div class="container-single">
        <?php
        if ($list) { ?>
            <table class="order">
                <tr>
                    <th>numerical order</th>
                    <th>Name Product</th>
                    <th>Image</th>
                    <th>unit price</th>
                    <th>quantity</th>
                    <th>operation</th>
                </tr>
                <?php
                $count = 1;
                foreach ($list as $key => $value) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $value['productName'] ?></td>
                        <td><img class="image-cart" src="admin/uploads/<?= $value['productImage'] ?>"></td>
                        <td><?= number_format($value['productPrice'], 0, '', ',') ?>VND </td>
                        <td>
                            <input id="<?= $value['productId'] ?>" type="number" name="qty" class="qty" value="<?= $value['qty'] ?>" onchange="update(this)" min="1">
                        </td>
                        <td>
                            <a href="delete_cart.php?id=<?= $value['id'] ?>">Xóa</a>
                        </td>
                    </tr>
                <?php }
                ?>
            </table>
            <div class="orderinfo">
                <div class="buy">
                    <h3>order information</h3>
                    <div>
                    orderer: <b><?= $userInfo['fullname'] ?></b>
                    </div>
                    <div>
                    quantity: <b id="qtycart"><?= $totalQty['total'] ?></b>
                    </div>
                    <div>
                    total money: <b id="totalcart"><?= number_format($totalPrice['total'], 0, '', ',') ?>VND</b>
                    </div>
                    <div>
                    delivery address: <b><?= $userInfo['address'] ?></b>
                    </div>
                    <div class="buy-btn">
                        <a href="add_order.php">proceed to order</a>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <h3>cart is currently empty</h3>
        <?php }
        ?>
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
<script type="text/javascript">
    function update(e) {
        var http = new XMLHttpRequest();
        var url = 'update_cart.php';
        var params = "productId=" + e.id + "&qty=" + e.value;
        http.open('POST', url, true);

        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        http.onreadystatechange = function() {
            if (http.readyState === XMLHttpRequest.DONE) {
                var status = http.status;
                if (status === 200) {
                    var arr = http.responseText;
                    var b = false;
                    var result = "";
                    for (let index = 0; index < arr.length; index++) {
                        if (arr[index] == "[") {
                            b = true;
                        }
                        if (b) {
                            result += arr[index];
                        }
                    }
                    var arrResult = JSON.parse(result.replace("undefined", ""));
                    console.log(arrResult);
                    document.getElementById("totalQtyHeader").innerHTML = arrResult[1]['total'];
                    document.getElementById("qtycart").innerHTML = arrResult[1]['total'];
                    document.getElementById("totalcart").innerHTML = arrResult[0]['total'].replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + "VND";

                    //alert('Đã cập nhật giỏ hàng!');
                } else if (status === 501) {
                    alert('The number of products is not enough to add to cart!');
                    e.value = parseInt(e.value) - 1;
                } else {
                    alert('Cart update failed!');
                    window.location.reload();
                }
            }

        }
        http.send(params);
    }

    var list = document.getElementsByClassName("qty");
    for (let item of list) {
        item.addEventListener("keypress", function(evt) {
            evt.preventDefault();
        });
    }
</script>

</html>