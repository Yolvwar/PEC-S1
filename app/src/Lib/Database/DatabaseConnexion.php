<?php

namespace App\Lib\Database;

use App\Lib\Database\Dsn;

class DatabaseConnexion
{
    private \PDO $pdo_connexion;

    public function setConnexion(): self
    {
        $dsn = new Dsn();
        $this->pdo_connexion = new \PDO(
            $dsn->getDsn(),
            $dsn->getUser(),
            $dsn->getPassword()
        );
        return $this;
    }

    public function getConnexion(): \PDO
    {
        return $this->pdo_connexion;
    }

    public function closeConnexion(): void
    {
        $this->pdo_connexion = null;
    }
}
