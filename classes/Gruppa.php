<?php

class Gruppa extends Table
{
    public $gruppa_id = 0;
    public $name = '';
    public $date_begin;
    public $date_end;

    public function __construct()
    {
        $this->date_begin = date('Y-m-d');
        $this->date_end = date('Y-m-d');
    }

    function validate()
    {
        if (
            !empty($this->name) &&
            !empty($this->date_begin) &&
            !empty($this->date_end)
        ) {
            return true;
        }
        return false;
    }
}