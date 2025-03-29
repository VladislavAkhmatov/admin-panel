<?php

class BaseMap extends Config
{
    public $db;

    function __construct()
    {
        try {
            $this->db = new PDO(
                'mysql:host=' . Config::HOST . ';port=' . Config::DB_PORT . ';dbname=' . Config::DB_NAME,
                Config::DB_USER,
                Config::DB_PASSWORD
            );
            $this->db->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            $this->db->exec("set names utf8mb4");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}