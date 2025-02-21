<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;

class Devis
{
    private $dbConnexion;
    private const NOMINATIM_BASE_URL = 'https://nominatim.openstreetmap.org/search';
    private const EARTH_RADIUS = 6371;

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

    public function updateEstimate($service_request_id, $final_estimate)
    {
        $this->dbConnexion->query("UPDATE devis SET estimated_cost = :estimated_cost WHERE service_request_id = :service_request_id");
        $this->dbConnexion->bind(':estimated_cost', $final_estimate);
        $this->dbConnexion->bind(':service_request_id', $service_request_id);
        return $this->dbConnexion->execute();
    }

    public function calculateFinalEstimate($adressFrom, $adressTo, $preliminaryEstimate) {

        $coordinatesFrom = $this->getCoordinates($adressFrom);
        $coordinatesTo = $this->getCoordinates($adressTo);

        if ($coordinatesFrom === null || $coordinatesTo === null) {
            return null;
        }

        $distance = $this->calculateDistance($coordinatesFrom, $coordinatesTo);
        $price_per_km = 1.5;
        $travel_cost = $distance * $price_per_km;
        $final_estimate = $preliminaryEstimate + $travel_cost;

        return round($final_estimate, 2);
        
    }

public function getCoordinates(string $city): ?array
{
    usleep(1000000); // 1 second pour la limite de con 

    $params = http_build_query([
        'q' => $city,
        'format' => 'json',
        'addressdetails' => 1
    ]);

    $url = self::NOMINATIM_BASE_URL . '?' . $params;

    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept: application/json'
            ]
        ]
    ];

    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        var_dump(error_get_last());
        return null;
    }

    $data = json_decode($response, true);

    if (empty($data)) {
        return null;
    }

    return [
        'lat' => (float)$data[0]['lat'],
        'lon' => (float)$data[0]['lon']
    ];
}

    public function calculateDistance(array $coordinatesFrom, array $coordinatesTo) {

        $lat1 = deg2rad($coordinatesFrom['lat']);
        $lon1 = deg2rad($coordinatesFrom['lon']);
        $lat2 = deg2rad($coordinatesTo['lat']);
        $lon2 = deg2rad($coordinatesTo['lon']);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS * $c;
    }

    public function getDistanceBetweenCities(string $cityFrom, string $cityTo) {
        try{
            $coordinatesFrom = $this->getCoordinates($cityFrom);
            $coordinatesTo = $this->getCoordinates($cityTo);

            if ($coordinatesFrom === null || $coordinatesTo === null) {
                return null;
            }

            $distance = $this->calculateDistance($coordinatesFrom, $coordinatesTo);

            return [
                'status' => 'success',
                'distance' => round($distance, 2),
                'units' => 'km',
                'city1' => [
                    'name' => $cityFrom,
                    'coordinates' => $coordinatesFrom
                ],
                'city2' => [
                    'name' => $cityTo,
                    'coordinates' => $coordinatesTo
                ]
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

public function getPreliminaryEstimateByServiceRequestId($service_request_id)
{
    $this->dbConnexion->query("SELECT estimated_cost FROM devis WHERE service_request_id = :service_request_id");
    $this->dbConnexion->bind(':service_request_id', $service_request_id);
    $result = $this->dbConnexion->single();

    return $result->estimated_cost;
}
}

