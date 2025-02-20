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

  public function createAndReturnId($street, $address, $city, $postal_code)
  {
      $this->dbConnexion->query("INSERT INTO locations (street, address, city, postal_code) VALUES (:street, :address, :city, :postal_code)");
      $this->dbConnexion->bind(':street', $street);
      $this->dbConnexion->bind(':address', $address);
      $this->dbConnexion->bind(':city', $city);
      $this->dbConnexion->bind(':postal_code', $postal_code);
      $this->dbConnexion->execute();
      return $this->dbConnexion->lastInsertId();
  }
}
