<?php
class ClassroomMap extends BaseMap {
    public function findById($id = null){
        if ($id) {
        $res = $this->db->query("SELECT classroom_id, name "
        . "FROM classroom WHERE classroom_id = $id");
        return $res->fetchObject("Classroom");
        }
    return new Classroom();
    }
    public function save($classroom = Classroom){
        if ($classroom->validate()) {
        if ($classroom->classroom_id == 0) {
        return $this->insert($classroom);
    } else {
    return $this->update($classroom);
    }
    }
    return false;
    }
    
    private function insert($classroom = Classroom){
        $name = $this->db->quote($classroom->name);
        $active = $this->db->quote($classroom->active);
        if ($this->db->exec("INSERT INTO classroom(name, active)"
        . " VALUES($name, $active)") == 1) {
        $classroom->classroom_id = $this->db->lastInsertId();
        return true;
        }
        return false;
    }
    
    private function update($classroom = Classroom){
        $name = $this->db->quote($classroom->name);
        if ( $this->db->exec("UPDATE gruppa SET name = $name WHERE classroom_id = ".$classroom->classroom_id) == 1) {
        return true;
        }
        return false;
    }
}
