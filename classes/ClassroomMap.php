<?php

class ClassroomMap extends BaseMap
{
    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT classroom_id, name FROM classroom WHERE classroom_id = $id");
            return $res->fetchObject("Classroom");
        }
        return new Classroom();
    }

    public function save($classroom = Classroom)
    {
        if ($classroom->validate()) {
            if ($classroom->classroom_id == 0) {
                return $this->insert($classroom);
            } else {
                return $this->update($classroom);
            }
        }
        return false;
    }

    private function insert($classroom = Classroom)
    {
        $name = $this->db->quote($classroom->name);
        if (
            $this->db->exec("INSERT INTO classroom(name, branch)"
                . " VALUES($name, {$_SESSION['branch']} )") == 1
        ) {
            $classroom->classroom_id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }


    private function update($classroom = Classroom)
    {
        $name = $this->db->quote($classroom->name);
        if ($this->db->exec("UPDATE classroom SET name = $name WHERE classroom_id = " . $classroom->classroom_id) == 1) {
            return true;
        }
        return false;
    }

    public function findAll($ofset = 0, $limit = 30)
    {

        $res = $this->db->query("SELECT classroom.classroom_id, classroom.name, branch.id, branch.branch FROM classroom
            INNER JOIN branch ON branch.id = classroom.branch
            WHERE classroom.branch = {$_SESSION['branch']} and classroom.deleted = 0
            LIMIT $ofset,
            $limit");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function count()
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM classroom 
        WHERE classroom.deleted = 0 AND classroom.branch = {$_SESSION['branch']}");
        return $res->fetch(PDO::FETCH_OBJ)->cnt;
    }

    public function findViewById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT classroom.classroom_id, classroom.name, branch.branch FROM classroom 
            INNER JOIN branch ON branch.id = classroom.branch WHERE classroom_id = $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function arrClassrooms()
    {
        $res = $this->db->query("SELECT classroom_id AS id, name AS value, branch AS branch FROM classroom 
        WHERE branch = {$_SESSION['branch']} and deleted = 0");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteClassroomById($id)
    {
        $query = "UPDATE classroom SET deleted = 1 WHERE classroom_id = :id";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'id' => $id
            ])
        ) {
            return true;
        }
        return false;
    }
}
