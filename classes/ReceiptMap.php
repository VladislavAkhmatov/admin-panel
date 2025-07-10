<?php

class ReceiptMap extends BaseMap
{
    public function insert($type, $note, $file)
    {
        $sql = "INSERT INTO `receipts`(`type`, `note`, `file`) 
        VALUES (:type, :note, :file)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':file', $file);
        return $stmt->execute();
    }


    public function findAll($ofset = 0, $limit = 30)
    {
        $sql = "SELECT `id`, `type`, `note`, `file` FROM `receipts`
        WHERE `checked` = 0
        LIMIT $ofset, $limit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function checked($id)
    {
        $sql = "UPDATE `receipts` SET `checked` = 1 WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}