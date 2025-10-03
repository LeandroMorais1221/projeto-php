<?php


class ProdutoDAO extends Database
{
    public function buscarTodosDisponiveis()
    {
        $query = "SELECT p.id, p.nome, p.valor, p.img
        FROM produtos p
        JOIN estoque e ON e.produto_id = p.id
        GROUP BY p.id, e.tamanho_id, e.cor_id
        HAVING SUM(e.quantidade) > 0";
        $statment = $this->pdo->prepare($query);
        $statment->execute();
        return $statment->fetchAll(PDO::FETCH_OBJ);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT p.nome, p.valor, p.descricao, p.img
        FROM produtos p
        JOIN estoque e ON e.produto_id = p.id
        WHERE p.id = ?
        GROUP BY p.id, e.tamanho_id, e.cor_id
        HAVING SUM(e.quantidade) > 0";
        $statment = $this->pdo->prepare($query);
        $statment->bindValue(1, $id);
        $statment->execute();
        return $statment->fetch(PDO::FETCH_OBJ);
    }

    public function buscarInformacoesCarrinho($itens)
    {
        foreach($itens as $item)
        {
            $query = "SELECT p.nome, c.cor, t.tamanho, p.valor, p.img FROM produtos p
            JOIN estoque e ON e.produto_id = p.id
            JOIN cores c ON c.id = e.cor_id
            JOIN tamanhos t ON t.id = e.tamanho_id
            WHERE p.id = ?
            AND e.tamanho_id = ?
            AND e.cor_id = ?";
            $statment = $this->pdo->prepare($query);
            $statment->bindValue(1, $item["id"]);
            $statment->bindValue(2, $item["tamanho_id"]);
            $statment->bindValue(3, $item["cor_id"]);
            $statment->execute();
            $produto = $statment->fetch(PDO::FETCH_OBJ);

            if($produto){
                $produto->quantidade = $item["quantidade"];
                $informacoes_produto[] = $produto;
            }
        }
        
        return $informacoes_produto;
    }
}
