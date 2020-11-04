<?php
include 'cart.php';
$cart = new Cart;
if (!empty((int)$_GET['id']) && !empty((int)$_GET['quantity'])) {
    $cart->add(['id' => (int)$_GET['id'], 'quantity' => (int)$_GET['quantity'], 'price' => $_SESSION['products'][(int)$_GET['id']]['price']]);
}
?>



<html>
<body>
    <form method="get">
        <select name="id">
            <?php foreach ($_SESSION['products'] as $id => $product) {
                echo '<option value="'.$id.'">'.$product['name'].'</option>';
            } ?>
        </select>
        <label>Количество товара <input name="quantity" type="number" value="1" min="1" /></label>
        <input type="submit" value="Отправить" />
    </form>
</body>
</html>






