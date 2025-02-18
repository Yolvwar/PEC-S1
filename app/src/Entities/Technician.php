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

    public function getTechnicians()
    {
        $this->dbConnexion->query("SELECT * FROM technicians");
        return $this->dbConnexion->resultSet();
    }

    public function findTechnicianById($id)
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

    public function acceptServiceRequest($technician_id, $service_request_id)
    {
        $this->dbConnexion->query("UPDATE service_requests SET technician_id = :technician_id WHERE id = :service_request_id");
        $this->dbConnexion->bind(':technician_id', $technician_id);
        $this->dbConnexion->bind(':service_request_id', $service_request_id);

        return $this->dbConnexion->execute();
    }
}