<?php

class GradeMap extends BaseMap
{
    public function save($user_id, $schedule_id, $activity, $attend, $homework)
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
}