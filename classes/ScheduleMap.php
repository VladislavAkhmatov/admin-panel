<?php

class ScheduleMap extends BaseMap
{

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

    public function getEventsByDay($day)
    {
        $sql = "SELECT `schedule_id`, `group_id`, `subject_id`, `teacher_id`, `date`, `time`, `classroom_id` 
            FROM `schedule` WHERE date LIKE :date";

        error_log("SQL Query: " . $sql);
        error_log("Parameter: " . $day);

        $stmt = $this->db->prepare($sql);
        $likeDate = $day . "%"; // Добавляем "%" для поиска по дате без учета времени
        $stmt->bindParam(':date', $likeDate, PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt) {
            error_log("Ошибка SQL: " . implode(" ", $this->db->errorInfo()));
        }

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Найденные записи: " . json_encode($result));

        return $result;
    }


    public function existsScheduleByLessonPlanId($idPlan)
    {
        $res = $this->db->query("SELECT schedule_id FROM schedule
        WHERE lesson_plan_id = $idPlan");
        if ($res->fetchColumn() > 0) {
            return true;
        }
        return false;
    }

    public function findDayById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT name FROM day
        WHERE date = $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function findByTeacherId($id = null)
    {
        $days = $this->findDays();
        $result = [];
        foreach ($days as $day) {
            $arrDay = [];
            $arrDay['id'] = $day->day_id;
            $arrDay['name'] = $day->name;
            $arrDay['gruppa'] = [];
            $gruppas = $this->findGruppasByDayTeacher($id);
            foreach ($gruppas as $gruppa) {
                $arrGruppa = [];
                $arrGruppa['name'] = $gruppa->name;
                $arrGruppa['schedule'] = $this->findByGruppasDayTeacher($id, $gruppa->gruppa_id);
                $arrDay['gruppa'][] = $arrGruppa;
            }
            $result[] = $arrDay;
        }
        return $result;
    }

    public function findDays()
    {
        $res = $this->db->query("SELECT day_id, name FROM day");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function existsScheduleTeacherAndGruppa($schedule = Schedule)
    {
        $plan = (new LessonPlanMap())->findById($schedule->lesson_plan_id);
        $res = $this->db->query("SELECT schedule.schedule_id FROM
        lesson_plan INNER JOIN schedule "
            . "ON
        lesson_plan.lesson_plan_id=schedule.lesson_plan_id "
            . "WHERE (lesson_plan.gruppa_id=$plan->gruppa_id OR lesson_plan.user_id=$plan->user_id) AND "
            . "(schedule.date=$schedule->date)");
        if ($res->fetchColumn() > 0) {
            return true;
        }
        return false;
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


    public function findByGruppaDayStudent($date, $gruppaId)
    {
        $res = $this->db->query("SELECT
        schedule.schedule_id,subject.name AS subject, gruppa.name AS gruppa, classroom.name AS classroom FROM lesson_plan 
        INNER JOIN schedule ON
        lesson_plan.lesson_plan_id=schedule.lesson_plan_id INNER JOIN subject ON
        lesson_plan.subject_id=subject.subject_id  INNER JOIN gruppa ON gruppa.gruppa_id=lesson_plan.gruppa_id INNER JOIN classroom ON
        schedule.classroom_id=classroom.classroom_id 
        WHERE schedule.date=$date AND lesson_plan.gruppa_id = $gruppaId
        
        ");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findGruppaByStudentId($id)
    {
        $res = $this->db->query("SELECT gruppa.gruppa_id, gruppa.name 
            FROM student
            INNER JOIN gruppa ON student.gruppa_id = gruppa.gruppa_id
            WHERE student.user_id = $id ");
        return $res->fetch(PDO::FETCH_ASSOC);
    }


    public function findGruppasByDayTeacher($teacherId)
    {
        $res = $this->db->query("SELECT DISTINCT
        gruppa.gruppa_id, gruppa.name FROM lesson_plan "
            . "INNER JOIN schedule ON
        lesson_plan.lesson_plan_id=schedule.lesson_plan_id "
            . "INNER JOIN gruppa ON
        lesson_plan.gruppa_id=gruppa.gruppa_id "
            . "WHERE lesson_plan.user_id=$teacherId
         ORDER BY gruppa.name");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }


    public function findByGruppasDayTeacher($teacherId, $gruppaId)
    {
        $res = $this->db->query(
            "SELECT
        schedule.schedule_id, CONCAT(special.time_begin, ' — ' ,special.time_end) as time, subject.name 
        AS subject,classroom.name AS
        classroom FROM lesson_plan INNER JOIN schedule ON
        lesson_plan.lesson_plan_id=schedule.lesson_plan_id INNER JOIN subject ON
        lesson_plan.subject_id=subject.subject_id INNER JOIN classroom ON
        schedule.classroom_id=classroom.classroom_id
        INNER JOIN special ON special.special_id = lesson_plan.subject_id
        WHERE lesson_plan.user_id=$teacherId AND
        lesson_plan.gruppa_id=$gruppaId"
        );
        return $res->fetchAll(PDO::FETCH_ASSOC);
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

    public function studentCount($gruppa_id)
    {
        $query = "SELECT COUNT(student.user_id) as count FROM student
        WHERE student.gruppa_id = :gruppa_id";
        $res = $this->db->prepare($query);
        $res->execute([
            'gruppa_id' => $gruppa_id,
        ]);
        return $res->fetch(PDO::FETCH_OBJ);
    }

    public function allowed($schedule_id)
    {
        $query = "UPDATE schedule SET allowed=1 WHERE schedule_id=:schedule_id";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'schedule_id' => $schedule_id,
            ])
        ) {
            return true;
        }
        return false;
    }

    public function findByDate($date)
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
            lesson_plan.date=$date
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

    public function updatePlan($schedule_id, $lesson_plan_id)
    {
        $query = "UPDATE schedule SET deleted = 1 WHERE schedule_id = :schedule_id";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'schedule_id' => $schedule_id,
            ])
        ) {
            return true;
        }
        return false;
    }
}
