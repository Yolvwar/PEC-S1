<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;

class Devis
{
    public function __construct()
    {
        $this->dbConnexion = new DatabaseConnexion();
    }

    public function getAll()
    {
        $this->dbConnexion->query("SELECT * FROM devis");
        return $this->dbConnexion->resultSet();
    }

    public function getById($id)
    {
        $this->dbConnexion->query("SELECT * FROM devis WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);
        return $this->dbConnexion->single();
    }

    public function create($data)
    {
        $this->dbConnexion->query(
            "INSERT INTO devis (user_id, service_id, vehicle_model, location_id, estimated_cost) 
             VALUES (:user_id, :service_id, :vehicle_model, :location_id, :estimated_cost)"
        );
        $this->dbConnexion->bind(':user_id', $data['user_id']);
        $this->dbConnexion->bind(':service_id', $data['service_id']);
        $this->dbConnexion->bind(':vehicle_model', $data['vehicle_model']);
        $this->dbConnexion->bind(':location_id', $data['location_id']);
        $this->dbConnexion->bind(':estimated_cost', $data['estimated_cost']);
        return $this->dbConnexion->execute();
    }
}