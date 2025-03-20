<?php

class Grade extends Table
{
    public $grades_id = 0;
    public $user_id = 0;
    public $subject_id = 0;
    public $grades = 0;
    public $date = date;
    public $reason = 0;

    public function __construct()
    {
        $this->date = date('Y-m-d');
    }

    function validate()
    {
        if (
            !empty($this->user_id) &&
            !empty($this->subject_id) &&
            !empty($this->grades) &&
            !empty($this->date)
        ) {
            return true;
        }
        return false;
    }
}