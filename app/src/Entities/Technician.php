<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;

class Technician
{
    private $dbConnexion;

    public function __construct()
    {
        $this->dbConnexion = new DatabaseConnexion();
    }

    public function getAll()
    {
        $this->dbConnexion->query("SELECT * FROM technicians");
        return $this->dbConnexion->resultSet();
    }

    public function getById($id)
    {
        $this->dbConnexion->query("SELECT * FROM technicians WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);

        $row = $this->dbConnexion->single();

        if ($this->dbConnexion->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function create($data)
    {
        $this->dbConnexion->query("INSERT INTO technicians (name, email, speciality) VALUES (:name, :email, :speciality)");
        $this->dbConnexion->bind(':name', $data['name']);
        $this->dbConnexion->bind(':email', $data['email']);
        $this->dbConnexion->bind(':speciality', $data['speciality']);
        return $this->dbConnexion->execute();
    }

    public function update($id, $data)
    {
        $this->dbConnexion->query("UPDATE technicians SET name = :name, email = :email, speciality = :speciality WHERE id = :id");
        $this->dbConnexion->bind(':name', $data['name']);
        $this->dbConnexion->bind(':email', $data['email']);
        $this->dbConnexion->bind(':speciality', $data['speciality']);
        $this->dbConnexion->bind(':id', $id);

        return $this->dbConnexion->execute();
    }

    public function delete($id)
    {
        $this->dbConnexion->query("DELETE FROM technicians WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);

        return $this->dbConnexion->execute();
    }
    
    public function acceptServiceRequest($technician_id, $service_request_id)
    {
        $this->dbConnexion->query("UPDATE service_requests SET technician_id = :technician_id WHERE id = :service_request_id");
        $this->dbConnexion->bind(':technician_id', $technician_id);
        $this->dbConnexion->bind(':service_request_id', $service_request_id);

        return $this->dbConnexion->execute();
    }
}