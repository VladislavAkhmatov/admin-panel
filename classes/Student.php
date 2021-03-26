<?php
class Student extends Table {
    public $user_id = 0;
    public $gruppa_id = 0;
    public $num_zach = 0;
    function validate() {
        if (!empty($this->gruppa_id)) {
            return true;
        }
    return false;
    }
}
