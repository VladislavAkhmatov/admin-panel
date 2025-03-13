<?php

class SubjectMap extends BaseMap
{
    public function arrSubjects()
    {

        $res = $this->db->query("SELECT subject.subject_id AS id, 
        subject.name AS value FROM subject
        WHERE subject.deleted = 0 AND subject.branch = {$_SESSION['branch']}
        ");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function arrSubjectsTime()
    {

        $res = $this->db->query("SELECT subject.subject_id AS id, 
        subject.name AS value FROM subject
        WHERE subject.deleted = 0 AND subject.branch = {$_SESSION['branch']}
        ");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT subject_id, name "
                . "FROM subject WHERE subject_id = $id");
            return $res->fetchObject("Subject");
        }
        return new Subject();
    }
    public function save($subject = Subject)
    {
        if ($subject->validate()) {
            if ($subject->subject_id == 0) {
                return $this->insert($subject);
            } else {
                return $this->update($subject);
            }
        }
        return false;
    }
    private function insert($subject = Subject)
    {
        $sql = "INSERT INTO subject(name, branch) VALUES(:name, :branch)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $subject->name);
        $stmt->bindParam(':branch', $_SESSION['branch']);
        if ($stmt->execute()) {
            $subject->subject_id = $this->db->lastInsertId();
            return true;
        }

        return false;
    }
    private function update($subject = Subject)
    {
        $name = $this->db->quote($subject->name);
        if (
            $this->db->exec("UPDATE subject SET name = $name
         WHERE subject_id = " . $subject->subject_id) == 1
        ) {
            return true;
        }
        return false;
    }
    public function findAll($ofset = 0, $limit = 30)
    {
        $res = $this->db->query("SELECT subject.subject_id,
        subject.name, subject.name AS special FROM subject WHERE subject.deleted = 0 AND subject.branch = {$_SESSION['branch']} LIMIT $ofset,
        $limit");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }
    public function count()
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM
        subject WHERE subject.deleted = 0 AND subject.branch = {$_SESSION['branch']}");
        return $res->fetch(PDO::FETCH_OBJ)->cnt;
    }
    public function findViewById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT subject.subject_id,
        subject.name, subject.name AS special FROM subject WHERE subject_id =
        $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function deleteSubjectById($id)
    {
        $query = "UPDATE subject SET deleted = 1 WHERE subject_id = :id";
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

    public function listSubject()
    {
        $query = "SELECT subject.subject_id, subject.name, branch.id as branch_id FROM subject
        INNER JOIN branch ON subject.branch = branch.id
                WHERE subject.deleted = 0";
        $res = $this->db->prepare($query);
        $res->execute();
        return $res->fetchAll(PDO::FETCH_OBJ);
    }
}