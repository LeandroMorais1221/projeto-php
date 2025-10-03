<?php

class Usuario
{
    private $id, $nome, $email, $senha, $nv_acesso;

    public static function ValidarLogin($senha, $usuario)
    {
        $autorizado = password_verify($senha, $usuario->senha);
        if($autorizado)
        {
            $_SESSION["autorizado"] = true;
            $_SESSION["usuario"] = $usuario;
            header("location:index.php");
        }
    }
}