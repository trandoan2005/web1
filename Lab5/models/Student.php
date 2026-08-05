<?php
class Student
{
    public $id;
    public $studentcode;
    public $fullname;
    public $phone;
    public $gender;
    public $created_at;

    public function __construct($id = 0, $studentcode = '', $fullname = '', $phone = '', $gender = '', $created_at = '')
    {
        $this->id = $id;
        $this->studentcode = $studentcode;
        $this->fullname = $fullname;
        $this->phone = $phone;
        $this->gender = $gender;
        $this->created_at = $created_at;
    }
}
?>
