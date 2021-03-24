<?php

class Gruppa extends Table{
    public $gruppa_id = 0;
    public $name = '';
    public $special_id = 0;
    public $date_begin = date;
    public $date_end = date;
    function validate() {
        return false;
    }
}


