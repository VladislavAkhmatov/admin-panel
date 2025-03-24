<?php

class GradeMap extends BaseMap
{
    public function insert($user_id, $schedule_id, $activity, $attend, $homework)
    {
        $sql = "INSERT INTO `grades`(`user_id`, `schedule_id`, `activity`, `attend`, `homework`, `date`, `branch_id`) 
                VALUES (:user_id, :schedule_id, :activity, :attend, :homework, :date, :branch_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':schedule_id', $schedule_id);
        $stmt->bindParam(':activity', $activity);
        $stmt->bindParam(':attend', $attend);
        $stmt->bindParam(':homework', $homework);
        $date = date('Y-m-d');
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':branch_id', $_SESSION['branch']);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update($user_id, $schedule_id, $activity, $attend, $homework)
    {

        $sql = "UPDATE `grades` SET activity = :activity, attend = :attend, homework = :homework 
                WHERE user_id = :user_id AND `schedule_id` = :schedule_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':schedule_id', $schedule_id);
        $stmt->bindParam(':activity', $activity);
        $stmt->bindParam(':attend', $attend);
        $stmt->bindParam(':homework', $homework);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function findGradeByUserAndSchedule($user_id, $schedule_id)
    {
        $sql = "SELECT  `activity`, `attend`, `homework` FROM `grades` WHERE user_id = :user_id
                                                         AND schedule_id = :schedule_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':schedule_id', $schedule_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}