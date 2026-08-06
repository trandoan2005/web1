<?php
class Category
{
    public $id;
    public $name;
    public $description;
    public $image;
    public $status;
    public $createdAt;
    public $updatedAt;

    public function __construct($id = 0, $name = '', $description = '', $image = '', $status = 1, $createdAt = '', $updatedAt = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
?>
