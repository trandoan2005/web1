<?php
class Brand
{
    public $id;
    public $name;
    public $logo;
    public $status;
    public $createdAt;
    public $updatedAt;

    public function __construct($id = 0, $name = '', $logo = '', $status = 1, $createdAt = '', $updatedAt = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->logo = $logo;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
?>
