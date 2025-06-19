<?php

class StudentMap extends BaseMap
{
    public function arrStudents()
    {
        $res = $this->db->query("SELECT student.user_id AS id, 
        CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) AS value, branch.id AS branch FROM student
        INNER JOIN user ON user.user_id = student.user_id
        INNER JOIN branch ON branch.id = user.branch_id
        WHERE user.role_id = 5 and student.deleted = 0 and user.branch_id = {$_SESSION['branch']}");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, 
            student.user_id, gruppa_id, user.role_id, student.entry_date, student.end_date FROM student 
            INNER JOIN user ON student.user_id = user.user_id
            WHERE student.user_id = $id");
            $student = $res->fetchObject("Student");
            if ($student) {
                return $student;
            }
        }
        return new Student();
    }

    public function findByGruppaID($id = null)
    {
        $sql = "SELECT CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as user, 
            student.user_id, gruppa.gruppa_id as gruppa_id, gruppa.name as gruppa_name 
            FROM student 
            INNER JOIN user ON student.user_id = user.user_id
            INNER JOIN gruppa ON student.gruppa_id = gruppa.gruppa_id
            WHERE gruppa.gruppa_id = :group_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":group_id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function save($user = User, $student = Student)
    {
        if ((new UserMap())->save($user)) {
            if ($student->user_id == 0) {
                $student->user_id = $user->user_id;
                return $this->insert($student);
            } else {
                return $this->update($student);
            }
        }
        return false;
    }

    private function insert($student = Student)
    {
        $entry_date = $this->db->quote($student->entry_date);
        $end_date = $this->db->quote($student->end_date);
        if (
            $this->db->exec("INSERT INTO student(user_id,
        gruppa_id, entry_date, end_date)
        VALUES($student->user_id, $student->gruppa_id, $entry_date, $end_date)") == 1
        ) {
            return true;
        }
        return false;
    }

    private function update($student = Student)
    {
        $entry_date = $this->db->quote($student->entry_date);
        $end_date = $this->db->quote($student->end_date);
        if ($this->db->exec("UPDATE student SET gruppa_id = $student->gruppa_id,
                   entry_date = $entry_date,
                   end_date = $end_date
               WHERE user_id=" . $student->user_id) == 1) {
            return true;
        }
        return false;
    }

    public function findAll($ofset = 0, $limit = 30)
    {
        $res = $this->db->query("SELECT user.user_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, user.birthday, gender.name AS gender, gruppa.name AS gruppa, 
        role.name AS role, branch.id AS branch, branch.branch AS branch_name, student.entry_date, student.end_date FROM user 
        INNER JOIN student ON user.user_id=student.user_id 
        INNER JOIN gender ON user.gender_id=gender.gender_id 
        INNER JOIN gruppa ON student.gruppa_id=gruppa.gruppa_id 
        INNER JOIN role ON user.role_id=role.role_id
        INNER JOIN branch ON user.branch_id = branch.id
        
        WHERE student.deleted = 0 AND user.branch_id = {$_SESSION['branch']}
            LIMIT $ofset, $limit");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }


    public function findStudentsFromParent()
    {
        $res = $this->db->query("SELECT DISTINCT user.user_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio FROM parent
        INNER JOIN user ON user.user_id = parent.child_id
        WHERE parent.user_id = {$_SESSION['id']}
        ");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }


    public function count()
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM student
            INNER JOIN user ON user.user_id = student.user_id
            WHERE user.branch_id = {$_SESSION['branch']} AND student.deleted = 0");
        return $res->fetch(PDO::FETCH_OBJ)->cnt;
    }

    public function findProfileById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT student.user_id, gruppa.name AS gruppa, user.user_id, branch.branch, student.entry_date, student.end_date FROM student 
            INNER JOIN user ON user.user_id=student.user_id 
            INNER JOIN branch ON branch.id=user.branch_id 
            INNER JOIN gruppa ON student.gruppa_id=gruppa.gruppa_id WHERE student.user_id = $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function findStudentById($id)
    {
        $res = $this->db->query("SELECT student.user_id, student.gruppa_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio FROM student 
            INNER JOIN user ON user.user_id=student.user_id WHERE student.user_id = $id
            ");
        return $res->fetch(PDO::FETCH_OBJ);
    }


    public function deleteStudentById($id)
    {
        $query = "UPDATE student SET deleted = 1 WHERE user_id = :id";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'id' => $id
            ])
        ) {
            return true;
        }
        return false;
    }
}