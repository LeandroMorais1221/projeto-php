<?php
session_start();

require "database/Database.php";
require "DAO/ProdutoDAO.php";
require "DAO/EstoqueDAO.php";

$produto_id = isset($_GET["id"]) && is_numeric($_GET["id"]) ? $_GET["id"] : 0;

$produtoDAO = new ProdutoDAO();
$produto =  $produtoDAO->buscarPorId($produto_id);

if (!$produto) {
    return header("location:index.php");
}

$estoqueDAO = new EstoqueDAO();
$coresDisponíveis = $estoqueDAO->buscarCoresDisponiveis($_GET["id"]);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto - <?= $produto->nome ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
                            <a class="nav-link" href="index.php">Início</a>
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



    <main class="container my-5">
        <div class="row">
            <div class="col-md-6 mb-4">
                <img src="<?= $produto->img; ?>" alt="Nome do Produto" class="img-fluid product-image" id="img-produto">
            </div>

            <div class="col-md-6">
                <h1 class="mb-3" id="nome-produto"><?= $produto->nome; ?></h1>
                <h2 class="text-success fw-bold mb-4"><?= "R$" . number_format($produto->valor, "2", ","); ?></h2>

                <p class="lead"><?= $produto->descricao ?></p>

                <div class="mb-4">
                    <h6 class="fw-bold">Cor:</h6>
                    <select class="form-select" aria-label="Selecione a cor" id="cores">
                        <option selected disabled>Selecione uma cor</option>
                        <?php foreach ($coresDisponíveis as $cor): ?>
                            <option value="<?= $cor->cor_id ?>"><?= $cor->cor ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold">Tamanho:</h6>
                    <select class="form-select" aria-label="Selecione o tamanho" id="tamanhos">
                        <option selected disabled>Selecione um tamanho</option>
                    </select>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold">Quantidade:</h6>
                    <div class="input-group quantity-input-wrapper">
                        <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                        <input type="number" class="form-control text-center" value="1" min="1" aria-label="Quantidade do produto" id="quantidade">
                        <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                    </div>
                </div>
                <button class="btn btn-primary btn-lg w-100" id="btnAdicionar">Adicionar ao Carrinho</button>
            </div>
        </div>
    </main>

    <script>
        const produto_id = "<?= $produto_id ?>"
    </script>
    <script src="js/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>