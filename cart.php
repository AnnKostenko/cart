<?php

session_start();

if (empty($_SESSION['products'])) {
    $_SESSION['products'] = [
        2 => ['name' => 'Книга1', 'price' => 233],
        7 => ['name' => 'Книга2', 'price' => 333],
        43 => ['name' => 'Книга3', 'price' => 332],
    ];
}

function add($item = [])
{
    if (empty($item)) {
        return false;
    } elseif (!empty((int)$item['id']) && isset($_SESSION['cart']['items'][(int)$item['id']])) {
        return change((int)$item['id'], $_SESSION['cart']['items'][(int)$item['id']]['quantity'] + $item['quantity']);
    }
    $_SESSION['cart']['sum'] = (empty($_SESSION['cart']['sum']) ? 0 : $_SESSION['cart']['sum']) + $item['quantity'] * $item['price'];
    if ($item['id']) {
        $_SESSION['cart']['items'][$item['id']] = $item;
    } else {
        $_SESSION['cart']['items'][] = $item;
    }
    return true;
}

function delete($itemId)
{
    if (empty((int)$itemId)) {
        return false;
    }
    $_SESSION['cart']['sum'] -= $_SESSION['cart']['items'][$itemId]['quantity'] * $_SESSION['cart']['items'][$itemId]['price'];
    unset($_SESSION['cart']['items'][$itemId]);
    return true;
}

function change($itemId, $quantity)
{
    if (empty((int)$itemId) || empty((int)$quantity)) {
        return false;
    }
    $_SESSION['cart']['sum'] += ($quantity - $_SESSION['cart']['items'][$itemId]['quantity']) * $_SESSION['cart']['items'][$itemId]['price'];
    $_SESSION['cart']['items'][$itemId]['quantity'] = $quantity;
    return true;
}

function useDiscount($discountType = 1)
{
    if (!in_array((int)$discountType, [1, 2])) {
        return false;
    }
    switch ($discountType) {
        case 1:
            $count = 0;
            foreach ($_SESSION['cart']['items'] as $item) {
                $count += $item['quantity'];
                if ($count > 10) {
                    $_SESSION['cart']['sum'] = $_SESSION['cart']['sum'] * 0.9; //скидка 10%
                    return true;
                }
            }
            break;
        case 2:
            if ($_SESSION['cart']['sum'] > 2000) {
                $_SESSION['cart']['sum'] = $_SESSION['cart']['sum'] * 0.93; //скидка 7%
                return true;
            }
            break;
    }
    return false;
}