<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;

class Evaluation
{
  private $dbConnexion;

  public function __construct()
  {
    $this->dbConnexion = new DatabaseConnexion();
  }

  public function addEvaluation($data)
  {
    $this->dbConnexion->query(
      "INSERT INTO evaluations (service_request_id, rating, comment) 
             VALUES (:service_request_id, :rating, :comment)"
    );

    $this->dbConnexion->bind(':service_request_id', $data['service_request_id']);
    $this->dbConnexion->bind(':rating', $data['rating']);
    $this->dbConnexion->bind(':comment', $data['comment']);

    return $this->dbConnexion->execute();
  }

  public function getEvaluationsByServiceRequestId($service_request_id)
  {
    $this->dbConnexion->query("SELECT * FROM evaluations WHERE service_request_id = :service_request_id");
    $this->dbConnexion->bind(':service_request_id', $service_request_id);

    return $this->dbConnexion->resultSet();
  }

  public function evaluationExists($service_request_id)
  {
    $this->dbConnexion->query("SELECT * FROM evaluations WHERE service_request_id = :service_request_id");
    $this->dbConnexion->bind(':service_request_id', $service_request_id);

    $this->dbConnexion->execute();
    return $this->dbConnexion->rowCount() > 0;
  }
}
