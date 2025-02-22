<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;
use Exception;

class Devis
{
    private DatabaseConnexion $dbConnexion;
    private const NOMINATIM_BASE_URL = 'https://nominatim.openstreetmap.org/search';
    private const EARTH_RADIUS = 6371;
    private const PRICE_PER_KM = 1.5;
    private const BASE_PRICE = 75;
    private const USER_AGENT = 'YourAppName/1.0';
    private const REQUEST_DELAY = 1000000;

    public function __construct()
    {
        $this->dbConnexion = new DatabaseConnexion();
    }

    public function getAll(): array
    {
        try {
            $this->dbConnexion->query("SELECT * FROM devis");
            return $this->dbConnexion->resultSet() ?? [];
        } catch (Exception $e) {
            $this->logError('Error fetching all devis', $e);
            return [];
        }
    }

    public function getById(int $id): ?object
    {
        try {
            $this->dbConnexion->query("SELECT * FROM devis WHERE id = :id");
            $this->dbConnexion->bind(':id', $id);
            return $this->dbConnexion->single();
        } catch (Exception $e) {
            $this->logError("Error fetching devis with ID: $id", $e);
            return null;
        }
    }

    public function getDevisByUserId(int $user_id): array
    {
        try {
            $this->dbConnexion->query("
                SELECT d.*, sr.description, s.name AS service_name, 
                       l.address AS location_address
                FROM devis d
                JOIN service_requests sr ON d.service_request_id = sr.id
                JOIN services s ON sr.service_id = s.id
                JOIN locations l ON sr.location_id = l.id
                WHERE sr.user_id = :user_id
            ");
            $this->dbConnexion->bind(':user_id', $user_id);
            return $this->dbConnexion->resultSet() ?? [];
        } catch (Exception $e) {
            $this->logError("Error fetching devis for user ID: $user_id", $e);
            return [];
        }
    }

    public function create(array $data): bool
    {
        try {
            $this->validateDevisData($data);
            
            $this->dbConnexion->query("
                INSERT INTO devis (service_request_id, estimated_cost)
                VALUES (:service_request_id, :estimated_cost)
            ");
            
            $this->dbConnexion->bind(':service_request_id', $data['service_request_id']);
            $this->dbConnexion->bind(':estimated_cost', $data['preliminary_estimate']);
            
            return $this->dbConnexion->execute();
        } catch (Exception $e) {
            $this->logError('Error creating devis', $e);
            return false;
        }
    }

    public function calculatePreliminaryEstimate(int $service_id, string $vehicleModel): float
    {
        $vehicle_multiplier = $this->getVehicleMultiplier($vehicleModel);
        return self::BASE_PRICE * $vehicle_multiplier;
    }

    public function calculateFinalEstimate(string $adressFrom, string $adressTo, float $preliminaryEstimate): ?float
    {
        try {
            $coordinatesFrom = $this->getCoordinates($adressFrom);
            $coordinatesTo = $this->getCoordinates($adressTo);

            if (!$coordinatesFrom || !$coordinatesTo) {
                throw new Exception("Could not get coordinates for addresses");
            }

            $distance = $this->calculateDistance($coordinatesFrom, $coordinatesTo);
            $travel_cost = $distance * self::PRICE_PER_KM;
            
            return round($preliminaryEstimate + $travel_cost, 2);
        } catch (Exception $e) {
            $this->logError('Error calculating final estimate', $e);
            return null;
        }
    }

    protected function getCoordinates(string $city): ?array
    {
        try {
            usleep(self::REQUEST_DELAY);

            $params = http_build_query([
                'q' => $city,
                'format' => 'json',
                'addressdetails' => 1
            ]);

            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => [
                        'User-Agent: ' . self::USER_AGENT,
                        'Accept: application/json'
                    ]
                ]
            ]);

            $response = file_get_contents(self::NOMINATIM_BASE_URL . '?' . $params, false, $context);

            if ($response === false) {
                throw new Exception('Failed to fetch coordinates');
            }

            $data = json_decode($response, true);

            if (empty($data)) {
                return null;
            }

            return [
                'lat' => (float)$data[0]['lat'],
                'lon' => (float)$data[0]['lon']
            ];
        } catch (Exception $e) {
            $this->logError("Error getting coordinates for city: $city", $e);
            return null;
        }
    }

    private function calculateDistance(array $coordinatesFrom, array $coordinatesTo): float
    {
        $lat1 = deg2rad($coordinatesFrom['lat']);
        $lon1 = deg2rad($coordinatesFrom['lon']);
        $lat2 = deg2rad($coordinatesTo['lat']);
        $lon2 = deg2rad($coordinatesTo['lon']);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) * sin($dlat / 2) + 
            cos($lat1) * cos($lat2) * 
            sin($dlon / 2) * sin($dlon / 2);
            
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS * $c;
    }

    private function getVehicleMultiplier(string $vehicleModel): float
    {
        return strtolower($vehicleModel) === 'moto' ? 1.3 : 1.0;
    }

    private function validateDevisData(array $data): void
    {
        if (!isset($data['service_request_id'], $data['preliminary_estimate'])) {
            throw new Exception('Invalid devis data');
        }
    }

    private function logError(string $message, Exception $e): void
    {
        error_log("$message: " . $e->getMessage());
    }

    public function getPreliminaryEstimateByServiceRequestId($service_request_id)
    {
        $this->dbConnexion->query("SELECT estimated_cost FROM devis WHERE service_request_id = :service_request_id");
        $this->dbConnexion->bind(':service_request_id', $service_request_id);
        $result = $this->dbConnexion->single();

        if ($result === false) {
            return null;
        }

        return $result->estimated_cost;
    }

    public function getDevisWithServiceRequestByUserId($user_id)
    {
        $this->dbConnexion->query("
        SELECT d.*, sr.description, sr.vehicle_type, sr.created_at AS service_request_date, 
               s.name AS service_name, l.street AS location_street, l.address AS location_address, 
               l.city AS location_city, l.postal_code AS location_postal_code, ts.time_range
        FROM devis d
        JOIN service_requests sr ON d.service_request_id = sr.id
        JOIN services s ON sr.service_id = s.id
        JOIN locations l ON sr.location_id = l.id
        JOIN time_slots ts ON sr.time_slot_id = ts.id
        WHERE sr.user_id = :user_id
    ");
        $this->dbConnexion->bind(':user_id', $user_id);
        return $this->dbConnexion->resultSet();
    }

public function updateEstimate($service_request_id, $final_estimate)
    {
        $this->dbConnexion->query("UPDATE devis SET estimated_cost = :estimated_cost WHERE service_request_id = :service_request_id");
        $this->dbConnexion->bind(':estimated_cost', $final_estimate);
        $this->dbConnexion->bind(':service_request_id', $service_request_id);
        return $this->dbConnexion->execute();
    }
}