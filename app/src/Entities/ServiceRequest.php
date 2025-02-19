<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;

class ServiceRequest
{
    private $dbConnexion;

    public function __construct()
    {
        $this->dbConnexion = new DatabaseConnexion();
    }

    public function getAll()
    {
        $this->dbConnexion->query("
            SELECT sr.*, 
                   u.name AS user_name, 
                   s.name AS service_name, 
                   l.name AS location_name, 
                   l.address AS location_address, 
                   ts.time_range, 
                   t.name AS technician_name
            FROM service_requests sr
            JOIN users u ON sr.user_id = u.id
            JOIN services s ON sr.service_id = s.id
            JOIN locations l ON sr.location_id = l.id
            JOIN time_slots ts ON sr.time_slot_id = ts.id
            LEFT JOIN technicians t ON sr.technician_id = t.id
        ");
    
        return $this->dbConnexion->resultSet();
    }

    public function create($data)
    {
        $this->dbConnexion->query(
            "INSERT INTO service_requests (user_id, service_id, location_id, time_slot_id, description) 
             VALUES (:user_id, :service_id, :location_id, :time_slot_id, :description)"
        );

        $this->dbConnexion->bind(':user_id', $data['user_id']);
        $this->dbConnexion->bind(':service_id', $data['service_id']);
        $this->dbConnexion->bind(':location_id', $data['location_id']);
        $this->dbConnexion->bind(':time_slot_id', $data['time_slot_id']);
        $this->dbConnexion->bind(':description', $data['description']);

        return $this->dbConnexion->execute();
    }

    public function getById($id)
    {
        $this->dbConnexion->query("SELECT * FROM service_requests WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);

        return $this->dbConnexion->single();
    }

    public function getServiceRequestsByUserId($user_id)
    {
        $this->dbConnexion->query("
            SELECT sr.*, s.name AS service_name, l.name AS location_name, l.address AS location_address, ts.time_range
            FROM service_requests sr
            JOIN services s ON sr.service_id = s.id
            JOIN locations l ON sr.location_id = l.id
            JOIN time_slots ts ON sr.time_slot_id = ts.id
            WHERE sr.user_id = :user_id
        ");
        $this->dbConnexion->bind(':user_id', $user_id);

        return $this->dbConnexion->resultSet();
    }

    public function markServiceRequestAsCompleted($id)
    {
        $this->dbConnexion->query("UPDATE service_requests SET completed = TRUE WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);

        return $this->dbConnexion->execute();
    }

    public function isServiceRequestCompleted($id)
    {
        $this->dbConnexion->query("SELECT completed FROM service_requests WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);

        $row = $this->dbConnexion->single();
        return $row->completed;
    }

    public function delete($id)
    {
        $this->dbConnexion->query("DELETE FROM service_requests WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);

        return $this->dbConnexion->execute();
    }

    public function update($id, $data) {
        $this->dbConnexion->query(
            "UPDATE service_requests SET service_id = :service_id, location_id = :location_id, time_slot_id = :time_slot_id, description = :description WHERE id = :id"
        );
        $this->dbConnexion->bind(':service_id', $data['service_id']);
        $this->dbConnexion->bind(':location_id', $data['location_id']);
        $this->dbConnexion->bind(':time_slot_id', $data['time_slot_id']);
        $this->dbConnexion->bind(':description', $data['description']);
        $this->dbConnexion->bind(':id', $id);
        return $this->dbConnexion->execute();
    }
}