<?php
class ProductImage
{
    public $id;
    public $productId;
    public $imageUrl;
    public $sortOrder;
    public $createdAt;

    public function __construct($id = 0, $productId = 0, $imageUrl = '', $sortOrder = 0, $createdAt = '')
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->imageUrl = $imageUrl;
        $this->sortOrder = $sortOrder;
        $this->createdAt = $createdAt;
    }
}
?>
