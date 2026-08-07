<?php
class Product
{
    public $id;
    public $categoryId;
    public $brandId;
    public $name;
    public $slug;
    public $oldPrice;
    public $salePrice;
    public $quantity;
    public $description;
    public $image;
    public $status;
    public $createdAt;
    public $updatedAt;
    
    // Properties for JOIN data
    public $cateName;
    public $brandName;

    public function __construct($id = 0, $categoryId = 0, $brandId = 0, $name = '', $slug = '', $oldPrice = 0, $salePrice = 0, $quantity = 0, $description = '', $image = '', $status = 1, $createdAt = '', $updatedAt = '')
    {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->brandId = $brandId;
        $this->name = $name;
        $this->slug = $slug;
        $this->oldPrice = $oldPrice;
        $this->salePrice = $salePrice;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->image = $image;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
?>
