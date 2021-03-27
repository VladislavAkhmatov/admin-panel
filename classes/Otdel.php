<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Otdel
 *
 * @author Абельдинов Аскар
 */
class Otdel extends Table {
    public $otdel_id = 0;
    public $name = '';
    public $active = 1;
    function validate() {
         if (!empty($this->name)) {
        return true;
        }
    return false;
    }
}
