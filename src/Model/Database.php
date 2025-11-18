<?php
namespace GrupoA\Supermercado\Model;

class Database
{
    private \PDO $conexao;

    public function __construct()
    {
        // Configurações do banco de dados, crie 
        // variáveis de ambiente para que a conexão 
        // com o banco de dados seja feita.
        $dbHost = getenv('DB_HOST') ?: 'localhost';
        $dbName = getenv('DB_NAME') ?: 'dbSistema';
        $dbUser = getenv('DB_USER') ?: 'root';
        $dbPass = getenv('DB_PASS') ?: '';

        try {
            $this->conexao = new \PDO(
                "mysql:host={$dbHost};dbname={$dbName}",
                $dbUser,
                $dbPass
            );
            $this->conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            // In a real application, you would log this error and show a user-friendly message.
            // For now, we'll re-throw or die.
            die("Database connection failed: " . $e->getMessage());
        }
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

    public function buscarProdutos(): array
    {
        $stmt = $this->conexao->prepare("SELECT * FROM produtos");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
