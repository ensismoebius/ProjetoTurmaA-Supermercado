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

    public function buscarProdutos(): array
{
    $stmt = $this->conexao->prepare("SELECT * FROM produtos");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


}