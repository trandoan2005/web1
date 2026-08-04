<?php
class Room {
    public $id;
    public $roomNumber;
    public $roomName;
    public $roomType;
    public $price;
    public $capacity;
    public $floor;
    public $status;
    public $image;
    public $description;

    public function __construct($id, $roomNumber, $roomName, $roomType, $price, $capacity, $floor, $status, $image, $description) {
        $this->id = $id;
        $this->roomNumber = $roomNumber;
        $this->roomName = $roomName;
        $this->roomType = $roomType;
        $this->price = $price;
        $this->capacity = $capacity;
        $this->floor = $floor;
        $this->status = $status;
        $this->image = $image;
        $this->description = $description;
    }

    public function getFormattedPrice() {
        return number_format($this->price, 0, ',', '.') . ' đ';
    }

    public function getStatusClass() {
        if ($this->status == 'Còn trống') return 'status-available';
        if ($this->status == 'Đã đặt') return 'status-booked';
        if ($this->status == 'Bảo trì') return 'status-maintenance';
        return '';
    }
}
?>
