<?php

class Api extends BaseMap
{
    public function getTeacher($id)
    {
        $query = "SELECT user.user_id,  CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, user.birthday, gender.name AS gender, role.name AS role, branch.id AS branch, branch.branch AS branch_name, teacher.salary
         FROM user 
                    INNER JOIN teacher ON user.user_id=teacher.user_id 
                    INNER JOIN gender ON user.gender_id=gender.gender_id 
                    INNER JOIN role ON user.role_id=role.role_id
                    INNER JOIN branch ON branch.id=user.branch_id
                    WHERE teacher.deleted = 0 AND teacher.user_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $teacher = $stmt->fetchAll(PDO::FETCH_OBJ);
        if (!$teacher) {
            http_response_code(404);
            echo json_encode([
                'error' => "user not found"
            ]);
        }

        echo json_encode([
            'teacher' => $teacher
        ]);
    }

    public function getStudent($id)
    {
        $query = "SELECT * FROM user WHERE user_id = {$id}";
    }

    public function getUser($login)
    {
        {
            $login = $this->db->quote($login);
            $res = $this->db->query("SELECT user.user_id, CONCAT(user.lastname,' ', user.firstname, ' ', user.patronymic) AS fio, user.pass, role.sys_name, role.name as role, branch.id AS branch, branch.branch as branch_name, student.points FROM user 
        LEFT JOIN student ON student.user_id = user.user_id
        INNER JOIN role ON user.role_id=role.role_id 
        INNER JOIN branch ON user.branch_id = branch.id 
        WHERE user.login = $login OR user.additional_login = $login");
            $user = $res->fetch(PDO::FETCH_ASSOC);
            if (!$user) {
                echo json_encode(["error" => "user not found"]);
                return;
            }
            echo json_encode(["user" => $user]);
        }
    }

    public function addReference($user_id, $target_file)
    {
        $sql = "INSERT INTO `reference`(`user_id`, `reference`) VALUES (:user_id, :reference)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':reference', $target_file);
        $data = $stmt->execute();
        if (!$data) {
            echo json_encode(["error" => "something went wrong"]);
        }
        echo json_encode(["success" => "data shared to server"]);
    }

    public function getReferences($user_id)
    {
        $sql = "SELECT * FROM reference WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $reference = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$reference) {
            echo json_encode(["error" => "something went wrong"]);
        }
        echo json_encode(["reference" => $reference]);
    }
}