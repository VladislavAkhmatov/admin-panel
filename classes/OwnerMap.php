<?php

class ownerMap extends BaseMap
{
    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT CONCAT(user.lastname, ' ', user.firstname, ' ', user.patronymic) as fio, owner.user_id, owner.branch_id FROM owner
            INNER JOIN user ON user.user_id = owner.user_id WHERE owner.user_id = $id");
            $owner = $res->fetchObject("owner");
            if ($owner) {
                return $owner;
            }
        }
        return new owner();
    }

    public function save($user = User, $owner = owner)
    {
        if ($user->validate() && (new UserMap())->save($user)) {
            if ($owner->user_id == 0) {
                $owner->user_id = $user->user_id;
                return $this->insert($owner);
            } else {
                return $this->update($owner);
            }
        }
        return false;
    }

    private function insert($owner = owner)
    {
        if (
            $this->db->exec("INSERT INTO owner(user_id, branch_id) VALUES($owner->user_id, $owner->branch_id)") == 1
        ) {
            return true;
        }
        return false;
    }
    public function insertNotice($owner = owner)
    {

        $query = "INSERT INTO `notice` (`text`, `subject_id`, `user_id`, `child_id`, `subject_count`, `subject_price`, `date`, `link`)
        VALUES (:text, :subject_id, :user_id, :child_id, :subject_count, :subject_price, :date, :link)";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'text' => $owner->text,
                'subject_id' => $owner->subject_id,
                'user_id' => $owner->user_id,
                'child_id' => $owner->child_id,
                'subject_count' => $owner->subject_count,
                'subject_price' => $owner->subject_price,
                'date' => $owner->date,
                'link' => $owner->link
            ]) == 1
        )
            return true;
        return false;
    }
    private function update($owner = owner)
    {
        if (
            $this->db->exec("UPDATE owner
        INNER JOIN user ON owner.branch_id = user.branch_id
        SET owner.branch_id = $owner->branch_id, user.branch_id = $owner->branch_id
        WHERE user.user_id = $owner->user_id") == 1
        ) {
            return true;
        }
        return false;
    }
    public function findAll($ofset = 0, $limit = 30)
    {
        $res = $this->db->query("SELECT user.user_id,  CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, user.birthday, gender.name AS gender, role.name AS role, branch.id AS branch, branch.branch AS branch_name FROM user 
        INNER JOIN owner ON user.user_id=owner.user_id 
        INNER JOIN gender ON user.gender_id=gender.gender_id 
        INNER JOIN role ON user.role_id=role.role_id
        INNER JOIN branch ON branch.id=user.branch_id
            LIMIT $ofset, $limit");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }
    public function count()
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM owner WHERE owner.deleted = 0 
        AND owner.branch = {$_SESSION['branch']}");
        return $res->fetch(PDO::FETCH_OBJ)->cnt;
    }
    public function findProfileById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT owner.user_id, branch.branch FROM owner 
            INNER JOIN branch ON owner.branch_id = branch.id
            WHERE owner.user_id = $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function deleteownerById($id)
    {
        $query = "UPDATE student SET deleted = 1 WHERE user_id = :id";
        $res = $this->db->prepare($query);
        $res->execute([
            'id' => $id
        ]);
    }

    public function saveBranch(owner $owner)
    {
        $query = "INSERT INTO `branch` (`branch`, `date_founding`, `deleted`) 
        VALUES (:text, NOW(), '0')";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'text' => $owner->text
            ])
        ) {
            return true;
        }
        return false;
    }

    public function findPaymentByDate($date)
    {
        $query = "SELECT payment.id, 
        CONCAT(parent.lastname, ' ', parent.firstname, ' ', parent.patronymic) as parent,
        CONCAT(child.lastname, ' ', child.firstname, ' ', child.patronymic) as child,
        subject.name as subject,
        payment.count as subject_count,
        payment.price as subject_price,
        payment.tab as tab,
        payment.link as link,
        payment.date as date,
        branch.id as branch_id,
        branch.branch as branch_name
        FROM `payment`
        INNER JOIN user as parent ON payment.parent_id = parent.user_id
        INNER JOIN user as child ON payment.child_id = child.user_id
        INNER JOIN subject ON subject.subject_id = payment.subject_id
        INNER JOIN branch ON branch.id = payment.branch_id
        WHERE payment.date = :date";

        $res = $this->db->prepare($query);

        $res->execute([
            'date' => $date
        ]);
        return $res->fetchAll(PDO::FETCH_OBJ);
    }
    public function findPaymentByDateAndBranch($date, $branch)
    {
        $query = "SELECT payment.id, 
        CONCAT(parent.lastname, ' ', parent.firstname, ' ', parent.patronymic) as parent,
        CONCAT(child.lastname, ' ', child.firstname, ' ', child.patronymic) as child,
        subject.name as subject,
        payment.count as subject_count,
        payment.price as subject_price,
        payment.tab as tab,
        payment.link as link,
        payment.date as date,
        branch.id as branch_id,
        branch.branch as branch_name
        FROM `payment`
        INNER JOIN user as parent ON payment.parent_id = parent.user_id
        INNER JOIN user as child ON payment.child_id = child.user_id
        INNER JOIN subject ON subject.subject_id = payment.subject_id
        INNER JOIN branch ON branch.id = payment.branch_id
        WHERE payment.date = :date AND branch.id = :branch";

        $res = $this->db->prepare($query);

        $res->execute([
            'date' => $date,
            'branch' => $branch
        ]);
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

}