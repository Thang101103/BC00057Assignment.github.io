<?php
include '../lib/session.php';
include '../classes/categories.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $category = new categories();
        $result = $category->insert($_POST['name']);
    }
} else {
    header("Location:../index.php");
}
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
    <title>Add new category</title>
</head>

<body>
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <label class="logo">ADMIN</label>
        <ul>
            <li><a href="productlist.php" >Product management</a></li>
            <li><a href="categoriesList.php" class="active" >Catalog management</a></li>
            <li><a href="orderlist.php">order management</a></li>
        </ul>
    </nav>
    <div class="title">
        <h1>add new category</h1>
    </div>
    <div class="container">
        <p style="color: green;"><?= !empty($result) ? $result : '' ?></p>
        <div class="form-add">
            <form action="add_category.php" method="post">
                <label for="name">Name list</label>
                <input type="text" id="name" name="name" placeholder="Tên danh mục.." required>

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