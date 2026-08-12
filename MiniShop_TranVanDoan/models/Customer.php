<?php
namespace Models;

class Customer
{
    public $id;
    public $fullname;
    public $email;
    public $phone;
    public $address;
    public $status;
    public $createdAt;
    public $updatedAt;

    public function __construct($id = 0, $fullname = '', $email = '', $phone = '', $address = '', $status = 1, $createdAt = '', $updatedAt = '')
    {
        $this->id = $id;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
?>
