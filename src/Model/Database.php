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
    // bla bla bla

    public function atualizaProduto(Produto $produto): bool
    {
        $sql = "UPDATE produtos 
                SET nome = :nome, 
                    valor = :valor, 
                    categoria = :categoria, 
                    descricao = :descricao, 
                    quantidade = :quantidade
                WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(":nome", $produto->nome);
        $stmt->bindValue(":valor", $produto->valor);
        $stmt->bindValue(":categoria", $produto->categoria);
        $stmt->bindValue(":descricao", $produto->descricao);
        $stmt->bindValue(":quantidade", $produto->quantidade);
        $stmt->bindValue(":id", $produto->id);

        return $stmt->execute();
    }

    public function buscarProdutoPorId($id)
{
    $sql = "SELECT * FROM produtos WHERE id = :id";
    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    $produto = $stmt->fetch(\PDO::FETCH_ASSOC);

    return $produto ? $produto : false;
}


}


