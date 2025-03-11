<?php
class Grade extends Table
{
    public $grade_id = 0;
    public $user_id = 0;
    public $subject_id = 0;
    public $grade = 0;
    public $date = date;
    public $reason = 0;
    function validate()
    {
        if (
            !empty($this->user_id) &&
            !empty($this->subject_id) &&
            !empty($this->grade) &&
            !empty($this->date)
        ) {
            return true;
        }
        return false;
    }
}