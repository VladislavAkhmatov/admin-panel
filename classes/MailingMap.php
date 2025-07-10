<?php

class MailingMap extends BaseMap
{
    public function insert($message, $end_period)
    {
        $sql = "INSERT INTO mailing (message, created_at, end_period) 
                VALUES (:message, now(), :end_period)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':end_period', $end_period);
        return $stmt->execute();
    }

    public function getMessages()
    {
        $sql = "SELECT message, created_at, end_period FROM mailing WHERE end_period > now()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$messages) {
            echo json_encode(["message" => "No messages"]);
            return;
        }
        echo json_encode(["messages" => $messages]);
    }
}