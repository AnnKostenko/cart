<?php
include 'cart.php';

delete($_GET['id']);

header('Location: /list.php');
exit;
