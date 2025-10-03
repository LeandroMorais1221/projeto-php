<?php
session_start();

require "database/Database.php";
require "DAO/ProdutoDAO.php";


$autorizado = isset($_SESSION["autorizado"]) && $_SESSION["autorizado"] == true ? $_SESSION["autorizado"] : false;

$produtoDAO = new ProdutoDAO();
$produtos = $produtoDAO->buscarTodosDisponiveis();

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Projeto Senac</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Início</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown me-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="cartDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-cart-fill me-1"></i> Carrinho
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="cartDropdown"
                                style="min-width: 300px;" id="carrinho-ul">
                                <hr class="dropdown-divider">
                                <li class="text-end d-flex justify-content-end gap-2">
                                    <?php if (!isset($_SESSION["autorizado"]) || $_SESSION["autorizado"] !== true): ?>
                                        <a href="login.php" class="btn btn-sm btn-primary">Logar</a>
                                    <?php endif; ?>

                                    <form action="checkout.php" method="POST">
                                        <button class="btn btn-sm btn-success" <?= !isset($_SESSION["autorizado"]) || $_SESSION["autorizado"] !== true ? "disabled" : "" ?>>
                                            Finalizar Compra
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                        <?php if (isset($_SESSION["autorizado"]) && $_SESSION["autorizado"] == true): ?>
                            <li class="nav-item">
                                <a href="logout.php" class="btn btn-danger">Sair</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-3 fw-bold">Descubra a Próxima Tendência</h1>
            <p class="lead mt-4 mb-4">Produtos exclusivos e de alta qualidade para você. Entrega rápida e segura em todo o país.</p>
        </div>
    </section>

    <main class="container my-5">
        <h2 class="text-center my-5">Nossos Produtos</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php foreach ($produtos as $produto): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm product-card">
                        <img src="<?= $produto->img; ?>" class="card-img-top" alt="Produto 1">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $produto->nome; ?></h5>
                            <p class="fs-4 fw-bold text-success"><?= "R$" . number_format($produto->valor, 2, ","); ?></p>
                            <a href="detalhes-produto.php?id=<?= $produto->id; ?>" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script src="js/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>