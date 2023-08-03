<?php
include_once 'lib/session.php';
Session::checkSession('client');
include_once 'classes/cart.php';

if (isset($_GET['id'])) {
    $cart = new cart();
    $result = $cart->add($_GET['id']);
    if ($result === 'out of stock') {
        echo '<script type="text/javascript">alert("The number of products is not enough!"); history.back();</script>';
        return;
    }

    if ($result) {
        echo '<script type="text/javascript">alert("Product added to cart successfully!"); history.back();</script>';
    } else {
        echo '<script type="text/javascript">alert("Add product to cart failed!"); history.back();</script>';
    }
}
