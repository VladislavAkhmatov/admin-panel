<?php
class User extends Table
{
    public $user_id = 0;
    public $lastname = '';
    public $firstname = '';
    public $patronymic = '';
    public $login = '';
    public $pass = '';
    public $birthday;
    public $role_id = 0;
    public $branch_id = 0;
    public $branch_name = '';
    public $gender_id = 0;
    function validate()
    {
        if (
            !empty($this->lastname) &&
            !empty($this->firstname) &&
            !empty($this->role_id) &&
            !empty($this->branch_id) &&
            !empty($this->gender_id)
        ) {
            return true;
        }
        return false;
    }
    public function __construct(){
        $this->birthday = date('Y-m-d');
    }
}