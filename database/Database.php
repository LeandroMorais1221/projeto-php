<?php

class Database
{
    protected $pdo;

    function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=ecomerce", "root", "root");
        } catch (Exception $e) {
            session_unset();
            session_destroy();
            header("location:404.php");
        }
    }
}
