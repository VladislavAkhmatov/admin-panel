<?php

class BalanceMap extends BaseMap
{
    public function findByUserIdAndSubjectId($user_id, $subject_id)
    {
        $sql = "SELECT balance.user_id, subject.subject_id, subject.name, balance.count FROM `balance` 
                INNER JOIN subject ON balance.subject_id = subject.subject_id
                WHERE user_id = :user_id AND subject.subject_id = :subject_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':subject_id', $subject_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}