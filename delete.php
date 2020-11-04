<?php

include 'cart.php';

$cart = new Cart;

$cart->delete($_GET['id']);

header('Location: /list.php');
exit;