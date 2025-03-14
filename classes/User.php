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
    public $gender_id = 0;
    function validate()
    {
        return true;
    }
    public function __construct(){
        $this->birthday = date('Y-m-d');
    }
}