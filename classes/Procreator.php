<?php
class Procreator extends Table
{
    public $user_id = 0;
    public $homework_teacher_id = 0;
    public $name = '';
    public $teacher_id = 0;
    public $gruppa_id = 0;
    public $date_begin = '';
    public $date_end = '';
    public $subject_id = '';
    public $file = '';
    public $file_prepared = '';
    public $child_id = 0;
    function validate()
    {
        return true;
    }
}