<?php
class Gruppa extends Table
{
    public $gruppa_id = 0;
    public $name = '';
    public $date_begin = date;
    public $date_end = date;
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