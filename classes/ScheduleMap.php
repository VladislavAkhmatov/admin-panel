<?php

class ScheduleMap extends BaseMap
{
    public function findScheduleByID($id)
    {
        $sql = "SELECT `schedule_id`, gruppa.name as gruppa, subject.name as subject, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as user, `date`, `time`, classroom.name, schedule.deleted FROM `schedule`
                INNER JOIN gruppa ON gruppa.gruppa_id = schedule.group_id
                INNER JOIN subject ON subject.subject_id = schedule.subject_id
                INNER JOIN user ON user.user_id = schedule.teacher_id
                INNER JOIN classroom ON classroom.classroom_id = schedule.classroom_id
                WHERE schedule_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findByParams($date, $subject_id, $group_id)
    {
        $sql = "SELECT schedule_id, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as teacher, group_id, time 
                FROM schedule
                JOIN user ON schedule.teacher_id = user.user_id
                WHERE subject_id = :subject_id
                AND group_id = :group_id AND date = :date";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':subject_id', $subject_id);
        $stmt->bindParam(':group_id', $group_id);
        $formattedData = Helper::formattedDataForDB($date);
        $stmt->bindParam(':date', $formattedData);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getEvents($group_id, $subject_id, $teacher_id, $month, $classroom)
    {
        $sql = "SELECT date, time, subject_id FROM schedule 
            WHERE group_id = ? AND subject_id = ? AND teacher_id = ? AND classroom_id = ? 
            AND DATE_FORMAT(date, '%Y-%m') = ?";

        error_log("SQL: " . $sql);
        error_log("Params: " . json_encode([$group_id, $subject_id, $teacher_id, $classroom, $month]));

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$group_id, $subject_id, $teacher_id, $classroom, $month]);

        if (!$stmt) {
            error_log("Ошибка SQL: " . implode(" ", $this->db->errorInfo()));
        }

        $events = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            error_log("Найдено событие: " . json_encode($row));
            $events[] = [
                'title' => "ID предмета: " . $row['subject_id'] . "\nВремя: " . $row['time'],
                'start' => $row['date'] . "T" . $row['time'],
                'allDay' => false
            ];
        }

