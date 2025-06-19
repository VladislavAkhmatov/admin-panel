<?php

class Student extends Table
{
    public $id = 0;
    public $user_id = 0;
    public $gruppa_id = 0;
    public $entry_date;
    public $end_date;

    function validate()
    {
        if (!empty($this->gruppa_id)) {
            return true;
        }
        return false;
    }
}
