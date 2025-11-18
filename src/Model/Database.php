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

}