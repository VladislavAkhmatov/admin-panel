<?php
class ProcreatorMap extends BaseMap
{

    public function arrParents()
    {
        $res = $this->db->query("SELECT DISTINCT parent.user_id AS id, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) AS value, branch.id AS branch FROM parent
		INNER JOIN user ON parent.user_id = user.user_id
        INNER JOIN branch ON branch.id = user.branch_id
        WHERE user.role_id = 6 and user.branch_id = {$_SESSION['branch']} and parent.deleted = 0");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }



    public function arrChilds()
    {

        $res = $this->db->query("SELECT DISTINCT parent.child_id as id, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) 
        as value FROM parent
        INNER JOIN user ON parent.child_id = user.user_id
        WHERE parent.deleted = 0
        ");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function arrChildsByParentId($id)
    {
        $query = "SELECT DISTINCT parent.child_id as id, 
        CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) 
        as value FROM parent
        INNER JOIN user ON parent.child_id = user.user_id
        WHERE parent.user_id = :id and parent.deleted = 0";
        $res = $this->db->prepare($query);
        $res->execute([
            'id' => $id
        ]);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function arrChildsByParent()
    {

        $query = "SELECT DISTINCT parent.child_id as id, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) 
        as value FROM parent
        INNER JOIN user ON parent.child_id = user.user_id
        WHERE parent.user_id = :id and parent.deleted = 0";
        $res = $this->db->prepare($query);
        $res->execute([
            'id' => $_SESSION['id']
        ]);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, parent.user_id, child_id FROM parent
            INNER JOIN user ON parent.user_id = user.user_id
            WHERE parent.user_id = $id");
            return $res->fetchObject("Procreator");
        }
        return new Procreator();
    }

    public function save($user = User, $parent = Parent)
    {
        if ($user->validate() && $parent->validate() && (new UserMap())->save($user)) {
            if ($parent->user_id == 0) {
                $parent->user_id = $user->user_id;
                return $this->insert($parent);
            }
        }
        return false;
    }


    private function insert($parent = Parent)
    {
        if (
            $this->db->exec("INSERT INTO parent(user_id) VALUES($parent->user_id)") == 1
        ) {
            return true;
        }
        return false;
    }

    public function saveChild($parent = Parent)
    {
        return $this->insertChild($parent);
    }

    private function insertChild($parent = Parent)
    {
        if (
            $this->db->exec("INSERT INTO parent(user_id, child_id) VALUES($parent->user_id, $parent->child_id)") == 1
        ) {
            return true;
        }
        return false;
    }

    public function findAll($ofset = 0, $limit = 30)
    {
        $res = $this->db->query("SELECT DISTINCT
        user.user_id,
        CONCAT(procreator.lastname,' ', procreator.firstname, ' ', procreator.patronymic) AS parent_fio, 
        gender.name as gender, 
        user.birthday as birthday,
        branch.branch as branch
        FROM parent
        INNER JOIN user as procreator on procreator.user_id = parent.user_id
        INNER JOIN user on user.user_id = parent.user_id
        INNER JOIN branch on user.branch_id = branch.id
        INNER JOIN gender ON user.gender_id = gender.gender_id
        WHERE user.branch_id = {$_SESSION['branch']} and parent.deleted = 0
            LIMIT $ofset, $limit");

        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function findStudentFromParentId($id)
    {
        $res = $this->db->query("SELECT DISTINCT
        user.user_id,
        CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS child
        FROM parent
        INNER JOIN user ON user.user_id = parent.child_id
        WHERE user.branch_id = {$_SESSION['branch']} and parent.deleted = 0 AND parent.user_id = $id");

        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function count()
    {

        $res = $this->db->query("SELECT COUNT(DISTINCT parent.user_id) AS cnt FROM parent 
        INNER JOIN user ON user.user_id  = parent.user_id
        WHERE parent.deleted = 0 
        AND user.branch_id = {$_SESSION['branch']}");
        return $res->fetch(PDO::FETCH_OBJ)->cnt;
    }
    public function notice()
    {
        $res = $this->db->query("SELECT notice.id as id, notice.text as text, 
        CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as 
        child, subject.name as subject, notice.date as date, notice.link, notice.canceled FROM notice
        INNER JOIN user ON user.user_id = notice.child_id
        INNER JOIN subject ON subject.subject_id = notice.subject_id
        WHERE notice.user_id = {$_SESSION['id']} and notice.deleted = 0
        ORDER BY notice.id DESC");

        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function noticeById($id)
    {
        $query = "SELECT notice.id as id, notice.text as text, 
            CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as 
            child, subject.name as subject, notice.date as date FROM notice
            INNER JOIN user ON user.user_id = notice.child_id
            INNER JOIN subject ON subject.subject_id = notice.subject_id
            WHERE notice.id = :id";
        $res = $this->db->prepare($query);
        $res->execute(['id' => $id]);
        return $res->fetch(PDO::FETCH_OBJ);
    }


    public function noticeCount()
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM notice
        INNER JOIN user ON notice.user_id = user.user_id
        WHERE notice.user_id = {$_SESSION['id']} and notice.deleted = 0");
        if ($res === false)
            return 0;
        return $res->fetch(PDO::FETCH_OBJ)->cnt;
    }

    public function findHomeworkByGruppaId($id)
    {
        $query = "SELECT homework_teacher.id as homework_id, homework_teacher.name as name, 
        homework_teacher.gruppa_id as gruppa_id FROM homework_teacher
        WHERE homework_teacher.gruppa_id = :id";
        $res = $this->db->prepare($query);
        $res->execute(['id' => $id]);
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function findHomeworkById($id)
    {
        $query = "SELECT homework_teacher.id as id, homework_teacher.name as name, homework_teacher.user_id as user_id,
        CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, homework_teacher.gruppa_id as gruppa_id,
        gruppa.name as gruppa, homework_teacher.date_begin, homework_teacher.date_end, homework_teacher.subject_id as subject_id, 
        subject.name as subject, homework_teacher.file
        FROM `homework_teacher` 
        INNER JOIN user ON homework_teacher.user_id = user.user_id
        INNER JOIN gruppa ON homework_teacher.gruppa_id = gruppa.gruppa_id
        INNER JOIN subject ON subject.subject_id = homework_teacher.subject_id
        WHERE id = :id";
        $res = $this->db->prepare($query);
        $res->execute(['id' => $id]);
        return $res->fetch(PDO::FETCH_OBJ);
    }

    public function findGruppaIdFromStudent($id)
    {
        $query = "SELECT student.user_id as user_id, student.gruppa_id as gruppa FROM student
        WHERE student.user_id = :id";
        $res = $this->db->prepare($query);
        $res->execute(['id' => $id]);
        return $res->fetch(PDO::FETCH_OBJ);
    }

    public function findStudentFromGruppa()
    {
        $query = "SELECT homework_teacher.name as name, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, 
        homework_teacher.gruppa_id as gruppa_id, gruppa.name as gruppa_name, 
        homework_teacher.date_begin as date_begin, homework_teacher.date_end as date_end, subject.name as subject_name,
        homework_teacher.file as file
        FROM homework_teacher
        INNER JOIN user ON homework_teacher.user_id = user.user_id
        INNER JOIN gruppa ON homework_teacher.gruppa_id = gruppa.gruppa_id
        INNER join subject ON homework_teacher.subject_id = subject.subject_id";
        $res = $this->db->prepare($query);
        $res->execute();
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertHomeworkFromParent(Procreator $procreator)
    {
        $query = "INSERT INTO `homework_parent` (`homework_teacher_id`, `name`, `teacher_id`, `gruppa_id`, 
        `student_id`, `date_begin`, `date_end`, `subject_id`, `file`, `file_prepared`) 
        VALUES (:homework_teacher_id, :name, :teacher_id, :gruppa_id, 
        :student_id, :date_begin, :date_end, :subject_id, :file, :file_prepared)";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'homework_teacher_id' => $procreator->homework_teacher_id,
                'name' => $procreator->name,
                'teacher_id' => $procreator->teacher_id,
                'gruppa_id' => $procreator->gruppa_id,
                'student_id' => $procreator->child_id,
                'date_begin' => $procreator->date_begin,
                'date_end' => $procreator->date_end,
                'subject_id' => $procreator->subject_id,
                'file' => $procreator->file,
                'file_prepared' => $procreator->file_prepared
            ])
        ) {
            return true;
        }
        return false;
    }

    public function deleteParentById($id)
    {
        $query = "UPDATE parent SET deleted = 1 WHERE user_id = :id";
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


    public function findPerformanceBygradesInfo($user_id, $subject_id, $branch_id)
    {
        $query = "SELECT grades.user_id as user_id, subject.name as subject, grades.subject_id, 
        grades.grade as grades, grades.date as date, grades.attend, grades.branch_id, 
        grades.comment, grades.homework FROM grades
        INNER JOIN subject ON subject.subject_id = grades.subject_id
        WHERE grades.user_id = :user_id and grades.subject_id = :subject_id and grades.branch_id = :branch_id";
        $res = $this->db->prepare($query);
        $res->execute([
            'user_id' => $user_id,
            'subject_id' => $subject_id,
            'branch_id' => $branch_id
        ]);
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function findNoticeById($id)
    {
        $query = "SELECT notice.id, notice.text, notice.child_id, 
        notice.subject_id as subject_id, subject.name as subject, 
        CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, notice.subject_count,
        notice.subject_price, notice.date, notice.link
        FROM notice
        INNER JOIN user ON notice.child_id = user.user_id
        LEFT JOIN subject ON notice.subject_id = subject.subject_id
        WHERE id = :id";
        $res = $this->db->prepare($query);
        $res->execute([
            'id' => $id
        ]);
        return $res->fetch(PDO::FETCH_OBJ);
    }

    public function listParentAndChild()
    {
        $query = "SELECT user.user_id, parent.child_id, branch.id as branch_id FROM parent
        INNER JOIN user ON user.user_id = parent.user_id
        INNER JOIN branch ON user.branch_id = branch.id
        WHERE parent.deleted = 0 AND parent.child_id IS NOT NULL";
        $res = $this->db->prepare($query);
        $res->execute();
        return $res->fetchAll(PDO::FETCH_OBJ);
    }
}