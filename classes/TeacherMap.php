<?php

class TeacherMap extends BaseMap
{
    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, 
            teacher.user_id,
            awards.subject_id, awards.award FROM teacher

            LEFT JOIN awards ON teacher.user_id = awards.user_id
            INNER JOIN user ON teacher.user_id = user.user_id
            
            WHERE teacher.user_id = $id");
            $teacher = $res->fetchObject("Teacher");
            if ($teacher) {
                return $teacher;
            }
        }
        return new Teacher();
    }

    public function save($user = User, $teacher = Teacher)
    {
        if ($teacher->validate() && (new UserMap())->save($user)) {
            if ($teacher->user_id == 0) {
                $teacher->user_id = $user->user_id;
                return $this->insert($teacher);
            } else {
                return $this->update($teacher);
            }
        }
        return false;
    }

    private function insert($teacher = Teacher)
    {
        if (
            $this->db->exec("INSERT INTO teacher(user_id) VALUES($teacher->user_id)") == 1
        ) {
            return true;
        }
        return false;
    }

    private function update($teacher = Teacher)
    {
        return true;
    }

    public function findAll($ofset = 0, $limit = 30)
    {

        $res = $this->db->query("SELECT user.user_id,  CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, user.birthday, gender.name AS gender, role.name AS role, branch.id AS branch, branch.branch AS branch_name, subject.name as subject,
        awards.award FROM user 
                    LEFT JOIN awards ON awards.user_id = user.user_id
                    LEFT JOIN subject ON awards.subject_id = subject.subject_id
                    INNER JOIN teacher ON user.user_id=teacher.user_id 
                    INNER JOIN gender ON user.gender_id=gender.gender_id 
                    INNER JOIN role ON user.role_id=role.role_id
                    INNER JOIN branch ON branch.id=user.branch_id
                    WHERE teacher.deleted = 0 AND user.branch_id = {$_SESSION['branch']}
            LIMIT $ofset, $limit");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function count()
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM teacher 
        INNER JOIN user ON user.user_id = teacher.user_id
        WHERE teacher.deleted = 0 AND user.branch_id = {$_SESSION['branch']}");
        return $res->fetch(PDO::FETCH_OBJ)->cnt;
    }

    public function findProfileById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT teacher.user_id, user.user_id, branch.branch FROM teacher 
            INNER JOIN user ON user.user_id=teacher.user_id 
            INNER JOIN branch ON branch.id=user.branch_id
            WHERE teacher.user_id = $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function findHomeworkByGruppaIdAndTeacherId($id)
    {
        $query = "SELECT 
        homework_parent.id as homework_id, 
        homework_parent.name as name, 
        homework_parent.teacher_id as teacher_id,
        CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as student_fio,
        homework_parent.gruppa_id as gruppa_id 
        FROM homework_parent
        INNER JOIN user ON homework_parent.student_id = user.user_id
        WHERE homework_parent.gruppa_id = :id and homework_parent.teacher_id = :teacher_id";
        $res = $this->db->prepare($query);
        $res->execute([
            'id' => $id,
            'teacher_id' => $_SESSION['id']
        ]);
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function findHomeworkById($id)
    {
        $query = "SELECT homework_parent.id as id,homework_parent.name as name, gruppa.name as gruppa, homework_parent.student_id as student_id, 
        CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as student_fio,
        homework_parent.date_begin as date_begin, homework_parent.date_end as date_end,
        homework_parent.subject_id as subject_id,
        subject.name as subject,
        homework_parent.file as file,
        homework_parent.file_prepared as file_prepared
        FROM homework_parent
        INNER JOIN gruppa ON homework_parent.gruppa_id = gruppa.gruppa_id
        INNER JOIN user ON homework_parent.student_id = user.user_id
        INNER JOIN subject ON homework_parent.subject_id = subject.subject_id
        WHERE id = :id";
        $res = $this->db->prepare($query);
        $res->execute(['id' => $id]);
        return $res->fetch(PDO::FETCH_OBJ);
    }

    public function deleteTeacherById($id)
    {
        $query = "UPDATE teacher SET deleted = 1 WHERE user_id = :id";
        $res = $this->db->prepare($query);
        $res->execute([
            'id' => $id
        ]);
    }

    public function arrTeachers()
    {
        $query = "SELECT teacher.user_id as id, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as value 
        FROM `teacher`
        INNER JOIN user ON teacher.user_id = user.user_id WHERE user.branch_id = {$_SESSION['branch']}
        AND user.user_id != {$_SESSION['id']} AND teacher.deleted = 0";
        $res = $this->db->prepare($query);
        $res->execute();
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
}