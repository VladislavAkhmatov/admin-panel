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

    public function arrAttends()
    {
        $res = $this->db->query("SELECT attend.id as id, attend.attend as value FROM attend");
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
    public function save($user = User, $student = Student)
    {
        if ($user->validate() && $student->validate() && (new UserMap())->save($user)) {
            if ($student->user_id == 0) {
                $student->user_id = $user->user_id;
                return $this->insert($student);
            } else {
                return $this->update($student);
            }
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

    private function insertPayment($student = Student)
    {

    }

    public function deleteNoticeById($id)
    {
        $query = "UPDATE notice SET deleted = 1 WHERE id = :id";
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

    public function savePaymentArchive($student = Student)
    {

        return $this->insertPaymentArchive($student);

    }

    public function deletePayment($student = Student)
    {
        $query = "UPDATE payment SET deleted = 1 WHERE id = :id";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'id' => $student->id
            ])
        ) {
            $query = "INSERT INTO notice(text, subject_id, user_id, child_id, subject_count, subject_price, canceled)
            VALUES(:text, :subject_id, :user_id, :child_id, :subject_count, :subject_price, :canceled)";
            $res = $this->db->prepare($query);
            if (
                $res->execute([
                    'text' => $student->text,
                    'subject_id' => $student->subject_id,
                    'user_id' => $student->parent_id,
                    'child_id' => $student->child_id,
                    'subject_count' => $student->subject_count,
                    'subject_price' => $student->subject_price,
                    'canceled' => 1
                ])
            ) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function saveUpdatePaymentArchive($student = Student)
    {

        return $this->updatePaymentArchive($student);

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

    public function checkPaymentArchive()
    {
        $res = $this->db->query("SELECT payment_archive.child_id as child_id, payment_archive.subject_id as subject_id FROM payment_archive");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    private function updatePaymentArchive($student = Student)
    {
        if ($this->db->exec("UPDATE payment_archive SET count = count + $student->count WHERE child_id=" . $student->user_id . " and subject_id=" . $student->subject_id) == 1) {
            $res = $this->db->query("UPDATE payment SET deleted = 1 WHERE id = $student->id");
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

    public function findStudentsFromgrades($id = null, $ofset = 0, $limit = 30)
    {
        if ($id) {
            $res = $this->db->query("SELECT user.user_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio,  
            branch.id as branch FROM user 
            INNER JOIN student ON user.user_id=student.user_id 
            INNER JOIN branch ON user.branch_id = branch.id 
            WHERE branch.id = {$_SESSION['branch']} LIMIT $ofset, $limit");
            return $res->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function checkgrades()
    {
        $res = $this->db->query("SELECT grades.grade_id as id, user.user_id AS user_id, 
        CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, subject.subject_id AS subject_id, 
        subject.name AS subject, grades.grade AS grade, grades.date AS date, attend.attend as attend, 
        attend.id as attend_id, grades.comment,grades.homework, branch.id AS branch FROM user
        INNER JOIN grades ON user.user_id = grades.user_id
        INNER JOIN subject on subject.subject_id=grades.subject_id
        LEFT JOIN attend on attend.id = grades.attend
        INNER JOIN branch on branch.id = user.branch_id
        WHERE grades.branch_id = {$_SESSION['branch']}");
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

    public function viewPerformance()
    {
        $res = $this->db->query("SELECT parent.child_id as child_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, subject.name as subject, grades.date as date, attend.attend as attend, branch.id as branch, user.user_id as user_id
            FROM parent
            INNER JOIN user ON user.user_id = parent.child_id
            INNER JOIN grades ON grades.user_id = parent.child_id
            INNER JOIN subject ON subject.subject_id = grades.subject_id
            INNER JOIN attend ON attend.id = grades.attend
            INNER JOIN branch ON branch.id = user.branch_id
            WHERE parent.user_id = {$_SESSION['id']} and (grades.grades = 0 or grades.grades is null) and branch.id = {$_SESSION['branch']}");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function savegrades($student = Student)
    {

        return $this->insertgrades($student);

    }

    public function saveUpdategrades($student = Student)
    {

        return $this->updategrades($student);

    }

    public function insertgrades($student = Student)
    {
        if (
            $this->db->exec("INSERT INTO grades (user_id, subject_id, grades, date, attend) VALUES ($student->user_id, $student->subject_id, '$student->grades', '$student->date', $student->attend)
            ") == 1
        ) {
            return true;
        }
        return false;
    }

    public function updategrades($student = Student)
    {
        $count = $this->db->query("SELECT count FROM payment_archive WHERE child_id = $student->user_id AND subject_id = $student->subject_id")->fetchColumn();

        if ($count > 0) {
            if (
                $this->db->exec("UPDATE payment_archive SET count = count - 1
            WHERE child_id=" . $student->user_id . " and subject_id=" . $student->subject_id) == 1
            ) {
                $this->db->exec("INSERT INTO grades (user_id, subject_id, grade, date, attend, comment, homework, branch_id) 
            VALUES ($student->user_id, $student->subject_id, '$student->grade', '$student->date', $student->attend, 
            '$student->comment', '$student->file', {$_SESSION['branch']})");
                $this->db->exec("DELETE FROM grades WHERE grade_id = '$student->grade_id'");
                return true;
            }
        }
        return false;
    }

    public function deletegrades($student = Student)
    {
        $res = $this->db->query("DELETE FROM grades WHERE grade_id = $student->grade_id");
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

    public function Payment()
    {
        $res = $this->db->query("SELECT 
        payment.id as id, 
        payment.parent_id, 
        payment.child_id as user_id, 
        CONCAT(parent.lastname,' ', parent.firstname, ' ', parent.patronymic) AS parent_fio, 
        CONCAT(child.lastname,' ', child.firstname, ' ', child.patronymic) AS child_fio, 
        subject.subject_id as subject_id,
        subject.name as subject, 
        payment.count as count, 
        payment.tab as tab, 
        payment.price as price,
        payment.deleted
        FROM payment
        INNER JOIN user AS parent ON parent.user_id = payment.parent_id
        INNER JOIN user AS child ON child.user_id = payment.child_id
        INNER JOIN subject ON payment.subject_id = subject.subject_id 
        WHERE payment.deleted = 0");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }
    public function findStudentById()
    {
        $res = $this->db->query("SELECT student.user_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio FROM student 
            INNER JOIN user ON user.user_id=student.user_id
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
    public function findParentByStudentId($id)
    {
        $query = "SELECT DISTINCT parent.user_id FROM parent
        WHERE child_id = :id";
        $res = $this->db->prepare($query);
        $res->execute([
            'id' => $id
        ]);
        return $res->fetchColumn();
    }

    public function saveSubjectForStudent(Student $student)
    {
        $query = "INSERT INTO student_subjects(user_id, subject_id) VALUES(:user_id, :subject_id)";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'user_id' => $student->user_id,
                'subject_id' => $student->subject_id,
            ])
        ) {
            return true;
        }
        return false;
    }

    public function findStudentSubjectsByUserId($id)
    {
        $query = "SELECT user.user_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio,  subject.name FROM user 
        INNER JOIN student ON user.user_id=student.user_id 
        LEFT JOIN student_subjects ON user.user_id=student_subjects.user_id 
        LEFT JOIN subject ON subject.subject_id=student_subjects.subject_id
        WHERE student.deleted = 0 AND user.branch_id = :branch AND user.user_id = :id";
        $res = $this->db->prepare($query);
        $res->execute([
            'branch' => $_SESSION['branch'],
            'id' => $id,
        ]);
        return $res->fetchAll(PDO::FETCH_OBJ);
    }


}