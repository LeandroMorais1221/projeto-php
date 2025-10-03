<?php
session_start();

require "database/Database.php";
require "DAO/UsuarioDAO.php";
require "model/Usuario.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $usuarioDAO = new UsuarioDAO();
  $usuario = $usuarioDAO->buscarLogin($_POST["email"]);
  Usuario::Validarlogin($_POST["senha"], $usuario);
}


?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Ecomerce</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

  <main class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-5">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <div class="text-center mb-4">
              <h1 class="h3 mb-1 fw-bold">Projeto Senac</h1>
              <p class="text-muted small">Acesse sua conta</p>
            </div>

            <form action="" method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" name="email" placeholder="seu-email@exemplo.com" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" name="senha" placeholder="••••••••" required>
              </div>

              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>