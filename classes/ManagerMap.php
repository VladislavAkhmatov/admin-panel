<?php

class ManagerMap extends BaseMap
{
    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, manager.user_id, manager.branch_id FROM manager
            INNER JOIN user ON user.user_id = manager.user_id WHERE manager.user_id = $id");
            $manager = $res->fetch(PDO::FETCH_OBJ);
            if ($manager) {
                return $manager;
            }
        }

    }

    public function save($user = User, $manager = manager)
    {
        if ($user->validate() && (new UserMap())->save($user)) {
            if ($manager->user_id == 0) {
                $manager->user_id = $user->user_id;
                return $this->insert($manager);
            } else {
                return $this->update($manager);
            }
        }
        return false;
    }

    private function insert($manager = Manager)
    {
        if (
            $this->db->exec("INSERT INTO manager(user_id, branch_id) 
            VALUES($manager->user_id, $manager->branch_id)") == 1
        ) {
            return true;
        }
        return false;
    }
    public function insertNotice($manager = Manager)
    {

        $query = "INSERT INTO `notice` (`text`, `subject_id`, `user_id`, `child_id`, `subject_count`, `subject_price`, `date`, `link`)
        VALUES (:text, :subject_id, :user_id, :child_id, :subject_count, :subject_price, :date, :link)";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'text' => $manager->text,
                'subject_id' => $manager->subject_id,
                'user_id' => $manager->user_id,
                'child_id' => $manager->child_id,
                'subject_count' => $manager->subject_count,
                'subject_price' => $manager->subject_price,
                'date' => $manager->date,
                'link' => $manager->link
            ]) == 1
        )
            return true;
        return false;
    }
    private function update($manager = Manager)
    {
        if (
            $this->db->exec("UPDATE manager
        INNER JOIN user ON manager.branch_id = user.branch_id
        SET manager.branch_id = $manager->branch_id, user.branch_id = $manager->branch_id
        WHERE user.user_id = $manager->user_id") == 1
        ) {
            return true;
        }
        return false;
    }
    public function findAll($ofset = 0, $limit = 30)
    {
        $res = $this->db->query("SELECT user.user_id,  CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, user.birthday, gender.name AS gender, role.name AS role, branch.id AS branch, branch.branch AS branch_name FROM user 
        INNER JOIN manager ON user.user_id=manager.user_id 
        INNER JOIN gender ON user.gender_id=gender.gender_id 
        INNER JOIN role ON user.role_id=role.role_id
        INNER JOIN branch ON branch.id=user.branch_id WHERE 
        manager.deleted = 0 and manager.branch_id = {$_SESSION['branch']}
            LIMIT $ofset, $limit");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }
    public function count()
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM manager 
        INNER JOIN user ON user.user_id = manager.user_id
        WHERE manager.branch_id = {$_SESSION['branch']} AND manager.deleted = 0");
        return $res->fetch(PDO::FETCH_OBJ)->cnt;
    }
    public function findProfileById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT manager.user_id, branch.branch FROM manager 
            INNER JOIN branch ON manager.branch_id = branch.id
            WHERE manager.user_id = $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function deleteManagerById($id)
    {
        $query = "UPDATE manager SET deleted = 1 WHERE user_id = :id";
        $res = $this->db->prepare($query);
        $res->execute([
            'id' => $id
        ]);
    }
}