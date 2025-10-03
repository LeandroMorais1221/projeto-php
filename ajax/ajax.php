<?php

header('Content-Type: application/json');

require "../database/Database.php";

if (isset($_POST["action"]) && $_POST["action"] == "tamanho") {
    require "../DAO/EstoqueDAO.php";
    $estoqueDAO = new EstoqueDAO();
    $tamanhos_disponiveis = $estoqueDAO->buscarTamanhosDisponiveis($_POST["produto_id"], $_POST["cor_id"]);
    echo json_encode($tamanhos_disponiveis);
}

if (isset($_POST["action"]) && $_POST["action"] == "carrinho") {

    require  "../DAO/ProdutoDAO.php";
    $produtoDAO = new ProdutoDAO();
    $produtos_carrinho = $produtoDAO->buscarInformacoesCarrinho($_POST["itens"]);
    echo json_encode($produtos_carrinho);
}