<?php

class UserMap extends BaseMap
{
    const USER = 'user';
    const TEACHER = 'teacher';
    const STUDENT = 'student';
    const owner = 'owner';
    const PARENT = 'procreator';

    function auth($login, $password)
    {
        $login = $this->db->quote($login);
        $res = $this->db->query("SELECT user.user_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, user.pass, role.sys_name, role.name, branch.id AS branch, branch.branch as branch_name FROM user 
        INNER JOIN role ON user.role_id=role.role_id 
        INNER JOIN branch ON user.branch_id = branch.id 
        WHERE user.login = $login");
        $user = $res->fetch(PDO::FETCH_OBJ);
        if ($user) {
            if (password_verify($password, $user->pass)) {

                return $user;
            }
        }
        return null;
    }

    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT user_id, lastname, firstname, patronymic, login, pass, gender_id, birthday, role_id, branch_id FROM user WHERE user_id = $id");
            $user = $res->fetchObject("User");
            if ($user) {
                return $user;
            }
        }
    }

    public function arrGenders()
    {
        $res = $this->db->query("SELECT gender_id AS id, name AS
        value FROM gender");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function arrBranchs()
    {
        $res = $this->db->query("SELECT id AS id, branch AS value FROM branch 
        WHERE id != 999 and deleted = 0");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function arrBranchWithoutCurrent()
    {
        $res = $this->db->query("SELECT id AS id, branch AS value FROM branch 
        WHERE id != 999 and deleted = 0 and id != {$_SESSION['branch']}");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }


    public function findBranchById($id)
    {
        $query = "SELECT id AS id, branch AS name, date_founding FROM branch 
        WHERE branch.id = :id and id != 999";
        $res = $this->db->prepare($query);
        $res->execute([
            'id' => $id
        ]);
        return $res->fetch(PDO::FETCH_OBJ);
    }

    public function save($user = User)
    {
        if ($user->user_id == 0) {
            return $this->insert($user);
        } else {
            return $this->update($user);
        }
    }

    private function insert($user = User)
    {
        $lastname = $this->db->quote($user->lastname);
        $firstname = $this->db->quote($user->firstname);
        $patronymic = $this->db->quote($user->patronymic);
        $login = $this->db->quote($user->login);
        $pass = $this->db->quote($user->pass);
        $birthday = $this->db->quote($user->birthday);
        if ($_SESSION['branch'] != 999) {
            if (
                $this->db->exec("INSERT INTO user(lastname,
            firstname, patronymic, login, pass, gender_id, birthday,
            role_id, branch_id) VALUES($lastname, $firstname, $patronymic, $login,
            $pass, $user->gender_id, $birthday, $user->role_id, $user->branch_id
            )") == 1
            ) {
                $user->user_id = $this->db->lastInsertId();
                return true;
            }
            return false;
        } else {
            if (
                $this->db->exec("INSERT INTO user(lastname,
            firstname, patronymic, login, pass, gender_id, birthday,
            role_id, branch_id) VALUES($lastname, $firstname, $patronymic, $login,
            $pass, $user->gender_id, $birthday, $user->role_id, $user->branch_id 
            )") == 1
            ) {
                $user->user_id = $this->db->lastInsertId();
                return true;
            }
            return false;
        }
        return false;
    }

    private function update($user = User)
    {
        $lastname = $this->db->quote($user->lastname);
        $firstname = $this->db->quote($user->firstname);
        $patronymic = $this->db->quote($user->patronymic);
        $login = $this->db->quote($user->login);
        $pass = $this->db->quote($user->pass);
        $birthday = $this->db->quote($user->birthday);
        if (
            $this->db->exec("UPDATE user SET lastname =
        $lastname, firstname = $firstname, patronymic =
        $patronymic, login = $login, pass = $pass, gender_id = $user->gender_id, 
                birthday = $birthday, role_id = $user->role_id WHERE user_id = $user->user_id") == 1
        ) {
            return true;
        }
        return false;
    }

    public function findProfileById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT user.user_id,
            CONCAT(user.lastname,' ', user.firstname, ' ',user.patronymic) AS fio, 
            user.login, user.birthday, gender.name AS
            gender, role.name AS role FROM user INNER JOIN gender ON
            user.gender_id=gender.gender_id 
            INNER JOIN role ON
            user.role_id=role.role_id WHERE user.user_id = $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function teacherCount()
    {
        $res = $this->db->query("SELECT COUNT(*) as count FROM teacher
            INNER JOIN user ON teacher.user_id = user.user_id
            WHERE user.branch_id = {$_SESSION['branch']} AND teacher.deleted = 0");
        return $res->fetch(PDO::FETCH_OBJ);
    }

    public function studentCount()
    {
        $res = $this->db->query("SELECT COUNT(*) as count FROM student
            INNER JOIN user ON student.user_id = user.user_id
            WHERE user.branch_id = {$_SESSION['branch']} and student.deleted = 0");
        return $res->fetch(PDO::FETCH_OBJ);
    }

    public function parentCount()
    {
        $res = $this->db->query("SELECT COUNT(DISTINCT parent.user_id) as count 
            FROM parent
            INNER JOIN user ON parent.user_id = user.user_id
            WHERE user.branch_id = {$_SESSION['branch']} AND parent.deleted = 0");
        return $res->fetch(PDO::FETCH_OBJ);
    }

}