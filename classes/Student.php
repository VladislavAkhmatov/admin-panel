<?php
class Student extends Table
{
    public $id = 0;
    public $text = '';
    public $user_id = 0;
    public $parent_id = 0;
    public $gruppa_id = 0;
    public $subject_id = 0;
    public $subject_count = 0;
    public $count = 0;
    public $price = 0;
    public $grade_id = 0;
    public $date;
    public $tab = '';
    public $grades = NULL;
    public $subject_price = 0;
    public $attend = 0;
    public $num_zach = 0;
    public $reference = '';
    public $comment = '';
    public $file = '';
    public $link = '';
    public $payment_method = 'Ссылка';
    function validate()
    {
        if (!empty($this->gruppa_id)) {
            return true;
        }
        return false;
    }

    public function __construct(){
        $this->date = date('Y-m-d');
    }
}
