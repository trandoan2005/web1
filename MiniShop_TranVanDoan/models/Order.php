<?php
class Order
{
    public $id;
    public $customerId;
    public $totalAmount;
    public $status;
    public $note;
    public $createdAt;
    public $updatedAt;
    public $customerName; // Thêm thuộc tính này cho Dashboard

    public function __construct($id = 0, $customerId = 0, $totalAmount = 0, $status = 'Chờ xử lý', $note = '', $createdAt = '', $updatedAt = '')
    {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->totalAmount = $totalAmount;
        $this->status = $status;
        $this->note = $note;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
?>
