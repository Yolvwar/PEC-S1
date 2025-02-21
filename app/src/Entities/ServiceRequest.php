<?php

namespace App\Entities;
use App\Entities\Devis;

use App\Lib\Database\DatabaseConnexion;

class ServiceRequest
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
        $this->dbConnexion->query("
            SELECT sr.*, 
                   s.name AS service_name, 
                   l.street AS location_street, 
                   l.address AS location_address, 
                   l.city AS location_city,
                   l.postal_code AS location_postal_code,
                   ts.time_range,
                   u.name AS user_name,
                    u.email AS user_email,
                   t.name AS technician_name
                    FROM service_requests sr
                    JOIN services s ON sr.service_id = s.id
                    JOIN locations l ON sr.location_id = l.id
                    JOIN time_slots ts ON sr.time_slot_id = ts.id
                    LEFT JOIN technicians t ON sr.technician_id = t.id
                    JOIN users u ON sr.user_id = u.id

        ");

        return $this->dbConnexion->resultSet();
    }

    public function create($data)
    {   
        $location_id = $this->location->createAndReturnId(
            $data['location_street'],
            $data['location_address'],
            $data['location_city'],
            $data['location_postal_code']
        );

        $this->dbConnexion->query(
            "INSERT INTO service_requests (user_id, service_id, location_id, time_slot_id, description, vehicle_type) 
             VALUES (:user_id, :service_id, :location_id, :time_slot_id, :description, :vehicle_type)"
        );

        $this->dbConnexion->bind(':user_id', $data['user_id']);
        $this->dbConnexion->bind(':service_id', $data['service_id']);
        $this->dbConnexion->bind(':location_id', $location_id);
        $this->dbConnexion->bind(':time_slot_id', $data['time_slot_id']);
        $this->dbConnexion->bind(':vehicle_type', $data['vehicle_type']);
        $this->dbConnexion->bind(':description', $data['description']);
        
        $preliminaryEstimate = $this->calculatePreliminaryEstimate($data['service_id'], $data['vehicle_type']);

        $this->dbConnexion->execute();

    }

    public function calculatePreliminaryEstimate($service_id, $vehicleModel) {
        $base_price = 75;
        $vehicle_multiplier = ($vehicleModel == 'moto') ? 1.3 : 1.0;
    
        return $base_price * $vehicle_multiplier;
    }


    public function getById($id)
    {
        $this->dbConnexion->query("
            SELECT sr.*, 
                   s.name AS service_name, 
                   l.street AS location_street, 
                   l.address AS location_address, 
                   l.city AS location_city,
                   l.postal_code AS location_postal_code,
                   ts.time_range,
                   t.name AS technician_name,
                   l.city AS user_location
            FROM service_requests sr
            JOIN services s ON sr.service_id = s.id
            JOIN locations l ON sr.location_id = l.id
            JOIN time_slots ts ON sr.time_slot_id = ts.id
            LEFT JOIN technicians t ON sr.technician_id = t.id
            WHERE sr.id = :id
        ");
        $this->dbConnexion->bind(':id', $id);
    
        return $this->dbConnexion->single();
    }

    public function getServiceRequestsByUserId($user_id)
    {
        $this->dbConnexion->query("
            SELECT sr.*, 
                   s.name AS service_name, 
                   l.street AS location_street, 
                   l.address AS location_address, 
                   l.city AS location_city,
                   l.postal_code AS location_postal_code,
                   ts.time_range,
                   t.name AS technician_name
            FROM service_requests sr
            JOIN services s ON sr.service_id = s.id
            JOIN locations l ON sr.location_id = l.id
            JOIN time_slots ts ON sr.time_slot_id = ts.id
            LEFT JOIN technicians t ON sr.technician_id = t.id
            WHERE sr.user_id = :user_id
        ");
        $this->dbConnexion->bind(':user_id', $user_id);
    
        return $this->dbConnexion->resultSet();
    }

    public function delete($id)
    {
        $this->dbConnexion->query("DELETE FROM service_requests WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);

        return $this->dbConnexion->execute();
    }

    public function update($id, $data) {

        $location_id = $this->location->createAndReturnId(
            $data['location_street'],
            $data['location_address'],
            $data['location_city'],
            $data['location_postal_code']
        );
        
        $this->dbConnexion->query(
            "UPDATE service_requests SET service_id = :service_id, location_id = :location_id, time_slot_id = :time_slot_id, description = :description WHERE id = :id"
        );
        $this->dbConnexion->bind(':service_id', $data['service_id']);
        $this->dbConnexion->bind(':location_id', $location_id);
        $this->dbConnexion->bind(':time_slot_id', $data['time_slot_id']);
        $this->dbConnexion->bind(':description', $data['description']);
        $this->dbConnexion->bind(':id', $id);
        return $this->dbConnexion->execute();
    }

    public function confirmedServiceRequest($id)
    {
        $this->dbConnexion->query("UPDATE service_requests SET confirmed = TRUE WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);

        return $this->dbConnexion->execute();
    }

    public function complete($id)
    {
        $this->dbConnexion->query("UPDATE service_requests SET completed = TRUE WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);
        $this->dbConnexion->execute();

        $this->dbConnexion->query("SELECT technician_id FROM service_requests WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);
        $technician_id = $this->dbConnexion->single()->technician_id;

        $this->dbConnexion->query("UPDATE technicians SET available = TRUE WHERE id = :technician_id");
        $this->dbConnexion->bind(':technician_id', $technician_id);
        return $this->dbConnexion->execute();
    }

    public function isServiceRequestCompleted($id)
    {
        $this->dbConnexion->query("SELECT completed FROM service_requests WHERE id = :id");
        $this->dbConnexion->bind(':id', $id);

        $row = $this->dbConnexion->single();
        return $row->completed;
    }

    public function assignTechnician($service_request_id, $technician_id)
    {
        $this->dbConnexion->query("UPDATE service_requests SET technician_id = :technician_id WHERE id = :service_request_id");
        $this->dbConnexion->bind(':technician_id', $technician_id);
        $this->dbConnexion->bind(':service_request_id', $service_request_id);
        return $this->dbConnexion->execute();

        // on recalcul le devis avec la position du technicien pour calculer new prix devis
        $devis = new Devis();
        $service_request = $this->getById($service_request_id);
        $technician = (new Technician())->getById($technician_id);

        $location_requester = (new Location())->getById($service_request->location_id);
        $location_technician = (new Location())->getById($technician->location_id);
        
        $final_estimate = $devis->calculateFinalEstimate($location_requester->city, $location_technician->city);
        return $devis->updateEstimate($service_request_id, $final_estimate);
    }

    public function getLastInsertId()
    {
        return $this->dbConnexion->lastInsertId();
    }

    public function getEvaluationsByServiceRequestId($service_request_id)
  {
    $this->dbConnexion->query("SELECT * FROM evaluations WHERE service_request_id = :service_request_id");
    $this->dbConnexion->bind(':service_request_id', $service_request_id);

    return $this->dbConnexion->resultSet();
  }

  public function getServiceRequestById($id)
  {
    $this->dbConnexion->query("SELECT * FROM service_requests WHERE id = :id");
    $this->dbConnexion->bind(':id', $id);

    return $this->dbConnexion->single();
  }

  public function countAll()
{
    $this->dbConnexion->query("SELECT COUNT(*) as count FROM service_requests");
    return $this->dbConnexion->single()->count;
}

public function calculateCompletedRate()
{
    $this->dbConnexion->query("
        SELECT (COUNT(*) / (SELECT COUNT(*) FROM service_requests)) * 100 as return_rate 
        FROM service_requests 
        WHERE completed = '1'
    ");
    return $this->dbConnexion->single()->return_rate;
}

public function calculateRevenue()
{
    $this->dbConnexion->query("SELECT SUM(estimated_cost) as revenue FROM devis");
    return $this->dbConnexion->single()->revenue;
}

public function calculateRevenueByTechnician()
{
    $this->dbConnexion->query("
        SELECT t.name, SUM(d.estimated_cost) as revenue 
        FROM devis d
        JOIN service_requests sr ON d.service_request_id = sr.id
        JOIN technicians t ON sr.technician_id = t.id
        GROUP BY t.name
    ");
    return $this->dbConnexion->resultSet();
}

public function countPending()
{
    $this->dbConnexion->query("SELECT COUNT(*) as count FROM service_requests WHERE completed = '0'");
    return $this->dbConnexion->single()->count;
}

public function calculateRevenueByPeriod($startDate, $endDate)
{
    $this->dbConnexion->query("
        SELECT SUM(estimated_cost) as revenue 
        FROM devis 
        WHERE created_at BETWEEN :start_date AND :end_date
    ");
    $this->dbConnexion->bind(':start_date', $startDate);
    $this->dbConnexion->bind(':end_date', $endDate);
    return $this->dbConnexion->single()->revenue;
}

public function getInterventionsDataByMonth()
{
    $this->dbConnexion->query("
        SELECT MONTH(created_at) as month, COUNT(*) as count 
        FROM service_requests 
        GROUP BY MONTH(created_at)
    ");
    return $this->dbConnexion->resultSet();
}

public function getRevenueDataByMonth()
{
    $this->dbConnexion->query("
        SELECT MONTH(created_at) as month, SUM(estimated_cost) as revenue 
        FROM devis 
        GROUP BY MONTH(created_at)
    ");
    return $this->dbConnexion->resultSet();
}
}