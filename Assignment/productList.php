<?php
include_once 'lib/session.php';
include_once 'classes/product.php';
include_once 'classes/categories.php';
include_once 'classes/cart.php';

$cart = new cart();
$totalQty = $cart->getTotalQtyByUserId();

$product = new product();
$list = $product->getProductsByCateId((isset($_GET['page']) ? $_GET['page'] : 1), (isset($_GET['cateId']) ? $_GET['cateId'] : 2));
$pageCount = $product->getCountPagingClient((isset($_GET['cateId']) ? $_GET['cateId'] : 2));

$categories = new categories();
$categoriesList = $categories->getAll();
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
    <title>product list</title>
</head>

<body>
    <nav>
        <label class="logo">STORENOW</label>
        <ul>
            <li><a href="index.php">Home</li>
            <li><a href="productList.php" class="active">Product</a></li>
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user']) { ?>
                <li><a href="logout.php" id="signin">Logout</a></li>
            <?php } else { ?>
                <li><a href="register.php" id="signup">Register</a></li>
                <li><a href="login.php" id="signin">Login</a></li>
            <?php } ?>
            <li><a href="order.php" id="order">Order</a></li>
            <li>
                <a href="checkout.php">
                    <i class="fa fa-shopping-bag"></i>
                    <span class="sumItem">
                        <?= ($totalQty['total']) ? $totalQty['total'] : "0" ?>
                    </span>
                </a>
            </li>
        </ul>
    </nav>
    <section class="banner"></section>
    <div class="featuredProducts">
        <h1>List of products</h1>
    </div>
    <div class="category">
    Category: <select onchange="location = this.value;">
            <?php
            foreach ($categoriesList as $key => $value) {
                if ($value['id'] == $_GET['cateId']) { ?>
                    <option selected value="productList.php?cateId=<?= $value['id'] ?>"><?= $value['name'] ?></option>
                <?php } else { ?>
                    <option value="productList.php?cateId=<?= $value['id'] ?>"><?= $value['name'] ?></option>
                <?php } ?>
            <?php }
            ?>
        </select>
    </div>
    <div class="container">
        <?php if ($list) {
            foreach ($list as $key => $value) { ?>
                <div class="card">
                    <div class="imgBx">
                        <a href="detail.php?id=<?= $value['id'] ?>"><img src="admin/uploads/<?= $value['image'] ?>" alt=""></a>
                    </div>
                    <div class="content">
                        <div class="productName">
                            <a href="detail.php?id=<?= $value['id'] ?>">
                                <h3><?= $value['name'] ?></h3>
                            </a>
                        </div>
                        <div>
                        sold: <?= $value['soldCount'] ?>
                        </div>
                        <div class="original-price">
                            <?php
                            if ($value['promotionPrice'] < $value['originalPrice']) { ?>
                                cost: <del><?= number_format($value['originalPrice'], 0, '', ',') ?>VND</del>
                            <?php } else { ?>
                                <p>.</p>
                            <?php } ?>
                        </div>
                        <div class="price">
                        price: <?= number_format($value['promotionPrice'], 0, '', ',') ?>VND
                        </div>
                        <!-- <div class="rating">
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div> -->
                        <div class="action">
                            <a class="add-cart" href="add_cart.php?id=<?= $value['id'] ?>">Add To Cart</a>
                            <a class="detail" href="detail.php?id=<?= $value['id'] ?>">View detail</a>
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <h3>No products...</h3>
        <?php  }
        ?>
    </div>
    <div class="pagination">
        <a href="productList.php?page=<?= (isset($_GET['page'])) ? (($_GET['page'] <= 1) ? 1 : $_GET['page'] - 1) : 1 ?>&cateId=<?= (isset($_GET['cateId'])) ? $_GET['cateId'] : 2 ?>">&laquo;</a>
        <?php
        for ($i = 1; $i <= $pageCount; $i++) {
            if (isset($_GET['page'])) {
                if ($i == $_GET['page']) { ?>
                    <a class="active" href="productList.php?page=<?= $i ?>&cateId=<?= (isset($_GET['cateId'])) ? $_GET['cateId'] : 2 ?>"><?= $i ?></a>
                <?php } else { ?>
                    <a href="productList.php?page=<?= $i ?>&cateId=<?= (isset($_GET['cateId'])) ? $_GET['cateId'] : 2 ?>"><?= $i ?></a>
                <?php  }
            } else { ?>
                <a href="productList.php?page=<?= $i ?>&cateId=<?= (isset($_GET['cateId'])) ? $_GET['cateId'] : 2 ?>"><?= $i ?></a>
            <?php  } ?>
        <?php }
        ?>
        <a href="productList.php?page=<?= (isset($_GET['page'])) ? $_GET['page'] + 1 : 2 ?>&cateId=<?= (isset($_GET['cateId'])) ? $_GET['cateId'] : 2 ?>">&raquo;</a>
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