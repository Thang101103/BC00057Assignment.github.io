<?php
include_once 'lib/session.php';
Session::checkSession('client');
include_once 'classes/order.php';
$order = new order();
$result = $order->add();
if ($result) {
    echo '<script type="text/javascript">alert("Order Success!"); history.back();</script>';
} else {
    echo '<script type="text/javascript">alert("Order Fail!"); history.back();</script>';
}
