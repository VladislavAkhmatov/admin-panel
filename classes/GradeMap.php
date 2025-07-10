<?php

class GradeMap extends BaseMap
{
    public function insert($user_id, $schedule_id, $activity, $attend, $homework, $subject_id)
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
            $query = "UPDATE student SET points = points + 1 WHERE user_id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();

            $withdraw = "UPDATE `balance` SET `count` = count + (-1) 
                WHERE user_id = :user_id AND subject_id = :subject_id";
            $stmtWithdraw = $this->db->prepare($withdraw);
            $stmtWithdraw->bindParam(':user_id', $user_id);
            $stmtWithdraw->bindParam(':subject_id', $subject_id);
            $stmtWithdraw->execute();
            if ($stmtWithdraw->rowCount() > 0) {
                return true;
            } else {
                $count = -1;
                $sql = "INSERT INTO `balance`(`user_id`, `subject_id`, `count`) 
                VALUES (:user_id, :subject_id, :count)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':subject_id', $subject_id);
                $stmt->bindParam(':count', $count);
                return $stmt->execute();
            }
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

    public function findByUserAndSubject($user_id, $subject_id)
    {
        $sql = "SELECT subject.name as subject, grades.activity, grades.attend, grades.homework, grades.date FROM `grades` 
                JOIN schedule ON grades.schedule_id = schedule.schedule_id
                JOIN subject ON schedule.subject_id = subject.subject_id
                WHERE grades.user_id = :user_id AND schedule.subject_id = :subject_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':subject_id', $subject_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function percentOfAttendanceByBranches()
    {
        $sql = "SELECT `attend` FROM `grades` WHERE branch_id = :branch_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':branch_id', $_SESSION['branch']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function percentOfAttendanceBySubject($subject_id)
    {
        $sql = "SELECT attend, schedule.subject_id FROM grades 
                INNER JOIN schedule ON grades.schedule_id = schedule.schedule_id
                WHERE branch_id = :branch_id AND subject_id = :subject_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':branch_id', $_SESSION['branch']);
        $stmt->bindParam(':subject_id', $subject_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}