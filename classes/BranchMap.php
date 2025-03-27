<?php

class BranchMap extends BaseMap
{
    public function findById($id)
    {
        $sql = "SELECT `branch`, `deleted` FROM `branch` WHERE id = :id AND `deleted` = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function arrBranches()
    {
        $res = $this->db->query("SELECT id AS id, branch AS value FROM branch 
        WHERE id != 999 and deleted = 0");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function arrBranchWithoutCurrent()
    {
        $res = $this->db->query("SELECT id AS id, branch AS value FROM branch 
        WHERE id != 999 and deleted = 0 and id != {$_SESSION['branch']}");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert($branch)
    {
        $query = "INSERT INTO `branch` (`branch`, `date_founding`, `deleted`) 
        VALUES (:branch, NOW(), '0')";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':branch', $branch);
        return $stmt->execute();
    }

    public function update($id, $branch){
        $sql = "UPDATE `branch` SET `branch` = :branch WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':branch', $branch);
        return $stmt->execute();
    }
    public function delete($id){
        $sql = "UPDATE `branch` SET `deleted` = 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}


