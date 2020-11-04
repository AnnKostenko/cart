<?php

include 'cart.php';

$cart = new Cart;

//Замена типа скидки:
$cart->setDiscountType(2);
$cart->calc();

?>

<html>
<body>
    <?php
    if (!empty($cart->getItems())) {
        foreach ($cart->getItems() as $id => $product) {
            echo '<span>' . $_SESSION['products'][$id]['name'] . ' <span>' . $product['quantity'] . '</span> <a href="delete.php?id=' . $id . '"> delete</a></span>';
            echo "<br />";
        }
        echo '<span>Сумма: '.$cart->getSum().'</span>';
        echo "<br />";
        echo '<span>Количество товаров в корзине: '.$cart->getCount().'</span>';
    } else {
        echo 'Корзина пуста';
    }
    ?>
</body>
</html>