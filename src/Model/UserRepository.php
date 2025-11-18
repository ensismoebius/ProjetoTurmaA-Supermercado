<?php

namespace GrupoA\Supermercado\Model;

/**
 * Classe UserRepository
 *
 * Responsável por gerenciar as operações de acesso a dados relacionadas aos usuários.
 * Atua como uma camada de abstração entre o controlador e a fonte de dados (Database).
 */
class UserRepository
{
    /**
     * @var Database $database Instância da classe Database para interação com o banco de dados.
     */
    private Database $database;

    /**
     * Construtor da classe UserRepository.
     *
     * @param Database $database A instância da conexão com o banco de dados.
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Busca um usuário no banco de dados pelo seu endereço de e-mail.
     *
     * @param string $email O endereço de e-mail do usuário a ser buscado.
     * @return array|null Um array associativo contendo os dados do usuário, ou null se não encontrado.
     */
    public function findByEmail(string $email): ?array
    {
        return $this->database->loadUserByEmail($email);
    }
}
