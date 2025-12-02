<?php

class Produto
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=loja', 'root', '');
    }

    public function buscarPorIds($ids)
    {
        if (count($ids) == 0) return [];

        $lista = implode(',', array_map('intval', $ids));

        $sql = "SELECT * FROM produtos WHERE id IN ($lista)";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}