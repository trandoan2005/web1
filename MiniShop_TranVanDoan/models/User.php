<?php
class User
{
    public $id;
    public $username;
    public $password;
    public $fullname;
    public $email;
    public $phone;
    public $role;
    public $status;
    public $createdAt;
    public $updatedAt;

    public function __construct($id = 0, $username = '', $password = '', $fullname = '', $email = '', $phone = '', $role = 'admin', $status = 1, $createdAt = '', $updatedAt = '')
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->phone = $phone;
        $this->role = $role;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
?>
