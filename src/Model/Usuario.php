<?php
namespace Model;

use PDO;

class Usuario
{
    public static function listarTodos(PDO $con)
    {
        $sql = "SELECT id, nome, email, role FROM usuarios ORDER BY nome ASC";
        return $con->query($sql, PDO::FETCH_ASSOC)->fetchAll();
    }
}

{
    private PDO $con;

    public function __construct(PDO $con)
    {
        $this->con = $con;
    }

    public function listarTodos(): array
    {
        $sql = "SELECT id, nome, email, role, criado_em 
                FROM usuarios 
                ORDER BY nome ASC";

        $stmt = $this->con->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodos(): array
    {
        $sql = "SELECT * FROM usuarios ORDER BY nome ASC";
        return $this->con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ?: null;
    }

    public function editar(int $id, string $nome, string $email, string $role): bool
    {
        $sql = "UPDATE usuarios 
                SET nome = ?, email = ?, role = ?
                WHERE id = ?";
        $stmt = $this->con->prepare($sql);

        return $stmt->execute([$nome, $email, $role, $id]);
    }
    
    public function excluir(int $id): bool
    {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->con->prepare($sql);

        return $stmt->execute([$id]);
    }
}
?>
