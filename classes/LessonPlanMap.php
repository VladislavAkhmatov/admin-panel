<?php
class LessonPlanMap extends BaseMap
{
    public function existsPlan($plan = LessonPlan)
    {
        $res = $this->db->query("SELECT lesson_plan_id FROM
    lesson_plan "
            . "WHERE gruppa_id = $plan->gruppa_id AND
    subject_id = $plan->subject_id AND user_id = $plan->user_id");
        if ($res->fetchColumn() > 0) {
            return true;
        }
        return false;
    }
    public function save($plan = LessonPlan)
    {
        if (
            $this->db->exec("INSERT INTO lesson_plan(gruppa_id,
        subject_id, user_id)"
                . " VALUES($plan->gruppa_id,$plan->subject_id,$plan->user_id)") == 1
        ) {
            return true;
        }
        return false;
    }
    public function findByTeacherId($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT special.special_id, gruppa.name as gruppa, subject.name 
            as subject, special.time_begin, special.time_end, lesson_plan.user_id, lesson_plan.lesson_plan_id FROM special
            INNER JOIN subject ON subject.subject_id = special.subject_id
            INNER JOIN lesson_plan ON lesson_plan.subject_id=special.special_id
            INNER JOIN gruppa ON gruppa.gruppa_id = lesson_plan.gruppa_id
            WHERE lesson_plan.user_id=$id");
            return $res->fetchAll(PDO::FETCH_OBJ);
        }
        return false;
    }
    public function delete($id)
    {
        if (
            $this->db->exec("DELETE FROM lesson_plan WHERE
        lesson_plan_id=$id") == 1
        ) {
            return true;
        }
        return false;
    }

    public function findTeachers($ofset = 0, $limit = 30)
    {
        $res = $this->db->query("SELECT user.user_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, COUNT(lesson_plan.subject_id) AS count_plan, branch.id AS branch FROM user 
        INNER JOIN teacher ON user.user_id=teacher.user_id 
        INNER JOIN branch ON branch.id=user.branch_id
        LEFT OUTER JOIN lesson_plan ON teacher.user_id=lesson_plan.user_id 
        LEFT OUTER JOIN subject ON lesson_plan.subject_id=subject.subject_id 
        WHERE teacher.deleted = 0 and user.branch_id = {$_SESSION['branch']}
        GROUP BY user.user_id LIMIT $ofset, $limit");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }
    public function arrPlanByTeacherId($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT
            lesson_plan.lesson_plan_id AS id, CONCAT(gruppa.name,' -> ', subject.name, ' -> ' ,special.time_begin, ' -> ', special.time_end) AS value FROM lesson_plan 
            INNER JOIN gruppa ON lesson_plan.gruppa_id=gruppa.gruppa_id 
            INNER JOIN subject ON lesson_plan.subject_id=subject.subject_id 
            INNER JOIN special ON special.special_id=lesson_plan.subject_id 
            WHERE lesson_plan.user_id=$id
            ORDER BY gruppa.name, subject.name");
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }
    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT lesson_plan_id,
        gruppa_id, subject_id, user_id FROM lesson_plan WHERE
        lesson_plan_id=$id");
            return $res->fetchObject('LessonPlan');
        }
        return false;
    }
}
