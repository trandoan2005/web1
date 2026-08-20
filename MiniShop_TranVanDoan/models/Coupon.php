<?php
namespace Models;

class Coupon
{
    public $id;
    public $code;
    public $discountPercent;
    public $maxUsage;
    public $usedCount;
    public $validUntil;
    public $status;
    public $createdAt;

    public function __construct($id, $code, $discountPercent, $maxUsage, $usedCount, $validUntil, $status, $createdAt)
    {
        $this->id = $id;
        $this->code = $code;
        $this->discountPercent = $discountPercent;
        $this->maxUsage = $maxUsage;
        $this->usedCount = $usedCount;
        $this->validUntil = $validUntil;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }
}
?>
