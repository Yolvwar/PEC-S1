<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;

class Devis
{
    private $dbConnexion;

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

    public function getDevisByUserId($user_id)
{
    $this->dbConnexion->query("
        SELECT d.*, sr.description, s.name AS service_name, l.address AS location_address
        FROM devis d
        JOIN service_requests sr ON d.service_request_id = sr.id
        JOIN services s ON sr.service_id = s.id
        JOIN locations l ON sr.location_id = l.id
        WHERE sr.user_id = :user_id
    ");
    $this->dbConnexion->bind(':user_id', $user_id);
    return $this->dbConnexion->resultSet();
}

    public function create($data)
    {
        $this->dbConnexion->query("
            INSERT INTO devis (service_request_id, estimated_cost)
            VALUES (:service_request_id, :estimated_cost)
        ");
        $this->dbConnexion->bind(':service_request_id', $data['service_request_id']);
        $this->dbConnexion->bind(':estimated_cost', $data['preliminary_estimate']);
        return $this->dbConnexion->execute();
    }

    public function calculatePreliminaryEstimate($service_id, $vehicleModel) {
        
        $base_price = 75;
        $vehicle_multiplier = ($vehicleModel == 'moto') ? 1.3 : 1.0;

        return $base_price * $vehicle_multiplier;
    }

    public function calculateFinalEstimate($preliminaryEstimate, $service_request_id, $technicians_id) {

        // utiliser api google maps pour calculer la distance entre le lieu de la réparation et le domicile du technicien
        // utiliser l'api google maps pour calculer le temps de trajet entre le lieu de la réparation et le domicile du technicien
        // utiliser l'api google maps pour calculer le coût du trajet entre le lieu de la réparation et le domicile du technicien


    }
}