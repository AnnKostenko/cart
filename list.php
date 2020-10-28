<?php
include 'cart.php';

?>
<html>
<body>
    <?php foreach ($_SESSION['cart']['items'] as $id => $product) {
       echo '<span>'.$_SESSION['products'][$id]['name'].' <span>'.$product['quantity'].'</span> <a href="delete.php?id='.$id.'"> delete</a></span>';
        echo "<br />";
    } 
        echo '<span>'.$_SESSION['cart']['sum'].'</span>';
    ?>
</body>
</html>
