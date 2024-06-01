<?php
class GradeMap extends BaseMap
{
    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT grade_id, user_id,
        subject_id, grade, date"
                . "FROM grades WHERE grade_id = $id");
            return $res->fetchObject("Grade");
        }
        return new Grade();
    }

    public function findBySubjectId($date, $subject_id, $gruppa_id)
    {
        $query = "SELECT grade_accept.id, user.user_id, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, 
        subject.name as subject, 
        grade_accept.grade as grade, 
        grade_accept.date as date, grade_accept.branch_id, gruppa.name, 
        CASE grade_accept.attend
            WHEN 1 THEN 'Б'
            WHEN 0 THEN 'Н'
        END as attend
        FROM grade_accept
        INNER JOIN user ON user.user_id = grade_accept.user_id
        INNER JOIN student ON student.user_id = user.user_id
        INNER JOIN gruppa ON student.gruppa_id = gruppa.gruppa_id
        INNER JOIN subject ON subject.subject_id = grade_accept.subject_id
        WHERE grade_accept.subject_id = :subject_id 
        AND grade_accept.branch_id = {$_SESSION['branch']} 
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

    public function insertReason(Grade $grade, $id)
    {
        $query = "UPDATE grade_accept SET reason = :reason WHERE id = :id";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'reason' => $grade->reason,
                'id' => $id
            ])
        ) {
            return true;
        }
        return false;
    }
}