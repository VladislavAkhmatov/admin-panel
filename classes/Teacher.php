<?php

class Teacher extends Table
{
    public $id = 0;
    public $name = '';
    public $user_id = 0;
    public $grades = 0;
    public $gruppa_id = 0;

    public $salary = 0;
    public $subject_id = 0;

    function validate()
    {
        return true;
    }
}
