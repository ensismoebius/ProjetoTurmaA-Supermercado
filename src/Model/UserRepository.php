<?php

namespace GrupoA\Supermercado\Model;

class UserRepository
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function findByEmail(string $email): ?array
    {
        return $this->database->loadUserByEmail($email);
    }
}
