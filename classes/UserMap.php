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
        $owner = new owner();
        $lastname = $this->db->quote($user->lastname);
        $firstname = $this->db->quote($user->firstname);
        $patronymic = $this->db->quote($user->patronymic);
        $login = $this->db->quote($user->login);
        $pass = $this->db->quote($user->pass);
        $birthday = $this->db->quote($user->birthday);
        if ($this->existsLogin($login)) {
            if ($_SESSION['branch'] != 999) {
                if (
                    $this->db->exec("INSERT INTO user(lastname,
            firstname, patronymic, login, pass, gender_id, birthday,
            role_id, branch_id) VALUES($lastname, $firstname, $patronymic, $login,
            $pass, $user->gender_id, $birthday, $user->role_id, $user->branch_id, 
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
        }
        return false;
    }

    public function arrParents()
    {
        $res = $this->db->query("SELECT DISTINCT parent.user_id AS id, CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) 
        AS value, branch.id AS branch FROM parent
        INNER JOIN user ON parent.user_id = user.user_id
        INNER JOIN branch ON branch.id = user.branch_id
        WHERE user.role_id = 6 and parent.deleted = 0");
        return $res->fetchAll(PDO::FETCH_ASSOC);
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

    private function existsLogin($login)
    {
        $login = $this->db->quote($login);
        $res = $this->db->query("SELECT user_id FROM user WHERE login = $login");
        if ($res->fetchColumn() > 0) {
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

    public function findProfileByOtdel($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT user.user_id,
            CONCAT(user.lastname,' ', user.firstname, ' ',
            user.patronymic) AS fio,"
                . " user.login, user.birthday, gender.name AS
            gender, role.name AS role FROM user "
                . "INNER JOIN gender ON
            user.gender_id=gender.gender_id INNER JOIN role ON
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

    public function identity($id)
    {
        if ((new TeacherMap())->findById($id)->validate()) {
            return self::TEACHER;
        }
        if ((new ownerMap())->findById($id)->validate()) {
            return self::owner;
        }
        if ((new StudentMap())->findById($id)->validate()) {
            return self::STUDENT;
        }
        if ((new ProcreatorMap())->findById($id)->validate()) {
            return self::PARENT;
        }
        if ($this->findById($id)->validate()) {
            return self::USER;
        }
        return null;
    }


    public function autoNotifications()
    {
        $listParentAndChild = (new ProcreatorMap())->listParentAndChild();

        $current_date = date("Y-m-d");

        $next_month = date('Y-m-d', strtotime('+1 month', strtotime($current_date)));

        $next_month_first_day = date('Y-m-01', strtotime($next_month));

        $current_date = date("Y-m-d");

        if (date('d', strtotime($current_date)) == 27) {
            foreach ($listParentAndChild as $item) {
                $query = "SELECT * FROM notice WHERE subject_id = :subject_id AND user_id = :user_id AND child_id = :child_id 
                    AND date = :date";
                $res = $this->db->prepare($query);
                $res->execute([
                    'subject_id' => $item->subject_id,
                    'user_id' => $item->user_id,
                    'child_id' => $item->child_id,
                    'date' => $next_month_first_day
                ]);
                if ($res->fetch()) {
                    continue;
                }

                if ($item->branch_id == 1) {
                    $query = "INSERT INTO notice(text, subject_id, user_id, child_id, subject_count, subject_price, link, date) 
                            VALUES(:text, :subject_id, :user_id, :child_id, :subject_count, :subject_price, :link, :date)";
                    $res = $this->db->prepare($query);

                    $subject_count = 0;
                    $subject_price = 0;
                    switch (trim($item->name)) {
                        case 'МАД':
                            $subject_count = 20;
                            $subject_price = 30000;
                            break;
                        case 'Математика':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Ағылшын':
                            $subject_count = 12;
                            $subject_price = 15000;
                            break;
                        case 'Изо':
                            $subject_count = 8;
                            $subject_price = 12000;
                            break;
                        case 'Хореография':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Домбыра':
                            $subject_count = 8;
                            $subject_price = 12000;
                            break;
                        case 'Фортепиано':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Вокал':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Шахмат':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;

                        default:
                            // Handle default case, if needed
                            break;
                    }

                    $res->execute([
                        'text' => 'Оплатите сумму указанную в приложении',
                        'subject_id' => $item->subject_id,
                        'user_id' => $item->user_id,
                        'child_id' => $item->child_id,
                        'subject_count' => $subject_count,
                        'subject_price' => $subject_price,
                        'link' => 'https://example.com',
                        'date' => $next_month_first_day
                    ]);
                } else if ($item->branch_id == 2) {
                    $query = "INSERT INTO notice(text, subject_id, user_id, child_id, subject_count, subject_price, link, date) 
                            VALUES(:text, :subject_id, :user_id, :child_id, :subject_count, :subject_price, :link, :date)";
                    $res = $this->db->prepare($query);

                    $subject_count = 0;
                    $subject_price = 0;

                    switch (trim($item->name)) {
                        case 'МАД':
                            $subject_count = 20;
                            $subject_price = 30000;
                            break;
                        case 'Математика':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Ағылшын':
                            $subject_count = 12;
                            $subject_price = 15000;
                            break;
                        case 'Изо':
                            $subject_count = 8;
                            $subject_price = 12000;
                            break;
                        case 'Хореография':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Домбыра':
                            $subject_count = 8;
                            $subject_price = 12000;
                            break;
                        case 'Фортепиано':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Вокал':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Шахмат':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Тхэквандо':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Дзюдо':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Еркін күрес':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        default:
                            break;
                    }
                    $res->execute([
                        'text' => 'Оплатите сумму указанную в приложении',
                        'subject_id' => $item->subject_id,
                        'user_id' => $item->user_id,
                        'child_id' => $item->child_id,
                        'subject_count' => $subject_count,
                        'subject_price' => $subject_price,
                        'link' => 'https://example.com',
                        'date' => $next_month_first_day
                    ]);
                } else if ($item->branch_id == 3) {
                    $query = "INSERT INTO notice(text, subject_id, user_id, child_id, subject_count, subject_price, link, date) 
                            VALUES(:text, :subject_id, :user_id, :child_id, :subject_count, :subject_price, :link, :date)";
                    $res = $this->db->prepare($query);

                    $subject_count = 0;
                    $subject_price = 0;

                    switch (trim($item->name)) {
                        case 'Хореография':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Домбыра':
                            $subject_count = 8;
                            $subject_price = 12000;
                            break;
                        case 'Вокал':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Фортепиано':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Изо':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Шахмат':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Тхэквондо':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Дзюдо':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Ағылшын':
                            $subject_count = 12;
                            $subject_price = 15000;
                            break;
                        default:
                            break;
                    }

                    $res->execute([
                        'text' => 'Оплатите сумму указанную в приложении',
                        'subject_id' => $item->subject_id,
                        'user_id' => $item->user_id,
                        'child_id' => $item->child_id,
                        'subject_count' => $subject_count,
                        'subject_price' => $subject_price,
                        'link' => 'https://example.com',
                        'date' => $next_month_first_day
                    ]);
                } else if ($item->branch_id == 4) {
                    $query = "INSERT INTO notice(text, subject_id, user_id, child_id, subject_count, subject_price, link, date) 
                            VALUES(:text, :subject_id, :user_id, :child_id, :subject_count, :subject_price, :link, :date)";
                    $res = $this->db->prepare($query);

                    $subject_count = 0;
                    $subject_price = 0;

                    switch (trim($item->name)) {
                        case 'МАД':
                            $subject_count = 20;
                            $subject_price = 30000;
                            break;
                        case 'Ағылшын':
                            $subject_count = 12;
                            $subject_price = 15000;
                            break;
                        case 'Домбыра':
                            $subject_count = 8;
                            $subject_price = 12000;
                            break;
                        case 'Хореография':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Шахмат':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Изо':
                            $subject_count = 8;
                            $subject_price = 12000;
                            break;
                        case 'Вокал':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Фортепиано':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        default:
                            break;
                    }

                    $res->execute([
                        'text' => 'Оплатите сумму указанную в приложении',
                        'subject_id' => $item->subject_id,
                        'user_id' => $item->user_id,
                        'child_id' => $item->child_id,
                        'subject_count' => $subject_count,
                        'subject_price' => $subject_price,
                        'link' => 'https://example.com',
                        'date' => $next_month_first_day
                    ]);
                } else if ($item->branch_id == 5) {
                    $query = "INSERT INTO notice(text, subject_id, user_id, child_id, subject_count, subject_price, link, date) 
                            VALUES(:text, :subject_id, :user_id, :child_id, :subject_count, :subject_price, :link, :date)";
                    $res = $this->db->prepare($query);

                    $subject_count = 0;
                    $subject_price = 0;

                    switch (trim($item->name)) {
                        case 'Хореография':
                            $subject_count = 12;
                            $subject_price = 15000;
                            break;
                        case 'Домбыра':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Вокал':
                            $subject_count = 8;
                            $subject_price = 20000;
                            break;
                        case 'Фортепиано':
                            $subject_count = 8;
                            $subject_price = 20000;
                            break;
                        case 'ИЗО':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Шахмат':
                            $subject_count = 12;
                            $subject_price = 15000;
                            break;
                        case 'Тхэквондо':
                            $subject_count = 12;
                            $subject_price = 15000;
                            break;
                        case 'Дзюдо':
                            $subject_count = 12;
                            $subject_price = 15000;
                            break;
                        case 'Бокс':
                            $subject_count = 12;
                            $subject_price = 15000;
                            break;
                        default:
                            break;
                    }

                    $res->execute([
                        'text' => 'Оплатите сумму указанную в приложении',
                        'subject_id' => $item->subject_id,
                        'user_id' => $item->user_id,
                        'child_id' => $item->child_id,
                        'subject_count' => $subject_count,
                        'subject_price' => $subject_price,
                        'link' => 'https://example.com',
                        'date' => $next_month_first_day
                    ]);
                } else if ($item->branch_id == 6) {
                    $query = "INSERT INTO notice(text, subject_id, user_id, child_id, subject_count, subject_price, link, date) 
                            VALUES(:text, :subject_id, :user_id, :child_id, :subject_count, :subject_price, :link, :date)";
                    $res = $this->db->prepare($query);

                    $subject_count = 0;
                    $subject_price = 0;

                    switch (trim($item->name)) {
                        case 'МАД':
                            $subject_count = 20;
                            $subject_price = 30000;
                            break;
                        case 'Продленка':
                            $subject_count = 20;
                            $subject_price = 35000;
                            break;
                        case 'Математика':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Ағылшын':
                            $subject_count = 12;
                            $subject_price = 15000;
                            break;
                        case 'Изо':
                            $subject_count = 8;
                            $subject_price = 12000;
                            break;
                        case 'Хореография':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Домбыра':
                            $subject_count = 8;
                            $subject_price = 12000;
                            break;
                        case 'Фортепиано':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Вокал':
                            $subject_count = 8;
                            $subject_price = 15000;
                            break;
                        case 'Шахмат':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Тхэквандо':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Дзюдо':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        case 'Еркін күрес':
                            $subject_count = 12;
                            $subject_price = 12000;
                            break;
                        default:
                            break;
                    }

                    $res->execute([
                        'text' => 'Оплатите сумму указанную в приложении',
                        'subject_id' => $item->subject_id,
                        'user_id' => $item->user_id,
                        'child_id' => $item->child_id,
                        'subject_count' => $subject_count,
                        'subject_price' => $subject_price,
                        'link' => 'https://example.com',
                        'date' => $next_month_first_day
                    ]);
                }
            }
        }
    }
}