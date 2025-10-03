<?php

class UsuarioDAO extends Database
{
    public function buscarLogin($email)
    {
        $query =  "SELECT u.id, u.nome, u.nv_acesso, u.senha
        FROM usuarios u
        WHERE u.email = ?";
        $statment = $this->pdo->prepare($query);
        $statment->bindValue(1, $email);
        $statment->execute();
        return $statment->fetch(PDO::FETCH_OBJ);
    }
}