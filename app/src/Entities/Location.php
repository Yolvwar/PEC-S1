<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;

class Location
{
  private $dbConnexion;

  public function __construct()
  {
    $this->dbConnexion = new DatabaseConnexion();
  }

  public function getAll()
  {
    $this->dbConnexion->query("SELECT * FROM locations");
    return $this->dbConnexion->resultSet();
  }

  public function create($name, $address)
  {
      $this->dbConnexion->query("INSERT INTO locations (name, address) VALUES (:name, :address)");
      $this->dbConnexion->bind(':name', $name);
      $this->dbConnexion->bind(':address', $address);
      return $this->dbConnexion->execute();
  }
}
