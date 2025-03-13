<?php
class Subject extends Table
{
    public $subject_id = 0;
    public $name = '';
    function validate()
    {
        if (
            !empty($this->name)
        ) {
            return true;
        }
        return false;
    }
}
