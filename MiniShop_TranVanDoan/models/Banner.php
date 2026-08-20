<?php
namespace Models;

class Banner
{
    public $id;
    public $title;
    public $image;
    public $link;
    public $sortOrder;
    public $status;
    public $createdAt;
    public $updatedAt;

    public function __construct($id, $title, $image, $link, $sortOrder, $status, $createdAt, $updatedAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->link = $link;
        $this->sortOrder = $sortOrder;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
?>
