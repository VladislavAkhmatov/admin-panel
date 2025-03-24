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

    public function update($user_id, $subject_id, $count)
    {
        $sql = "UPDATE `balance` SET `count` = count + :count 
                WHERE user_id = :user_id AND subject_id = :subject_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':subject_id', $subject_id);
        $stmt->bindParam(':count', $count);
        return $stmt->execute();
    }

    public function insert($user_id, $subject_id, $count)
    {
        $sql = "INSERT INTO `balance`(`user_id`, `subject_id`, `count`) 
                VALUES (:user_id, :subject_id, :count)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':subject_id', $subject_id);
        $stmt->bindParam(':count', $count);
        return $stmt->execute();
    }

    public function withdraw($user_id, $subject_id)
    {
        $sql = "UPDATE `balance` SET `count` = count + (-1) 
                WHERE user_id = :user_id AND subject_id = :subject_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':subject_id', $subject_id);
        if ($this->findByUserIdAndSubjectId($user_id, $subject_id) > 0) {
            return $stmt->execute();
        } else {
            $count = 0;
            if ($this->insert($user_id, $subject_id, $count)) {
                return $stmt->execute();
            }
        }

    }
}