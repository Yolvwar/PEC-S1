<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;
use App\Entities\Location;

class Technician
{
    private $dbConnexion;
    private $location;

    public function __construct()
    {
        $this->dbConnexion = new DatabaseConnexion();
        $this->location = new Location();
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

        $location_id = $this->location->createAndReturnId(
            $data['location_street'],
            $data['location_address'],
            $data['location_city'],
            $data['location_postal_code']
        );

        $this->dbConnexion->query("INSERT INTO technicians (name, email, speciality, phone, status, experience, location_id) VALUES (:name, :email, :speciality, :phone, :status, :experience, :location_id)");
        $this->dbConnexion->bind(':name', $data['name']);
        $this->dbConnexion->bind(':email', $data['email']);
        $this->dbConnexion->bind(':speciality', $data['speciality']);
        $this->dbConnexion->bind(':phone', $data['phone']);
        $this->dbConnexion->bind(':status', $data['status']);
        $this->dbConnexion->bind(':experience', $data['experience']);
        $this->dbConnexion->bind(':location_id', $location_id);
        return $this->dbConnexion->execute();
    }

    public function update($id, $data)
    {
        $location_id = $this->location->createAndReturnId(
            $data['location_street'],
            $data['location_address'],
            $data['location_city'],
            $data['location_postal_code']
        );

        $this->dbConnexion->query("UPDATE technicians SET name = :name, email = :email, speciality = :speciality, phone = :phone, status = :status, experience = :experience, location_id = :location_id WHERE id = :id");
        $this->dbConnexion->bind(':name', $data['name']);
        $this->dbConnexion->bind(':email', $data['email']);
        $this->dbConnexion->bind(':speciality', $data['speciality']);
        $this->dbConnexion->bind(':phone', $data['phone']);
        $this->dbConnexion->bind(':status', $data['status']);
        $this->dbConnexion->bind(':experience', $data['experience']);
        $this->dbConnexion->bind(':location_id', $location_id);
        $this->dbConnexion->bind(':id', $id);

        return $this->dbConnexion->execute();
    }

    public function delete($id)
    {
        $this->dbConnexion->query("DELETE FROM service_requests WHERE technician_id = :id");
        $this->dbConnexion->bind(':id', $id);
        $this->dbConnexion->execute();

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

        $this->dbConnexion->query("UPDATE technicians SET available = FALSE WHERE id = :technician_id");
        $this->dbConnexion->bind(':technician_id', $technician_id);
        return $this->dbConnexion->execute();
    }

    public function getAvailibleTechnicians()
    {
        $this->dbConnexion->query("SELECT * FROM technicians WHERE available = TRUE");
        return $this->dbConnexion->resultSet();
    }

}