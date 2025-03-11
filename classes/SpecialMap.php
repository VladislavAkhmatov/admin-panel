<?php
class SpecialMap extends BaseMap
{
    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT special_id, subject.name as subject, subject.subject_id as subject_id, 
            time_begin, time_end FROM special 
            LEFT JOIN subject on special.subject_id = subject.subject_id
            WHERE special_id = $id");
            return $res->fetchObject("Special");
        }
        return new Special();
    }
    public function save($special = Special)
    {
        if ($special->validate()) {
            if ($special->special_id == 0) {
                return $this->insert($special);
            } else {
                return $this->update($special);
            }
        }
        return false;
    }
    private function insert($special = Special)
    {
        $subject_id = $this->db->quote($special->subject_id);
        $time_begin = $this->db->quote($special->time_begin);
        $time_end = $this->db->quote($special->time_end);
        if ($this->db->exec("INSERT INTO special(subject_id, time_begin, time_end, branch_id) VALUES($subject_id, $time_begin, $time_end, {$_SESSION['branch']})") == 1) {
            $special->special_id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    private function update($special = Special)
    {
        $subject_id = $this->db->quote($special->subject_id);
        $time_begin = $this->db->quote($special->time_begin);
        $time_end = $this->db->quote($special->time_end);
        if (
            $this->db->exec("UPDATE special SET subject_id = $subject_id,
        time_begin = $time_begin, time_end = $time_end WHERE special_id = " . $special->special_id) == 1
        ) {
            return true;
        }
        return false;
    }
    public function findAll($ofset = 0, $limit = 30)
    {
        $res = $this->db->query("SELECT special_id,
        subject.name as subject, time_begin, time_end FROM special 
        LEFT JOIN subject ON special.subject_id = subject.subject_id 
        WHERE special.branch_id = {$_SESSION['branch']} AND special.deleted = 0
        LIMIT $ofset,
        $limit");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }
    public function count()
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM
        special");
        return $res->fetch(PDO::FETCH_OBJ)->cnt;
    }
    public function findViewById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT special.special_id, subject.name as subject, special.time_begin, special.time_end
            FROM special 
            LEFT JOIN subject ON special.subject_id=subject.subject_id WHERE special_id = $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function arrSubjectsTime()
    {

        $res = $this->db->query("SELECT special.special_id AS id, 
        CONCAT(subject.name, ' -> ',special.time_begin,' -> ',special.time_end) as value 
        FROM special
        INNER JOIN subject ON subject.subject_id = special.subject_id
        WHERE subject.deleted = 0 AND subject.branch = {$_SESSION['branch']} AND special.deleted = 0
        ");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteSpecialById($id){
        $query = "UPDATE special SET deleted = 1 WHERE special_id = :id";
        $res = $this->db->prepare($query);
        if($res->execute([
            'id' => $id
        ])){
            return true;
        }
        return false;
    }
}
