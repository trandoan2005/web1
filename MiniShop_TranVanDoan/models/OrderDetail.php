<?php
namespace Models;

class OrderDetail
{
    public $id;
    public $orderId;
    public $productId;
    public $quantity;
    public $price;
    public $createdAt;
    
    public $productName;
    public $productImage;

    public function __construct($id = 0, $orderId = 0, $productId = 0, $quantity = 1, $price = 0, $createdAt = '')
    {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->createdAt = $createdAt;
    }
}
?>
