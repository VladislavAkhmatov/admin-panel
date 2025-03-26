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

    public function arrSubjectFromBranch()
    {
        $res = $this->db->query("SELECT subject.subject_id as id, 
        subject.name as value FROM subject WHERE subject.deleted = 0 and subject.branch = {$_SESSION['branch']}");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, 
            student.user_id, gruppa_id, user.role_id FROM student 
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
        if (
            $this->db->exec("INSERT INTO student(user_id,
        gruppa_id, num_zach) VALUES($student->user_id, $student->gruppa_id, $student->num_zach)") == 1
        ) {
            return true;
        }
        return false;
    }

    private function update($student = Student)
    {
        if ($this->db->exec("UPDATE student SET gruppa_id = $student->gruppa_id WHERE user_id=" . $student->user_id) == 1) {
            return true;
        }
        return false;
    }

    public function savePayment($student = Student)
    {
        if (
            $this->db->exec("INSERT INTO payment(parent_id, child_id, subject_id, count, tab, price, link, date, branch_id) 
            VALUES($student->parent_id, $student->user_id, 
            $student->subject_id, $student->subject_count, '$student->tab', $student->subject_price, '$student->link', NOW(), {$_SESSION['branch']})") == 1
        ) {
            return true;
        }
        return false;
    }

    public function savePaymentArchive($student = Student)
    {

        return $this->insertPaymentArchive($student);

    }

    private function insertPaymentArchive($student = Student)
    {
        if (
            $this->db->exec("INSERT INTO 
            payment_archive (parent_id, child_id, subject_id, count, tab, price, attend, payment_method) 
            VALUES($student->parent_id, $student->user_id, 
            $student->subject_id, $student->count, '$student->tab', $student->price, $student->attend, '$student->payment_method')
            ") == 1
        ) {
            $res = $this->db->query("UPDATE payment SET deleted = 1 WHERE id = $student->id");
            return true;
        }
        return false;
    }

    public function saveUpdatePaymentArchive($student = Student)
    {

        return $this->updatePaymentArchive($student);

    }

    private function updatePaymentArchive($student = Student)
    {
        if ($this->db->exec("UPDATE payment_archive SET count = count + $student->count WHERE child_id=" . $student->user_id . " and subject_id=" . $student->subject_id) == 1) {
            $res = $this->db->query("UPDATE payment SET deleted = 1 WHERE id = $student->id");
            return true;
        }
        return false;
    }

    public function findAll($ofset = 0, $limit = 30)
    {
        $res = $this->db->query("SELECT user.user_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, user.birthday, gender.name AS gender, gruppa.name AS gruppa, 
        role.name AS role, branch.id AS branch, branch.branch AS branch_name FROM user 
        INNER JOIN student ON user.user_id=student.user_id 
        INNER JOIN gender ON user.gender_id=gender.gender_id 
        INNER JOIN gruppa ON student.gruppa_id=gruppa.gruppa_id 
        INNER JOIN role ON user.role_id=role.role_id
        INNER JOIN branch ON user.branch_id = branch.id
        
        WHERE student.deleted = 0 AND user.branch_id = {$_SESSION['branch']}
            LIMIT $ofset, $limit");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function findStudentsFromGroup($id)
    {
        $res = $this->db->query("SELECT user.user_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, user.birthday, gender.name AS gender, gruppa.name AS gruppa, 
            role.name AS role, branch.id as branch FROM user 
            INNER JOIN student ON user.user_id=student.user_id 
            INNER JOIN gender ON user.gender_id=gender.gender_id 
            INNER JOIN gruppa ON student.gruppa_id=gruppa.gruppa_id 
            INNER JOIN role ON user.role_id=role.role_id 
            INNER JOIN branch ON user.branch_id = branch.id 
            WHERE gruppa.gruppa_id = $id AND branch.id = {$_SESSION['branch']} and student.deleted = 0");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function viewgrades()
    {
        $res = $this->db->query("SELECT parent.child_id as child_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, subject.name as subject, grades.grades as grades, 
            grades.date as date, branch.id as branch, user.user_id as user_id FROM parent
            INNER JOIN user ON user.user_id = parent.child_id
            INNER JOIN grades ON grades.user_id = parent.child_id
            INNER JOIN subject ON subject.subject_id = grades.subject_id
            INNER JOIN branch ON branch.id = user.branch_id
            WHERE parent.user_id = {$_SESSION['id']} and grades.grades != 0 and branch.id = {$_SESSION['branch']}");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectgrades()
    {
        $res = $this->db->query("SELECT payment_archive.child_id as child_id, payment_archive.subject_id as subject_id FROM payment_archive");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function findStudentsFromParent($ofset = 0, $limit = 30)
    {
        $res = $this->db->query("SELECT DISTINCT user.user_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio FROM parent
        INNER JOIN user ON user.user_id = parent.child_id
        WHERE parent.user_id = {$_SESSION['id']}
        LIMIT $ofset, $limit");
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
            $res = $this->db->query("SELECT student.user_id, gruppa.name AS gruppa, user.user_id, branch.branch, student.reference FROM student 
            INNER JOIN user ON user.user_id=student.user_id 
            INNER JOIN branch ON branch.id=user.branch_id 
            INNER JOIN gruppa ON student.gruppa_id=gruppa.gruppa_id WHERE student.user_id = $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function findReferenceById($id = null)
    {
        $query = "SELECT id, user_id, reference FROM `reference` WHERE user_id = :id";
        $res = $this->db->prepare($query);
        $res->execute([
            'id' => $id
        ]);
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertReference(Student $student)
    {
        $query = "INSERT INTO `reference` (`user_id`, `reference`) 
        VALUES (:user_id, :reference)";
        $res = $this->db->prepare($query);
        $res->execute([
            'user_id' => $student->user_id,
            'reference' => $student->reference
        ]);
    }

    public function findStudentById($id)
    {
        $res = $this->db->query("SELECT student.user_id, student.gruppa_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio FROM student 
            INNER JOIN user ON user.user_id=student.user_id WHERE student.user_id = $id
            ");
        return $res->fetch(PDO::FETCH_OBJ);
    }

    public function findStudentByControl($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT payment_archive.id as id, payment_archive.child_id as child, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, subject.name as subject, payment_archive.count FROM payment_archive
            INNER JOIN subject ON subject.subject_id = payment_archive.subject_id
            INNER JOIN user ON user.user_id=payment_archive.child_id
            WHERE payment_archive.child_id = $id");
            return $res->fetchAll(PDO::FETCH_OBJ);
        }
        return false;
    }


    public function saveAddgrades($student = Student)
    {

        return $this->addgrades($student);

    }

    public function addgrades($student = null)
    {
        if (!$student || !is_object($student)) {
            echo "Объект не существует или не является объектом.";
            return false;
        }

        $query = "INSERT INTO grades (user_id, subject_id, grade, date, attend, branch_id, comment) VALUES (:user_id, :subject_id, :grade, NOW(), :attend, :branch_id, :comment)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $student->user_id, PDO::PARAM_INT);
        $stmt->bindParam(':subject_id', $student->subject_id, PDO::PARAM_INT);
        $stmt->bindParam(':grade', $student->grade);
        $stmt->bindParam(':attend', $student->attend, PDO::PARAM_INT);
        $stmt->bindParam(':branch_id', $_SESSION['branch']);
        $stmt->bindParam(':comment', $student->comment);
        return $stmt->execute();
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