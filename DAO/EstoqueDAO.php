<?php

class EstoqueDAO extends Database
{
    public function buscarCoresDisponiveis($id)
    {
        $query = "SELECT e.cor_id, c.cor FROM estoque e
        JOIN cores c ON c.id = e.cor_id
        WHERE e.produto_id = ?
        GROUP BY e.cor_id
        HAVING SUM(e.quantidade) > 0";
        $statment = $this->pdo->prepare($query);
        $statment->bindValue(1, $id);
        $statment->execute();
        return $statment->fetchAll(PDO::FETCH_OBJ);
    }

    public function buscarTamanhosDisponiveis($produto_id, $cor_id)
    {
        $query = "SELECT e.tamanho_id, t.tamanho FROM estoque e
        JOIN tamanhos t ON t.id = e.tamanho_id
        WHERE e.produto_id = ?
        AND e.cor_id = ?
        GROUP BY e.tamanho_id
        HAVING SUM(e.quantidade) > 0";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(1, $produto_id);
        $statement->bindValue(2, $cor_id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}
