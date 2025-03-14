<?php
class Admin extends Table
{
    public $user_id = 0;
    public $branch_id = 0;
    public $deleted = 0;

    function validate()
    {
        return true;
    }
}