        error_log("Всего событий: " . count($events));
        return $events;
    }

    public function getEventsByDay($day, $teacher = null, $group = null)
    {
        $sql = "SELECT `schedule_id`, gruppa.gruppa_id, subject.subject_id, user.user_id as teacher_id, classroom.classroom_id, gruppa.name as gruppa_name, subject.name as subject_name, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as teacher_fio, `date`, `time`, classroom.name as classroom_name
                FROM `schedule`
                JOIN gruppa ON schedule.group_id = gruppa.gruppa_id
                JOIN subject ON schedule.subject_id = subject.subject_id
                JOIN user ON schedule.teacher_id = user.user_id
                JOIN classroom ON schedule.classroom_id = classroom.classroom_id
                WHERE date LIKE :date";

        $params = [':date' => $day . "%"];

        if (!empty($teacher) && !empty($group)) {
            $sql .= " AND `teacher_id` = :teacher AND `gruppa_id` = :group";
            $params[':teacher'] = $teacher;
            $params[':group'] = $group;
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save($group_id, $subject_id, $teacher_id, $day, $time, $classroom)
    {
        $stmt = $this->db->prepare("INSERT INTO schedule (group_id, subject_id, teacher_id, date, time, classroom_id) 
        VALUES (:group, :subject, :teacher, :date, :time, :classroom)");

        $stmt->bindParam(':group', $group_id);
        $stmt->bindParam(':subject', $subject_id);
        $stmt->bindParam(':teacher', $teacher_id);
        $stmt->bindParam(':date', $day);
        $stmt->bindParam(':time', $time, PDO::PARAM_STR);
        $stmt->bindParam(':classroom', $classroom);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        if (
            $this->db->exec("DELETE FROM schedule WHERE
        schedule_id=$id") == 1
        ) {
            return true;
        }
        return false;
    }

    public function findByTeacher($teacherId)
    {
        $res = $this->db->query(
            "SELECT 
            schedule.schedule_id, 
            CONCAT(special.time_begin, ' — ' ,special.time_end) as time, 
            subject.name AS subject, 
            classroom.name AS classroom, 
            gruppa.name as gruppa, 
            COUNT(student.user_id) as count, 
            schedule.date,
            schedule.allowed
        FROM 
            lesson_plan 
            INNER JOIN schedule ON lesson_plan.lesson_plan_id=schedule.lesson_plan_id 
            INNER JOIN subject ON lesson_plan.subject_id=subject.subject_id 
            INNER JOIN classroom ON schedule.classroom_id=classroom.classroom_id
            INNER JOIN special ON special.special_id = lesson_plan.subject_id
            INNER JOIN gruppa ON gruppa.gruppa_id = lesson_plan.gruppa_id
            INNER JOIN student ON gruppa.gruppa_id = student.gruppa_id
        WHERE 
            lesson_plan.user_id=$teacherId AND student.deleted = 0 and schedule.deleted = 0
        GROUP BY 
            schedule.schedule_id, 
            CONCAT(special.time_begin, ' — ' ,special.time_end), 
            subject.name, 
            classroom.name, 
            gruppa.name,
            schedule.allowed, 
            schedule.date;"
        );
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function arrDate()
    {
        $query = "SELECT DISTINCT schedule.lesson_plan_id, schedule.date FROM `schedule` 
        INNER JOIN lesson_plan ON schedule.lesson_plan_id = lesson_plan.lesson_plan_id
        WHERE allowed = :allowed AND lesson_plan.user_id = :id and schedule.deleted = 0";
        $res = $this->db->prepare($query);
        $res->execute([
            'allowed' => 1,
            'id' => $_SESSION['id'],
        ]);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByDayTeacher($teacherId, $date)
    {
        $res = $this->db->query(
            "SELECT
            schedule.schedule_id, CONCAT(special.time_begin, ' — ' ,special.time_end) as time, subject.name 
            AS subject, classroom.name AS
            classroom, gruppa.name as gruppa, gruppa.gruppa_id, lesson_plan.lesson_plan_id, schedule.date, 
            COUNT(student.user_id) as count, subject.subject_id FROM lesson_plan INNER JOIN schedule ON
            lesson_plan.lesson_plan_id=schedule.lesson_plan_id INNER JOIN subject ON
            lesson_plan.subject_id=subject.subject_id INNER JOIN classroom ON
            schedule.classroom_id=classroom.classroom_id
            INNER JOIN special ON special.special_id = lesson_plan.subject_id
            INNER JOIN gruppa ON gruppa.gruppa_id = lesson_plan.gruppa_id
            INNER JOIN student ON gruppa.gruppa_id = student.gruppa_id
            WHERE lesson_plan.user_id={$_SESSION['id']} AND
            schedule.date='$date' AND student.deleted = 0 AND schedule.deleted = 0 AND schedule.allowed = 1
            GROUP BY 
            schedule.schedule_id,
            time,
            subject,
            classroom,
            gruppa,
            gruppa.gruppa_id,
            lesson_plan.lesson_plan_id,
            schedule.date"
        );
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function findByGroupId($group_id)
    {
        $sql = "SELECT gruppa.name as group_name, subject.name as subject, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as user, `date`, `time`, classroom.name as classroom, schedule.deleted FROM `schedule`
                JOIN gruppa ON schedule.group_id = gruppa.gruppa_id
                JOIN subject ON schedule.subject_id = subject.subject_id
                JOIN classroom ON schedule.classroom_id = classroom.classroom_id
                JOIN user ON schedule.teacher_id = user.user_id
                WHERE schedule.group_id = :group_id AND schedule.deleted = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findScheduleByDateAndTeacherId($date, $teacher_id)
    {
        $sql = "SELECT gruppa.name as group_name, subject.name as subject, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as user, `date`, `time`, classroom.name as classroom
                FROM `schedule`
                JOIN gruppa ON schedule.group_id = gruppa.gruppa_id
                JOIN subject ON schedule.subject_id = subject.subject_id
                JOIN user ON schedule.teacher_id = user.user_id
                JOIN classroom ON schedule.classroom_id = classroom.classroom_id
                WHERE DATE_FORMAT(date, '%Y-%m') = :date AND user.user_id = :teacher_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':teacher_id', $teacher_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
