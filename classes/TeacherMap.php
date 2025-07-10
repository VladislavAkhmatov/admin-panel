<?php

class TeacherMap extends BaseMap
{
    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, 
            teacher.user_id, teacher.salary
            FROM teacher
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
            $this->db->exec("INSERT INTO teacher(user_id, salary) VALUES($teacher->user_id, $teacher->salary)") == 1
        ) {
            return true;
        }
        return false;
    }

    private function update($teacher = Teacher)
    {
        if (
            $this->db->exec("UPDATE teacher SET salary = $teacher->salary WHERE user_id = $teacher->user_id") == 1
        ) {
            return true;
        }
        return false;
    }

    public function findAll($ofset = 0, $limit = 30)
    {

        $res = $this->db->query("SELECT user.user_id,  CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, user.birthday, gender.name AS gender, role.name AS role, branch.id AS branch, branch.branch AS branch_name, teacher.salary
         FROM user 
                    INNER JOIN teacher ON user.user_id=teacher.user_id 
                    INNER JOIN gender ON user.gender_id=gender.gender_id 
                    INNER JOIN role ON user.role_id=role.role_id
                    INNER JOIN branch ON branch.id=user.branch_id
                    WHERE teacher.deleted = 0 AND user.branch_id = {$_SESSION['branch']}
            LIMIT $ofset, $limit");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllArchive($ofset = 0, $limit = 30)
    {

        $res = $this->db->query("SELECT user.user_id,  CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, user.birthday, gender.name AS gender, role.name AS role, branch.id AS branch, branch.branch AS branch_name
         FROM user 
                    INNER JOIN teacher ON user.user_id=teacher.user_id 
                    INNER JOIN gender ON user.gender_id=gender.gender_id 
                    INNER JOIN role ON user.role_id=role.role_id
                    INNER JOIN branch ON branch.id=user.branch_id
                    WHERE teacher.deleted = 1 AND user.branch_id = {$_SESSION['branch']} AND teacher.archive_deleted = 'null'
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
            $res = $this->db->query("SELECT teacher.user_id, user.user_id, branch.branch, teacher.salary FROM teacher 
            INNER JOIN user ON user.user_id=teacher.user_id 
            INNER JOIN branch ON branch.id=user.branch_id
            WHERE teacher.user_id = $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function deleteTeacherById($id)
    {
        $query = "UPDATE teacher SET deleted = 1 WHERE user_id = :id";
        $res = $this->db->prepare($query);
        $res->execute([
            'id' => $id
        ]);
    }

    public function deleteArchiveTeacherById($id)
    {
        $query = "UPDATE `teacher` SET `archive_deleted`=1 WHERE user_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
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