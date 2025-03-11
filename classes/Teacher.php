<?php
class Teacher extends Table
{
  public $id = 0;
  public $name = '';
  public $user_id = 0;
  public $grade = 0;
  public $gruppa_id = 0;
  public $date_begin = '';
  public $date_end = '';
  public $subject_id = 0;
  public $award_subject_id = NULL;
  public $file = '';
  public $otdel_id = 0;
  public $comment = '';
  public $award = NULL;
  function validate()
  {
    return true;
  }
}
