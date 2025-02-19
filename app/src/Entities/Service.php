<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;

class Service
{
    private $dbConnexion;

    public function __construct()
    {
        $this->dbConnexion = new DatabaseConnexion();
    }

    public function getAll()
    {
        $this->dbConnexion->query("SELECT * FROM services");
        return $this->dbConnexion->resultSet();
    }

    public function getById($id)
    {
        $this->dbConnexion->query("SELECT * FROM services WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);
        return $this->dbConnexion->single();
    }

    public function create($data)
    {
        $this->dbConnexion->query(
            "INSERT INTO services (name, description) VALUES (:name, :description)"
        );
        $this->dbConnexion->bind(':name', $data['name']);
        $this->dbConnexion->bind(':description', $data['description']);
        return $this->dbConnexion->execute();
    }

    public function update($id, $data)
    {
        $this->dbConnexion->query(
            "UPDATE services SET name = :name, description = :description WHERE id = :id"
        );
        $this->dbConnexion->bind(':name', $data['name']);
        $this->dbConnexion->bind(':description', $data['description']);
        $this->dbConnexion->bind(':id', $id);
        return $this->dbConnexion->execute();
    }

    public function delete($id)
    {
        $this->dbConnexion->query("DELETE FROM services WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);
        return $this->dbConnexion->execute();
    }
}