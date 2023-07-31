<?php
include '../lib/session.php';
include '../classes/product.php';
include '../classes/categories.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    $product = new product();
    $productUpdate = mysqli_fetch_assoc($product->getProductbyIdAdmin($_GET['id']));
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $result = $product->update($_POST, $_FILES);
        $productUpdate = mysqli_fetch_assoc($product->getProductbyIdAdmin($_GET['id']));
    }
} else {
    header("Location:../index.php");
}

$category = new categories();
$categoriesList = $category->getAll();
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
    <title>Edit Product</title>
</head>

<body>
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <label class="logo">ADMIN</label>
        <ul>
            <li><a href="productlist.php" class="active">Product Management</a></li>
            <li><a href="categoriesList.php">Category Management</a></li>
            <li><a href="orderlist.php">Order Management</a></li>
        </ul>
    </nav>
    <div class="title">
        <h1>Edit Product</h1>
    </div>
    <div class="container">
        <?php
        if (isset($result)) {
            echo $result;
        }
        ?>
        <div class="form-add">
            <form action="edit_product.php?id=<?= $productUpdate['id'] ?>" method="post" enctype="multipart/form-data">
                <input type="text" hidden name="id" style="display: none;" value="<?= $productUpdate['id'] ?>">
                <label for="name">Name Product</label>
                <input type="text" id="name" name="name" placeholder="Name Product.." value="<?= $productUpdate['name'] ?>">

                <label for="originalPrice">cost</label>
                <input type="number" id="originalPrice" name="originalPrice" value="<?= $productUpdate['originalPrice'] ?>">

                <label for="promotionPrice">promotional price</label>
                <input type="number" id="promotionPrice" name="promotionPrice" value="<?= $productUpdate['promotionPrice'] ?>">

                <label for="image">Image</label>
                <img src="uploads/<?= $productUpdate['image'] ?>" style="height: 200px;" id="image"> <br>

                <label for="imageNew">choose new image</label>
                <input type="file" id="imageNew" name="image">

                <label for="cateId">product type</label>
                <select id="cateId" name="cateId">
                    <?php foreach ($categoriesList as $key => $value) {
                        if ($value['id'] == $productUpdate['cateId']) { ?>
                            <option selected value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                        <?php  } else { ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                        <?php   } ?>
                    <?php } ?>
                </select>

                <label for="qty">quantity</label>
                <input type="number" id="qty" name="qty" value="<?= $productUpdate['qty'] ?>">

                <label for="des">describe</label>
                <textarea name="des" id="des" cols="30" rows="10"><?= $productUpdate['des'] ?></textarea>

                <input type="submit" value="Lưu" name="submit">
            </form>
        </div>
    </div>
    </div>
    
    <footer>
        <p class="copyright">STORENOW @ 2023</p>
    </footer>
</body>

</html>