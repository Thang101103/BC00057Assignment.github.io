<?php
include_once 'lib/session.php';
Session::checkSession('client');
include_once 'classes/order.php';

if (isset($_GET['orderId'])) {
    $order = new order();
    $result = $order->completeOrder($_GET['orderId']);
    if ($result) {
        echo '<script type="text/javascript">alert("success!"); history.back();</script>';
    } else {
        echo '<script type="text/javascript">alert("fail!"); history.back();</script>';
    }
}