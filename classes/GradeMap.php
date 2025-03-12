<?php
class gradesMap extends BaseMap
{
    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT grades_id, user_id,
        subject_id, grades, date"
                . "FROM gradess WHERE grades_id = $id");
            return $res->fetchObject("grades");
        }
        return new grades();
    }

    public function findBySubjectId($date, $subject_id, $gruppa_id)
    {
        $query = "SELECT grades.id, user.user_id, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, 
        subject.name as subject, 
        grades.grades as grades, 
        grades.date as date, grades.branch_id, gruppa.name, 
        CASE grades.attend
            WHEN 1 THEN 'Б'
            WHEN 0 THEN 'Н'
        END as attend
        FROM grades
        INNER JOIN user ON user.user_id = grades.user_id
        INNER JOIN student ON student.user_id = user.user_id
        INNER JOIN gruppa ON student.gruppa_id = gruppa.gruppa_id
        INNER JOIN subject ON subject.subject_id = grades.subject_id
        WHERE grades.subject_id = :subject_id 
        AND grades.branch_id = {$_SESSION['branch']} 
        AND date = :date 
        AND gruppa.gruppa_id = :gruppa_id";
        $res = $this->db->prepare($query);
        $res->execute([
            'subject_id' => $subject_id,
            'date' => $date,
            'gruppa_id' => $gruppa_id
        ]);
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertReason(grades $grades, $id)
    {
        $query = "UPDATE grades SET reason = :reason WHERE id = :id";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'reason' => $grades->reason,
                'id' => $id
            ])
        ) {
            return true;
        }
        return false;
    }
}