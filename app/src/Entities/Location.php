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

  public function create($street, $address, $city, $postal_code)
  {
    $this->dbConnexion->query("INSERT INTO locations (street, address, city, postal_code) VALUES (:street, :address, :city, :postal_code)");
    $this->dbConnexion->bind(':street', $street);
    $this->dbConnexion->bind(':address', $address);
    $this->dbConnexion->bind(':city', $city);
    $this->dbConnexion->bind(':postal_code', $postal_code);
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

  public function getById($id)
  {
    $this->dbConnexion->query("SELECT * FROM locations WHERE id = :id");
    $this->dbConnexion->bind(':id', $id);
    return $this->dbConnexion->single();
  }

  public function update($id, $data)
    {
        $this->dbConnexion->query("UPDATE locations SET street = :street, address = :address, city = :city, postal_code = :postal_code WHERE id = :id");
        $this->dbConnexion->bind(':street', $data['street']);
        $this->dbConnexion->bind(':address', $data['address']);
        $this->dbConnexion->bind(':city', $data['city']);
        $this->dbConnexion->bind(':postal_code', $data['postal_code']);
        $this->dbConnexion->bind(':id', $id);
        return $this->dbConnexion->execute();
    }
}
