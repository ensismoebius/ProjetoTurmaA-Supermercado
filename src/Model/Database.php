<?php
namespace GrupoA\Supermercado\Model;

class Database
{
    private \PDO $conexao;

    public function __construct()
    {
        $this->conexao = new \PDO("mysql:host=localhost;dbname=dbSistema", "root", "");
    }

    public function loadUserByEmail(string $email): ?array
    {
        $stmt = $this->conexao->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $usuario ?: null;
    }

    function saveProduto(Produto $produto): bool
    {
        $stmt = $this->conexao->prepare("INSERT INTO Produto (prdTitulo, prdDescr, prdVlrUnit, prdCateg, prdFor) VALUES (:titulo, :descricao, :valor, :categoria, :fornecedor)");

        $stmt->bindValue(":titulo", $produto->prdTitulo);
        $stmt->bindValue(":descricao", $produto->prdDescr);
        $stmt->bindValue(":valor", $produto->valor);
        $stmt->bindValue(":categoria", $produto->prdCateg);
        $stmt->bindValue(":fornecedor", $produto->prdFor);

        return $stmt->execute();
    }
}