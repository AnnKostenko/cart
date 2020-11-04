<?php
session_start();

if (empty($_SESSION['products'])) {
    $_SESSION['products'] = [
        2 => ['name' => 'Книга1', 'price' => 233],
        7 => ['name' => 'Книга2', 'price' => 333],
        43 => ['name' => 'Книга3', 'price' => 332],
    ];
}

class Cart
{
    private $cart;
    private $discountType = 1;

    public function __construct()
    {
        $this->cart = $_SESSION['cart'];
    }

    public function add($item)
    {
        $this->cart = $_SESSION['cart'];

        if (empty($item)) {
            return false;
        } elseif (!empty((int)$item['id']) && isset($_SESSION['cart']['items'][(int)$item['id']])) {
            $this->change((int)$item['id'], $this->cart['items'][(int)$item['id']]['quantity'] + $item['quantity']);
        } else {
            if ($item['id']) {
                $this->cart['items'][$item['id']] = $item;
            } else {
                $this->cart['items'][] = $item;
            }
        }

        $this->calc();

        return true;

    }

    public function change($itemId, $quantity)
    {
        if (empty((int)$itemId) || empty((int)$quantity)) {
            return false;
        }

        $this->cart['items'][$itemId]['quantity'] = $quantity;
    }

    public function calc()
    {
        $this->cart['sum'] = 0;
        $this->cart['count'] = 0;

        // считает сумму и количество
        foreach ($this->cart['items'] as $id => $item) {
            $this->cart['sum'] += $item['quantity'] * $item['price'];
            $this->cart['count'] += $item['quantity'];
        }

        // делаем скидку
        $this->useDiscount();


        $_SESSION['cart'] = $this->cart;

    }

    private function useDiscount()
    {
        if (!in_array((int)$this->discountType, [1, 2])) {
            return false;
        }
        switch ($this->discountType) {
            case 1:
                if ($this->cart['count'] > 10) {
                    $this->cart['sum'] = $this->cart['sum'] * 0.9; //скидка 10%
                    return true;
                }
                break;
            case 2:
                if ($this->cart['sum'] > 2000) {
                    $this->cart['sum'] = $this->cart['sum'] * 0.93; //скидка 7%
                    return true;
                }
                break;
        }
        return false;
    }

    // Удалить с корзины
    public function delete($itemId)
    {
        if (empty((int)$itemId)) {
            return false;
        }

        unset($this->cart['items'][$itemId]);

        $this->calc();
    }

    public function getItems()
    {
        return $this->cart['items'];
    }

    public function getSum()
    {
        return $this->cart['sum'];
    }

    public function getCount()
    {
        return $this->cart['count'];
    }

    public function setDiscountType($discountType = 1)
    {
        $this->discountType = $discountType;
    }

}